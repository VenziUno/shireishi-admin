<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\GameNewsRepository;

class GameNewsController extends Controller
{
    protected $repo;
    
    function __construct()
    {
        $this->repo = new GameNewsRepository;
    }

    /**
     * @OA\Get(
     *      path="/game-news?category=1&id=1&search=HelloWorld&game=1",
     *      operationId="getGameNews",
     *      tags={"Game-News"},
     *      summary="Get Game News Data",
     *      description="Return All Game News Data",
     *   @OA\Response(response=201, description="Successful operation")
     * )
     */
    public function getGameNews()
    {
        $data = $this->repo->getData();

        return response([
            'status' => true,
            'message' => 'Get Game News Data',
            'data' => $data
        ]);
    }
}
