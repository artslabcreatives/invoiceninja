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

use App\Events\Credit\CreditWasMarkedSent;
use App\Models\Credit;
use App\Utils\Ninja;

class MarkSent
{
    private $client;

    private $credit;

    public function __construct($client, $credit)
    {
        $this->client = $client;
        $this->credit = $credit;
    }

    public function run()
    {

        /* Return immediately if status is not draft */
        if ($this->credit->status_id != Credit::STATUS_DRAFT) {
            return $this->credit;
        }

        $this->credit->markInvitationsSent();

        event(new CreditWasMarkedSent($this->credit, $this->credit->company, Ninja::eventVars(auth()->user() ? auth()->user()->id : null)));

        $this->credit
             ->service()
             ->setStatus(Credit::STATUS_SENT)
             ->applyNumber()
             ->adjustBalance($this->credit->amount)
             ->deletePdf()
             ->save();


        return $this->credit;
    }
}
