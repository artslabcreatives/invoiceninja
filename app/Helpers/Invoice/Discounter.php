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

namespace App\Helpers\Invoice;

/**
 * Class for discount calculations.
 */
trait Discounter
{
    public function discount($amount)
    {
        if ($this->invoice->is_amount_discount == true) {
            return $this->invoice->discount;
        }

        return round($amount * ($this->invoice->discount / 100), 2);
    }
}
