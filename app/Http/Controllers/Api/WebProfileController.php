<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\WebRepository;

class WebProfileController extends Controller
{
    protected $repo;
    
    function __construct()
    {
        $this->repo = new WebRepository;
    }

        /** 
     * @OA\Get(
     *      path="/web-profile",
     *      operationId="getWebProfile",
     *      tags={"Web Profile"},
     *      summary="Get Profile Data",
     *      description="Return Profile Data",
     *   @OA\Response(response=201, description="Successful operation")
     * )
     */
    public function getWebProfile()
    {
        $data = $this->repo->showData();
        if($data->promotional_video_link && str_contains($data->promotional_video_link, 'www.youtube.com/watch')){
            $key = explode("?v=", $data->promotional_video_link);
            $data->youtube_video_key = $key[1];
        }
        if($data->embedded_twitter){
            $twitter = explode("?", $data->embedded_twitter);
            if(count($twitter) > 1){
                $data->embedded_twitter = $twitter[0]."&ref_src=twsrc%5Etfw";
            }
            else{
                $data->embedded_twitter = $twitter[0]."?ref_src=twsrc%5Etfw";
            }
        }
        return response([
            'status' => true,
            'message' => 'Get Web Profile Data',
            'data' => $data
        ]);
    }
}
