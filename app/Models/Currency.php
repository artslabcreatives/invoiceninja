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

class Currency extends StaticModel
{
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        'exchange_rate' => 'float',
        'swap_currency_symbol' => 'boolean',
        'updated_at' => 'timestamp',
        'created_at' => 'timestamp',
        'deleted_at' => 'timestamp',
        //'precision' => 'string',
        'precision' => 'integer',
    ];
}
