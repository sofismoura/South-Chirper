<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Chirp;
use App\Models\Notification; // 🔥 IMPORTANTE
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Chirp $chirp)
    {
        $request->validate([
            'message' => 'required|max:255'
        ]);

        Comment::create([
            'message' => $request->message,
            'user_id' => Auth::id(),
            'chirp_id' => $chirp->id
        ]);

        // 🔔 só notifica se NÃO for você mesma
        if ($chirp->user_id != Auth::id()) {
            Notification::create([
                'user_id' => $chirp->user_id,
                'from_user_id' => Auth::id(),
                'type' => 'comment',
                'chirp_id' => $chirp->id
            ]);
        }

        return back();
    }
}