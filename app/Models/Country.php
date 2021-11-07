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

namespace App\Models;

class Country extends StaticModel
{
    public $timestamps = false;

    protected $casts = [
        'eea' => 'boolean',
        'swap_postal_code' => 'boolean',
        'swap_currency_symbol' => 'boolean',
        'thousand_separator' => 'string',
        'decimal_separator' => 'string',
        'updated_at' => 'timestamp',
        'created_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ];

    /**
     * Localizes the country name for the clients language.
     *
     * @return string The translated country name
     */
    public function getName() :string
    {
        return trans('texts.country_'.$this->name);
    }
}
