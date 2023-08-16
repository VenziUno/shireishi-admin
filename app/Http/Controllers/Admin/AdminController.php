<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\AdminEditRequest;
use Illuminate\Support\Facades\DB;
use App\Repository\AdminRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helper\Helper;

class AdminController extends Controller
{
    protected $admin;
    
    function __construct()
    {
        $this->admin = new AdminRepository;
    }

    public function index()
    {
        $content = view('admin.view');
        return view('main', compact('content'));
    }
    
    function data(Request $request, $status)
    {
        $data['status'] = $status;
        $data['admin'] = $this->admin->getData(10, $status);

        return view('admin.data', $data);
    }

    function addView()
    {
        $data['group'] = $this->admin->getAdminGroup();
        $content = view('admin.add', $data);
        return view('main', compact('content'));
    }

    function addPost(AdminRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->admin->addData();
            DB::commit();
            $message = [
                'status' => true,
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
        $data['group'] = $this->admin->getAdminGroup();
        $data['admin'] = $this->admin->getSingleData($id);
        $content = view('admin.edit', $data);
        return view('main', compact('content'));
    }

    function editPatch(AdminEditRequest $request ,$id)
    {
        DB::beginTransaction();
        try {
             $this->admin->updateData($id);
            DB::commit();
            $message = [
                'status' => true,
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

    function passwordView($id)
    {
        $data['admin'] = $this->admin->getSingleData($id);
        $content = view('admin.passchange', $data);
        return view('main', compact('content'));
    }

    function passwordChange(Request $request ,$id)
    {
        $request->validate([
            'password' => 'required',
        ]);
        
        DB::beginTransaction();
        try {
            $this->admin->changepass($id);
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

    function delete($id)
    {
        DB::beginTransaction();
        try {
            $this->admin->deleteData($id);
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

    function archive($id)
    {
        DB::beginTransaction();
        try {
            $this->admin->archiveData($id);
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

    function unarchive($id)
    {
        DB::beginTransaction();
        try {
            $this->admin->unarchiveData($id);
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

    function upload(Request $request){        
        $file = $request->file('cover_image');
        $this->validate($request, [
            'cover_image' => 'mimes:jpg,jpeg,png|max:5000',
        ],[
            'cover_image.mimes' => 'Harus format jpeg, jpg atau png',
            'cover_image.max' => 'Maksimal 5 MB',
        ]);
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension(); 
        $file_name = str_replace(" ", "_", $name);  
        $storage = Storage::disk('s3')->putFileAs('admin/' , $file , $file_name);
        $result = [
            'name' => $file->getClientOriginalName(),
            'link' => Helper::serveImage($storage),
            'path' => 'admin/'.$file_name,
        ];
        return response()->json($result, 200);
    }
}
