<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function createPost(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $user = User::find(auth()->user()->id);

        $user->posts()->create([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return response()->json(['message' => 'Berhasil membuat post'], 201);
    }

    public function getMyPosts() {
        $user = User::find(auth()->user()->id);
        $posts = $user->posts;

        return response()->json($posts, 200);
    }

    public function getPosts(){
        $posts = Post::paginate(10);

        return response()->json($posts, 200);
    }
}
