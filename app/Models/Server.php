<?php

namespace App\Models;

use App\Models\Concerns\UsesUuidPrimary;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kurozora\Cooldown\HasCooldowns;

/**
 * @mixin \Eloquent
 * @property string id
 * @property ApiKey apiKey
 * @property string api_key_id
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Server extends Model
{
    use UsesUuidPrimary, HasCooldowns;

    protected $fillable = [
        'api_key_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function apiKey(): BelongsTo
    {
        return $this->belongsTo(ApiKey::class);
    }
}
