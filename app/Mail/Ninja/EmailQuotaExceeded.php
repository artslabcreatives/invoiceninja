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

namespace App\Mail\Ninja;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailQuotaExceeded extends Mailable
{

    public $company;

    public $settings;

    public $logo;

    public $title;

    public $body;

    public $whitelabel;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company)
    {
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->settings = $this->company->settings;
        $this->logo = $this->company->present()->logo();
        $this->title = ctrans('texts.email_quota_exceeded_subject');
        $this->body = ctrans('texts.email_quota_exceeded_body', ['quota' => $this->company->account->getDailyEmailLimit()]);
        $this->whitelabel = $this->company->account->isPaid();
        $this->replyTo('contact@invoiceninja.com', 'Contact');

        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject(ctrans('texts.email_quota_exceeded_subject'))
                    ->view('email.admin.email_quota_exceeded');
    }
}
