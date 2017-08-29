<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainNavigationTest extends BrowserKitTestCase
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
            ->see('Trashtalpjk')
            ->see('Guides')
            ->see('About')
            ->click('Guides');
    }
}
