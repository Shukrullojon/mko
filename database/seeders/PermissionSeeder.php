<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'home.index',
                'title' => '',
                'guard_name' => 'web',
            ],
            [
                'name' => 'home',
                'title' => '',
                'guard_name' => 'web',
            ],
            [
                'name' => 'home.show',
                'title' => '',
                'guard_name' => 'web',
            ],
            [
                'name' => 'payment.index',
                'title' => '',
                'guard_name' => 'web',
            ],
            [
                'name' => 'payment.show',
                'title' => '',
                'guard_name' => 'web',
            ],
            [
                'name' => 'merchant.index',
                'title' => '',
                'guard_name' => 'web',
            ],
            [
                'name' => 'merchant.show',
                'title' => '',
                'guard_name' => 'web',
            ],
            [
                'name' => 'merchant.edit',
                'title' => '',
                'guard_name' => 'web',
            ],
            [
                'name' => 'merchant.add',
                'title' => '',
                'guard_name' => 'web',
            ],
            [
                'name' => 'client.index',
                'title' => '',
                'guard_name' => 'web',
            ],
            [
                'name' => 'client.show',
                'title' => '',
                'guard_name' => 'web',
            ],
            [
                'name' => 'brand.index',
                'title' => '',
                'guard_name' => 'web',
            ],
            [
                'name' => 'brand.add',
                'title' => '',
                'guard_name' => 'web',
            ],
            [
                'name' => 'brand.show',
                'title' => '',
                'guard_name' => 'web',
            ],
            [
                'name' => 'brand.edit',
                'title' => '',
                'guard_name' => 'web',
            ],
        ];
        foreach ($permissions as $permission){
            Permission::firstOrCreate([
                'name' => $permission['name'],
            ],
            [
                'title' => $permission['title'],
                'guard_name' => $permission['guard_name'],
            ]);
        }
    }
}
