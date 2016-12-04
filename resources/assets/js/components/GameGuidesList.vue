<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-md-offset-3 text-center">
                <h1 v-if="category === 'heroes'">Game Guides - Heroes</h1>
                <h1 v-else>Game Guides - Items</h1>
            </div>
            <div class="col-sm-4 col-md-4 col-md-offset-4 text-center">
                <a href="/login" v-if="user === null">Login to Post a Guide</a>
                <a href="/guides/post" v-else class="button button-fullwidth button-link">
                    Post a new Guide
                </a>
            </div>
        </div>
        


        <div v-for="parent in parents">
            <div class="row guide-link-row" v-if="parent.guides.length">
                <div class="col-xs-3 col-sm-2 col-md-1 col-md-offset-2">
                    <img class="guide-image" :src="parent.image" />
                </div>
                <div class="col-xs-9 col-sm-10 col-md-8" >
                    <h3>{{ parent.localized_name }}</h3>
                    <div class="guide-links">
                        <div class="guide-link" v-for="guide in parent.guides">
                            <a :href="guide.url" target="_blank">
                                <h4>{{guide.title}}</h4>
                                <h5>{{patches[guide.patch_id].version}} · {{guide.desc}}</h5>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['category'],
        mounted() {
            const guide_types = {};
            window.serverData.guide_types.forEach(type => {
                guide_types[type.id] = type;
            });
            this.guide_types = guide_types;

            const patches = {};
            window.serverData.patches.forEach(patch => {
                patches[patch.id] = patch;
            });
            this.patches = patches;
        },
        data() {
            return {
                parents: window.serverData.guides,
                guide_types: {},
                patches: {},
            }
        },
        methods: {
            getItems() {
                
            }
        }
    }
</script>
