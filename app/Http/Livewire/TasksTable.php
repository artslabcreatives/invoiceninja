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
use App\Models\Task;
use App\Utils\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class TasksTable extends Component
{
    use WithSorting;
    use WithPagination;

    public $per_page = 10;

    public $company;

    public function mount()
    {
        MultiDB::setDb($this->company->db);
    }

    public function render()
    {
        $query = Task::query()
            ->where('company_id', $this->company->id)
            ->where('client_id', auth('contact')->user()->client->id);

        if ($this->company->getSetting('show_all_tasks_client_portal') === 'invoiced') {
            $query = $query->whereNotNull('invoice_id');
        }

        if ($this->company->getSetting('show_all_tasks_client_portal') === 'uninvoiced') {
            $query = $query->whereNull('invoice_id');
        }

        $query = $query
            ->orderBy($this->sort_field, $this->sort_asc ? 'asc' : 'desc')
            ->withTrashed()
            ->paginate($this->per_page);

        return render('components.livewire.tasks-table', [
            'tasks' => $query,
        ]);
    }
}
