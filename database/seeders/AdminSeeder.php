<?php

namespace Database\Seeders;

use App\Models\AdminModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AdminModel::truncate();
        AdminModel::insert([
            [
                'admin_groups_id' => 1,
                'fullname' => 'Master',
                'email' => 'master@shireishi.com',
                'password' => bcrypt('shireishi@2022'),
                'is_active' => 1
            ],
        ]);
    }
}
