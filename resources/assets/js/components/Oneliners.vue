<template>
    <div class="container">
        <h3 class="text-center secondary">A collection of the finest dota2 oneliners</h3>
        <div class="oneliner-container">
            <h1>{{ line.text }}</h1>
            <md-button v-on:click="getOneLiner" class="md-raised md-primary">Boring, next!</md-button>
        </div>

        <div class="text-center oneliner-success-message" v-if="thanksMessageVisible === true">
            <md-button v-on:click="removeSuccessMessage" class="md-raised md-accent">ty bro. our mods will accept your message if they find it appropiate. cyka.</md-button>
        </div>

        <div v-if="user === null">
            <p class="text-center">Got a good one? <a href="/login">Log In</a> to post your own</p>
        </div>
        <div v-else>
            <form v-on:submit.prevent="submitNew">
                <md-input-container>
                    <label>Got a good one to share? Type here</label>
                    <md-input v-model="newOneLiner" v-on:keyup.13="submitNew"></md-input>
                </md-input-container>
                <p class="subtle">Press Enter to submit. Oneliners require validation from a mod to be displayed. Please allow a few hours for that to happen.</p>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getOneLiner();
        },
        data() {
            return {
                line: window.serverData,
                user: window.Laravel.user,
                newOneLiner: '',
                thanksMessageVisible: false,
            }
        },
        methods: {
            getOneLiner() {
                // the id guarantees that the next oneliner won't be the same'
                this.$http.get(`${window.Laravel.apiUrl}/oneliner/single/${this.line.id}`).then((response) => {
                    // success callback
                    this.line = response.body;
                }, (response) => {
                    // error callback
                    console.log(response)
                });
            },
            removeSuccessMessage() {
                this.thanksMessageVisible = false;
            },
            submitNew() {
                console.log('submitting', this.newOneLiner);
                this.$http.post(`${window.Laravel.apiUrl}/oneliner`, {'text': this.newOneLiner}).then((response) => {
                    // success callback
                    console.log(response);
                }, (response) => {
                    // error callback
                    console.log(response)
                });

                this.thanksMessageVisible = true;

                var timeinterval = setInterval(this.removeSuccessMessage, 5000);

                this.newOneLiner = '';
            }
        }
    }
</script>
