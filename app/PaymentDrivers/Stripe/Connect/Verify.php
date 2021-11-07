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

namespace App\PaymentDrivers\Stripe\Connect;

use App\Exceptions\PaymentFailed;
use App\Exceptions\StripeConnectFailure;
use App\Http\Requests\ClientPortal\PaymentMethod\VerifyPaymentMethodRequest;
use App\Http\Requests\Request;
use App\Jobs\Mail\NinjaMailerJob;
use App\Jobs\Mail\NinjaMailerObject;
use App\Jobs\Util\SystemLogger;
use App\Mail\Gateways\ACHVerificationNotification;
use App\Models\ClientGatewayToken;
use App\Models\GatewayType;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\SystemLog;
use App\PaymentDrivers\StripePaymentDriver;
use App\Utils\Traits\MakesHash;
use Exception;
use Stripe\Customer;
use Stripe\Exception\CardException;
use Stripe\Exception\InvalidRequestException;

class Verify
{
    use MakesHash;

    /** @var StripePaymentDriver */

    public $stripe;

    public function __construct(StripePaymentDriver $stripe)
    {
        $this->stripe = $stripe;
    }

    public function run()
    {
        $this->stripe->init();

        if($this->stripe->stripe_connect && strlen($this->stripe->company_gateway->getConfigField('account_id')) < 1)
            throw new StripeConnectFailure('Stripe Connect has not been configured');

        $customers = Customer::all([], $this->stripe->stripe_connect_auth);

        $stripe_customers = $this->stripe->company_gateway->client_gateway_tokens->map(function ($cgt){

            $customer = Customer::retrieve($cgt->gateway_customer_reference, $this->stripe->stripe_connect_auth);

            return [
                'customer' => $cgt->gateway_customer_reference, 
                'record' => $customer
            ];

        });

        $data = [
            'stripe_customer_count' => count($customers),
            'stripe_customers' => $stripe_customers,
        ];

        return response()->json($data, 200);
    }
}