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
        $post = Post::findOrFail($request->id);

        $comments = $post->comments()
            ->with(['user', 'documents'])
            ->latest()
            ->get()
            ->map(function ($comment) {

                $documents = $comment->documents->map(function ($doc) {

                    $ext = strtolower(pathinfo($doc->file, PATHINFO_EXTENSION));

                    $icon = match ($ext) {
                        'pdf' => asset('assets/img/icons/pdf.png'),
                        'doc', 'docx' => asset('assets/img/icons/word.png'),
                        'xls', 'xlsx' => asset('assets/img/icons/excel.png'),
                        'zip', 'rar' => asset('assets/img/icons/zip.png'),
                        default => asset('assets/img/icons/file.png'),
                    };

                    return [
                        'id'   => $doc->id,
                        'name' => basename($doc->file),
                        'url'  => asset('uploads/comments/documents/' . $doc->file),
                        'icon' => $icon,
                    ];
                });

                return [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'created_at' => $comment->created_at->format('Y-m-d'),

                    'user' => [
                        'id' => $comment->user->id,
                        'name' => strtoupper($comment->user->name),
                    ],

                    'documents' => $documents,
                ];
            });

        return response()->json($comments);
    }






    public function store(Request $request)
    {

        return $this->saveData($request, Comment::class);
    }

}
