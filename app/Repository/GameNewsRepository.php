<?php

namespace App\Repository;

use App\Models\GameNewsModel;
use App\Helper\Helper;

use Exception;

class GameNewsRepository
{

    function getData($n = NULL)
    {
        $data = GameNewsModel::with(['Category', 'Admin', 'Game'])->orderBy('id', 'desc');
        if(request('id')){
            return $data->find(request('id'));
        }
        if(request('search')){
            $keyword = request('search');
            $data = $data->where('title', 'LIKE', "%$keyword%");
        }
        
        if(request('category')){
            $data = $data->where('game_news_categories_id', request('category'));
        }

        if(request('game')){
            $data = $data->where('games_id', request('game'));
        }
        
        if($n){
            return $data->paginate($n);
        }
        else{
            return $data->get();
        }
    }

    function getSingleData($id)
    {
        $data = GameNewsModel::with(['Category', 'Admin', 'Game'])->find($id);
        return $data;
    }

    function addData()
    {
        $data = GameNewsModel::create([
            'title' => request('title'),
            'body' => request('body'),
            'cover_image' => request('picture'),
            'admins_id' => request('admin'),
            'game_news_categories_id' => request('category'),
            'games_id' => request('games_id')
        ]);
    }

    function updateData($id)
    {
        $data = [
            'title' => request('title'),
            'body' => request('body'),
            'cover_image' => request('picture'),
            'admins_id' => request('admin'),
            'game_news_categories_id' => request('category'),
            'games_id' => request('games_id')
        ];
        GameNewsModel::find($id)->update($data);

    }

    function deleteData($id)
    {
        GameNewsModel::find($id)->delete();
    }
}
