<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-6 col-md-offset-3 text-center">
        <h1 v-if="category === 'heroes'">Game Guides - Heroes</h1>
        <h1 v-else-if="category === 'items'">Game Guides - Items</h1>
        <h1 v-else>Game Guides - General</h1>
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
          <h3 v-if="parent.localized_name">{{ parent.localized_name }}</h3>
          <h3 v-if="parent.title">{{ parent.title }}</h3>

          <div class="guide-links">
            <div class="guide-link" v-for="guide in parent.guides">
              <a :href="guide.url" target="_blank">
                <h4>{{guide.title}}</h4>
                <h5>
                  <span>{{guide_types[guide.guide_type_id].title}}</span>
                  <span>· {{patches[guide.patch_id].version}} (started {{patches[guide.patch_id].start}})</span>
                  <span v-if="guide.desc.length"> · {{guide.desc}}</span>
                </h5>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  const moment = require('moment');

  export default {
    props: ['category'],
    mounted() {
      const guideTypes = {};
      window.serverData.guideTypes.forEach((type) => {
        guideTypes[type.id] = type;
      });
      this.guideTypes = guideTypes;

      const patches = {};
      window.serverData.patches.forEach((data) => {
        const patch = data;
        patch.start = moment(patch.started_at).format('YYYY/MM');
        patch.end = moment(patch.ended_at).format('YYYY/MM');
        patches[patch.id] = patch;
      });
      this.patches = patches;
    },
    data() {
      return {
        parents: window.serverData.guides,
        guideTypes: {},
        patches: {},
        user: window.Laravel.user,
      };
    },
  };
</script>
