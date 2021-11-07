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

namespace App\Mail\ClientContact;

use App\Utils\Ninja;
use Illuminate\Support\Facades\App;

class ClientContactResetPasswordObject
{

    public $client_contact;

    public $token;

    private $company;
    /**
     *
     */
    public function __construct($token, $client_contact)
    {
        $this->token = $token;
        $this->client_contact = $client_contact;
        $this->company = $client_contact->company;
    }

    public function build()
    {

        App::forgetInstance('translator');
        $t = app('translator');
        App::setLocale($this->client_contact->preferredLocale());
        $t->replace(Ninja::transformTranslations($this->client_contact->client->getMergedSettings()));


        $data = [
            'title' => ctrans('texts.your_password_reset_link'),
            'content' => ctrans('texts.reset_password'),
            'url' => route('client.password.reset', ['token' => $this->token, 'email' => $this->client_contact->email]),
            'button' => ctrans('texts.reset'),
            'signature' => $this->company->settings->email_signature,
            'settings' => $this->company->settings,
            'company' => $this->company,
            'logo' => $this->company->present()->logo(),
        ];


        $mail_obj = new \stdClass;
        $mail_obj->subject = ctrans('texts.your_password_reset_link');
        $mail_obj->data = $data;
        $mail_obj->markdown = 'email.client.generic';
        $mail_obj->tag = $this->company->company_key;

        return $mail_obj;
    }
}
