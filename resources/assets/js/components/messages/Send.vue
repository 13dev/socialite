<template>
	<div style="width: 100%;">
		<div class="field has-addons" style="margin-bottom: 0; border-radius: 0; height: 48px !important;">
		  <div class="control has-icons-right"  style="width: 100%;">
		    <input 
		    :disabled="success === false || !changeThread" 
		    class="input" 
		    type="text"
		    style="height: 48px; border-radius:0;" 
		    v-model="message"
		    @keydown.enter="trigger=true"
		    @focus="showPicker=false"
		    @keyup="writingMessage"
		    placeholder="Message">

		    <div @click="showEmojis()" class="icon is-right show-emojis">
		    	<i class="mdi mdi-emoticon mdi-24px"></i>
		    </div>

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
		<picker 
		:style="{ position: 'absolute', bottom: '50px', right: '50px' }" 
		:showPreview="false"
		@select="addEmoji"
		v-show="showPicker"/>
	</div>
</template>
<script>
import { Picker, Emoji } from 'emoji-mart-vue'
export default {
	components: {
		Picker, Emoji
	},
	data () {
		return {
			message: null,
			changeThread: null,
			trigger: false,
			success: null,
			response: null,
			textBtn: 'Enviar',
			showPicker: false,
		}
	},
	mounted() {
		Event.$on('change-thread',(data) => {
			this.changeThread = true
		})

	},
	methods: {
		showEmojis(){
			if(this.success === false || !this.changeThread)
				return;

			this.showPicker = !this.showPicker
		},
		addEmoji(emoji){
			if(this.message == null)
				this.message = emoji.colons
			else
				this.message += emoji.colons
		},
		sendMessage(){
			this.$api.sendMessage()
			this.message = ''
		},
		successMessage(response){
			this.success = true
			let lastmessage = response.data.data

			if(lastmessage != null){
				// Reciving message
		    	// Fire event to update thread
				Event.$emit('update-thread', {
		    		convid: lastmessage.thread_id,
		    		message: lastmessage,
		    		me: true
		    	})

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

.show-emojis {
	top:5px!important; 
	right: 5px!important;
	pointer-events:all!important;
}

.show-emojis:hover,
.show-emojis:focus {
	color: #575757!important;
}

</style>