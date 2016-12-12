/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('countdown', require('./components/Countdown.vue'));
Vue.component('items', require('./components/Items.vue'));
Vue.component('oneliners', require('./components/Oneliners.vue'));

Vue.component('gameguidesoverview', require('./components/GameGuidesOverview.vue'));
Vue.component('gameguidescreate', require('./components/GameGuidesCreate.vue'));
Vue.component('gameguideslist', require('./components/GameGuidesList.vue'));

const app = new Vue({
    el: '#app',
});

var attachFastClick = require('fastclick');
attachFastClick(document.body);
