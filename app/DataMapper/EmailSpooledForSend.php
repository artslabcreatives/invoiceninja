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

namespace App\DataMapper;

/**
 * EmailSpooledForSend.
 *
 * Stubbed class used to store the meta data
 * for an email that was unable to be sent
 * for a reason such as:
 *
 *  - Quota exceeded
 *  - SMTP issues
 *  - Upstream connectivity
 */
class EmailSpooledForSend
{
    public $entity_name;

    public $invitation_key = '';

    public $reminder_template = '';

    public $subject = '';

    public $body = '';
}
