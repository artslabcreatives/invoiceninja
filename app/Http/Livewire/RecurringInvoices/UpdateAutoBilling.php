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

namespace App\Http\Livewire\RecurringInvoices;

use Livewire\Component;

class UpdateAutoBilling extends Component
{
    /** @var \App\Models\RecurringInvoice */
    public $invoice;

    public function updateAutoBilling(): void
    {
        if ($this->invoice->auto_bill == 'optin' || $this->invoice->auto_bill == 'optout') {
            $this->invoice->auto_bill_enabled = !$this->invoice->auto_bill_enabled;
            $this->invoice->saveQuietly();
        }
    }

    public function render()
    {
        return render('components.livewire.recurring-invoices-switch-autobilling');
    }
}
