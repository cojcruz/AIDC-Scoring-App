require('jquery');
require('./bootstrap');

window.Vue = require('vue');
window.axios = require('axios');
window.VueRouter = require('vue-router');

import Vue from 'vue';
import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';

Vue.use(BootstrapVue);
Vue.use(VueRouter);

Vue.component('modal', require('./components/modal'));
Vue.component('activeform', require('./components/forms/activeform').default)
Vue.component('card', require('./components/card').default);

const router = new VueRouter();

new Vue({
	el: "#app",

	data: 
	{
		
	},

	methods: 
	{
		
	},

	computed: 
	{

	},

	mounted() 
	{
		
	},

	created()
	{
		this.csrfToken = document.querySelector('meta[name="csrf-token').content;
	}
})