<template>
	<div>
		<api-request 
		@success="done"
	 	@error="handleErrors"
		:resource="$api.getUserFeed"
	  	:params="{id: user().id }"
		v-model="response" style="margin:0 auto;">
			<div v-if="response" v-for="post in posts" class="post">
				  <div v-if="post.is_repost">
				    <i class="mdi mdi-twitter-retweet is-size-5" style="color: #00b108;"></i>
				    <a :href="'/u/' + post.user_repost.username" 
				      v-html="'@' + post.user_repost.username" /> 
				    repost
				  </div>
				<post :post="post"></post>
			</div>
		</api-request>
	</div>
</template>

<script>
export default {

  name: 'Feed',

  data () {
    return {
    	response: null,
    	posts:null
    }
  },
  methods: {
  	user(){
  		return this.$user()
  	},
  	handleErrors(error) {

  	},
  	done(res) {
  		this.posts = res.data
  	}
  }
}
</script>

<style lang="css" scoped>

.post:not(:last-child) {
  border-bottom: 1px solid #dbdbdb;
  margin-bottom: 5px;
  padding-bottom: 5px;
}

</style>