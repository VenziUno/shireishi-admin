<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\GamesRepository;
use App\Repository\GameCategoryRepository;
use App\Http\Requests\GamesRequest;
use Illuminate\Support\Facades\Storage;
use App\Helper\Helper;
use Illuminate\Support\Facades\DB;

class GamesController extends Controller
{
    protected $repo;
    
    function __construct()
    {
        $this->category = new GameCategoryRepository;
        $this->repo = new GamesRepository;
    }

    public function index()
    {

        $content = view('games.view');
        return view('main', compact('content'));
    }
    
    function data(Request $request)
    {
        $data['game'] = $this->repo->getData(10);
        return view('games.data', $data);
    }

    function addView()
    {
        $data['category'] = $this->category->getData();
        $data['game'] = $this->repo->getLastOrder();
        if($data['game'] && $data['game']->order != NULL){
            $data['order'] = $data['game']->order + 1;
        }
        else{
            $data['order'] = 1;
        }
        $content = view('games.add', $data);
        return view('main', compact('content'));
    }

    function addPost(GamesRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->repo->addData();
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
        $data['category'] = $this->category->getData();
        $data['game'] = $this->repo->getSingleData($id);
        $content = view('games.edit', $data);
        return view('main', compact('content'));
    }

    function editPatch(GamesRequest $request ,$id)
    {
        DB::beginTransaction();
        try {
             $this->repo->updateData($id);
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
             $this->repo->updateStatus($id, $status);
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
            $this->repo->deleteData($id);
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
            $file = $request->file('ico');
        }
        if($type == 2){
            $file = $request->file('image');
        }
        if($type == 3){
            $file = $request->file('web_image');
        }
        if($type == 4){
            $file = $request->file('sub_pho');
        }
        $this->validate($request, [
            'image' => 'mimes:jpg,jpeg,png,mp4,mov,ogg,qt|max:20000',
        ],[
            'image.mimes' => 'Harus dalam format jpeg, jpg, png, mp4, mov, ogg, qt ',
            'image.max' => 'Max. 20 MB',
        ]);

        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file_name = str_replace(" ", "_", $name);  
        $storage = Storage::disk('s3')->putFileAs('game' , $file , $file_name);
        $explode = explode('.', $file_name);
        if(end($explode) == 'jpg' || end($explode) == 'jpeg' || end($explode) == 'png' || end($explode) == 'JPG' || end($explode) == 'JPEG' || end($explode) == 'PNG'){
            $result = [
                'name' => $file->getClientOriginalName(),
                'link' => Helper::serveImage($storage),
                'path' => 'game/'.$file_name,
            ];
        }
        else{
            $result = [
                'name' => $file->getClientOriginalName(),
                'link' => Helper::staticPath($storage),
                'path' => 'game/'.$file_name,
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
            $storage = Storage::disk('s3')->putFileAs('game/content/' , $file , $file_name);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = \App\Helper\Helper::serveImage($storage); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }  
}
