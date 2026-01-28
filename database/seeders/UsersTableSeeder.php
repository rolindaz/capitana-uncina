<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $me = new User;

        $me->name = 'Rolinda';
        $me->email = 'rolinda@duck.com';
        $me->email_verified_at = null;
        $me->password = '$2y$12$nK4/9Xmtm4U0e0jK6U0WDuHSmULh/U33GNFOrkGhLgcyN47PR795C';
        $me->remember_token = null;

        $me->save();
    }
}
