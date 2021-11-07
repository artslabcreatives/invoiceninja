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

namespace App\Http\Requests\ClientPortal\Credits;

use App\Http\ViewComposers\PortalComposer;
use Illuminate\Foundation\Http\FormRequest;

class ShowCreditsRequest extends FormRequest
{
    public function authorize()
    {
        return auth('contact')->user()->company->enabled_modules & PortalComposer::MODULE_CREDITS;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
