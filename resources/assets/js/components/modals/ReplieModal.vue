<template>
<form action="">
	<div class="modal-card" has-modal-card>
	    <header class="modal-card-head">
	        <p class="modal-card-title">Replies</p>
	        <div @click="$parent.close()" class="close-modal">
	        	<b-icon icon="close" style="justify-content: flex-end;"></b-icon>
	        </div>
	    </header>
	    <section class="modal-card-body" style="padding: 0;">
	    	<div 
		    	class="p-l-15 p-r-15 p-t-15 p-b-5" 
		    	style="background-color: #e9e9e9;border-left: 4px solid #168efe;margin-bottom: 15px;">
	    		<post :post="post" :can-reply="false"></post>
	    	</div>
	    	<div>
	    		<div v-for="p in data" class="posts p-r-50 p-l-50">
		    		<post :post="p"></post>
		    	</div>
		    	<div v-if="!data || data && data.length == 0">
		    		Esta publicação não tem nenhuma resposta
		    	</div>
	    	</div>
	    </section>
	    <footer class="modal-card-foot" style="flex-wrap: wrap;">
	    	<div style="width: 100%;">
	    		<post-send 
	    		:always-button="true" 
	    		:parent-id="post.id"
	    		:picker-style="{
	    			position: 'absolute', 
	    			top: '-200px', 
	    			'z-index': '2', 
	    			width: '280px', 
	    			height: '200px'
	    		}"
	    		 placeholder-text="Write something awesome!" 
	    		 buttonText="REPLIE"
	    		 ></post-send>
	    	</div>
	    </footer>
	</div>
</form>
</template>

<script>
import Form from '../posts/Form.vue'
export default {

  name: 'ReplieModal',
  props:['data', 'post'],
  components: {
  	'post-send': Form
  },
  data () {
    return {
    	replieText: ''
    }
  },
  mounted(){
  	//this.$emit('close')
  	//console.log(JSON.stringify(this.data))
  }
}
</script>

<style lang="scss" scoped>

.posts:not(:last-child) {
  border-bottom: 1px solid #dbdbdb;
  margin-bottom: 5px;
  padding-bottom: 5px;
}

.close-modal:hover,
.close-modal:focus {
	cursor: pointer;
	color: #989898;
}
</style>