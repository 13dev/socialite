<template>
	<div>
		<api-request
		@success="successMessages"
		@error="success = false"
		spinner="smallspinner"
		:resource="$api.userUnreadMessages"
		v-model="response"
		:spinner-scale="1"
		:spinner-padding="0"
		:trigger.sync="trigger"
		>
		<span v-if="count != 0">
			(<span class="badge badge-primary badge-pill unread">{{ count }}</span>)
		</span>
	</api-request>
	</div>
</template>
<script>
export default {
	data () {
		return {
			count: 0,
			response: null,
			success: false,
			trigger: false
		}
	},
	mounted() {
		console.log('unread mounted()')

		window.Echo.private('messages.' + Global.user.id)
		.listen('.new.message', (e) =>{

			// New message
			setTimeout(() => {
		    	this.$toast.open({
                    duration: 3000,
                    message: `You have a new message!`,
                    position: 'is-top',
                    type: 'is-success'
                })
		    },1000)
		    
			this.trigger = true
			blink('li.nav-item.message')

		})
		.listen('.new.message.thread', (e) => {
			// New message in new thread!
			setTimeout(() => {
		    	this.$toast.open({
                    duration: 3000,
                    message: `You are in new thread!`,
                    position: 'is-top',
                    type: 'is-success'
                })
		    },1000)
			this.isLoading = false
			console.log('.new.message.thread')
			console.log(e)
	        //Global.convs.push(e.convid)
	        this.trigger = true
	        	
	        blink('li.nav-item.message')
	        })

	},
	methods: {
		successMessages(response){
			this.success = true
			this.count = response.data.count
		}
	}
}
</script>

<style scoped>
div {
	display: inline;
}
</style>