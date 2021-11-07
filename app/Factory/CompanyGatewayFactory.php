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

use App\DataMapper\FeesAndLimits;
use App\Models\CompanyGateway;

class CompanyGatewayFactory
{
    public static function create(int $company_id, int $user_id) :CompanyGateway
    {
        $company_gateway = new CompanyGateway;
        $company_gateway->company_id = $company_id;
        $company_gateway->user_id = $user_id;
        $company_gateway->require_billing_address = false;
        $company_gateway->require_shipping_address = false;
        // $company_gateway->fees_and_limits = new FeesAndLimits;
        
        return $company_gateway;
    }
}
