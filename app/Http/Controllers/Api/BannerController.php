<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\BannerRepository;

class BannerController extends Controller
{
    protected $repo;

    function __construct()
    {
        $this->repo = new BannerRepository;
    }

    /**
     * @OA\Get(
     *      path="/banner?search=banner&limit=10",
     *      operationId="getBanners",
     *      tags={"Banner"},
     *      summary="Get Banner Data",
     *      description="Return All Banner Data",
     *   @OA\Response(response=201, description="Successful operation")
     * )
     */
    public function getBanners()
    {
        $data = $this->repo->showData();
        return response([
            'status' => true,
            'message' => 'Get All Banner Data',
            'data' => $data
        ]);
    }

    /**
     * @OA\Get(
     *      path="/banner/{banner_id}",
     *      operationId="getSingleBanner",
     *      tags={"Banner"},
     *      summary="Get Single Banner Data",
     *      description="Return Single Banner Data by ID",
     *   @OA\Response(response=201, description="Successful operation")
     * )
     */
    function getBanner($id)
    {
        $data = $this->repo->getSingleData($id);
        return response([
            'status' => true,
            'message' => 'Get Single Banner Data',
            'data' => $data
        ]);
    }
}
