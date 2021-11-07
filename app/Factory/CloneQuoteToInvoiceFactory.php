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

use App\Models\Invoice;
use App\Models\Quote;

class CloneQuoteToInvoiceFactory
{
    public static function create(Quote $quote, $user_id) : ?Invoice
    {
        $invoice = new Invoice();

        $quote_array = $quote->toArray();

        unset($quote_array['client']);
        unset($quote_array['company']);
        unset($quote_array['hashed_id']);
        unset($quote_array['invoice_id']);
        unset($quote_array['id']);
        unset($quote_array['invitations']);
        unset($quote_array['terms']);
        // unset($quote_array['public_notes']);
        unset($quote_array['footer']);
        unset($quote_array['design_id']);
        unset($quote_array['user']);

        
        foreach ($quote_array as $key => $value) {
            $invoice->{$key} = $value;
        }

        $invoice->status_id = Invoice::STATUS_DRAFT;
        $invoice->due_date = null;
        $invoice->partial_due_date = null;
        $invoice->number = null;
        $invoice->date = now()->format('Y-m-d');
        $invoice->balance = 0;
        $invoice->deleted_at = null;
        
        return $invoice;
    }
}
