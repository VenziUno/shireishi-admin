<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repository\SocialMediaRepository;
use App\Http\Requests\SocialMediaRequest;
use Illuminate\Support\Facades\Storage;
use App\Helper\Helper;

class SocialMediaController extends Controller
{
    protected $media;
    
    function __construct()
    {
        $this->media = new SocialMediaRepository;
    }

    public function index()
    {
        $content = view('social_media.view');
        return view('main', compact('content'));
    }
    
    function data(Request $request)
    {
        $data['media'] = $this->media->getData(10);

        return view('social_media.data', $data);
    }

    function addView()
    {
        $content = view('social_media.add');
        return view('main', compact('content'));
    }

    function addPost(SocialMediaRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->media->addData();
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
        $data['media'] = $this->media->getSingleData($id);
        $content = view('social_media.edit', $data);
        return view('main', compact('content'));
    }

    function editPatch(SocialMediaRequest $request ,$id)
    {
        DB::beginTransaction();
        try {
             $this->media->updateData($id);
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
            $this->media->deleteData($id);
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
        $storage = Storage::disk('s3')->putFileAs('social-media' , $file , $file_name);
        $explode = explode('.', $file_name);
        if(end($explode) == 'jpg' || end($explode) == 'jpeg' || end($explode) == 'png' || end($explode) == 'JPG' || end($explode) == 'JPEG' || end($explode) == 'PNG'){
            $result = [
                'name' => $file->getClientOriginalName(),
                'link' => Helper::serveImage($storage),
                'path' => 'social-media/'.$file_name,
            ];
        }
        else{
            $result = [
                'name' => $file->getClientOriginalName(),
                'link' => Helper::staticPath($storage),
                'path' => 'social-media/'.$file_name,
                'namepath' => $file_name,
            ];
        }
        return response()->json($result, 200);
    }
}