<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \Eloquent
 * @property string  api_key_id
 * @property ApiKey  apiKey
 * @property integer max_tries
 * @property integer timeout_in_seconds
 * @property string  url
 */
class Webhook extends Model
{
    protected $fillable = [
        'api_key_id',
        'max_tries',
        'timeout_in_seconds',
        'url',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'api_key_id',
    ];

    public function apiKey(): BelongsTo
    {
        return $this->belongsTo(ApiKey::class);
    }
}
