
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import InstantSearch from 'vue-instantsearch';

require('./bootstrap');

window.Vue = require('vue');

window.events = new Vue();

Vue.use(InstantSearch);

window.flash = function (message , level = 'success'){
  window.events.$emit('flash' , {message , level});
};

let authorizations = require('./authorizations');

Vue.prototype.autorize = function (...params) {

    if(! window.App.signedIn) return false;

	if(typeof params[0] === 'string'){
	   return authorizations[params[0]](params[1]);
    }

	return params[0](window.App.user);
};

Vue.prototype.signedIn = window.App.signedIn;


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('flash-component', require('./components/FlashComponent.vue').default);
Vue.component('thread-view', require('./pages/Thread.vue').default);

Vue.component('user-notifications-component', require('./components/UserNotificationsComponent.vue').default);
Vue.component('favorite-component', require('./components/FavoriteComponent.vue').default);
Vue.component('paginator-component', require('./components/PaginatorComponent.vue').default);
Vue.component('avatar-component', require('./components/AvatarComponent.vue').default);
Vue.component('wysiwyg-component', require('./components/WysiwygComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});