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

namespace App\Mail\Migration;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StripeConnectMigration extends Mailable
{
    // use Queueable, SerializesModels;

    public $company;

    public $settings;

    public $logo;

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
        $this->whitelabel = $this->company->account->isPaid();

        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject(ctrans('texts.stripe_connect_migration_title'))
                    ->view('email.migration.stripe_connect');
    }
}
