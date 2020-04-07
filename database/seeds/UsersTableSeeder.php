<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factory;
use App\User;
use Faker\Generator as Faker;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            
            [
                'fname' => 'Renjith',
                'lname' => 'R S',
                'email' => 'info@rsrenjith.com',
                'email_verified_at' => Carbon::now(),
                'state' => '1',
                'password' => bcrypt('passmenow'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'fname' => 'Babu',
                'lname' => 'Babu',
                'email' => 'admin@therismos.com',
                'email_verified_at' => Carbon::now(),
                'state' => '1',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

    }
}