<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\SocialMediaRepository;

class SocialMediaController extends Controller
{
    protected $repo;
    
    function __construct()
    {
        $this->repo = new SocialMediaRepository;
    }

    /** 
     * @OA\Get(
     *      path="/social-media?search=media&limit=10",
     *      operationId="getSocialMedias",
     *      tags={"Social Media"},
     *      summary="Get Social Media Data",
     *      description="Return All Social Media Data",
     *   @OA\Response(response=201, description="Successful operation")
     * )
     */
    public function getSocialMedias()
    {
        $data = $this->repo->showData();
        return response([
            'status' => true,
            'message' => 'Get All Social Media Data',
            'data' => $data
        ]);
    }
    

    /**
     * @OA\Get(
     *      path="/social-media/{social-media_id}",
     *      operationId="getSingleSocialMedia",
     *      tags={"Social Media"},
     *      summary="Get Single Social Media Data",
     *      description="Return Single Social Media Data by ID",
     *   @OA\Response(response=201, description="Successful operation")
     * )
     */
    function getSocialMedia($id)
    {
        $data = $this->repo->getSingleData($id);
        return response([
            'status' => true,
            'message' => 'Get Single Social Media Data',
            'data' => $data
        ]);
    }
}
