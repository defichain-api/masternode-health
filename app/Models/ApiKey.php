<?php

namespace App\Models;

use App\Models\Concerns\UsesUuidPrimary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @mixin \Eloquent
 * @property string  id
 * @property integer throttle
 * @property boolean is_active
 * @property Carbon  created_at
 * @property Carbon  updated_at
 */
class ApiKey extends Model
{
    use HasFactory, UsesUuidPrimary;

    protected $fillable = [
        'throttle',
        'is_active',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function key(): string
    {
        return $this->id;
    }
}
