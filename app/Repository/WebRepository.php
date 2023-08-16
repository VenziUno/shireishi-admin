<?php

namespace App\Repository;

use App\Models\WebProfilesModel;
use Carbon\Carbon;

use Exception;

class WebRepository
{

    function getData()
    {
        $data = WebProfilesModel::paginate(5);
        return $data;
    }

    function showData()
    {
        $data = WebProfilesModel::first();
        return $data;
    }

    function getSingleData($id)
    {
        $data = WebProfilesModel::find($id);
        return $data;
    }

    function getDataWithSearch($n)
    {
        $keyword = request('search');
        $data = WebProfilesModel::where('name', 'LIKE', "%$keyword%")->paginate($n);
        return $data;
    }

    function createData()
    {
        $data = WebProfilesModel::create([
            'about_us' => request('about'),
            // 'promotional_video_link' =>  request('link'),
            'contact_us' => request('contact'),
            'embedded_twitter' =>  request('twitter')
        ]);
        return $data;

    }

    function updateData($id)
    {
        $web = WebProfilesModel::find($id);
        $data = [
            'about_us' => request('about'),
            // 'promotional_video_link' =>  request('link'),
            'contact_us' => request('contact'),
            'embedded_twitter' =>  request('twitter')
        ];
        WebProfilesModel::find($id)->update($data);
    }

}
