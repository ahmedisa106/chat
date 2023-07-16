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
                'name' => 'Ahmed',
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin'),
                'photo' => 'admins/me.jpg',
            ],
            [
                'name' => 'El-Sayed El-Beshry',
                'email' => 'saied@admin.com',
                'password' => bcrypt('admin'),
                'photo' => 'admins/sayed.jpg',
            ],
            [
                'name' => 'Omar Bero',
                'email' => 'omar@admin.com',
                'password' => bcrypt('admin'),
                'photo' => 'admins/pero.jpg',
            ],

        ]);

        //   Admin::factory(9)->create();

    }
}
