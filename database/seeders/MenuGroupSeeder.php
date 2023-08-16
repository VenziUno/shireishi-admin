<?php

namespace Database\Seeders;

use App\Models\MenuGroupsModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MenuGroupsModel::truncate();
        MenuGroupsModel::insert([
            [
                'id' => 1,
                'name' => 'Nav Top',

            ],
            [
                'id' => 2,
                'name' => 'Nav Bottom',

            ],
            [
                'id' => 3,
                'name' => 'Admin',
            ],
            [
                'id' => 4,
                'name' => 'Games',
            ],
            [
                'id' => 5,
                'name' => 'News',

            ],
            [
                'id' => 6,
                'name' => 'Blog',
            ],
            [
                'id' => 7,
                'name' => 'Other',
            ],

        ]);
    }
}
