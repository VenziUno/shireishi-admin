<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\AdminGroupsModel;

class AdminGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		AdminGroupsModel::truncate();
        AdminGroupsModel::insert([
			[
                'id' => '1',
                'name' => 'Master',
            ],
		]);
    }
}
