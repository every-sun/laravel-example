<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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

    public function indexLikedComments(Request $request){
        $data = (new Comment)::whereIn('id', (new CommentLike)::where('user_id', Auth::id())->pluck('comment_id'))->withCount('likes')->with(['post', 'user'])->orderByDesc('created_at')->paginate(10);
        return Inertia::render('MyPage/Comment/Index', [
            'data' => $data
        ]);
    }
}
