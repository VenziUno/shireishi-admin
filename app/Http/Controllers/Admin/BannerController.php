<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Repository\BannerRepository;
use App\Repository\GamesRepository;
use App\Http\Requests\BannerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helper\Helper;

class BannerController extends Controller
{
    protected $banner;
    
    function __construct()
    {
        $this->game = new GamesRepository;
        $this->banner = new BannerRepository;
    }

    public function index()
    {
        $data['game'] = $this->game->getData();
        $content = view('banner.view', $data);
        return view('main', compact('content'));
    }
    
    function data(Request $request)
    {
        $data['banner'] = $this->banner->getData(10);
        return view('banner.data', $data);
    }

    function addView()
    {
        $data['game'] = $this->game->getData();
        $data['banner'] = $this->banner->getLastOrder();
        if($data['banner'] && $data['banner']->order != NULL){
            $data['order'] = $data['banner']->order + 1;
        }
        else{
            $data['order'] = 1;
        }
        $content = view('banner.add', $data);
        return view('main', compact('content'));
    }

    function addPost(BannerRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->banner->addData();
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
        $data['game'] = $this->game->getData();
        $data['banner'] = $this->banner->getSingleData($id);
        $content = view('banner.edit', $data);
        return view('main', compact('content'));
    }

    function editPatch(BannerRequest $request ,$id)
    {
        DB::beginTransaction();
        try {
             $this->banner->updateData($id);
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

    function editStatus(Request $request ,$id, $status)
    {
        DB::beginTransaction();
        try {
             $this->banner->updateStatus($id, $status);
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

    function delete($id)
    {
        DB::beginTransaction();
        try {
            $this->banner->deleteData($id);
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

    function upload(Request $request, $type){        
        if($type == 1){
            $file = $request->file('image');
            $this->validate($request, [
                'image' => 'mimes:jpg,jpeg,png,mp4,mov,ogg,qt|max:20000',
            ],[
                'image.mimes' => 'Harus dalam format jpeg, jpg, png, mp4, mov, ogg, qt ',
                'image.max' => 'Max. 20 MB',
            ]);
        }
        else{
            $file = $request->file('thumbnail');
            $this->validate($request, [
                'thumbnail' => 'mimes:jpg,jpeg,png,mp4,mov,ogg,qt|max:20000',
            ],[
                'thumbnail.mimes' => 'Harus dalam format jpeg, jpg, png, mp4, mov, ogg, qt ',
                'thumbnail.max' => 'Max. 20 MB',
            ]);
        }
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file_name = str_replace(" ", "_", $name);  
        $storage = Storage::disk('s3')->putFileAs('banner' , $file , $file_name);
        $explode = explode('.', $file_name);
        if(end($explode) == 'jpg' || end($explode) == 'jpeg' || end($explode) == 'png' || end($explode) == 'JPG' || end($explode) == 'JPEG' || end($explode) == 'PNG'){
            $result = [
                'name' => $file->getClientOriginalName(),
                'link' => Helper::serveImage($storage),
                'path' => 'banner/'.$file_name,
            ];
        }
        else{
            $result = [
                'name' => $file->getClientOriginalName(),
                'link' => Helper::staticPath($storage),
                'path' => 'banner/'.$file_name,
                'namepath' => $file_name,
            ];
        }
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
