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

namespace App\Http\Requests\Payments;

use App\Http\Requests\Request;
use App\Libraries\MultiDB;
use App\Models\Client;
use App\Models\Company;
use App\Models\CompanyGateway;
use App\Models\Payment;
use App\Models\PaymentHash;
use App\Utils\Traits\MakesHash;

class PaymentWebhookRequest extends Request
{
    use MakesHash;

    public function authorize()
    {
        MultiDB::findAndSetDbByCompanyKey($this->company_key);

        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Resolve company gateway.
     *
     * @param mixed $id
     * @return null|\App\Models\CompanyGateway
     */
    public function getCompanyGateway()
    {
        return CompanyGateway::findOrFail($this->decodePrimaryKey($this->company_gateway_id));
    }

    /**
     * Resolve payment hash.
     *
     * @param string $hash
     * @return null|\App\Models\PaymentHash
     */
    public function getPaymentHash()
    {
        if ($this->query('hash')) {
            return PaymentHash::where('hash', $this->query('hash'))->firstOrFail();
        }

        return false;
    }

    /**
     * Resolve company from company_key parameter.
     *
     * @return null|\App\Models\Company
     */
    public function getCompany(): ?Company
    {
        return Company::where('company_key', $this->company_key)->firstOrFail();
    }
}
