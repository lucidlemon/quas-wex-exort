<template>
  <div class="container screen-spacer">
    <div class="row">
      <div class="col-sm-12 col-md-6 col-md-offset-3 text-center">
        <h1>Game Guides - Submit</h1>
        <p>
          Thanks for contributing to our guides. In order to make the search in the future more reliable, we also encourage you to specify which patch this guide was written for.
          <!--If you post a link from reddit we will also fetch some information for you (like guessing game patch based on reddit date, getting the title…).-->
          As always your post will only be visible after moderation.
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-md-6 col-md-offset-3">
        <form v-on:submit.prevent="submitNew">
          <div class="row">
            <div class="col-sm-12 col-md-12">
              <label for="url">URL</label>
              <input name="url" v-model="url" v-on:keyup.13="submitNew" placeholder="http://..." />
            </div>
            <!--<div class="col-sm-12 col-md-4">
                <label for=""> </label>
                <a href="#" class="button button-fullwidth">fetch infos</a>
            </div>-->
          </div>
          <div class="row">
            <div class="col-sm-12">
              <label for="title">Title</label>
              <input name="title" v-model="title" v-on:keyup.13="submitNew" placeholder="Ganking as ..." />
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <label for="desc">Description (optional)</label>
              <input name="desc" v-model="desc" v-on:keyup.13="submitNew" placeholder="Ganking as ..." />
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-8">
              <label for="morph">Relates To</label>
              <basic-select
                :options="morphs"
                :selected-option="morph"
                @select="onSelectMorph"
              />
            </div>
            <div class="col-sm-12 col-md-4">
              <label for="type">Type</label>
              <basic-select
                :options="guideTypes"
                :selected-option="guide_type"
                @select="onSelectType"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-8">
              <label for="patch">Game Patch</label>

              <basic-select
                :options="patches"
                :selected-option="patch"
                @select="onSelectPatch"
              />

            </div>
            <div class="col-sm-12 col-md-4">
              <label for="">done?</label>
              <input type="submit" class="" value="post your own">
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="text-center form-success-message" v-on:click="removeSuccessMessage" v-if="thanksMessageVisible === true">
      ty bro. our mods will accept your message if they find it appropiate.
    </div>
  </div>
</template>

<script>
  import { BasicSelect } from 'vue-search-select';
  import moment from 'moment';

  export default {
    mounted() {
      this.guideTypes = this.guideTypes.map(item => ({
        ...item,
        value: item.id,
        text: item.title,
      }));

      this.patches = this.patches.map((rawPatch) => {
        const patch = rawPatch;

        patch.value = patch.id;
        patch.text = `${patch.version} (since ${moment(patch.started_at).format('YYYY/MM/DD')})`;

        if (patch.ended_at !== null) {
          patch.text = `${patch.version} (${moment(patch.started_at).format('YYYY/MM/DD')} - ${moment(patch.ended_at).format('YYYY/MM/DD')})`;
        }

        return patch;
      });
    },
    components: {
      BasicSelect,
    },
    data() {
      return {
        user: window.Laravel.user,
        url: '',
        title: '',
        desc: '',
        guide_type: {
          value: '',
          text: '',
        },
        patch: {
          value: '',
          text: '',
        },
        morph: {
          value: '',
          text: '',
        },
        guideTypes: window.serverData.guideTypes,
        patches: window.serverData.patches,
        morphs: window.serverData.morphs,
        thanksMessageVisible: false,
      };
    },
    methods: {
      fetchInfos() {
        // the id guarantees that the next oneliner won't be the same'
        this.$http.get(`${window.Laravel.apiUrl}/oneliner/single/${this.line.id}`).then((response) => {
          // success callback
          this.line = response.body;
        });
      },
      onSelectType(type) {
        this.guide_type = type;
      },
      onSelectPatch(patch) {
        this.patch = patch;
      },
      onSelectMorph(morph) {
        this.morph = morph;
      },
      removeSuccessMessage() {
        this.thanksMessageVisible = false;
      },
      submitNew() {
        const data = {
          url: this.url,
          title: this.title,
          desc: this.desc,
          patch: this.patch,
          morph: this.morph,
          guide_type: this.guide_type,
        };

        this.$http.post(`${window.Laravel.apiUrl}/guide`, data);

        this.thanksMessageVisible = true;

        setInterval(this.removeSuccessMessage, 10000);

        this.title = '';
        this.desc = '';
        this.url = '';
      },
    },
  };
</script>
