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

namespace App\Http\Controllers\ClientPortal;

use App\Http\Controllers\Controller;
use App\Models\ClientContact;
use App\Utils\Traits\MakesHash;
use Illuminate\Support\Facades\Auth;

class SwitchCompanyController extends Controller
{
    use MakesHash;

    public function __invoke(string $contact)
    {
        $client_contact = ClientContact::where('email', auth()->user()->email)
            ->where('id', $this->transformKeys($contact))
            ->first();

        auth()->guard('contact')->login($client_contact, true);

        return redirect('/client/dashboard');
    }
}
