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

namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gateways\Mollie\Mollie3dsRequest;
use App\Models\PaymentHash;

class Mollie3dsController extends Controller
{
    public function index(Mollie3dsRequest $request)
    {
        return $request->getCompanyGateway()
            ->driver($request->getClient())
            ->process3dsConfirmation($request);
    }
}
