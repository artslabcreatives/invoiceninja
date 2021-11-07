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

use App\Models\Proposal;

class ProposalObserver
{
    /**
     * Handle the proposal "created" event.
     *
     * @param Proposal $proposal
     * @return void
     */
    public function created(Proposal $proposal)
    {
        //
    }

    /**
     * Handle the proposal "updated" event.
     *
     * @param Proposal $proposal
     * @return void
     */
    public function updated(Proposal $proposal)
    {
        //
    }

    /**
     * Handle the proposal "deleted" event.
     *
     * @param Proposal $proposal
     * @return void
     */
    public function deleted(Proposal $proposal)
    {
        //
    }

    /**
     * Handle the proposal "restored" event.
     *
     * @param Proposal $proposal
     * @return void
     */
    public function restored(Proposal $proposal)
    {
        //
    }

    /**
     * Handle the proposal "force deleted" event.
     *
     * @param Proposal $proposal
     * @return void
     */
    public function forceDeleted(Proposal $proposal)
    {
        //
    }
}
