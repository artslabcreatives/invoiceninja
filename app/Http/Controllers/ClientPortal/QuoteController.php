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

use App\Events\Misc\InvitationWasViewed;
use App\Events\Quote\QuoteWasApproved;
use App\Events\Quote\QuoteWasViewed;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientPortal\Quotes\ProcessQuotesInBulkRequest;
use App\Http\Requests\ClientPortal\Quotes\ShowQuoteRequest;
use App\Http\Requests\ClientPortal\Quotes\ShowQuotesRequest;
use App\Jobs\Invoice\InjectSignature;
use App\Models\Quote;
use App\Utils\Ninja;
use App\Utils\TempFile;
use App\Utils\Traits\MakesHash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipStream\Option\Archive;
use ZipStream\ZipStream;

class QuoteController extends Controller
{
    use MakesHash;

    /**
     * Display a listing of the quotes.
     *
     * @return Factory|View
     */
    public function index(ShowQuotesRequest $request)
    {
        return $this->render('quotes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param ShowQuoteRequest $request
     * @param Quote $quote
     * @return Factory|View|BinaryFileResponse
     */
    public function show(ShowQuoteRequest $request, Quote $quote)
    {
        $data = [
            'quote' => $quote,
        ];


            $invitation = $quote->invitations()->where('client_contact_id', auth()->user()->id)->first();

            if ($invitation && auth()->guard('contact') && ! request()->has('silent') && ! $invitation->viewed_date) {

                $invitation->markViewed();

                event(new InvitationWasViewed($quote, $invitation, $quote->company, Ninja::eventVars()));
                event(new QuoteWasViewed($invitation, $invitation->company, Ninja::eventVars()));
            
            }

        if ($request->query('mode') === 'fullscreen') {
            return render('quotes.show-fullscreen', $data);
        }

        return $this->render('quotes.show', $data);
    }

    public function bulk(ProcessQuotesInBulkRequest $request)
    {
        $transformed_ids = $this->transformKeys($request->quotes);

        if ($request->action == 'download') {
            return $this->downloadQuotePdf((array) $transformed_ids);
        }

        if ($request->action = 'approve') {
            return $this->approve((array) $transformed_ids, $request->has('process'));
        }

        return back();
    }

    protected function downloadQuotePdf(array $ids)
    {
        $quotes = Quote::whereIn('id', $ids)
            ->whereClientId(auth()->user()->client->id)
            ->get();

        if (! $quotes || $quotes->count() == 0) {
            return redirect()
                ->route('client.quotes.index')
                ->with('message', ctrans('texts.no_quotes_available_for_download'));
        }

        if ($quotes->count() == 1) {

           $file = $quotes->first()->service()->getQuotePdf();
           // return response()->download($file, basename($file), ['Cache-Control:' => 'no-cache'])->deleteFileAfterSend(true);
           return response()->streamDownload(function () use($file) {
                    echo Storage::get($file);
            },  basename($file), ['Content-Type' => 'application/pdf']);
        }

        // enable output of HTTP headers
        $options = new Archive();
        $options->setSendHttpHeaders(true);

        // create a new zipstream object
        $zip = new ZipStream(date('Y-m-d').'_'.str_replace(' ', '_', trans('texts.invoices')).'.zip', $options);

        foreach ($quotes as $quote) {
            $zip->addFile(basename($quote->pdf_file_path()), file_get_contents($quote->pdf_file_path(null, 'url', true)));

            // $zip->addFileFromPath(basename($quote->pdf_file_path()), TempFile::path($quote->pdf_file_path()));
        }

        // finish the zip stream
        $zip->finish();
    }

    protected function approve(array $ids, $process = false)
    {
        $quotes = Quote::whereIn('id', $ids)
            ->where('client_id', auth('contact')->user()->client->id)
            ->where('company_id', auth('contact')->user()->client->company_id)
            ->where('status_id', Quote::STATUS_SENT)
            ->get();

        if (!$quotes || $quotes->count() == 0) {
            return redirect()
                ->route('client.quotes.index')
                ->with('message', ctrans('texts.quotes_with_status_sent_can_be_approved'));
        }

        if ($process) {
            foreach ($quotes as $quote) {
                $quote->service()->approve(auth()->user())->save();
                event(new QuoteWasApproved(auth('contact')->user(), $quote, $quote->company, Ninja::eventVars()));

                if (request()->has('signature') && !is_null(request()->signature) && !empty(request()->signature)) {
                    InjectSignature::dispatch($quote, request()->signature);
                }
            }

            return redirect()
                ->route('client.quotes.index')
                ->withSuccess('Quote(s) approved successfully.');
        }

        return $this->render('quotes.approve', [
            'quotes' => $quotes,
        ]);
    }
}
