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

namespace App\Services\Quote;

use App\Factory\ClientContactFactory;
use App\Factory\QuoteInvitationFactory;
use App\Models\Quote;
use App\Models\QuoteInvitation;
use App\Utils\Traits\MakesHash;
use Illuminate\Support\Str;

class CreateInvitations
{
    use MakesHash;
    
    public $quote;

    public function __construct(Quote $quote)
    {
        $this->quote = $quote;
    }

    public function run()
    {

       $contacts = $this->quote->client->contacts;

        if($contacts->count() == 0){
            $this->createBlankContact();

            $this->quote->refresh();
            $contacts = $this->quote->client->contacts;
        }

        $contacts->each(function ($contact){
            $invitation = QuoteInvitation::whereCompanyId($this->quote->company_id)
                ->whereClientContactId($contact->id)
                ->whereQuoteId($this->quote->id)
                ->withTrashed()
                ->first();

            if (! $invitation && $contact->send_email) {
                $ii = QuoteInvitationFactory::create($this->quote->company_id, $this->quote->user_id);
                $ii->key = $this->createDbHash(config('database.default'));
                $ii->quote_id = $this->quote->id;
                $ii->client_contact_id = $contact->id;
                $ii->save();
            } elseif ($invitation && ! $contact->send_email) {
                $invitation->delete();
            }
        });

        return $this->quote->fresh();
    }

    private function createBlankContact()
    {
        $new_contact = ClientContactFactory::create($this->quote->company_id, $this->quote->user_id);
        $new_contact->client_id = $this->quote->client_id;
        $new_contact->contact_key = Str::random(40);
        $new_contact->is_primary = true;
        $new_contact->save();
    }

}
