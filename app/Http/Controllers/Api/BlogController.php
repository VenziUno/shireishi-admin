<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\BlogRepository;

class BlogController extends Controller
{
    protected $repo;
    
    function __construct()
    {
        $this->repo = new BlogRepository;
    }

    /**
     * @OA\Get(
     *      path="/blog?category=1&id=1&search=HelloWorld&hashtag=[1,3]",
     *      operationId="getBlogs",
     *      tags={"Blog"},
     *      summary="Get Blog Data",
     *      description="Return All Blog Data",
     *   @OA\Response(response=201, description="Successful operation")
     * )
     */
    public function getBlog()
    {
        $data = $this->repo->getData();

        return response([
            'status' => true,
            'message' => 'Get Blog Data',
            'data' => $data
        ]);
    }
}
