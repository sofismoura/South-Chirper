<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Chirp;
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

        return back();
    }
}