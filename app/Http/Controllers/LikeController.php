<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Chirp;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Chirp $chirp)
    {
        $like = Like::where('user_id', Auth::id())
            ->where('chirp_id', $chirp->id)
            ->first();

        if ($like) {
            $like->delete(); // descurtir
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'chirp_id' => $chirp->id
            ]);
        }

        return back();
    }
}