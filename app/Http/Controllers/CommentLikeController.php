<?php

namespace App\Http\Controllers;

use App\Models\CommentLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentLikeController extends Controller
{
    public function storeCommentLike(Request $request, $comment_id) {
         (new CommentLike)::create([
            'user_id'=> Auth::id(),
            'comment_id'=>$comment_id,
        ]);
    }

    public function destroyCommentLike(Request $request, $comment_id) {
        (new CommentLike)::where('user_id', Auth::id())->where('comment_id', $comment_id)->delete();
    }
}
