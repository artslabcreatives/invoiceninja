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

use App\Events\Invoice\InvoiceWasViewed;
use App\Events\Misc\InvitationWasViewed;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientPortal\Invoices\ProcessInvoicesInBulkRequest;
use App\Http\Requests\ClientPortal\Invoices\ShowInvoiceRequest;
use App\Http\Requests\ClientPortal\Invoices\ShowInvoicesRequest;
use App\Models\Invoice;
use App\Utils\Ninja;
use App\Utils\Number;
use App\Utils\TempFile;
use App\Utils\Traits\MakesDates;
use App\Utils\Traits\MakesHash;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use ZipStream\Option\Archive;
use ZipStream\ZipStream;

class InvoiceController extends Controller
{
    use MakesHash, MakesDates;

    /**
     * Display list of invoices.
     *
     * @return Factory|View
     */
    public function index(ShowInvoicesRequest $request)
    {
        return $this->render('invoices.index');
    }

    /**
     * Show specific invoice.
     *
     * @param ShowInvoiceRequest $request
     * @param Invoice $invoice
     *
     * @return Factory|View
     */
    public function show(ShowInvoiceRequest $request, Invoice $invoice)
    {
        set_time_limit(0);

        $invoice->service()->removeUnpaidGatewayFees()->save();


            $invitation = $invoice->invitations()->where('client_contact_id', auth()->user()->id)->first();

            if ($invitation && auth()->guard('contact') && ! request()->has('silent') && ! $invitation->viewed_date) {

                $invitation->markViewed();

                event(new InvitationWasViewed($invoice, $invitation, $invoice->company, Ninja::eventVars()));
                event(new InvoiceWasViewed($invitation, $invitation->company, Ninja::eventVars()));
            
            }

        $data = [
            'invoice' => $invoice,
        ];

        if ($request->query('mode') === 'fullscreen') {
            return render('invoices.show-fullscreen', $data);
        }

        return $this->render('invoices.show', $data);
    }

    /**
     * Pay one or more invoices.
     *
     * @param ProcessInvoicesInBulkRequest $request
     * @return mixed
     */
    public function bulk(ProcessInvoicesInBulkRequest $request)
    {
        $transformed_ids = $this->transformKeys($request->invoices);

        if ($request->input('action') == 'payment') {
            return $this->makePayment((array) $transformed_ids);
        } elseif ($request->input('action') == 'download') {
            return $this->downloadInvoicePDF((array) $transformed_ids);
        }

        return redirect()
            ->back()
            ->with('message', ctrans('texts.no_action_provided'));
    }

    /**
     * @param array $ids 
     * @return Factory|View|RedirectResponse 
     */
    private function makePayment(array $ids)
    {
        $invoices = Invoice::whereIn('id', $ids)
                            ->whereClientId(auth()->user()->client->id)
                            ->withTrashed()
                            ->get();

        //filter invoices which are payable
        $invoices = $invoices->filter(function ($invoice) {
            return $invoice->isPayable();
        });

        //return early if no invoices.
        if ($invoices->count() == 0) {
            return back()
                ->with('message', ctrans('texts.no_payable_invoices_selected'));
        }

        //iterate and sum the payable amounts either partial or balance
        $total = 0;
        foreach($invoices as $invoice)
        {

            if($invoice->partial > 0)
                $total += $invoice->partial;
            else
                $total += $invoice->balance;

        }

        //format data
        $invoices->map(function ($invoice) {
            $invoice->service()->removeUnpaidGatewayFees()->save();
            $invoice->balance = $invoice->balance > 0 ? Number::formatValue($invoice->balance, $invoice->client->currency()) : 0;
            $invoice->partial =  $invoice->partial > 0 ? Number::formatValue($invoice->partial, $invoice->client->currency()) : 0;

            return $invoice;
        });

        //format totals
        $formatted_total = Number::formatMoney($total, auth()->user()->client);

        $payment_methods = auth()->user()->client->service()->getPaymentMethods($total);

        //if there is only one payment method -> lets return straight to the payment page

        $data = [
            'settings' => auth()->user()->client->getMergedSettings(),
            'invoices' => $invoices,
            'formatted_total' => $formatted_total,
            'payment_methods' => $payment_methods,
            'hashed_ids' => $invoices->pluck('hashed_id'),
            'total' =>  $total,
        ];

        return $this->render('invoices.payment', $data);
    }

    /**
     * Helper function to download invoice PDFs.
     *
     * @param array $ids
     *
     * @return void
     * @throws \ZipStream\Exception\FileNotFoundException
     * @throws \ZipStream\Exception\FileNotReadableException
     * @throws \ZipStream\Exception\OverflowException
     */
    private function downloadInvoicePDF(array $ids)
    {
        $invoices = Invoice::whereIn('id', $ids)
                            ->whereClientId(auth()->user()->client->id)
                            ->get();

        //generate pdf's of invoices locally
        if (! $invoices || $invoices->count() == 0) {
            return back()->with(['message' => ctrans('texts.no_items_selected')]);
        }

        //if only 1 pdf, output to buffer for download
        if ($invoices->count() == 1) {
            $invoice = $invoices->first();
            $invitation = $invoice->invitations->first();
           //$file = $invoice->pdf_file_path($invitation);
           $file = $invoice->service()->getInvoicePdf(auth()->user());
           // return response()->download($file, basename($file), ['Cache-Control:' => 'no-cache'])->deleteFileAfterSend(true);;
            return response()->streamDownload(function () use($file) {
                    echo Storage::get($file);
            },  basename($file), ['Content-Type' => 'application/pdf']);
        }

        // enable output of HTTP headers
        $options = new Archive();
        $options->setSendHttpHeaders(true);

        // create a new zipstream object
        $zip = new ZipStream(date('Y-m-d').'_'.str_replace(' ', '_', trans('texts.invoices')).'.zip', $options);

        foreach ($invoices as $invoice) {

            #add it to the zip
            $zip->addFile(basename($invoice->pdf_file_path()), file_get_contents($invoice->pdf_file_path(null, 'url', true)));

        }

        // finish the zip stream
        $zip->finish();
    }
}
