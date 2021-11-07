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

namespace App\Observers;

use App\Models\ClientContact;

class ClientContactObserver
{
    /**
     * Handle the client contact "created" event.
     *
     * @param ClientContact $clientContact
     * @return void
     */
    public function created(ClientContact $clientContact)
    {
        //
    }

    /**
     * Handle the client contact "updated" event.
     *
     * @param ClientContact $clientContact
     * @return void
     */
    public function updated(ClientContact $clientContact)
    {
        //
    }

    /**
     * Handle the client contact "deleted" event.
     *
     * @param ClientContact $clientContact
     * @return void
     */
    public function deleted(ClientContact $clientContact)
    {
        $clientContact->invoice_invitations()->delete();
        $clientContact->quote_invitations()->delete();
        $clientContact->credit_invitations()->delete();
    }

    /**
     * Handle the client contact "restored" event.
     *
     * @param ClientContact $clientContact
     * @return void
     */
    public function restored(ClientContact $clientContact)
    {
        $clientContact->invoice_invitations()->restore();
        $clientContact->quote_invitations()->restore();
        $clientContact->credit_invitations()->restore();
    }

    /**
     * Handle the client contact "force deleted" event.
     *
     * @param ClientContact $clientContact
     * @return void
     */
    public function forceDeleted(ClientContact $clientContact)
    {
        //
    }
}
