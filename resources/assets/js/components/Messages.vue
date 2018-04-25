<template>
	<api-request
	@success="done"
	:resource="$api.getMessages" 
	:params="{id: selectedThread() }"
	:trigger.sync="trigger"
	v-model="response">
	<div slot="waiting" class="my-auto mx-auto w-100">
		<h4>Escolhe uma conversa...</h4> 
	</div>
	<div slot="success">
		<div v-for="message in messages">
			<div class="chat-bubble mb-5" :class="{'left': !isUser(message.user_id), 'right': isUser(message.user_id)  }">
				<div class="px-2 p-1">
					{{ message.body }}
				</div>
				<small v-if="message.created_at" class="d-inline-flex mt-1 message-date" attr-date=""><i class="fa" style="margin-top:2px;">&#xf017;&nbsp;</i>{{ message.created_at }}</small>
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
		    	console.log('Presence: here()')
		    	console.log(users);
		        //Display online users
		    })
		    .joining((user) => {
		    	console.log('Presence: joining()')
		    	//Display a new online user
		        console.log(user.name);
		    })
		    .leaving((user) => {
		    	console.log('Presence: leaving()')
		    	//Display leaving user
		        console.log(user.name);
		    }).listen('.new.message.presence', (e) =>{
		    	this.messages.push(e)
		    	
		    	console.log('Presence: new.message.presence')
		    	console.log(e)
				//Append new message to current thread
			}).listenForWhisper('typing', (e) => {
				this.$scrollAllBottom('messages')
		        console.log(e.name);
		        let m = this.messages.find(function(element) {
				  return element.id == Global.user.id + 't';
				});

		    	if(m == null){
		    		this.messages.push({
		        		body: e.name + ' is typing...',
		        		id: Global.user.id + 't'

		        	})
		    	}
		       

		        setTimeout(()=> {
		        	this.messages = this.messages.filter(u => u.id != Global.user.id + 't');
		        }, 4000)
		    });
		}
	}
}
</script>

<style scoped>

</style>