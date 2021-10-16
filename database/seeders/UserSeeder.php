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
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        User::create([
            'fname' => 'Test',
            'lname' => 'Test',
            'bday' => '1998-07-21',
            'phone' => 'test',
            'username' => 'test',
            'email' => 'test',
            'password' => '$2y$10$92IXUNpkjO0dsadrOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        /* Users factory */
        User::create([
            'fname' => 'Cafe 1',
            'lname' => 'Cafe 1',
            'bday' => '1999-07-21',
            'phone' => '111111',
            'username' => 'cafe1',
            'email' => 'cafe1@live.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        User::create([
            'fname' => 'Cafe 2',
            'lname' => 'Cafe 2',
            'bday' => '1998-07-21',
            'phone' => '222222',
            'username' => 'cafe2',
            'email' => 'cafe2@live.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        User::create([
            'fname' => 'Petar',
            'lname' => 'Petrovic',
            'bday' => '1998-07-21',
            'phone' => 'petar',
            'username' => 'petar',
            'email' => 'petar@cafe1.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'place' => 1,
            'active' => false,
        ]);
        User::create([
            'fname' => 'Pavle',
            'lname' => 'Pavlobiv',
            'bday' => '1998-07-21',
            'phone' => 'pavle',
            'username' => 'pavle',
            'email' => 'pavle@cafe1.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'place' => 1,
            'active' => false,
        ]);
        User::create([
            'fname' => 'Nikola',
            'lname' => 'Nikolic',
            'bday' => '1998-07-21',
            'phone' => 'nikola',
            'username' => 'nikola',
            'email' => 'nikola@cafe1.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'place' => 1,
            'active' => false,
        ]);
        User::create([
            'fname' => 'Nenad',
            'lname' => 'Nedovic',
            'bday' => '1998-07-21',
            'phone' => 'nenad',
            'username' => 'nenad',
            'email' => 'nenad@cafe1.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'place' => 1,
            'active' => false,
        ]);
        User::create([
            'fname' => 'Marko',
            'lname' => 'Markovic',
            'bday' => '1998-07-21',
            'phone' => 'marko',
            'username' => 'marko',
            'email' => 'marko@cafe1.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'place' => 1,
            'active' => false,
        ]);
        User::create([
            'fname' => 'Jelena',
            'lname' => 'Jelovic',
            'bday' => '1998-07-21',
            'phone' => 'jeka',
            'username' => 'jeka',
            'email' => 'jeka@cafe1.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'place' => 1,
            'active' => false,
        ]);
        User::create([
            'fname' => 'Marija',
            'lname' => 'Marinkovic',
            'bday' => '1998-07-21',
            'phone' => 'marija',
            'username' => 'marija',
            'email' => 'marija@cafe2.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'place' => 2,
            'active' => false,
        ]);
        User::create([
            'fname' => 'Marina',
            'lname' => 'Neisc',
            'bday' => '1998-07-21',
            'phone' => 'marina',
            'username' => 'marina',
            'email' => 'marina@cafe2.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'place' => 2,
            'active' => false,
        ]);
        User::create([
            'fname' => 'Masa',
            'lname' => 'Masic',
            'bday' => '1998-07-21',
            'phone' => 'masa',
            'username' => 'masa',
            'email' => 'masa@cafe2.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'place' => 2,
            'active' => false,
        ]);

        User::factory(10)->create();
    }
}
