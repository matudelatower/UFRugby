import Vue from 'vue';
// const Vue = require('vue');
// global.Vue = Vue;

global.axios = require('axios');

global.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


// Fastclick prevents the 300ms touch delay on touch devices
// var attachFastClick = require('fastclick');
// attachFastClick.attach(document.body);

import Precompetitivo from './components/precompetitivo';
import Precompetitivo1 from './components/Precompetitivo1';
import Precompetitivo2 from './components/Precompetitivo2';
import Precompetitivo3 from './components/Precompetitivo3';
import Precompetitivo4 from './components/Precompetitivo4';
import Precompetitivo5 from './components/Precompetitivo5';
import Precompetitivo51 from './components/Precompetitivo51';
import Precompetitivo6 from './components/Precompetitivo6';
import Precompetitivo7 from './components/Precompetitivo7';

Vue.component('precompetitivo', Precompetitivo);
Vue.component('precompetitivo-1', Precompetitivo1);
Vue.component('precompetitivo-2', Precompetitivo2);
Vue.component('precompetitivo-3', Precompetitivo3);
Vue.component('precompetitivo-4', Precompetitivo4);
Vue.component('precompetitivo-5', Precompetitivo5);
Vue.component('precompetitivo-5-1', Precompetitivo51);
Vue.component('precompetitivo-6', Precompetitivo6);
Vue.component('precompetitivo-7', Precompetitivo7);


import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)


import VueFormWizard from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
Vue.use(VueFormWizard)

import BlockUI from 'vue-blockui'

Vue.use(BlockUI)


const app = new Vue({
    // delimiters: ['[[', ']]'],
    el: '#app',
    data: {
    },
    methods: {

    }
});