<template>
	<div style="display:flex;" v-if="users.length > 0"> 
		<div v-for="user in users" class="t-user">
			<b-tooltip :label="user.name">
				<figure class="image is-24x24">
				  <img  class="is-rounded" src="https://bulma.io/images/placeholders/24x24.png">
				</figure>
			</b-tooltip>
		</div>
		<span class="has-text-grey-dark">&nbsp; is typing...</span>
	</div>
</template>

<script>
export default {

  name: 'UserTyping',
  data () {
    return {
    	users: [],
    	timeoutTyping: null
    }
  },
  mounted() {
  	console.log('user typings')
  	Event.$on('is-typing', (data) => {

  		// Adds users to array
		if (!this.users.some(user => user.id === data.user.id)) {
			console.log('Adicionar user - window.userTyping')
			this.users.push(data.user)
			//console.log(data.user)

			// remove user after x seconds
			this.removeTyping()
		}
  	})

  },
  methods: {
  		removeTyping(time = 2000){
  			clearTimeout(this.timeoutTyping);
			this.timeoutTyping = setTimeout(()=> {
				this.users = this.users.filter(user => user.id == Global.user.id);
			}, time)
		},
  }
}
</script>

<style lang="css" scoped>

img {
	border: 2px solid #fff;
}

.t-user:not(:first-child) {
	margin-left: -5px;
}
</style>