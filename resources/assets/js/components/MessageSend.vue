<template>
	<div style="width: 100%;">
		<div class="field has-addons" style="border-radius: 0; height: 48px !important;">
		  <div class="control"  style="width: 100%;">
		    <input 
		    :disabled="success === false || !changeThread" 
		    class="input" 
		    type="text"
		    style="height: 48px; border-radius:0;" 
		    v-model="message"
		    @keydown.enter="trigger=true"
		    @keyup="writingMessage"
		    placeholder="Message">
		  </div>
		  <div class="control">
		    <a 
		    @click="trigger=true" 
			:disabled="success === false || !changeThread" 
			class="button is-primary"
			style="height: 48px;border-radius:0;">

			    <api-request
					@success="successMessage"
					@loaded="loadedMessage"
					@error="success = false"
					:resource="$api.sendMessage"
					:params="{thread_id: $selectedThread, message: this.message}"
					v-model="response"
					:trigger.sync="trigger"
					:spinner-scale="0.13"
					:spinner-padding="0">
					<span slot="waiting">
						<i class="fa fa-send"></i> Enviar
					</span>
					<span slot="loading">
						<i class="fa fa-send"></i> Enviando...
					</span>
				</api-request>
		    </a>
		  </div>
		</div>
	</div>
</template>
<script>
export default {
	data () {
		return {
			message: null,
			changeThread: null,
			trigger: false,
			success: null,
			response: null,
			textBtn: 'Enviar'
		}
	},
	mounted() {
		Event.$on('change-thread',(data) => {
			this.changeThread = true
		})

	},
	methods: {
		sendMessage(){
			this.$api.sendMessage()
			this.message = ''
		},
		successMessage(response){
			this.success = true
			let lastmessage = response.data.data

			if(lastmessage != null){
				Event.$emit('send-message',{
					lastmessage: lastmessage
				})
			}
			
		},
		loadedMessage(response){
			this.message = ''
		},
		writingMessage(){
			console.log('user is typing..')
			//this.$scrollAllBottom('messages')
			// Pass all user data
			Echo.join('thread.' + this.$selectedThread).whisper('typing', {
		        user: Global.user,
		    })
		}
	}
}
</script>

<style lang="scss" scoped>
.inner-addon:hover .buttonsend {
	&:hover{
		font-size:27px;
	}
	cursor: pointer
}
</style>