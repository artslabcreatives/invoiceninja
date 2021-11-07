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

namespace App\DataMapper;

class PaymentTransaction
{
    public $transaction_id;

    public $gateway_response;

    public $account_gateway_id;

    public $type_id;

    public $status; // prepayment|payment|response|completed

    public $invoices;
}
