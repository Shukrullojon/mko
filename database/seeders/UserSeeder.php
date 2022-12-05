<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            "name" => "Shukrullo",
            "email" => "shukrullobk@gmail.com",
            "token" => Str::random(80),
            "password" => Hash::make(12345678),
            "theme" => "default",
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ]);
        DB::table('model_has_roles')->insert(
            [
                'role_id' => 1,
                'model_id' => $user->id,
                'model_type' => "App\Models\User",
            ]
        );
        $user = User::create([
            "name" => "Application",
            "email" => "mko-application@gmail.com",
            "token" => Str::random(80),
            "password" => Hash::make(12345678),
            "theme" => "default",
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ]);
    }
}
