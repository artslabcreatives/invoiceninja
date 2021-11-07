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

namespace App\Http\Requests\ClientPortal;

use App\Http\Requests\Request;
use App\Utils\Traits\MakesHash;

class UpdateClientRequest extends Request
{
    use MakesHash;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->encodePrimaryKey(auth()->user()->id) === request()->segment(3);
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|required',
            'file' => 'sometimes|nullable|max:100000|mimes:png,svg,jpeg,gif,jpg,bmp',
        ];
    }
}
