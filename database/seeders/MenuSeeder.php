<?php

namespace Database\Seeders;

use App\Models\MenusModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MenusModel::truncate();
        MenusModel::insert([
            [
                'id' => 1,
                'name' => 'Dashboard',
                'route' => 'dashboard',
                'icon' => 'dashboard',
                'sort_number' => 1,
                'menu_groups_id' => 1
            ],
            [
                'id' => 2,
                'name' => 'Banner',
                'route' => 'banner',
                'icon' => 'fas fa-scroll',
                'sort_number' => 5,
                'menu_groups_id' => 4
            ],
            [
                'id' => 3,
                'name' => 'Social Media',
                'route' => 'social-media',
                'sort_number' => 1,
                'icon' => 'fas fa-mobile-alt',
                'menu_groups_id' => 7
            ],
            [
                'id' => 4,
                'name' => 'Web-Profile',
                'route' => 'web-profile',
                'icon' => 'fas fa-globe',
                'sort_number' => 2,
                'menu_groups_id' => 7
            ],
            [
                'id' => 5,
                'name' => 'Games Category',
                'route' => 'game-category',
                'icon' => 'fas fa-gamepad',
                'sort_number' => 1,
                'menu_groups_id' => 4
            ],
            [
                'id' => 6,
                'name' => 'Games',
                'route' => 'game',
                'icon' => 'fas fa-gamepad',
                'sort_number' => 2,
                'menu_groups_id' => 4
            ],
            [
                'id' => 7,
                'name' => 'Games News Category',
                'route' => 'game-news-category',
                'icon' => 'fas fa-newspaper',
                'sort_number' => 1,
                'menu_groups_id' => 5
            ],
            [
                'id' => 8,
                'name' => 'Games News',
                'route' => 'game-news',
                'icon' => 'fas fa-newspaper',
                'sort_number' => 2,
                'menu_groups_id' => 5
            ],
            [
                'id' => 9,
                'name' => 'Blog Category',
                'route' => 'blog-category',
                'icon' => 'fas fa-blog',
                'sort_number' => 1,
                'menu_groups_id' => 6
            ],
            [
                'id' => 10,
                'name' => 'Blog',
                'route' => 'blog',
                'icon' => 'fas fa-blog',
                'sort_number' => 2,
                'menu_groups_id' => 6
            ],
            [
                'id' => 11,
                'name' => 'Hashtag',
                'route' => 'hashtag',
                'icon' => 'fas fa-hashtag',
                'sort_number' => 3,
                'menu_groups_id' => 6
            ],
            [
                'id' => 12,
                'name' => 'Promotional Video',
                'route' => 'promotional-video',
                'icon' => 'fas fa-video',
                'sort_number' => 5,
                'menu_groups_id' => 7
            ],
            [
                'id' => 13,
                'name' => 'Admin Group',
                'route' => 'admin-group',
                'icon' => 'fas fa-user-friends',
                'sort_number' => 1,
                'menu_groups_id' => 3
            ],
            [
                'id' => 14,
                'name' => 'Admin',
                'route' => 'admin',
                'icon' => 'fa fa-user-tie',
                'sort_number' => 2,
                'menu_groups_id' => 3
            ],
            [
                'id' => 15,
                'name' => 'Authorization',
                'route' => 'authorization',
                'icon' => 'fa fa-cogs',
                'sort_number' => 3,
                'menu_groups_id' => 3
            ],
        ]);
    }
}
