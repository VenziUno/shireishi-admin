<?php

namespace App\Repository;

use App\Models\GamesModel;
use App\Models\GameHasGameCategoriesModel;
use App\Models\GameDownloadLinkModel;
use App\Models\GameSystemRequirementModel;
use App\Models\GamePhotosModel; 
use Carbon\Carbon;
use App\Helper\Helper;

use Exception;

class GamesRepository
{

    function getData($n = NULL)
    {
        $data = GamesModel::orderBy('order', 'asc');
        if(request('search')){
            $keyword = request('search');
            $data = $data->where('name', 'LIKE', "%$keyword%");
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
        $data = GamesModel::with(['Photo', 'Banner', 'HasCategory.Category', 'Require', 'DownloadLink'])->where('status', 1)->orderBy('order', 'asc');
        if(request('search')){
            $keyword = request('search');
            $data = $data->where('name', 'LIKE', "%$keyword%")->orWhereHas('HasCategory', function($query) use($keyword){
                $query->whereHas('Category', function($query) use($keyword){
                    $query->where('name', 'LIKE', "%$keyword%");
                });
            })->where('status', 1)->orderBy('order', 'asc');
        }
        return $data->get();
    }

    function getSingleData($id)
    {
        $data = GamesModel::with(['Photo', 'Banner', 'HasCategory.Category', 'Require', 'DownloadLink'])->find($id);
        return $data;
    }

    function getLastOrder()
    {
        $data = GamesModel::orderBy('order', 'desc')->first();
        return $data;
    }

    function addData()
    {
        $check = GamesModel::where('order', request('order'))->first();
        if($check){
            $get = GamesModel::where('order', '>=', request('order'))->get();
            
            $number = request('order');
            foreach($get as $g){
                $number += 1;
                GamesModel::find($g->id)->update([
                    'order' => $number
                ]);
            }
        }
        $data = GamesModel::create([
            'name' => request('name'),
            'cover_image' => request('picture'),
            'color_background' => request('color'),
            'redirect_link' => request('redirect_link'),
            'order' => request('order'),
            'description' => request('desc'),
            'small_icon' => request('icon'),
            'web_background_image' => request('web'),
        ]);

        foreach(request('category') as $c){
            GameHasGameCategoriesModel::create([
                'games_id' => $data->id, 
                'game_categories_id' => $c
            ]);
        }
        
        foreach(request('link') as $key=>$link){
            GameDownloadLinkModel::create([
                'name' => request('link_name')[$key],
                'games_id' => $data->id,
                'redirect_link' => $link
            ]);
        }

        GameSystemRequirementModel::create([
            'min_os' => request('min_os'), 
            'min_processor' => request('min_processor'), 
            'min_memory' => request('min_memory'), 
            'min_graphics' => request('min_graphics'), 
            'min_storage' => request('min_storage'), 
            'rec_os' => request('rec_os'), 
            'rec_processor' => request('rec_processor'), 
            'rec_memory' => request('rec_memory'), 
            'rec_graphics' => request('rec_graphics'), 
            'rec_storage' => request('rec_storage'), 
            'games_id' => $data->id,
        ]);

        foreach(request('sub_photo') as $p){
            GamePhotosModel::create([
                'link' => $p, 
                'games_id' => $data->id
            ]);
        }
    }

    function updateData($id)
    {
        $check = GamesModel::where('order', request('order'))->whereNot('id', $id)->first();
        $update = GamesModel::find($id);
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
        $get = GamesModel::where('order', '>=', $number_order)->whereNot('id', $id)->orderBy('order', 'asc')->get();

        foreach($get as $g){
            $number += 1;
            if($type == 1 && $number == request('order')){
                $number += 1;
            }
            GamesModel::find($g->id)->update([
                'order' => $number
            ]);
        }
        $data = [
            'name' => request('name'),
            'cover_image' => request('picture'),
            'color_background' => request('color'),
            'redirect_link' => request('redirect_link'),
            'order' => request('order'),
            'description' => request('desc'),
            'small_icon' => request('icon'),
            'web_background_image' => request('web'),

        ];
        GamesModel::find($id)->update($data);

        GameHasGameCategoriesModel::where('games_id', $id)->delete();
        
        foreach(request('category') as $c){
            GameHasGameCategoriesModel::create([
                'games_id' => $id, 
                'game_categories_id' => $c
            ]);
        }

        GameDownloadLinkModel::where('games_id', $id)->delete();
        foreach(request('link') as $key=>$link){
            GameDownloadLinkModel::create([
                'name' => request('link_name')[$key],
                'games_id' => $id,
                'redirect_link' => $link
            ]);
        }
        
        if(GameSystemRequirementModel::where('games_id', $id)->first()){
            GameSystemRequirementModel::where('games_id', $id)->update([
                'min_os' => request('min_os'), 
                'min_processor' => request('min_processor'), 
                'min_memory' => request('min_memory'), 
                'min_graphics' => request('min_graphics'), 
                'min_storage' => request('min_storage'), 
                'rec_os' => request('rec_os'), 
                'rec_processor' => request('rec_processor'), 
                'rec_memory' => request('rec_memory'), 
                'rec_graphics' => request('rec_graphics'), 
                'rec_storage' => request('rec_storage'), 
            ]);
        }
        else{
            GameSystemRequirementModel::create([
                'min_os' => request('min_os'), 
                'min_processor' => request('min_processor'), 
                'min_memory' => request('min_memory'), 
                'min_graphics' => request('min_graphics'), 
                'min_storage' => request('min_storage'), 
                'rec_os' => request('rec_os'), 
                'rec_processor' => request('rec_processor'), 
                'rec_memory' => request('rec_memory'), 
                'rec_graphics' => request('rec_graphics'), 
                'rec_storage' => request('rec_storage'), 
                'games_id' => $id,
            ]);
        }

        GamePhotosModel::where('games_id', $id)->delete();
        foreach(request('sub_photo') as $p){
            GamePhotosModel::create([
                'link' => $p, 
                'games_id' => $id
            ]);
        }
    }

    function updateStatus($id, $status)
    {
        $data = [
            'status' => $status,
        ];
        GamesModel::find($id)->update($data);
    }

    function deleteData($id)
    {
        $data = GamesModel::find($id);
        $get = GamesModel::where('order', '>=', $data->order)->whereNot('id', $id)->orderBy('order', 'asc')->get();

        $number = $data->order;
        foreach($get as $g){
            GamesModel::find($g->id)->update([
                'order' => $number
            ]);
            $number += 1;
        }
        GamesModel::find($id)->delete();
    }
}
