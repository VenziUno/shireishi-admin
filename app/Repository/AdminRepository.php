<?php

namespace App\Repository;

use App\Models\AdminModel;
use App\Models\AdminGroupsModel;
use Carbon\Carbon;
use App\Helper\Helper;

use Exception;

class AdminRepository
{

    function getData($n = NULL, $status = NULL)
    {
        $data = AdminModel::with(['AdminGroup'])->orderBy('id', 'desc');
        if($status){
            $data = $data->where('is_active', $status);
        }
        $keyword = request('search');
        if($keyword){
            $data = $data->where('fullname', 'LIKE', "%$keyword%")->orWhere('email', 'LIKE', "%$keyword%")->with(['AdminGroup'])->orderBy('id', 'desc');
            if($status){
                $data = $data->where('is_active', $status);
            }
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
        $data = AdminModel::find($id);
        return $data;
    }

    function getAdminGroup()
    {
        $data = AdminGroupsModel::get();
        return $data;
    }

    function addData()
    {
        $data = AdminModel::create([
            'fullname' => request('name'),
            'email' => request('email'),
            'is_active' => request('status'),
            'admin_groups_id' => request('group'),
            'password' => bcrypt(request('password')),
        ]);
        
        return $data;
    }

    function updateData($id)
    {
        $data = [
            'fullname' => request('name'),
            'email' => request('email'),
            'admin_groups_id' => request('group'),
            'is_active' => request('status'),
            'password' => bcrypt(request('password')),
            'updated_at' => Carbon::now()
        ];
        AdminModel::find($id)->update($data);
    }

    function deleteData($id)
    {
        $data = AdminModel::find($id);

        AdminModel::find($id)->delete();
    }

    function archiveData($id)
    {
        $data = [
            'is_active' => 0
        ];
        AdminModel::find($id)->update($data);
    }

    function unarchiveData($id)
    {
        $data = [
            'is_active' => 1
        ];
        AdminModel::find($id)->update($data);
    }

    function changepass($id)
    {
        $data = [
            'password' => bcrypt(request('password')),
        ];
        AdminModel::find($id)->update($data);
    }
}
