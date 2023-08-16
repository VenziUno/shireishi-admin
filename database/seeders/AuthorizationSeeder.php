<?php

namespace Database\Seeders;

use App\Models\DivisionModel;
use App\Models\AuthorizationsModel;
use App\Models\MenusModel;
use App\Models\AdminGroupsModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AuthorizationsModel::truncate();

        /*----------------------------- For Master ---------------------------------*/
        $menus = MenusModel::where('route', '!=', null)->get();
        foreach ($menus as $i) {
            for ($x = 1; $x < 5; $x++) {
                $data[] =  [
                    'authorization_types_id' => $x,
                    'admin_groups_id' => 1,
                    'menus_id' => $i->id,
                ];
            }
        }
        /*----------------------------- For Master ---------------------------------*/

        AuthorizationsModel::insert($data);
    }
}
