<?php

use App\Models\Auth\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 'admin', 1)->create();
        factory(User::class, 'verified', 1)->create();
        factory(User::class, 'unverified', 1)->create();
        factory(User::class, 50)->create();
    }
}