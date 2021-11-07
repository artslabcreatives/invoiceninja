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
use App\Utils\Traits\SavesDocuments;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class UploadController extends Controller
{
    use SavesDocuments;

    /**
     * Main logic behind uploading the files.
     *
     * @param StoreUploadRequest $request
     * @return Response|ResponseFactory
     */
    public function __invoke(StoreUploadRequest $request)
    {
        $this->saveDocuments($request->getFile(), auth()->user()->client, true);

        return response([], 200);
    }
}
