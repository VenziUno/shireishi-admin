<?php

namespace App\Repository;

use App\Models\AuthorizationsModel;
use App\Models\AuthorizationTypesModel;
use App\Models\AdminGroupsModel;
use App\Models\MenusModel;
use Exception;

class AuthorizationRepository
{

    function getData($admin_group)
    {
        $data = AuthorizationsModel::where('admin_groups_id', $admin_group)->get();
        return $data;
    }

    function getAdminGroup(){
        $data = AdminGroupsModel::all();
        return $data;
    }

    function getMenu(){
        $data = MenusModel::all();
        return $data;
    }

    function getType(){
        $data = AuthorizationTypesModel::all();
        return $data;
    }

    function update(){
        AuthorizationsModel::where('admin_groups_id',request('admin_group'))->delete();
        $req = request('menu_tipe');
        $temp = [];
        foreach ($req as $val)
        {
            $exp = explode('_',$val);
            $ar['admin_groups_id'] = request('admin_group');
            $ar['menus_id'] =  $exp[0];
            $ar['authorization_types_id'] =  $exp[1];
            $temp[] = $ar;
        }
       AuthorizationsModel::insert($temp);
    }
}
