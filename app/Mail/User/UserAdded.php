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

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserAdded extends Mailable
{
    // use Queueable, SerializesModels;

    public $company;

    public $user;

    public $created_user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company, $user, $created_user)
    {
        $this->company = $company;
        $this->user = $user;
        $this->created_user = $created_user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject(ctrans('texts.created_user'))
            ->view('email.admin.user_added')
            ->with([
                'settings' => $this->company->settings,
                'logo' => $this->company->present()->logo(),
                'title' => ctrans('texts.created_user'),
                'body' => ctrans('texts.user_created_user', ['user' => $this->user->present()->name(), 'created_user' => $this->created_user->present()->name(), 'time' => now()]),
                'whitelabel' => $this->company->account->isPaid(),
            ]);
    }
}
