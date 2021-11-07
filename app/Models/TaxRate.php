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

use App\Utils\Traits\MakesHash;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaxRate extends BaseModel
{
    use MakesHash;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'rate',
    ];

    // protected $appends = ['tax_rate_id'];

    public function getEntityType()
    {
        return self::class;
    }

    public function getRouteKeyName()
    {
        return 'tax_rate_id';
    }

    public function getTaxRateIdAttribute()
    {
        return $this->encodePrimaryKey($this->id);
    }
}
