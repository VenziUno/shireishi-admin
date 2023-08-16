<?php

namespace Database\Seeders;

use App\Models\AuthorizationTypesModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorizationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AuthorizationTypesModel::truncate();
        AuthorizationTypesModel::insert([
            [
                'name' => 'view'
            ],
            [
                'name' => 'add'
            ],
            [
                'name' => 'edit'
            ],
            [
                'name' => 'delete'
            ]
        ]);
    }
}
