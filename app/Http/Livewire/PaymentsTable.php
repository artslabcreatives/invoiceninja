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
use App\Models\Payment;
use App\Utils\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentsTable extends Component
{
    use WithSorting;
    use WithPagination;

    public $per_page = 10;

    public $user;

    public $company;
    
    public function mount()
    {
        MultiDB::setDb($this->company->db);

        $this->user = auth()->user();

    }

    public function render()
    {
        $query = Payment::query()
            ->with('type', 'client')
            ->whereIn('status_id', [Payment::STATUS_COMPLETED, Payment::STATUS_PENDING, Payment::STATUS_REFUNDED, Payment::STATUS_PARTIALLY_REFUNDED])
            ->where('company_id', $this->company->id)
            ->where('client_id', auth('contact')->user()->client->id)
            ->orderBy($this->sort_field, $this->sort_asc ? 'asc' : 'desc')
            ->withTrashed()
            ->paginate($this->per_page);

        return render('components.livewire.payments-table', [
            'payments' => $query,
        ]);
    }
}
