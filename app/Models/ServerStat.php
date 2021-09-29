<?php

namespace App\Models;

use App\Models\Concerns\UsesUuidPrimary;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \Eloquent
 * @property string id
 * @property ApiKey apiKey
 * @property string api_key_id
 * @property string type
 * @property string value
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class ServerStat extends Model
{
    use UsesUuidPrimary, HasFactory;

    protected $fillable = [
        'api_key_id',
        'type',
        'value',
    ];
    protected $hidden = [
        'id',
        'api_key_id',
        'created_at',
        'updated_at',
    ];

    public function apiKey(): BelongsTo
    {
        return $this->belongsTo(ApiKey::class, 'api_key_id');
    }
}
