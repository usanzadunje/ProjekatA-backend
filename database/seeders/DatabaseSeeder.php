<?php

namespace Database\Seeders;

use App\Models\Cafe;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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
            'email' => 'dussann1997@live.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        for($i = 1; $i < 25; $i++){
            Cafe::create([
                'name' => 'Cafe ' . $i,
                'city' => 'City ' . $i,
                'address' => 'Address ' . $i,
                'phone' => $i . $i . $i . $i . $i . $i,
                'email' => 'cafe' . $i . '@live.com'
            ]);
        }

        User::create([
            'fname' => 'Cafe 1',
            'lname' => 'Cafe 1',
            'bday' => null,
            'phone' => '111111',
            'username' => 'cafe1',
            'email' => 'cafe1@live.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'cafe_id' => 1
        ]);
        User::create([
            'fname' => 'Cafe 2',
            'lname' => 'Cafe 2',
            'bday' => null,
            'phone' => '222222',
            'username' => 'cafe2',
            'email' => 'cafe2@live.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'cafe_id' => 2
        ]);

         User::factory(2)->create();
         Cafe::factory(5000)->create();
    }
}
