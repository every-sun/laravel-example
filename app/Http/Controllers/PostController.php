<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function indexPosts() : Response{
        $post = (new Post)::with('user')->withCount('comments')->orderByDesc('created_at')->paginate(10);
        return Inertia::render('Post/Index', [
            'data' => $post
        ]);
    }
    public function showPost(Request $request, $id) {
        try{
            $post = (new Post)::with('user')->withCount('comments')->findOrFail($id);
            $comments = $post->comments()->where('parent_id', null)->with(['user', 'replies'])->orderByDesc('created_at')->paginate(10);
            return Inertia::render('Post/Show/Index', [
                'data'=>$post,
                'comments_data'=>$comments
            ]);
        }catch (ModelNotFoundException $err){
            return Inertia::location(route('posts.index'));
        }
    }
    public function createPost(){
        return Inertia::render('Post/Create/Index');
    }
    public function storePost(Request $request){
        $request->validate([
            'title'=>'required|max:40',
            'content'=>'required'
        ]);
        (new Post)::create([
            'user_id'=> Auth::id(),
            'title'=> $request->input('title'),
            'content'=> $request->input('content'),
        ]);
        return to_route('posts.index');
    }
    public function editPost(Request $request, $id) {
        try{
            $post = (new Post)::findOrFail($id);
            return Inertia::render('Post/Create/Index', [
                'data'=>$post
            ]);
        }catch (ModelNotFoundException $err){
            return Inertia::location(route('posts.index'));
        }
    }
    public function updatePost(Request $request, $id) {
        $request->validate([
            'title'=>'required|max:40',
            'content'=>'required'
        ]);
        (new Post)::findOrFail($id)->update([
            'title'=> $request->input('title'),
            'content'=> $request->input('content'),
        ]);
        return to_route('post.show', ['id'=>$request->route('id')]);
    }
    public function destroyPost(Request $request, $id) {
        (new Post)::findOrFail($id)->delete();
        return to_route('posts.index');
    }

    public function indexMyPosts(Request $request):Response{
        $post = (new Auth)::user()->posts()->with('user')->paginate(10);
        return Inertia::render('Post/Index', [
            'data'=> $post
        ]);
    }
}
