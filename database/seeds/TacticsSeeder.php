<?php

use Illuminate\Database\Seeder;

class TacticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Tactic::create([
            'title' => 'General',
            'slug' => 'general'
        ]);

        \App\Tactic::create([
            'title' => 'Laning',
            'slug' => 'laning'
        ]);

        \App\Tactic::create([
            'title' => 'Carry',
            'slug' => 'carry'
        ]);

        \App\Tactic::create([
            'title' => 'Support',
            'slug' => 'support'
        ]);

        \App\Tactic::create([
            'title' => 'Mid',
            'slug' => 'mid'
        ]);

        \App\Tactic::create([
            'title' => 'Offlane',
            'slug' => 'offlane'
        ]);

        \App\Tactic::create([
            'title' => 'Patch Analysis',
            'slug' => 'patch'
        ]);
    }
}
