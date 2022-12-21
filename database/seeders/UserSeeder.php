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
        $userDashboard = User::create([
            "name" => "Dashboard",
            "email" => "dashboard@gmail.com",
            "token" => Str::random(80),
            "password" => Hash::make(12345678),
            "theme" => "default",
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ]);
        DB::table('roles')->insert(
            [
                'name' => "Admin",
                'guard_name' => "web",
                'title' => "Super Admin",
            ]
        );

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

        $userApplication = User::create([
            "name" => "Application",
            "email" => "mko-application@gmail.com",
            "token" => Str::random(80),
            "password" => Hash::make(12345678),
            "theme" => "default",
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ]);

        $userMobile = User::create([
            "name" => "Mobile",
            "email" => "mko-mobile@gmail.com",
            "token" => Str::random(80),
            "password" => Hash::make(12345678),
            "theme" => "default",
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ]);

        $userShahzodbek = User::create([
            "name" => "Shahzodbek",
            "email" => "shahzodbek@gmail.com",
            "token" => Str::random(80),
            "password" => Hash::make(12345678),
            "theme" => "default",
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ]);
        DB::table('model_has_roles')->insert(
            [
                'role_id' => 1,
                'model_id' => $userShahzodbek->id,
                'model_type' => "App\Models\User",
            ]
        );
        $userJurabek = User::create([
            "name" => "Jurabek",
            "email" => "jurabek@gmail.com",
            "token" => Str::random(80),
            "password" => Hash::make(12345678),
            "theme" => "default",
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ]);
        DB::table('model_has_roles')->insert(
            [
                'role_id' => 1,
                'model_id' => $userJurabek->id,
                'model_type' => "App\Models\User",
            ]
        );
    }
}
