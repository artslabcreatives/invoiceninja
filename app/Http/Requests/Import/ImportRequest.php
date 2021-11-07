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

namespace App\Http\Requests\Import;

use App\Http\Requests\Request;

class ImportRequest extends Request
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
			'import_type' => 'required',
            'files' => 'required_without:hash|array|min:1|max:6',
            'hash' => 'nullable|string',
            'column_map' => 'required_with:hash|array',
            'skip_header' => 'required_with:hash|boolean',
			'files.*' => 'file|mimes:csv,txt',
        ];
    }
}
