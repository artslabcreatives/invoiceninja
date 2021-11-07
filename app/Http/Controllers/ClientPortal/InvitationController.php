<?php
/**
 * Hype Sri Lanka (https://hypesl.org).
 *
 * @link https://github.com/artslabcreatives/invoiceninja source repository
 *
 * @copyright Copyright (c) 2021. Hype Sri Lanka (https://hypesl.org)
 *
 * @license https://www.elastic.co/licensing/elastic-license
 */

namespace App\Http\Controllers\ClientPortal;

use App\Events\Credit\CreditWasViewed;
use App\Events\Invoice\InvoiceWasViewed;
use App\Events\Misc\InvitationWasViewed;
use App\Events\Quote\QuoteWasViewed;
use App\Http\Controllers\Controller;
use App\Jobs\Entity\CreateRawPdf;
use App\Models\Client;
use App\Models\ClientContact;
use App\Models\InvoiceInvitation;
use App\Models\Payment;
use App\Services\ClientPortal\InstantPayment;
use App\Utils\CurlUtils;
use App\Utils\Ninja;
use App\Utils\Traits\MakesDates;
use App\Utils\Traits\MakesHash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Class InvitationController.
 */
class InvitationController extends Controller
{
    use MakesHash;
    use MakesDates;

    public function router(string $entity, string $invitation_key)
    {   
        Auth::logout();

        return $this->genericRouter($entity, $invitation_key);
    }

    public function recurringRouter(string $invitation_key)
    {
        return $this->genericRouter('recurring_invoice', $invitation_key);
    }

    public function invoiceRouter(string $invitation_key)
    {
        return $this->genericRouter('invoice', $invitation_key);
    }

    public function quoteRouter(string $invitation_key)
    {
        return $this->genericRouter('quote', $invitation_key);
    }

    public function creditRouter(string $invitation_key)
    {
        return $this->genericRouter('credit', $invitation_key);
    }

    private function genericRouter(string $entity, string $invitation_key)
    {

        if(!in_array($entity, ['invoice', 'credit', 'quote', 'recurring_invoice']))
            return response()->json(['message' => 'Invalid resource request']);

        $key = $entity.'_id';

        $entity_obj = 'App\Models\\'.ucfirst(Str::camel($entity)).'Invitation';

        $invitation = $entity_obj::where('key', $invitation_key)
                                    ->whereHas($entity, function ($query) {
                                         $query->where('is_deleted',0);
                                    })
                                    ->with('contact.client')
                                    ->firstOrFail();

        /* Return early if we have the correct client_hash embedded */
        $client_contact = $invitation->contact;

        if(empty($client_contact->email))
            $client_contact->email = Str::random(15) . "@example.com"; $client_contact->save();

        if (request()->has('client_hash') && request()->input('client_hash') == $invitation->contact->client->client_hash) {
            auth()->guard('contact')->login($client_contact, true);

        } elseif ((bool) $invitation->contact->client->getSetting('enable_client_portal_password') !== false) {
            $this->middleware('auth:contact');
            return redirect()->route('client.login');

        } else {
            nlog("else - default - login contact");
            auth()->guard('contact')->login($client_contact, true);
        }


        if (auth()->guard('contact') && ! request()->has('silent') && ! $invitation->viewed_date) {
            $invitation->markViewed();

            event(new InvitationWasViewed($invitation->{$entity}, $invitation, $invitation->{$entity}->company, Ninja::eventVars()));

            $this->fireEntityViewedEvent($invitation, $entity);
        }

        return redirect()->route('client.'.$entity.'.show', [$entity => $this->encodePrimaryKey($invitation->{$key})]);
    }

    private function fireEntityViewedEvent($invitation, $entity_string)
    {
        switch ($entity_string) {
            case 'invoice':
                event(new InvoiceWasViewed($invitation, $invitation->company, Ninja::eventVars()));
                break;
            case 'quote':
                event(new QuoteWasViewed($invitation, $invitation->company, Ninja::eventVars()));
                break;
            case 'credit':
                event(new CreditWasViewed($invitation, $invitation->company, Ninja::eventVars()));
                break;
            default:
                // code...
                break;
        }
    }

    public function routerForDownload(string $entity, string $invitation_key)
    {

        if(Ninja::isHosted())
            return $this->returnRawPdf($entity, $invitation_key);

        return redirect('client/'.$entity.'/'.$invitation_key.'/download_pdf');
    }

    private function returnRawPdf(string $entity, string $invitation_key)
    {

        if(!in_array($entity, ['invoice', 'credit', 'quote', 'recurring_invoice']))
            return response()->json(['message' => 'Invalid resource request']);

        $key = $entity.'_id';

        $entity_obj = 'App\Models\\'.ucfirst(Str::camel($entity)).'Invitation';

        // $invitation = $entity_obj::whereRaw('BINARY `key`= ?', [$invitation_key])
        //                             ->with('contact.client')
        //                             ->firstOrFail();

        $invitation = $entity_obj::where('key', $invitation_key)
                                    ->with('contact.client')
                                    ->firstOrFail();

        if(!$invitation)
            return response()->json(["message" => "no record found"], 400);

        $file_name = $invitation->{$entity}->numberFormatter().'.pdf';
        nlog($file_name);

        $file = CreateRawPdf::dispatchNow($invitation, $invitation->company->db);

        $headers = ['Content-Type' => 'application/pdf'];

        if(request()->input('inline') == 'true')
            $headers = array_merge($headers, ['Content-Disposition' => 'inline']);

        return response()->streamDownload(function () use($file) {
                echo $file;
        },  $file_name, $headers);
        
    }

    public function routerForIframe(string $entity, string $client_hash, string $invitation_key)
    {
    }

    public function paymentRouter(string $contact_key, string $payment_id)
    {
        $contact = ClientContact::where('contact_key', $contact_key)->firstOrFail();
        $payment = Payment::find($this->decodePrimaryKey($payment_id));

        if($payment->client_id != $contact->client_id)
            abort(403, 'You are not authorized to view this resource');

        auth()->guard('contact')->login($contact, true);

        return redirect()->route('client.payments.show', $payment->hashed_id);

    }

    public function payInvoice(Request $request, string $invitation_key)
    {
        $invitation = InvoiceInvitation::where('key', $invitation_key)
                                    ->with('contact.client')
                                    ->firstOrFail();
        
        auth()->guard('contact')->login($invitation->contact, true);

        $invoice = $invitation->invoice;

        if($invoice->partial > 0)
            $amount = round($invoice->partial, (int)$invoice->client->currency()->precision);
        else 
            $amount = round($invoice->balance, (int)$invoice->client->currency()->precision);

        $gateways = $invitation->contact->client->service()->getPaymentMethods($amount);

        if(is_array($gateways))
        {

            $data = [
                'company_gateway_id' => $gateways[0]['company_gateway_id'],
                'payment_method_id' => $gateways[0]['gateway_type_id'],
                'payable_invoices' => [
                    ['invoice_id' => $invitation->invoice->hashed_id, 'amount' => $amount],
                ],
                'signature' => false
            ];

            $request->replace($data);

            return (new InstantPayment($request))->run();
        }

        abort(404, "Invoice not found");
    }
}
