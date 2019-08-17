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
		standby: true,
		activeCode: null,
		entry: [],
		userid: null,
		score: null,
	},

	methods: 
	{
		// startInterval() {
		// 	setInterval(function() {

		// 		axios.get('/dashboard/admin/getactive').then( response => this.activeCode  = response.data[0].code);

		// 		window.location.reload();

		// 	}, 10000);
		// },

		// getCurrentActive() {
		// 	var vm = this;
		// 	//axios.get('/dashboard/admin/getactive').then( response => vm.activeCode = response.data[0].code);
		// 	axios.get('/dashboard/admin/getactive').then( function(response) {
		// 		vm.activeCode = response.data[0].code;
		// 	});
			
		// 	console.log( window.EntryCode[0].code );
		// 	console.log( this.activeCode );

		// 	if ( vm.activeCode === null ) {
				
		// 	} else {
		// 		vm.standby = false;
		// 		axios.get('/dashboard/admin/find?code=' + window.EntryCode[0].code).then( response => vm.entry = response.data );
		// 	}
		// },
	},

	computed: 
	{

	},

	mounted() 
	{
		//this.getCurrentActive();

		//this.startInterval();
	},

	created()
	{
		this.csrfToken = document.querySelector('meta[name="csrf-token').content;
	},
})