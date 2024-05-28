<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterMeter extends Model
{
    use HasFactory;
    protected $fillable = [
        'device_id',
        'value',
        'taken_at',
    ];
    protected $casts = [
        'taken_at' => 'datetime',
    ];
}
