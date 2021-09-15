<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @mixin \Eloquent
 * @property Carbon  date
 * @property integer api_key_count
 * @property integer webhook_sent_count
 * @property integer request_received_count
 */
class Statistic extends Model
{
    public $timestamps = false;
    protected $dateFormat = 'Y-m-d';
    protected $fillable = [
        'date',
        'api_key_count',
        'webhook_sent_count',
        'request_received_count',
    ];
    protected $hidden = [
        'id',
    ];
}
