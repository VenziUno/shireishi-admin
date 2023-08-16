<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\GameNewsRequest;
use App\Repository\GameNewsRepository;
use App\Repository\GameNewsCategoryRepository;
use App\Repository\GamesRepository;
use App\Repository\AdminRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helper\Helper;

class GameNewsController extends Controller
{
    protected $repo;
    
    function __construct()
    {
        $this->admin = new AdminRepository;
        $this->category = new GameNewsCategoryRepository;
        $this->game = new GamesRepository;
        $this->repo = new GameNewsRepository;
    }

    public function index()
    {
        $data['category'] = $this->category->getData();
        $data['game'] = $this->game->getData();
        $content = view('game_news.view', $data);
        return view('main', compact('content'));
    }
    
    function data(Request $request)
    {
        $data['news'] = $this->repo->getData(10);

        return view('game_news.data', $data);
    }

    function addView()
    {
        $data['category'] = $this->category->getData();
        $data['game'] = $this->game->getData();
        $data['admin'] = $this->admin->getData();
        $content = view('game_news.add', $data);
        return view('main', compact('content'));
    }

    function addPost(GameNewsRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->repo->addData();
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
        $data['category'] = $this->category->getData();
        $data['game'] = $this->game->getData();
        $data['admin'] = $this->admin->getData();
        $data['news'] = $this->repo->getSingleData($id);
        $content = view('game_news.edit', $data);
        return view('main', compact('content'));
    }

    function editPatch(GameNewsRequest $request ,$id)
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

    function upload(Request $request){        

        $file = $request->file('image');
        $this->validate($request, [
            'image' => 'mimes:jpg,jpeg,png,mp4,mov,ogg,qt|max:20000',
        ],[
            'image.mimes' => 'Harus dalam format jpeg, jpg, png, mp4, mov, ogg, qt ',
            'image.max' => 'Max. 20 MB',
        ]);

        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file_name = str_replace(" ", "_", $name);  
        $storage = Storage::disk('s3')->putFileAs('game-news' , $file , $file_name);
        $explode = explode('.', $file_name);
        if(end($explode) == 'jpg' || end($explode) == 'jpeg' || end($explode) == 'png' || end($explode) == 'JPG' || end($explode) == 'JPEG' || end($explode) == 'PNG'){
            $result = [
                'name' => $file->getClientOriginalName(),
                'link' => Helper::serveImage($storage),
                'path' => 'game-news/'.$file_name,
            ];
        }
        else{
            $result = [
                'name' => $file->getClientOriginalName(),
                'link' => Helper::staticPath($storage),
                'path' => 'game-news/'.$file_name,
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
            $storage = Storage::disk('s3')->putFileAs('news/content/' , $file , $file_name);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = \App\Helper\Helper::serveImage($storage); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }  
}
