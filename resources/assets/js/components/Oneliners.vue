<template>
    <div class="container">
        <div class="oneliner-container">
            <h1>{{ line.text }}</h1>
        </div>

        <div v-if="user === null">
            <p>Got a good one? <a href="/login">Log In</a> to post your own</p>
        </div>
        <div v-else>
            <form v-on:submit.prevent="submitNew">
                <md-input-container>
                    <label>got something to say?</label>
                    <md-input v-model="newOneLiner" v-on:keyup.13="submitNew"></md-input>
                </md-input-container>
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
            }
        },
        methods: {
            getOneLiner() {
                console.log('getOneLiner');
                this.$http.get(`${window.Laravel.apiUrl}/oneliner/single`).then((response) => {
                    // success callback
                    this.line = response.body;
                }, (response) => {
                    // error callback
                    console.log(response)
                });
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
            }
        }
    }
</script>
