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

namespace App\Http\Requests\ExpenseCategory;

use App\Http\Requests\Request;
use App\Models\ExpenseCategory;

class StoreExpenseCategoryRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return auth()->user()->can('create', ExpenseCategory::class);
    }

    public function rules()
    {
        $rules = [];

        $rules['name'] = 'required|unique:expense_categories,name,null,null,company_id,'.auth()->user()->companyId();

        return $this->globalRules($rules);
    }

    protected function prepareForValidation()
    {
        $input = $this->all();

        $input = $this->decodePrimaryKeys($input);

        if(array_key_exists('color', $input) && is_null($input['color']))
            $input['color'] = '';

        $this->replace($input);
    }
}