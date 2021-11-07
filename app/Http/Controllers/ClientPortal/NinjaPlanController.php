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
use App\Http\Requests\ClientPortal\Uploads\StoreUploadRequest;
use App\Libraries\MultiDB;
use App\Models\Account;
use App\Models\ClientContact;
use App\Models\Company;
use App\Utils\Ninja;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class NinjaPlanController extends Controller
{

    public function index(string $contact_key, string $account_or_company_key)
    {
        MultiDB::findAndSetDbByCompanyKey($account_or_company_key);
        $company = Company::where('company_key', $account_or_company_key)->first();

        if(!$company){
            MultiDB::findAndSetDbByAccountKey($account_or_company_key);
            $account = Account::where('key', $account_or_company_key)->first();
        }
        else
            $account = $company->account;

        if (MultiDB::findAndSetDbByContactKey($contact_key) && $client_contact = ClientContact::where('contact_key', $contact_key)->first())
        {            
        
            nlog("Ninja Plan Controller - Found and set Client Contact");
            
            Auth::guard('contact')->login($client_contact,true);

            /* Current paid users get pushed straight to subscription overview page*/
            if($account->isPaidHostedClient())
                return redirect('/client/dashboard');

            /* Users that are not paid get pushed to a custom purchase page */
            return $this->render('subscriptions.ninja_plan', ['settings' => $client_contact->company->settings]);
        }

        return redirect()->route('client.catchall');

    }
}
