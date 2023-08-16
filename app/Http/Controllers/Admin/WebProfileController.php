<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repository\WebRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helper\Helper;
use App\Http\Requests\WebProfileRequest;

class WebProfileController extends Controller
{
    protected $web;
    
    function __construct()
    {
        $this->web = new WebRepository;
    }

    public function index()
    {
        $data['web'] = $this->web->getSingleData(1);
        $content = view('web_profile.view', $data);
        return view('main', compact('content'));
    }

    function editPatch(WebProfileRequest $request)
    {
        DB::beginTransaction();
        try {
            $data= $this->web->getSingleData(1);
            if($data){
                $this->web->updateData(1);
            }
            else{
                $this->web->createData();
            }
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

    function upload(Request $request){        
        $file = $request->file('imagelink');
        $this->validate($request, [
            'imagelink' => 'mimes:jpg,jpeg,png,svg|max:5000',
        ],[
            'imagelink.mimes' => 'Harus format jpeg, jpg, svg atau png',
            'imagelink.max' => 'Maksimal 5 MB',
        ]);
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension(); 
        $file_name = str_replace(" ", "_", $name);  
        $storage = Storage::disk('s3')->putFileAs('web_profile/' , $file , $file_name);
        $result = [
            'name' => $file->getClientOriginalName(),
            'link' => Helper::serveImage($storage),
            'path' => 'web_profile/'.$file_name,
        ];
        return response()->json($result, 200);
    }

    public function uploadContent(Request $request) {    
        if($request->hasFile('upload')) {
            $file = $request->file('upload');

            $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension(); 
            $file_name = str_replace(" ", "_", $name);  
            $storage = Storage::disk('s3')->putFileAs('web-config/content/' , $file , $file_name);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = \App\Helper\Helper::serveImage($storage); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }  
}
