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

namespace App\Listeners\Invoice;

use App\Jobs\Entity\CreateEntityPdf;
use App\Libraries\MultiDB;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateInvoicePdf implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        MultiDB::setDb($event->company->db);

        if(isset($event->invoice))
        {
            $event->invoice->invitations->each(function ($invitation) {
                CreateEntityPdf::dispatch($invitation);
            });
        }

        if(isset($event->quote))
        {
            $event->quote->invitations->each(function ($invitation) {
                CreateEntityPdf::dispatch($invitation);
            });
        }

        if(isset($event->credit))
        {
            $event->credit->invitations->each(function ($invitation) {
                CreateEntityPdf::dispatch($invitation);
            });
        }

    }
}
