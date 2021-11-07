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

use App\Models\ClientGatewayToken;
use Illuminate\Support\Str;

class ClientGatewayTokenFactory
{
    public static function create(int $company_id) :ClientGatewayToken
    {
        $client_gateway_token = new ClientGatewayToken;
        $client_gateway_token->company_id = $company_id;
        $client_gateway_token->is_default = false;
        $client_gateway_token->meta = '';
        $client_gateway_token->is_deleted = false;
        $client_gateway_token->token = '';
        $client_gateway_token->routing_number = '';
        
        return $client_gateway_token;
    }
}
