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

trait WithSorting
{
    public $sort_field = 'id'; // Default sortBy. Feel free to change or pull from client/company settings.
    public $sort_asc = true;

    public function sortBy($field)
    {
        $this->sort_field === $field
            ? $this->sort_asc = ! $this->sort_asc
            : $this->sort_asc = true;

        $this->sort_field = $field;
    }
}
