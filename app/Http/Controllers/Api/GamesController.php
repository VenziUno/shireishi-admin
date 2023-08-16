<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\GamesRepository;

class GamesController extends Controller
{
    protected $repo;
    
    function __construct()
    {
        $this->repo = new GamesRepository;
    }

    /**
     * @OA\Get(
     *      path="/game?search=game&limit=10",
     *      operationId="getGames",
     *      tags={"Game"},
     *      summary="Get Game Data",
     *      description="Return All Game Data",
     *   @OA\Response(response=201, description="Successful operation")
     * )
     */
    public function getGames()
    {
        $data = $this->repo->showData();
        return response([
            'status' => true,
            'message' => 'Get All Game Data',
            'data' => $data
        ]);
    }
    
        /**
     * @OA\Get(
     *      path="/game/{game_id}",
     *      operationId="getSingleGame",
     *      tags={"Game"},
     *      summary="Get Single Game Data",
     *      description="Return Single Game Data by ID",
     *   @OA\Response(response=201, description="Successful operation")
     * )
     */
    function getGame($id)
    {
        $data = $this->repo->getSingleData($id);
        return response([
            'status' => true,
            'message' => 'Get Single Game Data',
            'data' => $data
        ]);
    }
}
