<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'fname' => 'Dusan',
            'lname' => 'Djordjevic',
            'bday' => '1997-07-21',
            'phone' => '0640763084',
            'username' => 'usanzadunje',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        /* Users factory */
        User::create([
            'fname' => 'Cafe 1',
            'lname' => 'Cafe 1',
            'bday' => '1999-07-21',
            'phone' => '111111',
            'username' => 'cafe1',
            'email' => 'cafe1@live.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'cafe_id' => 1,
        ]);
        User::create([
            'fname' => 'Cafe 2',
            'lname' => 'Cafe 2',
            'bday' => '1998-07-21',
            'phone' => '222222',
            'username' => 'cafe2',
            'email' => 'cafe2@live.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'cafe_id' => 2,
        ]);

        User::factory(10)->create();
    }
}
