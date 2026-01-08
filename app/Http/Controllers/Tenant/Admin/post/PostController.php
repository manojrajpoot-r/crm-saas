<?php

namespace App\Http\Controllers\Tenant\Admin\post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Post;
use App\Models\Tenant\Project;
use App\Traits\UniversalCrud;
use Illuminate\Support\Facades\Auth;
class PostController extends Controller
{

       use UniversalCrud;

    public function index(Request $request)
    {
        $id =$request->id;
        $project = Project::findOrFail($id);
        return view('tenant.admin.posts.index',compact('project'));
    }

    public function list(Request $request)
    {

        $projectId = $request->project_id;
       $query = Post::with('uploader')
        ->withCount('comments')
        ->where('project_id', $projectId)
        ->latest();


        return datatables()->of($query)
            ->addIndexColumn()
          ->addColumn('uploaded_by', function ($t) {

                if ($t->uploader) {

                    $profile = $t->uploader->profile
                        ? asset('uploads/tenantusers/profile/' . $t->uploader->profile)
                        : asset('images/default-profile.png');

                    $name = $t->uploader->name ?? 'Unknown';

                    return "
                        <div class='d-flex align-items-center gap-2'>
                            <img src='{$profile}'
                                width='35' height='35'
                                style='border-radius:50%; object-fit:cover'>
                            <span>{$name}</span>
                        </div>
                    ";
                }

                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='".asset('images/default-profile.png')."'
                            width='35' height='35'
                            style='border-radius:50%; object-fit:cover'>
                        <span>Unknown</span>
                    </div>
                ";
            })

            ->addColumn('description', function ($t) {

                $desc = strip_tags($t->description ?? '');

                if (strlen($desc) > 100) {
                    $desc = substr($desc, 0, 100) . '...';
                }

                $date = $t->created_at
                    ? $t->created_at->format('d M Y')
                    : '-';

                return "
                    <div>
                        <div class='fw-semibold'>{$desc}</div>
                        <small class='text-muted'>Created: {$date}</small>
                    </div>
                ";
            })

            ->addColumn('status_btn', function ($t) {
                if (!canAccess('post status')) {
                    return "<span class='badge bg-secondary'>No Access</span>";
                }

                $class = $t->status ? "btn-success" : "btn-danger";
                $text = $t->status ? "Active" : "Inactive";
                $url = route('tenant.posts.status',  $t->id);

                return "<button class='btn btn-sm $class statusBtn' data-url='$url'>$text</button>";
            })

            ->addColumn('action', function ($t) {
                $buttons = '';

                if (canAccess('post edit')) {
                    $editUrl = route('tenant.posts.edit', $t->id);
                    $buttons .= "<button class='btn btn-info btn-sm editBtn' data-url='$editUrl'>Edit</button> ";
                }

                if (canAccess('post delete')) {
                    $deleteUrl = route('tenant.posts.delete',  $t->id);
                    $buttons .= "<button class='btn btn-danger btn-sm deleteBtn' data-url='$deleteUrl'>Delete</button> ";
                }


                if (!canAccess('comment add')) {
                    return '';
                }
                $Auth_id = Auth::id();
                $post ="post";
               $buttons .= "
                    <button class='btn btn-secondary btn-sm dynamicGlobalModal'
                         data-title='Comment Posts'
                        data-comment_type='{$post}'
                        data-id='{$t->id}'
                          data-user_id='{$Auth_id}'
                        data-url='".route('tenant.comments.store')."'>
                        Comment
                    </button>";

                  $buttons .= "
                    <button class='btn btn-sm btn-outline-primary viewComments'
                        data-url='".route('tenant.comments.index',['id'=> $t->id])."'>
                        View Comments ({$t->comments_count})
                    </button>";

                return $buttons ?: 'No Action';
            })

            ->rawColumns(['uploaded_by','description','status_btn','action'])
            ->make(true);
    }

     // ===============================
    // CREATE / STORE
    // ===============================

    public function store(Request $request)
    {

        return $this->saveData($request, Post::class);
    }


    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {

        $t = Post::find($id);
        $json=[
            "name" => $t->name,
        ];
        return response()->json($json);
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update(Request $request, $id)
    {

         return $this->saveData($request, Post::class, $id);

    }

    // ===============================
    // DELETE
    // ===============================
    public function delete($id)
    {
        return $this->deleteData(
            Post::class,
            $id,


        );
    }


    // ===============================
    // STATUS
    // ===============================
    public function status($id)
    {
        return $this->toggleStatus(Post::class, $id);
    }
}