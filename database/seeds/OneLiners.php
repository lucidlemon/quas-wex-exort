<?php

use Illuminate\Database\Seeder;

class OneLiners extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'steamid' => rand(10,1000000),
            'username' => str_random(10),
            'avatar' => 'http://www.placecage.com/300/300'
        ]);

        DB::table('users')->insert([
            'steamid' => rand(10,1000000),
            'username' => str_random(10),
            'avatar' => 'http://www.placecage.com/300/300'
        ]);

        DB::table('users')->insert([
            'steamid' => rand(10,1000000),
            'username' => str_random(10),
            'avatar' => 'http://www.placecage.com/300/300'
        ]);

        DB::table('one_liners')->insert([
            'text' => 'You\'re as useful as a used condom',
            'granted' => 1,
            'user_id' => rand(1,3),
        ]);

        DB::table('one_liners')->insert([
            'text' => 'You ran so fast even the french are put to shame',
            'granted' => 1,
            'user_id' => rand(1,3),
        ]);

        DB::table('one_liners')->insert([
            'text' => 'Stevie Wonder has better mini-map vision than you',
            'granted' => 1,
            'user_id' => rand(1,3),
        ]);

        DB::table('one_liners')->insert([
            'text' => 'Stephen Hawking roams better than you',
            'granted' => 1,
            'user_id' => rand(1,3),
        ]);
    }
}
