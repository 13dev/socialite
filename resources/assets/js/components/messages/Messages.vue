<template>
	<api-request
	@success="done"
	:resource="$api.getMessages" 
	:params="{id: selectedThread() }"
	:trigger.sync="trigger"
	v-model="response">
	<div slot="waiting" style="display: flex;flex-direction: column; justify-content: center;align-items: center;height: 350px; opacity: 0.5;">
		<h2 class="title">CHOOSE ONE THREAD</h2>
		<img src="assets/conv.png" style="max-width: 30%;">
	</div>
	<div slot="success">
		<div v-for="message in messages">
			<div class="chat-bubble m-b-5" :class="{'left': !isUser(message.user_id), 'right': isUser(message.user_id)  }">
				<div v-show="!isUser(message.user_id)">
					<small style="position: relative!important;">{{ message.user_name }}</small>
					<hr class="m-0"/>
				</div>
				<div class="p-l-2 p-r-2 p-1" style="word-break: break-all;">
					<render-emojis :message="message.body"></render-emojis>
				</div>
				<small v-if="message.created_at" class="m-t-3 m-r-5 message-date" attr-date="">
					<b-icon icon="clock" size="is-small"></b-icon>
					{{ message.created_at }}
				</small>
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
			channel: null,
			typing: false
		}
	},
	mounted() {
		console.log('Unread mounted()')

		Event.$on('change-thread', (data) => {
			console.log('-> Thread: ' + this.$selectedThread)
			this.connectThread(this.$selectedThread)
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
		},
		selectedThread(){
			return this.$selectedThread
		},
		connectThread(threadid){

			this.channel = Echo.join('thread.' + threadid)

		    this.channel.here((users) => {
		    	for (var i = 0; i < users.length; i++) {
		    		if(users[i].id == this.$user().id)
		    			continue

		    		Event.$emit(`is-online:add-user`, { user: users[i] })
		    	}
		    }).joining((user) => {

		    	Event.$emit(`is-online:add-user`, { user: user })

		    	console.log('Presence: joining()')

		    	setTimeout(() => {
			    	this.$toast.open({
	                    duration: 3000,
	                    message: `${user.name} is now in this conversation, send a message now!`,
	                    position: 'is-top',
	                    type: 'is-success'
	                })
		    	},1000)
		    	//Display a new online user
		        console.log(user.name);
		    })
		    .leaving((user) => {
		    	console.log('Presence: leaving()')

		    	Event.$emit(`is-online:remove-user`, { user: user })

		    	setTimeout(() => {
			    	this.$toast.open({
	                    duration: 3000,
	                    message: `${user.name} ĺeft this conversation, see you later!`,
	                    position: 'is-top',
	                    type: 'is-warning'
	                })
		    	},1000)
		    	//Display leaving user
		        console.log(user.name);
		    }).listen('.new.message.presence', (e) =>{
		    	// Reciving message
		    	// Fire event to update thread
				Event.$emit('update-thread', {
		    		convid: e.thread_id,
		    		message: e,
		    		me: false
		    	})

		    	this.messages.push(e)
		    	console.log('Presence: new.message.presence')
		    	this.$scrollAllBottom('messages')
				//Append new message to current thread
			}).listenForWhisper('typing', (user) => {
				Event.$emit('is-typing', user)
		    });
		}
	}
}
</script>
