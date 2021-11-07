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

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use App\Http\ValidationRules\UniqueUserRule;

class UpdateUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return auth()->user()->id == $this->user->id || auth()->user()->isAdmin();
    }

    public function rules()
    {
        $input = $this->all();

        $rules = [
            'password' => 'nullable|string|min:6',
        ];

        if (isset($input['email'])) {
            $rules['email'] = ['email', 'sometimes', new UniqueUserRule($this->user, $input['email'])];
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        $input = $this->all();

        if(array_key_exists('email', $input))
            $input['email'] = trim($input['email']);

        $this->replace($input);
    }
}
