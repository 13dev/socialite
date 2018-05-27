<template>
	<div style="width:100%!important;">
		<b-input placeholder="Search..."
            type="search"
            icon="magnify"
            v-model="search"
            @input="searchMethod()">
        </b-input>
	</div>
</template>

<script>
export default {

  	name: 'SearchThread',

	data () {
		return {
			search: ''
		}
	},
	methods: {
		searchMethod() {
			console.log('search')
			Event.$emit('search-threads', { data: this.search })
		}
	}
}
</script>
