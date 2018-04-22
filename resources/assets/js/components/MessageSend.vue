<template>
	<div v-if="changeThread">


		<div class="input-group input-group mt-auto">
			<input 
			type="text" 
			:disabled="success === false"
			v-model="message" 
			class="form-control rounded-0 border-0 border-top" 
			placeholder="Mensagem..." 
			aria-label="Mensagem...">
			<div class="input-group-append">
				<button 
				@click="trigger=true" 
				:disabled="success === false" 
				class="btn border-primary
				 btn-primary rounded-0">

					<api-request
					@success="successMessage"
					@loaded="loadedMessage"
					@error="success = false"
					:resource="$api.sendMessage"
					:params="{thread_id: this.threadid, message: this.message}"
					v-model="response"
					:trigger.sync="trigger"
					:spinner-scale="0.13"
					:spinner-padding="0"
					>
					<span slot="waiting">
						<i class="fa fa-send"></i> Enviar
					</span>
					<span slot="loading">
						<i class="fa fa-send"></i> Enviando...
					</span>
				</api-request>

			</button>
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
			threadid: null,
			success: null,
			response: null,
			textBtn: 'Enviar'
		}
	},
	mounted() {
		Event.$on('change-thread',(data) => {
			this.changeThread = true
			this.threadid = data.id
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