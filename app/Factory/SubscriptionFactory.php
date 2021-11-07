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

namespace App\Factory;

use App\Models\Subscription;

class SubscriptionFactory
{
    public static function create(int $company_id, int $user_id): Subscription
    {
        $billing_subscription = new Subscription();
        $billing_subscription->company_id = $company_id;
        $billing_subscription->user_id = $user_id;

        return $billing_subscription;
    }
}
