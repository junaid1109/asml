<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'label' => 'Home',
                'route_name' => 'home',
                'url' => null,
                'order' => 1,
                'active' => true,
            ],
            [
                'label' => 'About',
                'route_name' => 'about',
                'url' => null,
                'order' => 2,
                'active' => true,
            ],
            [
                'label' => 'Team',
                'route_name' => 'team',
                'url' => null,
                'order' => 3,
                'active' => true,
            ],
            [
                'label' => 'Contact',
                'route_name' => 'contact.index',
                'url' => null,
                'order' => 4,
                'active' => true,
            ],
            [
                'label' => 'Portfolio',
                'route_name' => 'portfolio.index',
                'url' => null,
                'order' => 5,
                'active' => true,
            ],
            [
                'label' => 'Advisory',
                'route_name' => 'advisory.index',
                'url' => null,
                'order' => 6,
                'active' => true,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
