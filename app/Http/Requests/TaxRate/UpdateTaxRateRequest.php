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

namespace App\Http\Requests\TaxRate;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class UpdateTaxRateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules()
    {
        $rules = [];

        $rules['rate'] = 'numeric';

        if($this->number)
            $rules['number'] = Rule::unique('tax_rates')->where('company_id', auth()->user()->company()->id)->ignore($this->tax_rate->id);

        return $rules;

    }
}
