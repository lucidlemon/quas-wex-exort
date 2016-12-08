<?php

use Illuminate\Database\Seeder;

class GuideTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\GuideType::create([
            'title' => 'Blog Post'
        ]);

        \App\GuideType::create([
            'title' => 'Reddit Discussion'
        ]);

        \App\GuideType::create([
            'title' => 'Video Guide'
        ]);

        \App\GuideType::create([
            'title' => 'Replay Analysis'
        ]);

        \App\GuideType::create([
            'title' => 'Pro Replay'
        ]);

        \App\GuideType::create([
            'title' => 'Video Guide (Premium / Non-Free)'
        ]);

        \App\GuideType::create([
            'title' => 'Tips n Tricks'
        ]);
    }
}
