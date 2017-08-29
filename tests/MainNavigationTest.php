<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainNavigationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->visit('/')
            ->see('Login with Steam')
            ->see('Countdown')
            ->see('Trashtalk')
            ->see('Guides')
            ->see('About')
            ->click('Guides');
    }
}
