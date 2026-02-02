<?php

namespace App\Http\Controllers\Tenant\Admin\comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\UniversalCrud;
use App\Models\Tenant\Comment;
use App\Models\Tenant\Post;
use App\Models\Tenant\Project;
class CommentController extends Controller
{        use UniversalCrud;


    public function index(Request $request)
    {
        $req_id = base64_decode($request->id);
        $project = Project::findOrFail($req_id);

        $comments = Comment::with(['user','documents'])->where('project_id', $req_id)->latest()->paginate(10);

        if ($request->ajax()) {
            return view('tenant.admin.comments.table', compact('comments'))->render();
        }

        return view('tenant.admin.comments.index', compact('project','comments'));
    }



        public function show($id)
        {
            $comment = Comment::findOrFail($id);

            return response()->json([
                'description' => $comment->comment,
                'created_at' => $this->formatDate($comment->created_at),
            ]);
        }

    public function store(Request $request)
    {

        return $this->saveData($request, Comment::class);
    }

     // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {

        $t = Comment::find($id);
        $json=[
            "fields" => [
                    "comment" => ["type"=>"textarea", "value"=>$t->comment],
            ]];
        return response()->json($json);
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update(Request $request, $id)
    {

         return $this->saveData($request, Comment::class, $id);

    }

    // ===============================
    // DELETE
    // ===============================
    public function delete($id)
    {
        return $this->deleteData( Comment::class, $id);
    }


    // ===============================
    // STATUS
    // ===============================
    public function status($id)
    {
        return $this->toggleStatus(Comment::class, $id);
    }

}
