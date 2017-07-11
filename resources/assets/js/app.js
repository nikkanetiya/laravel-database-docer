
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('schema-view', require('./components/dbSchema.vue'));

Vue.filter('implode', function (value, piece, key) {
    piece = piece ? piece : ', ';

    if(_.isUndefined(key)) {
        return value.join(piece);
    }

    return _.pluck(value, key).join(piece);
});

// const app = new Vue({
//     el: '#app'
// });
