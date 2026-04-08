<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;

class Comment extends Model
{
    protected $fillable = ['message', 'user_id', 'chirp_id'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function chirp()
    {
        return $this->belongsTo(\App\Models\Chirp::class);
    }
}