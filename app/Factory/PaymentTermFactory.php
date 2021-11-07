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

use App\Models\PaymentTerm;

class PaymentTermFactory
{
    public static function create(int $company_id, int $user_id) :PaymentTerm
    {
        $payment_term = new PaymentTerm;
        $payment_term->user_id = $user_id;
        $payment_term->company_id = $company_id;

        return $payment_term;
    }
}
