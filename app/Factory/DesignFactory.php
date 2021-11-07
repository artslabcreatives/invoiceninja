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

namespace App\Factory;

use App\Models\Design;

class DesignFactory
{
    public static function create(int $company_id, int $user_id) :Design
    {
        $design = new Design();
        $design->user_id = $user_id;
        $design->company_id = $company_id;
        $design->is_deleted = false;
        $design->is_active = true;
        $design->is_custom = true;
        $design->name = '';
        $design->design = '';

        return $design;
    }
}
