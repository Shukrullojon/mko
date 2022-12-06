<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            'name' => "MEDIAPARK",
            'logo' => "https://mobile.unired.uz/partners/mediapark.png",
            'status' => 1,
            'is_unired' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('brands')->insert([
            'name' => "Zoodmall",
            'logo' => "https://mobile.unired.uz/partners/mediapark.png",
            'status' => 1,
            'is_unired' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('brands')->insert([
            'name' => "Goodzone",
            'logo' => "https://mobile.unired.uz/partners/mediapark.png",
            'status' => 1,
            'is_unired' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
