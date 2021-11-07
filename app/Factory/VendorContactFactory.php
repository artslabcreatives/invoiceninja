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

namespace App\Factory;

use App\Models\VendorContact;

class VendorContactFactory
{
    public static function create(int $company_id, int $user_id) :VendorContact
    {
        $vendor_contact = new VendorContact;
        $vendor_contact->first_name = '';
        $vendor_contact->user_id = $user_id;
        $vendor_contact->company_id = $company_id;
        $vendor_contact->id = 0;

        return $vendor_contact;
    }
}
