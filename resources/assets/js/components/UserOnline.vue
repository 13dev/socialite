<template>
	<div style="display: flex;" class="p-t-5" v-show="users.length > 0"> 
		<small class="m-r-15">Online now: </small>
		<div v-for="user in users" class="t-user">
			<b-tooltip :label="user.name">
				<figure class="image is-24x24">
				  <img  class="is-rounded" src="https://bulma.io/images/placeholders/24x24.png">
				</figure>
			</b-tooltip>
		</div>
	</div>
</template>

<script>
export default {

  name: 'UserOnline',
  data () {
    return {
    	users: [],
    	timeoutTyping: null
    }
  },
  mounted() {

    // Add user to array
  	Event.$on(`is-online:add-user`, (data) => {
  		// Adds users to array
  		if (!this.users.some(user => user.id === data.user.id)) {
  			console.log('Adicionar user - userOnline')
  			this.users.push(data.user)
  		}
  	})

    //Remove one user from array
  	Event.$on(`is-online:remove-user`, (data) => {
  		//Remove user from array
  		for (var i = 0; i < this.users.length; i++) {
  			if(this.users[i].id == data.user.id){
  				this.users.splice(i, 1)
          break
        }
  		}
  	})

    //Clean users array
    Event.$on(`is-online:remove-all-users`, (data) => {
      this.users = []
    })

  }
}
</script>

<style lang="css" scoped>

img {
	border: 2px solid #08ff25;
}

.t-user:not(:first-child) {
	margin-left: -5px;
}
</style>