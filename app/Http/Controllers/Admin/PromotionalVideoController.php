<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\VideoRequest;
use App\Repository\PromotionalVideoRepository;
use Illuminate\Support\Facades\DB;

class PromotionalVideoController extends Controller
{
    protected $repo;
    
    function __construct()
    {
        $this->repo = new PromotionalVideoRepository;
    }

    public function index()
    {

        $content = view('promotional_video.view');
        return view('main', compact('content'));
    }
    
    function data(Request $request)
    {

        $data['video'] = $this->repo->getData(10);

        return view('promotional_video.data', $data);
    }

    function addView()
    {
        $content = view('promotional_video.add');
        return view('main', compact('content'));
    }

    function addPost(VideoRequest $request)
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
        $data['video'] = $this->repo->getSingleData($id);
        $content = view('promotional_video.edit', $data);
        return view('main', compact('content'));
    }

    function editPatch(VideoRequest $request ,$id)
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
