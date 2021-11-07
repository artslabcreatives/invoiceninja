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

use App\DataMapper\CompanySettings;
use App\Models\CompanyUser;

class CompanyUserFactory
{
    public static function create($user_id, $company_id, $account_id) :CompanyUser
    {
        $company_user = new CompanyUser;
        $company_user->user_id = $user_id;
        $company_user->company_id = $company_id;
        $company_user->account_id = $account_id;
        $company_user->notifications = CompanySettings::notificationDefaults();

        return $company_user;
    }
}
