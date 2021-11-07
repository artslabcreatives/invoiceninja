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

namespace App\Services\Quote;

use App\Models\Quote;
use App\Utils\Traits\GeneratesCounter;

class ApplyNumber
{
    use GeneratesCounter;

    private $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function run($quote)
    {
        if ($quote->number != '') {
            return $quote;
        }

        switch ($this->client->getSetting('counter_number_applied')) {
            case 'when_saved':
                $quote->number = $this->getNextQuoteNumber($this->client, $quote);
                break;
            case 'when_sent':
                if ($quote->status_id == Quote::STATUS_SENT) {
                    $quote->number = $this->getNextQuoteNumber($this->client, $quote);
                }
                break;

            default:
                // code...
                break;
        }

        return $quote;
    }
}
