<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\GameNewsCategoryRequest;
use App\Repository\GameNewsCategoryRepository;
use Illuminate\Support\Facades\DB;

class GameNewsCategoryController extends Controller
{
    protected $repo;
    
    function __construct()
    {
        $this->repo = new GameNewsCategoryRepository;
    }

    public function index()
    {

        $content = view('game_news_category.view');
        return view('main', compact('content'));
    }
    
    function data(Request $request)
    {

        $data['category'] = $this->repo->getData(10);

        return view('game_news_category.data', $data);
    }

    function addView()
    {
        $content = view('game_news_category.add');
        return view('main', compact('content'));
    }

    function addPost(GameNewsCategoryRequest $request)
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
        $data['category'] = $this->repo->getSingleData($id);
        $content = view('game_news_category.edit', $data);
        return view('main', compact('content'));
    }

    function editPatch(GameNewsCategoryRequest $request ,$id)
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
