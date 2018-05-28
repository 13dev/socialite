<template>
	<div>
		<api-request 
		@success="done"
	 	@error="handleErrors"
	 	@loading="loading"
		:resource="$api.insertPost"
	  	:params="{post: message}"
		v-model="response"
		:trigger.sync="trigger"
		:spinner-scale="0.13"
		:spinner-padding="0">
		<div slot="waiting">
			<b-input
				rows="1"
				maxlength="200" 
				type="textarea" 
				placeholder="What are you thinking?..."
				v-model="message"
				@focus="showButton=true"
				@blur="blur()"
				name="post">
			</b-input>
			<button @click="clickButton()" v-show="showButton" style="margin-top: -60px;float: right; margin-right: 10px;" class="button is-info is-small">
	            <b-icon icon="plus" size="is-small"></b-icon>
	            <span>Post</span>
	        </button>
		</div>		
			
	    </api-request>

	</div>
</template>

<script>
export default {

  name: 'Form',

  data () {
    return {
    	message: '',
    	showButton:false,
    	trigger: false,
    	response: null,
    	params: null,
    	loadingo: null
    }
  },
  methods: {
  	done(response){
  		let vm = this
  		setTimeout(function() {
  			vm.message = ''
  			if(vm.loadingo)
  			vm.loadingo.close()
  		},2000)

  		this.$toast.open({
            message: 'Post Was Sent!',
            type: 'is-success'
        })

  	},
  	handleErrors(response){
  		this.loadingo = this.$loading.open()
  		this.$toast.open({
            message: 'Error Sending Post!',
            type: 'is-danger'
        })
  	},
  	loading(response){
  		this.loadingo = this.$loading.open()
  		 this.$toast.open({
            message: 'Sending... Please Wait!',
            type: 'is-info'
        })
  	},
  	clickButton() {
  		this.trigger = true
  		console.log('e324')
  	},
  	blur() {
  		setTimeout(function(){
  			this.showButton = false
  		},1000)

  	}
  }
}
</script>

<style lang="css">
textarea[name="post"] {
	max-height: 50px!important;
	resize: none!important;
	padding-right: 10px;
	overflow:hidden;
}

textarea[name="post"]:focus {
	border-right: 80px solid #e6e6e6!important;
}

textarea[name="post"]:blur {
	border-right: none!important;
}
</style>