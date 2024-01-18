<?php

namespace App\Http\Controllers;

use App\Models\CommentLike;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
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
            $viewedIds = Cache::get('posts_history');
            if(is_null($viewedIds)){
                $viewedIds = [];
            }
            if(!in_array((int)$id, $viewedIds)){
                $history = array_merge($viewedIds, [(int)$id]);
                Cache::store('redis')->put('posts_history', $history, 600);
            }
            $post = (new Post)::with('user')->withCount('comments')->findOrFail($id);
            $comments = $post->comments()->where('parent_id', null)->with(['user', 'replies'])->withCount('likes')->orderByDesc('created_at')->paginate(10);
            $user_like_comments = [];
            if(Auth::check()){
                $user_like_comments = (new CommentLike)::whereIn('comment_id', $comments->pluck('id'))->where('user_id', Auth::id())->pluck('comment_id');
            }
            return Inertia::render('Post/Show/Index', [
                'data'=>$post,
                'comments_data'=>$comments,
                'user_like_comments'=>$user_like_comments
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
            'title'=>'required|max:255',
            'content'=>'required'
        ]);
        $post = (new Post)::create([
            'user_id'=> Auth::id(),
            'title'=> $request->input('title'),
            'content'=> $request->input('content'),
        ]);
        return to_route('post.show', ['id'=>$post->id]);
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
            'title'=>'required|max:255',
            'content'=>'required'
        ]);
        (new Post)::findOrFail($id)->update([
            'title'=> $request->input('title'),
            'content'=> $request->input('content'),
        ]);
        return to_route('post.show', ['id'=>$request->route('id')]);
    }
    public function destroyPost(Request $request, $id) {
        (new Post)::destroy($id);
    }

    public function indexMyPosts(Request $request):Response{
        $post = (new Auth)::user()->posts()->with('user')->withCount('comments')->orderByDesc('created_at')->paginate(10);
        return Inertia::render('Post/Index', [
            'data'=> $post
        ]);
    }

    public function indexPostsHistory(Request $request){
        $ids = Cache::get('posts_history');
        if(is_null($ids)){
            $ids = [];
        }
        $post = (new Post)::whereIn('id', $ids)->with('user')->withCount('comments')->orderByDesc('created_at')->paginate(10);
        return Inertia::render('Post/Index', [
            'data'=>$post
        ]);
    }

    public function searchPostsIndex(Request $request){
        $input = $request->input('query');
        $post = (new Post)::where('title', 'like', '%' . $input . '%')->orWhere('content', 'like', '%' . $input . '%')
            ->orWhereHas('user', function(Builder $query) use($input) {
                $query->where('name', 'like', '%' . $input . '%');
            })->with('user')->withCount('comments')->orderByDesc('created_at')->paginate(10);
        return Inertia::render('Post/Index', [
            'data'=> $post
        ]);
    }
}
