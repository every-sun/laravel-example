<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
class PostController extends Controller
{
    public function indexPosts() : Response{
        return Inertia::render('Post/Index', [
            'data' => Post::paginate(10)
        ]);
    }
    public function showPost(Request $request) {
        $post = Post::find($request->route('id'));
        if(!$post){
            return Inertia::location(route('posts.index'));
        }
        return Inertia::render('Post/Show/Index', [
            'data'=>Post::find($request->route('id'))
        ]);
    }
    public function createPost(){
        return Inertia::render('Post/Create/Index');
    }
    public function storePost(Request $request){
        $request->validate([
            'title'=>'required|max:40',
            'writer'=>'required',
            'content'=>'required'
        ]);
        Post::create([
            'user_id'=> Auth::id(),
            'title'=> $request->input('title'),
            'writer'=>$request->input('writer'),
            'content'=> $request->input('content'),
        ]);
        return to_route('posts.index');
    }
    public function editPost(Request $request) {
        $post = Post::find($request->route('id'));
        if(!$post){
            return Inertia::location(route('posts.index'));
        }
        return Inertia::render('Post/Create/Index', [
            'data'=>$post
        ]);
    }
    public function updatePost(Request $request) {
        $request->validate([
            'title'=>'required|max:40',
            'writer'=>'required',
            'content'=>'required'
        ]);
        Post::find($request->route('id'))->update([
            'title'=> $request->input('title'),
            'writer'=>$request->input('writer'),
            'content'=> $request->input('content'),
        ]);
        return to_route('post.show', ['id'=>$request->route('id')]);
    }
    public function destroyPost(Request $request) {
        Post::find($request->route('id'))->delete();
        return to_route('posts.index');
    }

    public function indexMyPosts(Request $request):Response{
        $post = Auth::user()->posts()->paginate(10);
        return Inertia::render('Post/Index', [
            'data'=> $post
        ]);
    }
}
