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
namespace App\Helpers\Mail;

use Illuminate\Mail\MailManager;
use App\CustomMailDriver\CustomTransport;
use Dacastro4\LaravelGmail\Services\Message\Mail;
use Illuminate\Support\Facades\Config;


class GmailTransportManager extends MailManager
{
    protected function createGmailTransport()
    {
        return new GmailTransport(new Mail);
    }
}