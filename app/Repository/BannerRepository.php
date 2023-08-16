<?php

namespace App\Repository;

use App\Models\BannerModel;
use Carbon\Carbon;
use App\Helper\Helper;

use Exception;

class BannerRepository
{

    function getData($n = NULL)
    {
        $data = BannerModel::with(['Game'])->orderBy('order', 'asc');
        if(request('search')){
            $keyword = request('search');
            $data = $data->where('name', 'LIKE', "%$keyword%");
        }
        if(request('game')){
            $data = $data->where('games_id', request('game'));
        }
        if(request('status') != NULL){
            $data = $data->where('status', request('status'));
        }
        if($n){
            return $data->paginate($n);
        }
        else{
            return $data->get();
        }

    }

    function showData()
    {
        $data = BannerModel::with(['Game'])->where('status', 1)->orderBy('order', 'asc')->get();
        return $data;
    }

    function getSingleData($id)
    {
        $data = BannerModel::find($id);
        return $data;
    }

    function getLastOrder()
    {
        $data = BannerModel::orderBy('order', 'desc')->first();
        return $data;
    }

    function addData()
    {
        $check = BannerModel::where('order', request('order'))->first();
        if($check){
            $get = BannerModel::where('order', '>=', request('order'))->get();

            $number = request('order');
            foreach($get as $g){
                $number += 1;
                BannerModel::find($g->id)->update([
                    'order' => $number
                ]);
            }
        }
        $data = BannerModel::create([
            'title' => request('title'),
            'description' => request('description'),
            'cover_image_path' => request('picture'),
            'thumbnail_image_path' => request('thumbnail_link'),
            'order' => request('order'),
            'games_id' => request('game')
        ]);
    }

    function updateData($id)
    {
        $check = BannerModel::where('order', request('order'))->whereNot('id', $id)->first();
        $update = BannerModel::find($id);
        if($update->order < request('order')){
            $number = $update->order - 1;
            $number_order = $update->order;
            $type = 1;
        }
        else{
            $number = request('order');
            $number_order = request('order');
            $type = 2;
        }
        $get = BannerModel::where('order', '>=', $number_order)->whereNot('id', $id)->orderBy('order', 'asc')->get();

        foreach($get as $g){
            $number += 1;
            if($type == 1 && $number == request('order')){
                $number += 1;
            }
            BannerModel::find($g->id)->update([
                'order' => $number
            ]);
        }
        $data = [
            'title' => request('title'),
            'description' => request('description'),
            'cover_image_path' => request('picture'),
            'thumbnail_image_path' => request('thumbnail_link'),
            'order' => request('order'),
            'games_id' => request('game')
        ];
        $update->update($data);
    }

    function updateStatus($id, $status)
    {
        $data = [
            'status' => $status,
        ];
        BannerModel::find($id)->update($data);
    }

    function deleteData($id)
    {
        $data = BannerModel::find($id);
        $get = BannerModel::where('order', '>=', $data->order)->whereNot('id', $id)->orderBy('order', 'asc')->get();

        $number = $data->order;
        foreach($get as $g){
            BannerModel::find($g->id)->update([
                'order' => $number
            ]);
            $number += 1;
        }
        BannerModel::find($id)->delete();
    }
}
