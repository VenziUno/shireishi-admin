<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\BannerRepository;
use App\Repository\GameCategoryRepository;
use App\Repository\GamesRepository;
use App\Repository\GameNewsCategoryRepository;
use App\Repository\GameNewsRepository;
use App\Repository\BlogCategoryRepository;
use App\Repository\BlogRepository;
use App\Repository\HashtagRepository;
use App\Repository\PromotionalVideoRepository;
use App\Repository\SocialMediaRepository;
use App\Repository\WebRepository;

class AllDataController extends Controller
{
    protected $banner;
    protected $gameCategory;
    protected $game;
    protected $newsCategory;
    protected $news;
    protected $blogCategory;
    protected $blog;
    protected $hashtag;
    protected $social;
    protected $web;
    protected $video;
    
    function __construct()
    {
        $this->banner = new BannerRepository;
        $this->gameCategory = new GameCategoryRepository;
        $this->game = new GamesRepository;
        $this->newsCategory = new GameNewsCategoryRepository;
        $this->news = new GameNewsRepository;
        $this->blogCategory = new BlogCategoryRepository;
        $this->blog = new BlogRepository;
        $this->hashtag = new HashtagRepository;
        $this->social = new SocialMediaRepository;
        $this->web = new WebRepository;
        $this->video = new PromotionalVideoRepository;
    }

    /**
     * @OA\Get(
     *      path="/all-data",
     *      operationId="getAlls",
     *      tags={"All"},
     *      summary="Get All Data",
     *      description="Return All Data",
     *   @OA\Response(response=201, description="Successful operation")
     * )
     */
    public function getData()
    {
        $data['banner'] = $this->banner->showData();
        $data['social_media'] = $this->social->showData();
        $data['game_category'] = $this->gameCategory->getData();
        $data['game'] = $this->game->showData();
        $data['newsCategory'] = $this->newsCategory->getData();
        $data['news'] = $this->news->getData();
        $data['blogCategory'] = $this->blogCategory->getData();
        $data['blog'] = $this->blog->getData();
        $data['hashtag'] = $this->hashtag->getData();
        $data['web_profile'] = $this->web->showData();
        $data['promotional_video'] = $this->video->getData();
        if($data['web_profile']->promotional_video_link && str_contains($data['web_profile']->promotional_video_link, 'www.youtube.com/watch')){
            $key = explode("?v=", $data['web_profile']->promotional_video_link);
            $data['web_profile']->youtube_video_key = $key[1];
        }
        if($data['web_profile']->embedded_twitter){
            $twitter = explode("?", $data['web_profile']->embedded_twitter);
            if(count($twitter) > 1){
                $data['web_profile']->embedded_twitter = $data['web_profile']->embedded_twitter."&ref_src=twsrc%5Etfw";
            }
            else{
                $data['web_profile']->embedded_twitter = $twitter[0]."?ref_src=twsrc%5Etfw";
            }
        }
        return response([
            'status' => true,
            'message' => 'Get All Data',
            'data' => $data
        ]);
    }
}
