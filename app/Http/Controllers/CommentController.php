<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CommentController extends Controller
{
    public function storeComment(Request $request, $post_id){
        $request->validate([
            'content'=>'required|max:255'
        ]);
        $parent_id=$request->input('parent_id');
        (new Comment)::create([
            'user_id'=> Auth::id(),
            'post_id'=>$post_id,
            'parent_id'=>$parent_id,
            'content'=> $request->input('content'),
        ]);
    }

    public function updateComment(Request $request, $post_id, $id){
        $request->validate([
            'content'=>'required|max:255'
        ]);
        (new Comment)::findOrFail($id)->update([
            'content'=> $request->input('content'),
        ]);
    }

    public function destroyComment(Request $request, $post_id, $id){
        (new Comment)::findOrFail($id)->delete();
    }

    public function indexMyComments(Request $request){
        $data = (new Comment)::where('user_id', Auth::id())->with(['post', 'user'])->withCount('likes')->orderByDesc('created_at')->paginate(10);
        return Inertia::render('MyPage/Comment/Index', [
            'data'=>$data,
        ]);
    }
}
