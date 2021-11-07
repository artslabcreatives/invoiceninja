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

use App\Http\Requests\Request;
use App\Http\ViewComposers\PortalComposer;

class ShowInvoiceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return auth('contact')->user()->client->id == $this->invoice->client_id
            &&  auth('contact')->user()->company->enabled_modules & PortalComposer::MODULE_INVOICES;
    }
}
