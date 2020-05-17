/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./main');

window.Vue = require('vue');



/**
 * Below lines we need to get a working date-picker due to the reason that
 * the standard HTML thing isn't really working.
 */

const flatpickr = require("flatpickr");

window.getConfigDateTime = function(){
    return {
        allowInput: true,
        enableTime: true,
        minTime: "06:00",
        maxTime: "22:00",
        time_24hr: true,
        altInput: true,
        altFormat: "d.m.Y H:i",
        dateFormat: "Y-m-d H:i",
        disableMobile: true,
        weekNumbers: true,
        wrap: true
    };
}

function getConfigDate(){
    return {
        allowInput: true,
        altInput: true,
        altFormat: "d.m.Y",
        dateFormat: "Y-m-d",
        disableMobile: true,
        wrap: true,
    };
};

document.initDatepicker = function(element, config){
    if(!config) {
        config = getConfigDate();
    }
    return flatpickr(element, config);
}

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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
