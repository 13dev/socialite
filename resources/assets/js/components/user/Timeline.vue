<template>
	<api-request 
	@success="done"
  @error="handleErrors"
	:resource="$api.getUserTimeline"
  :params="{id: user.id }"
	v-model="response" style="margin:0 auto;">

<div v-if="response" v-for="post in timeline" class="post">
  <div v-if="post.is_repost">
    <i class="mdi mdi-twitter-retweet is-size-5" style="color: #00b108;"></i>
    <a :href="'/u/' + post.user_repost.username" 
      v-html="'@' + post.user_repost.username" /> 
    repost
  </div>
  <post :post="post"></post>
</div>
<div v-if="timeline && timeline.length == 0">
    <h3 class="has-text-centered"> Este utilizador não tem nenhuma publicação </h3>
</div>
</api-request>
</template>

<script>

export default {

  name: 'Timeline',
  props: ['user'],
  components: {
    'post': require('../Post.vue')
  },
  data () {
    return {
    	timeline: null,
    	response: null,
      /*option: {
        count: {
          favorited: null,
          reposted: null,  
          replied: null,        
        },
        me: {
          favorited: false,
          reposted: false,  
          replied: false, 
          author: false,
        }
      } */
    }
  },
  methods: {
    done(response){
      this.timeline = response.data
      console.log('post 0')
      console.log(JSON.stringify(this.timeline[0]))
      //this.handleOptions(this.timeline)
      //#ffcc4d
    },
    handleErrors(error) {
      this.$snackbarError({
          message: 'Something wen\'t wrong (' + error.message + '), please try again...',
      })
    }
  },
}
</script>

<style lang="scss" scoped>
.post:not(:last-child) {
  border-bottom: 1px solid #dbdbdb;
  margin-bottom: 5px;
  padding-bottom: 5px;
}

</style>