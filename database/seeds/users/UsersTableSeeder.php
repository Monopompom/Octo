<?php

namespace Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 4/6/2018
 * Time: 15:00
 */
class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('tbl_octo_users')->insert([
            'email' => 'oleksijvolkov@gmail.com',
            'password' => '$2y$10$yrMnhKcqueu.gu4YJnxSIu5WBz9W5lI1QaCPBIvPY86s8bMtykBCK' //123456
        ]);
    }
}