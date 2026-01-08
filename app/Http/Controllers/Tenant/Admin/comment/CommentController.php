<?php

namespace App\Http\Controllers\Tenant\Admin\comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\UniversalCrud;
use App\Models\Tenant\Comment;
use App\Models\Tenant\Post;
class CommentController extends Controller
{        use UniversalCrud;
    public function index(Request $request)
    {
        $id = $request->id;
         $post = Post::findOrFail($id);
        $comments = $post->comments()->with('user')->latest()->get();
        return response()->json($comments);
    }

    public function store(Request $request)
    {

        return $this->saveData($request, Comment::class);
    }

}