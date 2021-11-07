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

namespace App\Http\Requests\Design;

use App\Http\Requests\Request;

class StoreDesignRequest extends Request
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
        return [
            //'name' => 'required',
            'name' => 'required|unique:designs,name,null,null,company_id,'.auth()->user()->companyId(),
            'design' => 'required',
        ];
    }

    protected function prepareForValidation()
    {
        $input = $this->all();

        if (! array_key_exists('product', $input['design']) || is_null($input['design']['product'])) {
            $input['design']['product'] = '';
        }

        if (! array_key_exists('task', $input['design']) || is_null($input['design']['task'])) {
            $input['design']['task'] = '';
        }

        if (! array_key_exists('includes', $input['design']) || is_null($input['design']['includes'])) {
            $input['design']['includes'] = '';
        }
        
        if (! array_key_exists('footer', $input['design']) || is_null($input['design']['footer'])) {
            $input['design']['footer'] = '';
        }
        
        if (! array_key_exists('header', $input['design']) || is_null($input['design']['header'])) {
            $input['design']['header'] = '';
        }

        if (! array_key_exists('body', $input['design']) || is_null($input['design']['body'])) {
            $input['design']['body'] = '';
        }

        $this->replace($input);
    }
}
