<template>
  <div class="container container-oneliner">
    <div class="row">
      <div class="col-sm-12">
        <h2 class="text-center secondary">A collection of the finest dota2 oneliners</h2>
        <div class="text-center" v-if="user === null">
          <p class="text-center">Got a good one? <a href="/login">Log In</a> to post your own</p>
        </div>
        <div v-else class="oneliner-form">
          <form v-on:submit.prevent="submitNew">
            <div class="row">
              <div class="col-sm-12 col-md-4 col-md-offset-3">
                <input v-model="newOneLiner" v-on:keyup.13="submitNew" placeholder="Want to add your own?" />
              </div>
              <div class="col-sm-12 col-md-2">
                <input type="submit" class="button" value="post your own">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="oneliner-line text-center">
      <div class="row">
        <div class="col-sm-12">
          <h1>{{ line.text }}</h1>
        </div>
        <div class="col-sm-12 col-md-2 col-md-offset-5">
          <a v-on:click="getOneLiner" class="button button-link button-full-width">Another One</a>
        </div>
      </div>
    </div>

    <div class="text-center form-success-message" v-on:click="removeSuccessMessage" v-if="thanksMessageVisible === true">
      ty bro. our mods will accept your message if they find it appropiate. cyka.
    </div>
  </div>
</template>

<style>
  p{
    max-width: 100%;
  }
</style>

<script>
  export default {
    mounted() {
      this.getOneLiner();
    },
    data() {
      return {
        line: '',
        user: window.Laravel.user,
        newOneLiner: '',
        thanksMessageVisible: false,
      };
    },
    methods: {
      getOneLiner() {
        // the id guarantees that the next oneliner won't be the same'
        this.$http.get(`${window.Laravel.apiUrl}/oneliner/single/${this.line.id}`).then((response) => {
          // success callback
          this.line = response.body;
        });
      },
      removeSuccessMessage() {
        this.thanksMessageVisible = false;
      },
      submitNew() {
        this.$http.post(`${window.Laravel.apiUrl}/oneliner`, { text: this.newOneLiner });

        // removed callbacks as I didn't use them yet

        this.thanksMessageVisible = true;
        setInterval(this.removeSuccessMessage, 5000);
        this.newOneLiner = '';
      },
    },
  };
</script>
