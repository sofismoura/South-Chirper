<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function fromUser()
{
    return $this->belongsTo(User::class, 'from_user_id');
}

protected $fillable = [
    'user_id',
    'from_user_id',
    'type',
    'chirp_id'
];
}
