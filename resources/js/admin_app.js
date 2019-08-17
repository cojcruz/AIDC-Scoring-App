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
		code: null,
		activeCode : null,
		findCode	: null,
		csrfToken : null,
		tempCode : null,
	},

	methods: 
	{
		getCurrentActive() {
			axios.get('/dashboard/admin/getactive').then( response => this.activeCode  = response.data[0].code);
		},

		setActive() {
			let obj = this;

			axios.post('/dashboard/admin/activate', {
				_token : this.csrfToken,
				code : this.code,
			})
				.then(function (response) {
				
				axios.get('/dashboard/admin/getactive').then( response => this.activeCode  = response.data[0].code);

				window.location.reload();

				alert('Entry Activated');
			})
				.catch(function (err) {
				obj.output = err;

				console.log(err);
			});
		},

		findEntry() {

		},

		clearActive() {
			let obj = this;

			axios.post('/dashboard/admin/clear', {
				_token : this.csrfToken,
			})
				.then(function (response) {
				alert('Active Cleared!');

				axios.get('/dashboard/admin/getactive').then( response => this.activeCode  = response.data[0].code);

				window.location.reload();
			})
				.catch(function (err) {
					obj.output = err;
			});

			
		}
	},

	computed: 
	{

	},

	mounted() 
	{
		this.getCurrentActive();


	},

	created()
	{
		this.csrfToken = document.querySelector('meta[name="csrf-token').content;
	}
})