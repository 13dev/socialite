<template>
	<div>
		<api-request 
		@success="done"
	 	@error="handleErrors"
	 	@loading="loading"
		:resource="$api.insertPost"
	  :params="{
      post: message, 
      parent_id: parentId
    }"
		v-model="response"
		:trigger.sync="trigger"
		:spinner-scale="0.13"
		:spinner-padding="0">
		<div slot="waiting">
      <div class="control has-icons-left">
        <b-input
          rows="1"
          maxlength="200" 
          type="textarea" 
          :placeholder="placeholderText"
          v-model="message"
          @focus="focus()"
          @blur="blur()"
          name="post">
        </b-input>
        <div v-show="showButton">
           <button @click.prevent="clickButton()" style="margin-top: -60px;float: right; margin-right: 10px;" class="button is-info is-small">
          <b-icon icon="plus" size="is-small" style="color: #fff;height: 0;pointer-events: all;position: relative;width: 100%;z-index: 1;"></b-icon>
          <span>{{ this.buttonText }}</span>
        </button>
        </div>
       
        <span @click="showEmojis()" class="icon is-left show-emojis">
          <i class="mdi mdi-emoticon mdi-24px"></i>
        </span>
      </div>
          <picker 
      :style="pickerStyle" 
      :showPreview="false"
      @select="addEmoji"
      v-show="showPicker"/>
		</div>	
	    </api-request>
	</div>
</template>

<script>
import { Picker, Emoji } from 'emoji-mart-vue'
export default {

  name: 'Form',
  props: {
      parentId: {
        default: null,
      },
      buttonText: {
        default: 'POST',
        type: String,
      },
      placeholderText: {
        default: 'What are you thinking?...',
        type: String
      },
      alwaysButton: {
        default: false,
        type:Boolean
      },
      pickerStyle: {
        default: () => { 
          return { 
            position: 'absolute', 
            top: '130px', 
            'z-index': '2', 
            width: '250px', 
            height: '250px'
          }
        },
        type: Object
      }
  },
  components: {
    Picker, Emoji
  },
  data () {
    return {
    	message: '',
    	showButton: this.alwaysButton,
    	trigger: false,
    	response: null,
    	loadingo: null,
      showPicker: false
    }
  },
  methods: {
    showEmojis(){
      this.showPicker = !this.showPicker
      console.log('emoji!')
    },
    addEmoji(emoji){
      if(this.message == null)
        this.message = emoji.colons
      else
        this.message += emoji.colons
    },
  	done(response){
  		let vm = this
  		setTimeout(function() {
  			vm.message = ''
  			if(vm.loadingo)
  			vm.loadingo.close()
  		},2000)

  		this.$toast.open({
            message: 'It was sent successfully!',
            type: 'is-success'
        })

  	},
  	handleErrors(response){
  		this.loadingo = this.$loading.open()
  		this.$toast.open({
            message: 'Error sending post, try later!',
            type: 'is-danger'
        })
      setTimeout(function() {
        window.location.href = '/'
      }, 2000)
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
      this.showPicker = false
  		console.log('e324')
  	},
    focus() {
      if(!this.alwaysButton)
        this.showButton = true
      this.showPicker = false
    },
  	blur() {
      console.log('blurr!')
      this.showPicker = false

      let vm = this
  		setTimeout(function(){
        if(!vm.alwaysButton)
  			 vm.showButton = false
  		},300)

  	}
  }
}
</script>

<style lang="css">
textarea[name="post"] {
	max-height: 50px!important;
	resize: none!important;
	padding-right: 10px;
  padding-left: 30px;
	overflow:hidden;
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

textarea[name="post"]:focus {
	border-right: 80px solid #e6e6e6!important;
}

textarea[name="post"]:blur {
	border-right: none!important;
}
</style>