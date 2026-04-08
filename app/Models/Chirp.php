<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Chirp extends Model
{
    // Permite salvar esses campos no banco
    protected $fillable = [
        'user_id',
        'message',
    ];

    // Relacionamento: cada chirp pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
{
    return $this->hasMany(\App\Models\Like::class);
}
}