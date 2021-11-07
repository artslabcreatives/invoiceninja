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

namespace App\Http\Livewire;

use App\Libraries\MultiDB;
use App\Models\RecurringInvoice;
use App\Utils\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class SubscriptionRecurringInvoicesTable extends Component
{
    use WithPagination;
    use WithSorting;

    public $per_page = 10;

    public $company;
    
    public function mount()
    {
        MultiDB::setDb($this->company->db);
    }
    
    public function render()
    {
        $query = RecurringInvoice::query()
            ->where('client_id', auth('contact')->user()->client->id)
            ->where('company_id', $this->company->id)
            ->whereNotNull('subscription_id')
            ->orderBy($this->sort_field, $this->sort_asc ? 'asc' : 'desc')
            ->withTrashed()
            ->paginate($this->per_page);

        return render('components.livewire.subscriptions-recurring-invoices-table', [
            'recurring_invoices' => $query,
        ]);
    }
}
