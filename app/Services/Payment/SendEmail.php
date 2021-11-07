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

namespace App\Services\Payment;

use App\Jobs\Payment\EmailPayment;

class SendEmail
{
    public $payment;

    public $contact;

    public function __construct($payment, $contact)
    {
        $this->payment = $payment;

        $this->contact = $contact;
    }

    /**
     * Builds the correct template to send.
     * @return void
     */
    public function run()
    {
        $this->payment->load('company', 'client.contacts');

        $this->payment->client->contacts->each(function ($contact) {
            if ($contact->email) {
                EmailPayment::dispatchNow($this->payment, $this->payment->company, $contact);
            }
        });
    }
}
