<?php

namespace App\Http\Controllers\Tenant\Admin\post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Post;
use App\Models\Tenant\Project;
use App\Models\Tenant\Comment;
use App\Traits\UniversalCrud;
use Illuminate\Support\Facades\Auth;
class PostController extends Controller
{
       use UniversalCrud;

    public function index(Request $request)
    {
        $id = base64_decode($request->id);
        $project = Project::findOrFail($id);

        $posts = Post::with('uploader')
            ->where('project_id', $project->id)
            ->latest()
            ->paginate(10);

        if ($request->ajax()) {
            return view('tenant.admin.posts.table', compact('posts'))->render();
        }

        return view('tenant.admin.posts.index', compact('project','posts'));
    }



    public function store(Request $request)
    {

        return $this->saveData($request, Post::class);
    }

    public function show($id)
    {
        $post = Post::with('documents')->findOrFail($id);

        $documents = $post->documents->map(function ($doc) {
            $ext = strtolower(pathinfo($doc->file, PATHINFO_EXTENSION));

            $icon = match ($ext) {
                'pdf' => asset('assets/img/icons/pdf.png'),
                'doc', 'docx' => asset('assets/img/icons/word.png'),
                'xls', 'xlsx' => asset('assets/img/icons/excel.png'),
                'zip', 'rar' => asset('assets/img/icons/zip.png'),
                default => asset('assets/img/icons/file.png'),
            };

            return [
                'id' => $doc->id,
                'name' => basename($doc->file_path),
                'url' => asset('uploads/posts/documents/' . $doc->file_path),
                'icon' => $icon,
            ];
        });

        return response()->json([
            'title' => $post->title,
            'description' => $post->description,
            'documents' => $documents,
            'created_at' => $this->formatDate($post->created_at),
        ]);
    }

    public function edit($id)
    {

        $t = Post::find($id);
        $json=[
            "fields" => [
                    "name" => ["type"=>"text", "value"=>$t->name],
                    "description" => ["type"=>"textarea", "value"=>$t->description],
            ]];
        return response()->json($json);
    }


    public function update(Request $request, $id)
    {

         return $this->saveData($request, Post::class, $id);

    }

    public function delete($id)
    {
        return $this->deleteData(
            Post::class,
            $id,


        );
    }

    public function status($id)
    {
        return $this->toggleStatus(Post::class, $id);
    }
}