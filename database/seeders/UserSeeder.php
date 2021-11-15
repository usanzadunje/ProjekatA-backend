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
        //Admin user
        User::create([
            'fname' => 'Dusan',
            'lname' => 'Djordjevic',
            'bday' => '1997-07-21',
            'phone' => '0640763084',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        //Test user which will be assigned to all cafes
        User::create([
            'fname' => 'Test',
            'lname' => 'Test',
            'bday' => '1998-07-21',
            'phone' => 'test',
            'username' => 'test',
            'email' => 'test',
            'password' => '$2y$10$92IXUNpkjO0dsadrOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        //Owners of cafe1 and cafe2 palces
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

        // Staff of cafe1 and cafe2 places
        User::create([
            'fname' => 'Petar',
            'lname' => 'Petrovic',
            'bday' => '1998-07-21',
            'phone' => 'petar',
            'username' => 'staffcafe1',
            'email' => 'staff@cafe1.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'place' => 1,
            'active' => false,
        ]);
        User::create([
            'fname' => 'Marija',
            'lname' => 'Marinkovic',
            'bday' => '1998-07-21',
            'phone' => 'marija',
            'username' => 'staffcafe2',
            'email' => 'staff@cafe2.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'place' => 2,
            'active' => false,
        ]);

        for($i = 1; $i <= 20; $i++)
        {
            User::factory(10)->create([
                'place' => $i,
            ]);
        }

        User::factory(10)->create();
    }
}
