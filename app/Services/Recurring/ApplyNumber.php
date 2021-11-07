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

namespace App\Services\Recurring;

use App\Models\Client;
use App\Services\AbstractService;
use App\Utils\Traits\GeneratesCounter;

class ApplyNumber extends AbstractService
{
    use GeneratesCounter;

    private $client;

    private $recurring_entity;

    public function __construct(Client $client, $recurring_entity)
    {
        $this->client = $client;

        $this->recurring_entity = $recurring_entity;
    }

    /* Recurring numbers are set when saved */
    public function run()
    {
        if ($this->recurring_entity->number != '')
            return $this->recurring_entity;

        $this->recurring_entity->number = $this->getNextRecurringInvoiceNumber($this->client, $this->recurring_entity);

        return $this->recurring_entity;
    }
}
