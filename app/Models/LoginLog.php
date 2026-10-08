<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'login_method',
        'country',
        'city',
        'latitude',
        'longitude',
        'login_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}