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

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BouncedEmail extends Mailable 
{

    public $invitation;

    public function __construct($invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $entity_type = class_basename(lcfirst($this->invitation->getEntityType()));

        $subject = ctrans("texts.notification_{$entity_type}_bounced_subject", ['invoice' => $invoice->number]);
        
        return
            $this->from(config('mail.from.address'), config('mail.from.name'))
                ->text()
                ->subject($subject);

    }
    
}
