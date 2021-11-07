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

namespace App\Services\Credit;

use App\Models\Client;
use App\Models\Credit;
use App\Services\AbstractService;
use App\Utils\Traits\GeneratesCounter;

class ApplyNumber extends AbstractService
{
    use GeneratesCounter;

    private $client;

    private $credit;

    public function __construct(Client $client, Credit $credit)
    {
        $this->client = $client;

        $this->credit = $credit;
    }

    public function run()
    {
        if ($this->credit->number != '') {
            return $this->credit;
        }

        $this->credit->number = $this->getNextCreditNumber($this->client, $this->credit);

        return $this->credit;
    }
}
