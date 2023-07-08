<?php

namespace Database\Seeders;

use App\Models\Admin;
use Database\Factories\AdminFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $admin = new Admin();

        $admin->insert([
            [
                'name' => 'ahmed',
                'email' => 'admin@admin.com',
                'password' => bcrypt(123456),
                'photo' => null,
            ],

        ]);

        Admin::factory(9)->create();

    }
}
