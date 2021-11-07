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

namespace App\Services\Ledger;

use App\Factory\CompanyLedgerFactory;
use App\Models\Activity;
use App\Models\CompanyLedger;

class LedgerService
{
    private $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function updateInvoiceBalance($adjustment, $notes = '')
    {
        $balance = 0;

        \DB::connection(config('database.default'))->beginTransaction();

        $company_ledger = $this->ledger();

        if ($company_ledger) {
            $balance = $company_ledger->balance;
        }

        $company_ledger = CompanyLedgerFactory::create($this->entity->company_id, $this->entity->user_id);
        $company_ledger->client_id = $this->entity->client_id;
        $company_ledger->adjustment = $adjustment;
        $company_ledger->notes = $notes;
        $company_ledger->balance = $balance + $adjustment;
        $company_ledger->activity_id = Activity::UPDATE_INVOICE;
        $company_ledger->save();

        $this->entity->company_ledger()->save($company_ledger);

        \DB::connection(config('database.default'))->commit();

        return $this;
    }

    public function updatePaymentBalance($adjustment, $notes = '')
    {
        $balance = 0;

        \DB::connection(config('database.default'))->beginTransaction();

        /* Get the last record for the client and set the current balance*/
        $company_ledger = $this->ledger();

        if ($company_ledger) {
            $balance = $company_ledger->balance;
        }

        $company_ledger = CompanyLedgerFactory::create($this->entity->company_id, $this->entity->user_id);
        $company_ledger->client_id = $this->entity->client_id;
        $company_ledger->adjustment = $adjustment;
        $company_ledger->balance = $balance + $adjustment;
        $company_ledger->activity_id = Activity::UPDATE_PAYMENT;
        $company_ledger->notes = $notes;
        $company_ledger->save();

        $this->entity->company_ledger()->save($company_ledger);

        \DB::connection(config('database.default'))->commit();
        
        return $this;
    }

    public function updateCreditBalance($adjustment, $notes = '')
    {
        $balance = 0;
        
        \DB::connection(config('database.default'))->beginTransaction();

        $company_ledger = $this->ledger();

        if ($company_ledger) {
            $balance = $company_ledger->balance;
        }

        $company_ledger = CompanyLedgerFactory::create($this->entity->company_id, $this->entity->user_id);
        $company_ledger->client_id = $this->entity->client_id;
        $company_ledger->adjustment = $adjustment;
        $company_ledger->notes = $notes;
        $company_ledger->balance = $balance + $adjustment;
        $company_ledger->activity_id = Activity::UPDATE_CREDIT;
        $company_ledger->save();

        $this->entity->company_ledger()->save($company_ledger);

        \DB::connection(config('database.default'))->commit();
        
        return $this;
    }

    private function ledger() :?CompanyLedger
    {
        return CompanyLedger::whereClientId($this->entity->client_id)
                        ->whereCompanyId($this->entity->company_id)
                        ->orderBy('id', 'DESC')
                        ->lockForUpdate()
                        ->first();
    }

    public function save()
    {
        $this->entity->save();

        return $this->entity;
    }
}

/*
        DB::connection(config('database.default'))->beginTransaction();

        \DB::connection(config('database.default'))->commit();


*/
