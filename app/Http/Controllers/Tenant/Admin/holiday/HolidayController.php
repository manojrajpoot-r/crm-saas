<?php

namespace App\Http\Controllers\tenant\admin\holiday;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Holiday;
use App\Traits\UniversalCrud;
class HolidayController extends Controller
{
    use UniversalCrud;
    public function index(Request $request)
    {
        $holidays = Holiday::latest()->paginate(10);

        if ($request->ajax()) {
            return view('tenant.admin.holiday.table', compact('holidays'))->render();
        }

        return view('tenant.admin.holiday.index', compact('holidays'));
    }

     public function store(Request $request)
    {

        return $this->saveData($request, Holiday::class);
    }


 public function edit($id)
{
    $t = Holiday::findOrFail($id);

    $json = [
        "fields" => [
            "title" => [
                "type"  => "text",
                "value" => $t->title
            ],
            "date" => [
                "type"  => "date",
                "value" => $t->date
            ],
                "type" => [
                "type"=>"select",
                "value"=>$t->type,
                "options"=>[
                    ["id"=>"national","name"=>"National Holiday"],
                    ["id"=>"festival","name"=>"Festival Holiday"],
                    ["id"=>"optional","name"=>"Optional Holiday"],
                    ["id"=>"company","name"=>"Company Holiday"],
                    ["id"=>"regional","name"=>"Regional Holiday"],

                ]
            ],
            "is_optional" => [
                "type"  => "checkbox",
                "value" => $t->is_optional ? 1 : 0
            ],
            "description" => [
                "type"  => "textarea",
                "value" => $t->description
            ],
        ]
    ];

    return response()->json($json);
}


    public function update(Request $request, $id)
    {

         return $this->saveData($request, Holiday::class, $id);

    }


    public function delete($id)
    {
        return $this->deleteData(
            Holiday::class,
            $id,


        );
    }


    public function status($id)
    {
        return $this->toggleStatus(Holiday::class, $id);
    }
}
