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

namespace App\Events\Document;

use App\Models\Company;
use App\Models\Document;
use Illuminate\Queue\SerializesModels;

/**
 * Class DocumentWasRestored.
 */
class DocumentWasRestored
{
    use SerializesModels;

    /**
     * @var Document
     */
    public $document;

    public $company;

    public $event_vars;

    public $fromDeleted;
    /**
     * Create a new event instance.
     *
     * @param Document $document
     * @param Company $company
     * @param array $event_vars
     */
    public function __construct(Document $document, $fromDeleted, Company $company, array $event_vars)
    {
        $this->document = $document;
        $this->fromDeleted = $fromDeleted;
        $this->company = $company;
        $this->event_vars = $event_vars;
    }
}
