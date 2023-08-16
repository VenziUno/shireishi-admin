<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use App\Repository\BlogRepository;
use App\Repository\BlogCategoryRepository;
use App\Repository\AdminRepository;
use App\Repository\HashtagRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helper\Helper;

class BlogController extends Controller
{
    protected $repo;
    
    function __construct()
    {
        $this->admin = new AdminRepository;
        $this->category = new BlogCategoryRepository;
        $this->hashtag = new HashtagRepository;
        $this->repo = new BlogRepository;
    }

    public function index()
    {
        $data['category'] = $this->category->getData();
        $data['hashtag'] = $this->hashtag->getData();
        $content = view('blog.view', $data);
        return view('main', compact('content'));
    }
    
    function data(Request $request)
    {
        $data['blog'] = $this->repo->getData(10);

        return view('blog.data', $data);
    }

    function addView()
    {
        $data['category'] = $this->category->getData();
        $data['hashtag'] = $this->hashtag->getData();
        $data['admin'] = $this->admin->getData();
        $content = view('blog.add', $data);
        return view('main', compact('content'));
    }

    function addPost(BlogRequest $request)
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
        $data['hashtag'] = $this->hashtag->getData();
        $data['admin'] = $this->admin->getData();
        $data['blog'] = $this->repo->getSingleData($id);
        $data['hashtag_array'] = [];
        if(count($data['blog']->HasHashtag) > 0){
            foreach($data['blog']->HasHashtag as $has){
                $data['hashtag_array'][] = $has->hashtags_id;
            }
        }
        $content = view('blog.edit', $data);
        return view('main', compact('content'));
    }

    function editPatch(BlogRequest $request ,$id)
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

        if(request('type') == 1){
            $file = $request->file('image');
        }
        if(request('type') == 2){
            $file = $request->file('sub-image');
        }
        $this->validate($request, [
            'image' => 'mimes:jpg,jpeg,png,mp4,mov,ogg,qt|max:20000',
        ],[
            'image.mimes' => 'Harus dalam format jpeg, jpg, png, mp4, mov, ogg, qt ',
            'image.max' => 'Max. 20 MB',
        ]);

        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file_name = str_replace(" ", "_", $name);  
        $storage = Storage::disk('s3')->putFileAs('blog' , $file , $file_name);
        $explode = explode('.', $file_name);
        if(end($explode)== 'jpg' || end($explode)== 'jpeg' || end($explode)== 'png' || end($explode)== 'JPG' || end($explode)== 'JPEG' || end($explode)== 'PNG'){
            $result = [
                'name' => $file->getClientOriginalName(),
                'link' => Helper::serveImage($storage),
                'path' => 'blog/'.$file_name,
            ];
        }
        else{
            $result = [
                'name' => $file->getClientOriginalName(),
                'link' => Helper::staticPath($storage),
                'path' => 'blog/'.$file_name,
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
            $storage = Storage::disk('s3')->putFileAs('blog/content/' , $file , $file_name);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = \App\Helper\Helper::serveImage($storage); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }  
}
