<?php

namespace Database\Seeders;

use App\Enums\ROLE;
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

        if (env('APP_ENV') === 'prod') {
            $admin = User::firstOrCreate(
                ['email' => 'admin@cysc.fr'],
                [
                    'password' => bcrypt('fnFPB3TzGWTBoLA'),
                    'name' => 'Admin'
                ],
            );
            $admin->assignRole(ROLE::ADMIN);

            $user = User::firstOrCreate(
                ['email' => 'user@cysc.fr'],
                [
                    'password' => bcrypt('nRapnRYRdxcE'),
                    'name' => 'User'
                ],
            );
            $user->assignRole(ROLE::USER);
        } else {
            $admin = User::firstOrCreate(
                ['email' => 'admin@cysc.fr'],
                [
                    'password' => bcrypt('admin'),
                    'name' => 'Admin'
                ],
            );
            $admin->assignRole(ROLE::ADMIN);
            $user = User::firstOrCreate(
                ['email' => 'user@cysc.fr'],
                [
                    'password' => bcrypt('user'),
                    'name' => 'User'
                ],
            );
            $user->assignRole(ROLE::USER);
        }
    }
}
