/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
import Datepicker from 'vuejs-datepicker';

require('./bootstrap');
// const attachFastClick = require('fastclick');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('datepicker', Datepicker);

Vue.component('countdown', require('./components/Countdown.vue'));
Vue.component('items', require('./components/Items.vue'));
Vue.component('oneliners', require('./components/Oneliners.vue'));
Vue.component('patches', require('./components/Patches.vue'));
Vue.component('quiz', require('./components/Quiz.vue'));

Vue.component('gameguidesoverview', require('./components/GameGuidesOverview.vue'));
Vue.component('gameguidescreate', require('./components/GameGuidesCreate.vue'));
Vue.component('gameguideslist', require('./components/GameGuidesList.vue'));

export const app = new Vue({
  el: '#app',
});

// attachFastClick(document.body);

export default app;
