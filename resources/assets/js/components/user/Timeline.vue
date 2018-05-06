<template>
	<api-request 
	@success="done" 
	:resource="$api.getUserTimeline"
  :params="{id: user.id }"
	v-model="response">
		<ul v-if="response" class="list-group list-group-flush">
			<li class="list-group-item" v-for="tl in timeline">
        <h5>{{ tl.user.name }} <small>@{{ tl.user.username }}</small></h5>
          <small v-show="tl.is_repost">
            @{{ user.username }} repost
          </small>
				<div class="post">
            <p>{{ tl.post }}</p>
        </div>
        <div class="p-options">
          <div class="p-reply mr-4">
            <i class="fa fa-reply"></i>
            <span class="mx-1">{{ tl.count.replies }}</span>
          </div>
          <div class="p-retweet mr-4">
            <i class="fa fa-retweet"></i>
            <span class="mx-1">{{ tl.count.reposts }}</span>
          </div> 
          <div class="p-favorite mr-4">
            <i class="fa" :class="{'fa-star': tl.me.favorited, 'fa-star-o': !tl.me.favorited || !gUser() }"></i>
            <span class="mx-1">{{ tl.count.favorites }}</span>
          </div>
          <div class="p-more" v-if="tl.me.author">
            <i class="fa fa-ellipsis-h"></i>
          </div>
        </div>
			</li>
		</ul>
</api-request>
</template>

<script>
export default {

  name: 'Timeline',
  props: ['user'],
  data () {
    return {
    	timeline: null,
    	response: null
    }
  },
  methods: {
  	done(response){
  		this.timeline = response.data.data
      //console.log(JSON.stringify(this.timeline))
      //  //#ffcc4d
  	},
    gUser(){
      return Global.user
    }
  }
}
</script>

<style lang="css" scoped>
.p-options div {
  display: inline-block;
}

.p-options i {
  font-size: 18px;
}

.p-favorite i {

  color: #f4900c;
}
</style>