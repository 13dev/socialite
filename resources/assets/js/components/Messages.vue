<template>
	<api-request
	@success="done"
	:resource="$api.getMessages" 
	:params="{id: this.threadId}"
	:trigger.sync="trigger"
	v-model="response">
	<div slot="waiting" class="my-auto mx-auto w-100">
		<h4>Escolhe uma conversa...</h4> 
	</div>
	<div slot="success">
		<div v-for="message in messages">
			<div class="chat-bubble mb-5" :class="{'left': isUser(message.user_id), 'right': !isUser(message.user_id)  }">
				<div class="px-2 p-1">
					{{ message.body }}
				</div>
				<small class="d-inline-flex mt-1 message-date" attr-date=""><i class="fa" style="margin-top:2px;">&#xf017;&nbsp;</i>{{ message.created_at }}</small>
			</div>
		</div>
	</div>
	<div slot="error">
		Error em obter esta conversa...
	</div>
</api-request>
</template> 
<script>
export default {
	data () {
		return {
			messages: null,
			response: null,
			trigger: false,
			threadId: null
		}
	},
	mounted() {
		console.log('unread mounted()')

		Event.$on('change-thread', (data) => {
			console.log('change thread!!')
			this.threadId = data.id
			this.trigger = true
		})

		Event.$on('send-message',(data) => {
			this.messages.push(data.lastmessage)
			this.$scrollAllBottom('messages')
		})

	},
	methods: {
		isUser (user) {
			return Global.user.id == user
		},
		done(response){
			this.messages = response.data.data
			this.$scrollAllBottom('messages')
		}
	}
}
</script>

<style scoped>

</style>