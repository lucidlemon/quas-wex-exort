<template>
    <div class="container">
        <div class="row">

            <div class="row">
                <div class="col-xs-12">
                    <div class="spacer"></div>
                </div>
            </div>

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
            <div class="col-sm-4 col-md-2 col-md-offset-3">
                <a href="/guides/heroes" class="button button-fullwidth button-link">
                    Browse Hero Guides
                </a>
            </div>
            <div class="col-sm-4 col-md-2">
                <a href="/guides/tactics" class="button button-fullwidth button-link">
                    General Knowledge
                </a>
            </div>
            <div class="col-sm-4 col-md-2">
                <a href="/guides/items" class="button button-fullwidth button-link">
                    Browse Item Guides
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="spacer"></div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <h3>Latest Guides</h3>
                <div class="row" v-for="guide in latest">
                    <a :href="guide.url" class="col-xs-12" target="_blank">
                        <h4>{{guide.title}}</h4>
                        <h5>
                            <span>{{guide.guide_type.title}}</span>
                            <span v-if="guide.morphable.title">· {{guide.morphable.title}}</span>
                            <span v-if="guide.morphable.localized_name">· {{guide.morphable.localized_name}}</span>
                            <span>· {{patches[guide.patch_id].version}}</span>
                            <span v-if="guide.desc.length"> · {{guide.desc}}</span>
                        </h5>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const moment = require('moment');

    export default {
        mounted() {
            const guide_types = {};
            window.serverData.guide_types.forEach(type => {
                console.log('received');
                guide_types[type.id] = type;
            });
            this.guide_types = guide_types;

            const patches = {};
            window.serverData.patches.forEach(patch => {
                console.log('received');
                patch['start'] = moment(patch.started_at).format('YYYY/MM');
                patch['end'] = moment(patch.ended_at).format('YYYY/MM');
                patches[patch.id] = patch;
            });
            this.patches = patches;
        },
        data() {
            return {
                user: window.Laravel.user,
                latest: window.serverData.latestGuides,
                guide_types: {},
                patches: {},
            }
        }
    }
</script>
