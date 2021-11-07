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

namespace App\Mail\Company;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyDeleted extends Mailable
{
    // use Queueable, SerializesModels;

    public $account;

    public $company;

    public $user;

    public $settings;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company, $user, $account, $settings)
    {
        $this->company = $company;
        $this->user = $user;
        $this->account = $account;
        $this->settings = $settings;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject(ctrans('texts.company_deleted'))
            ->view('email.admin.company_deleted')
            ->with([
                'settings' => $this->settings,
                'logo' => '',
                'title' => ctrans('texts.company_deleted'),
                'body' => ctrans('texts.company_deleted_body', ['company' => $this->company, 'user' => $this->user->present()->name(), 'time' => now()]),
                'whitelabel' => $this->account->isPaid(),
            ]);
    }
}
