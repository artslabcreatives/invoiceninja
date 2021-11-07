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

/**
 * NinjaMailerObject.
 */
class NinjaMailerObject
{

    public $mailable;

    public $company;

    public $from_user; //not yet used

    public $to_user;

    public $settings;

    public $transport; //not yet used

    /* Variable for cascading notifications */
    public $entity_string = FALSE;

    public $invitation = FALSE;

    public $template = FALSE;

    public $entity = FALSE;
    
}
