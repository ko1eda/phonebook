import Vue from 'vue';
import axios from 'axios';
import Navbar from "./components/nav/Navbar.vue";
import PhonebookIndex from "./pages/phonebook/index.vue";
import FlashMessage from './components/flash/Flash';

window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Global Vue event bus
window.events = new Vue;

// Global flash function for emiting
// flash messages 
// level represents the type of message i.e info, danger, warning, etc
window.flash = function(message, level = null) {
  window.events.$emit('flashEvent', {message, level});
}

/**
 * Create a new Vue instance
 */
const app = new Vue({
    el: '#app',
    components: {
        Navbar,
        PhonebookIndex,
        FlashMessage
    }
});