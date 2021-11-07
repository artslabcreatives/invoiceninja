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

namespace App\Jobs\Mail;

use App\Jobs\Mail\NinjaMailer;
use App\Jobs\Mail\NinjaMailerJob;
use App\Jobs\Mail\NinjaMailerObject;
use App\Libraries\MultiDB;
use App\Mail\Admin\ClientPaymentFailureObject;
use App\Mail\Admin\EntityNotificationMailer;
use App\Mail\Admin\PaymentFailureObject;
use App\Models\Client;
use App\Models\Company;
use App\Models\PaymentHash;
use App\Models\User;
use App\Utils\Traits\Notifications\UserNotifies;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

/*Multi Mailer implemented*/

class PaymentFailedMailer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, UserNotifies;

    public PaymentHash $payment_hash;

    public string $error;

    public Company $company;

    public Client $client;

    /**
     * Create a new job instance.
     *
     * @param $client
     * @param $message
     * @param $company
     * @param $amount
     */
    public function __construct(?PaymentHash $payment_hash, Company $company, Client $client, string $error)
    {

        $this->payment_hash = $payment_hash;
        $this->client = $client;
        $this->error = $error;
        $this->company = $company;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        //Set DB
        MultiDB::setDb($this->company->db);

        $settings = $this->client->getMergedSettings();
        $amount = 0;

        if($this->payment_hash)
            $amount = array_sum(array_column($this->payment_hash->invoices(), 'amount')) + $this->payment_hash->fee_total;

        //iterate through company_users
        $this->company->company_users->each(function ($company_user) use($amount, $settings){        

            //determine if this user has the right permissions
            $methods = $this->findCompanyUserNotificationType($company_user, ['payment_failure','all_notifications']);

            //if mail is a method type -fire mail!!
            if (($key = array_search('mail', $methods)) !== false) {
                unset($methods[$key]);

                $mail_obj = (new PaymentFailureObject($this->client, $this->error, $this->company, $amount, $this->payment_hash))->build();

                $nmo = new NinjaMailerObject;
                $nmo->mailable = new NinjaMailer($mail_obj);
                $nmo->company = $this->company;
                $nmo->to_user = $company_user->user;
                $nmo->settings = $settings;

                NinjaMailerJob::dispatch($nmo);

            }
        });

        //add client payment failures here.
        nlog("pre client failure email");

        if($contact = $this->client->primary_contact()->first())
        {
        
        nlog("inside failure");

            $mail_obj = (new ClientPaymentFailureObject($this->client, $this->error, $this->company, $this->payment_hash))->build();

            $nmo = new NinjaMailerObject;
            $nmo->mailable = new NinjaMailer($mail_obj);
            $nmo->company = $this->company;
            $nmo->to_user = $contact;
            $nmo->settings = $settings;

            NinjaMailerJob::dispatch($nmo);
        }
        
    }



}
