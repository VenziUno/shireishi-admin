<?php

namespace App\Repository;

use App\Models\AdminGroupsModel;
use App\Helper\Helper;

use Exception;

class AdminGroupRepository
{

    function getData($n)
    {
        $data = AdminGroupsModel::orderBy('id', 'desc')->paginate($n);
        return $data;
    }

    function getSingleData($id)
    {
        $data = AdminGroupsModel::find($id);
        return $data;
    }

    function getDataWithSearch($n)
    {
        $keyword = request('search');
        $data = AdminGroupsModel::where('name', 'LIKE', "%$keyword%")->paginate($n);
        return $data;
    }

    function addData()
    {
        $data = AdminGroupsModel::create([
            'name' => request('name'),
        ]);

    }

    function updateData($id)
    {
        $data = [
            'name' => request('name'),
        ];
        AdminGroupsModel::find($id)->update($data);

    }

    function deleteData($id)
    {
        $data = AdminGroupsModel::find($id);
        AdminGroupsModel::find($id)->delete();
    }
}
