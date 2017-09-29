@extends('layouts.master')

@section('title', 'About Quas-Wex-Exort.com')

@section('bodyclass', 'about')


@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
            <h1>The Fuck is this?</h1>
            <p>
                Quas-Wex-Exort.com intends to be some sort of community hub for dota2.<br>
                It currently just features a <a href="/">countdown</a> that may get update for several events (such as big patches, tournaments, special livestreams etc.) as well as some <a href="/oneliner">one-liners</a> and a few <a href="/guides">guides</a> in case you want to step up your game.
            </p>
            <h3>Why shouldn't I use dotafire, dotamastery or whatever for this?</h3>
            <p>
                You can and absolutely should. Quas-Wex-Exort does not intend to be an alternative to these sites. Instead I want this to become some sort of bookmarking service for good guides out there.
            </p>
            <h3>Plans and Technology.</h3>
            <p>
                Future plans include some minigames, integration of some services (like more info on heroes), social media dashboards and such. In case you want to contribute, <a href="https://github.com/lucidlemon/quas-wex-exort" target="_blank">feel free to do so</a>.
            </p>
            <p>
                The only thing that is guaranteed: No Ads. No Paywall. No Donations.
            </p>
            <p>
                The technology stack behind this is pretty easy: Laravel as a PHP Backend and API, Vue.js 2.0 for Frontend stuff, a full featured server as a platform, Github for VCS and Steam Login via OAuth to remove just another password to <strike>get leaked</strike> remember.
            </p>

            <br>

            <p>
                Created by <a href="https://www.reddit.com/user/karreerose/" target="_blank">/u/karreerose</a>.
            </p>
            <p>
                gl hf.
                <!--And don't pick Techies you stupid fucks.-->
            </p>
        </div>
    </div>


@endsection
