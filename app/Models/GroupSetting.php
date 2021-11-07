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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupSetting extends StaticModel
{
    use MakesHash;
    use SoftDeletes;

    //public $timestamps = false;

    protected $casts = [
        'settings' => 'object',
        'updated_at' => 'timestamp',
        'created_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ];

    protected $fillable = [
        'name',
        'settings',
    ];

    protected $appends = [
        'hashed_id',
    ];

    public function getHashedIdAttribute()
    {
        return $this->encodePrimaryKey($this->id);
    }
    
    protected $touches = [];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function clients()
    {
        return $this->hasMany(Client::class, 'id', 'group_settings_id');
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
    
    /**
     * Retrieve the model for a bound value.
     *
     * @param mixed $value
     * @param null $field
     * @return Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this
            ->where('id', $this->decodePrimaryKey($value))->firstOrFail();
    }
}
