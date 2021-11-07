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

namespace App\Http\Requests\ClientPortal\Invoices;

use App\Http\ViewComposers\PortalComposer;
use Illuminate\Foundation\Http\FormRequest;

class ShowInvoicesRequest extends FormRequest
{
    public function authorize()
    {
        return auth('contact')->user()->company->enabled_modules & PortalComposer::MODULE_INVOICES;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
