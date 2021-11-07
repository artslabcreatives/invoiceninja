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

namespace App\Repositories;

use App\Models\Document;
use App\Utils\Ninja;

/**
 * Class for document repository.
 */
class DocumentRepository extends BaseRepository
{
    public function delete($document)
    {
        $document->deleteFile();
        $document->forceDelete();
    }

    public function restore($document)
    {
        if (! $document->trashed()) {
            return;
        }

        $document->restore();

        // if (class_exists($className)) {
        //     event(new $className($document, $document->company, Ninja::eventVars()));
        // }
    }
}
