<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function storeComment(Request $request, $post_id){
        $request->validate([
            'content'=>'required'
        ]);
        (new Comment())::create([
            'user_id'=> Auth::id(),
            'post_id'=>$post_id,
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
}
