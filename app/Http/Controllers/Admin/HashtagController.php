<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\HashtagRequest;
use App\Repository\HashtagRepository;
use Illuminate\Support\Facades\DB;

class HashtagController extends Controller
{
    protected $repo;
    
    function __construct()
    {
        $this->repo = new HashtagRepository;
    }

    public function index()
    {

        $content = view('hashtag.view');
        return view('main', compact('content'));
    }
    
    function data(Request $request)
    {

        $data['hashtag'] = $this->repo->getData(10);

        return view('hashtag.data', $data);
    }

    function addView()
    {
        $content = view('hashtag.add');
        return view('main', compact('content'));
    }

    function addPost(HashtagRequest $request)
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
        $data['hashtag'] = $this->repo->getSingleData($id);
        $content = view('hashtag.edit', $data);
        return view('main', compact('content'));
    }

    function editPatch(HashtagRequest $request ,$id)
    {
        DB::beginTransaction();
        try {
             $this->repo->updateData($id);
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
}
