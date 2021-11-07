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


namespace App\Http\Requests\Migration;

use App\Http\Requests\Request;

class UploadMigrationFileRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'migration' => [],
        ];

        /* We'll skip mime validation while running tests. */
        if (app()->environment() !== 'testing') {
            $rules['migration'] = ['required', 'file', 'mimes:zip'];
        }

        return $rules;
    }
}
