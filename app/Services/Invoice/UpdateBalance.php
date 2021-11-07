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

namespace App\Services\Invoice;

use App\Models\Invoice;
use App\Services\AbstractService;

class UpdateBalance extends AbstractService
{
    public $invoice;

    public $balance_adjustment;

    private $is_draft;

    public function __construct($invoice, $balance_adjustment, bool $is_draft)
    {
        $this->invoice = $invoice;
        $this->balance_adjustment = $balance_adjustment;
        $this->is_draft = $is_draft;
    }

    public function run()
    {
        if ($this->invoice->is_deleted) {
            return $this->invoice;
        }

        $this->invoice->balance += floatval($this->balance_adjustment);
        
        if ($this->invoice->balance == 0 && !$this->is_draft) {
            $this->invoice->status_id = Invoice::STATUS_PAID;
        }

        return $this->invoice;
    }
}
