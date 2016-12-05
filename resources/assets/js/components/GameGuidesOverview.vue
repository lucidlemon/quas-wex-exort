<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-md-offset-3 text-center">
                <h1>Game Guides</h1>
                <p>
                    Whether you are 2k or 6k, all of us want to improve and raise their MMR. Reddit and a few wikis and coached deliver good material, but you might lose overview, especially since reddits search is not quite usable.
                </p>
                <p>
                    In order to make your gameplay better we want to offer a list of links to guides which may help you. We don’t want to become just another Wiki where you post your complete guide. Instead use existing sites such as Medium, Reddit or Liquidpedia to create them, and
                    <a href="/login" v-if="user === null">Login to post a guide</a>
                    <a href="/guides/post" v-else>
                        post a new guide
                    </a>
                    here.
                </p>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-sm-4 col-md-3 col-md-offset-3">
                <a href="/guides/heroes" class="button button-fullwidth button-link">
                    Browse Heroe Guides
                </a>
            </div>
            <!--
            <div class="col-sm-4 col-md-2">
                <a href="#" class="button button-fullwidth button-link">
                    General Knowledge
                </a>
            </div>
            -->
            <div class="col-sm-4 col-md-3">
                <a href="/guides/items" class="button button-fullwidth button-link">
                    Browse Item Guides
                </a>
            </div>
        </div>
        


        <!--<div class="row">
            <div class="col-sm-4 col-md-2" v-for="item in items">
                <md-card>
                    <md-card-header>
                        <md-card-header-text>
                            <div class="md-title">{{ item.localized_name }}</div>
                            <div class="md-subhead">{{ item.cost }}g</div>
                        </md-card-header-text>
                    </md-card-header>

                    <md-card-media>
                        <img :src="'http://cdn.dota2.com/apps/dota2/images/items/' + item.name + '_lg.png'" alt="People">
                    </md-card-media>
                </md-card>
            </div>
        </div>-->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: window.Laravel.user,
            }
        }
    }
</script>
