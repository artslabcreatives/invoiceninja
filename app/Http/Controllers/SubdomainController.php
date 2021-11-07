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

namespace App\Http\Controllers;

use App\Libraries\MultiDB;

class SubdomainController extends BaseController
{
    private $protected = [
        'www',
        'app',
        'ninja',
        'sentry',
        'staging',
        'pdf',
        'demo',
        'docs',
        'client_domain',
        'custom_domain',
        'preview',
        'invoiceninja',
        'cname',
        'sandbox',
        'stage',
    ];

    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {

        if(in_array(request()->input('subdomain'), $this->protected) || MultiDB::findAndSetDbByDomain(['subdomain' => request()->input('subdomain')]))
            return response()->json(['message' => 'Domain not available'] , 401);

        return response()->json(['message' => 'Domain available'], 200);
    }

}
