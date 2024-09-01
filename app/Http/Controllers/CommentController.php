<?php

namespace App\Http\Controllers;

use id;
use App\Models\Comment;
use Illuminate\Http\Request;

// app/Http/Controllers/CommentController.php
class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:post,id',
            'content' => 'required|string',
        ]);

        $comment = Comment::create([
           // 'user_id' => auth()->id(),
            'post_id' => $request->post_id,
            'content' => $request->content,
        ]);

        return response()->json($comment, 201);
    }

    public function index($postId)
    {
        $comments = Comment::where('post_id', $postId)->with('user')->get();
        return response()->json($comments);
    }
}
