<template>
	<div>
		<li class="list-group-item" v-for="thread in threads">
		    <h5>
		        <a href="">{{ thread.subject }}</a>
		    </h5>
		    <p>
		        <strong>Creator:</strong>
		        <br/>
		        <strong>Participants:</strong>
		    </p>
		</li>
	</div>
</template>
<script>
	export default {
		props:['threads'],
		data () {
			return {
			}
		}
	}
</script>

<style scoped>

</style>