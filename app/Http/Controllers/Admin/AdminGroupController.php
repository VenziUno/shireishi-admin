<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminGroupRequest;
use Illuminate\Support\Facades\DB;
use App\Repository\AdminGroupRepository;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class AdminGroupController extends Controller
{
    protected $admingroup;
    
    function __construct()
    {
        $this->admingroup = new AdminGroupRepository;
    }

    public function index()
    {

        $content = view('admin_group.view');
        return view('main', compact('content'));
    }
    
    function data(Request $request)
    {

        $data['admingroup'] = $this->admingroup->getData(10);

        return view('admin_group.data', $data);
    }

    function addView()
    {
        $content = view('admin_group.add');
        return view('main', compact('content'));
    }

    function addPost(AdminGroupRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->admingroup->addData();
            DB::commit();
            $message = [
                'status' => true,
                'data' =>$data,
            ];
        } catch (\Exception $exception) {
            DB::rollback();
            $message = [
                'status' => false,
                'error' => $exception->getMessage()
            ];
        }
        return response()->json($message);
    }

    function editView($id)
    {
        $data['admingroup'] = $this->admingroup->getSingleData($id);
        $content = view('admin_group.edit', $data);
        return view('main', compact('content'));
    }

    function editPatch(AdminGroupRequest $request ,$id)
    {
        DB::beginTransaction();
        try {
             $this->admingroup->updateData($id);
            DB::commit();
            $message = [
                'status' => true,
                'data' =>$data,
            ];
        } catch (\Exception $exception) {
            DB::rollback();
            $message = [
                'status' => false,
                'error' => $exception->getMessage()
            ];
        }
        return response()->json($message);
    }

    function delete($id)
    {
        DB::beginTransaction();
        try {
            $this->admingroup->deleteData($id);
            DB::commit();
            $message = [
                'status' => true
            ];
        } catch (\Exception $exception) {
            DB::rollback();
            $message = [
                'status' => false,
                'error' => "Something Wrong"
            ];
        }
        return response()->json($message);
    }
}
