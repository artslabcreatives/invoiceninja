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
use App\Models\Quote;
use App\Utils\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class QuotesTable extends Component
{
    use WithSorting;
    use WithPagination;

    public $per_page = 10;

    public $status = [];

    public $company;
    
    public function mount()
    {
        MultiDB::setDb($this->company->db);

    }

    public function render()
    {
        $query = Quote::query()
            ->orderBy($this->sort_field, $this->sort_asc ? 'asc' : 'desc');

        if (count($this->status) > 0) {
            $query = $query->whereIn('status_id', $this->status);
        }

        $query = $query
            ->where('company_id', $this->company->id)
            ->where('client_id', auth('contact')->user()->client->id)
            ->where('status_id', '<>', Quote::STATUS_DRAFT)
            ->withTrashed()
            ->paginate($this->per_page);

        return render('components.livewire.quotes-table', [
            'quotes' => $query,
        ]);
    }
}
