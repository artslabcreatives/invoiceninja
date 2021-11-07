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

use App\Models\Subscription;

class SubscriptionObserver
{
    /**
     * Handle the billing_subscription "created" event.
     *
     * @param Subscription $billing_subscription
     * @return void
     */
    public function created(Subscription $subscription)
    {
        //
    }

    /**
     * Handle the billing_subscription "updated" event.
     *
     * @param Subscription $billing_subscription
     * @return void
     */
    public function updated(Subscription $subscription)
    {
        //
    }

    /**
     * Handle the billing_subscription "deleted" event.
     *
     * @param Subscription $billing_subscription
     * @return void
     */
    public function deleted(Subscription $subscription)
    {
        //
    }

    /**
     * Handle the billing_subscription "restored" event.
     *
     * @param Subscription $billing_subscription
     * @return void
     */
    public function restored(Subscription $subscription)
    {
        //
    }

    /**
     * Handle the billing_subscription "force deleted" event.
     *
     * @param Subscription $billing_subscription
     * @return void
     */
    public function forceDeleted(Subscription $subscription)
    {
        //
    }
}
