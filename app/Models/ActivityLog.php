<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'request_type',
        'ip_address',
        'geo_location',
        'description',
        'activity_type',
        'url',
        'changed_id',
        'data',
    ];

    protected $casts = [
        'geo_location' => 'array',
        'data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Define the user relationship
    }
}
