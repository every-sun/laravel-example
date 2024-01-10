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
            'content'=>'required'
        ]);
        $parent_id=$request->input('parent_id');
        (new Comment)::create([
            'user_id'=> Auth::id(),
            'post_id'=>$post_id,
            'parent_id'=>$parent_id,
            'content'=> $request->input('content'),
        ]);
        return to_route('post.show', ['id'=>$post_id]);
    }

    public function updateComment(Request $request, $post_id, $id){
        try{
            $request->validate([
                'content'=>'required'
            ]);
            (new Comment)::findOrFail($id)->update([
                'content'=> $request->input('content'),
            ]);

            return to_route('post.show', ['id'=>$post_id]);
        }catch (ModelNotFoundException $err){
            return to_route('post.show', ['id'=>$post_id]);
        }
    }

    public function destroyComment(Request $request, $post_id, $id){
        try{
            (new Comment)::findOrFail($id)->delete();
            return to_route('post.show', ['id'=>$post_id]);
        }catch (ModelNotFoundException $err){
            return to_route('post.show', ['id'=>$post_id]);
        }
    }

    public function indexMyComments(Request $request){
        $data = (new Comment)::where('user_id', Auth::id())->with(['post', 'user'])->withCount('likes')->orderByDesc('created_at')->paginate(10);
        return Inertia::render('MyPage/Comment/Index', [
            'data'=>$data,
        ]);
    }
    public function destroyMyComments(Request $request, $id){
        try{
            (new Comment)::findOrFail($id)->delete();
            return to_route('user.comments.index');
        }catch (ModelNotFoundException $err){
            return to_route('user.comments.index');
        }
    }
}
