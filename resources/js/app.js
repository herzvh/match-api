import Vue from "vue";
import App from "./components/App";
import axios from 'axios'
import VueAxios from 'vue-axios'

require('./bootstrap');

Vue.component('app', App);

Vue.use(VueAxios, axios);

const app = new Vue({
    el: '#app'
});
