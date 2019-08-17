<template>
	<div class="card" :class="addclass">
        <div class="card-header bg-primary text-center">
        	<h3 class="text-light">{{ title }}</h3>
       	</div>

        <div class="card-body text-center">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
	data: function() {

		return {

		}

	},

	props: ['title','addclass'],


	methods: {

	},

	mounted() {

	}
}
</script>