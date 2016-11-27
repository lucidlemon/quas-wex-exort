<template>
    <div class="container">
        <h1>Items!</h1>

        <div class="row">
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
                    <!--<md-card-content>-->
                        <!--id: {{ item.id }}-->
                    <!--</md-card-content>-->
                </md-card>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getItems();
        },
        data() {
            return {
                items: [],
            }
        },
        methods: {
            getItems() {
                console.log('attempting to get items');

                this.$http.get(`${window.Laravel.apiUrl}/items`).then((response) => {
                    // success callback
                    console.log(response);
                    this.items = response.body;
                }, (response) => {
                    // error callback
                    console.log(response)
                });
            }
        }
    }
</script>
