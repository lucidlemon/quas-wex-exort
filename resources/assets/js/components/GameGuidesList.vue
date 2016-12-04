<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-md-offset-3 text-center">
                <h1 v-if="category === 'heroes'">Game Guides - Heroes</h1>
                <h1 v-else>Game Guides - Items</h1>
            </div>
            <div class="col-sm-4 col-md-4 col-md-offset-4 text-center">
                <a href="/guides/post" class="button button-fullwidth button-link">
                    Post a new Guide
                </a>
            </div>
        </div>
        


        <div v-for="guide in guides">
            <div class="row" v-if="guide.guides.length">
                <div class="col-sm-2 col-md-1 col-md-offset-2">
                    <img class="guide-image" :src="guide.image" />
                </div>
                <div class="col-sm-10 col-md-8" >
                    <h3>{{ guide.localized_name }}</h3>
                    <p>{{ guide.guides.length }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['category'],
        mounted() {
            // this.getItems();
        },
        data() {
            return {
                guides: window.serverData.guides,
            }
        },
        methods: {
            getItems() {
                
            }
        }
    }
</script>
