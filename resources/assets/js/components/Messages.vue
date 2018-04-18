<template>
	<div>
	<div v-for="message in messages">
		<div class="chat-bubble mb-5" :class="{'left': isUser(message.user_id), 'right': !isUser(message.user_id)  }">
	      <div class="p-3">
	        {{ message.body }}
	      </div>
	      <small class="d-inline-flex mt-1 ml-2 message-date" attr-date=""><i class="fa" style="margin-top:2px;">&#xf017;&nbsp;</i>{{ message.created_at }}</small>
	    </div>
	</div>
</div>
</template>
<script>
	export default {
		data () {
			return {
				messages: null
			}
		},
		mounted() {
			console.log('unread mounted()')

		},
		created() {
			Event.$on('change-thread', this.getMessages(this.$selectedThread))
		},
		methods: {
			isUser (user) {
				return Global.user.id == user
			},
			getMessages(thread){
				this.isLoading = true
				axios.get('/api/v1/messages/' + thread)
				.then(response => {
					console.log(response)
					this.isLoading = false
			        this.messages = response.data.data
		      	}).catch(response => {
		      		this.isLoading = false
					console.log(response)
		      	})
			}
		}
	}
</script>

<style scoped>

</style>