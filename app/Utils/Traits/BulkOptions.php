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

namespace App\Utils\Traits;

trait BulkOptions
{
    /**
     * Store method in requests.
     *
     * @var string
     */
    public static $STORE_METHOD = 'create';

    /**
     * Default chunk size.
     *
     * @var int
     */
    public static $CHUNK_SIZE = 100;

    /**
     * Default queue for bulk processing.
     *
     * @var string
     */
    public static $DEFAULT_QUEUE = 'bulk_processing';

    /**
     * Available bulk options - used in requests (eg. BulkClientRequests).
     *
     * @return array
     * @var array
     */
    public function getBulkOptions()
    {
        return [
            'create', 'edit', 'view',
        ];
    }

    /**
     * Shared rules for bulk requests.
     *
     * @return array
     * @var array
     */
    public function getGlobalRules()
    {
        return [
            'action' => ['required'],
        ];
    }
}
