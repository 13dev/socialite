<template>
	<api-request 
	@success="done" 
	:resource="$api.getUserTimeline"
  :params="{id: user.id }"
	v-model="response">

<div v-if="response" v-for="tl in timeline" class="post">
  <div v-if="tl.is_repost">
    <i class="mdi mdi-twitter-retweet is-size-5" style="color: #00b108;"></i>
    <a :href="'/u/' + tl.user_repost.username" 
      v-html="'@' + tl.user_repost.username" /> 
    repost
  </div>
<article class="media">
  <figure class="media-left">
    <p class="image is-64x64">
      <img class="is-rounded" src="https://bulma.io/images/placeholders/128x128.png">
    </p>
  </figure>
  <div class="media-content">
    <div class="content m-b-2">     
      <p>
        <strong>
          {{ tl.user.name }}
          <a :href="'/u/' + tl.user.username" v-html="'@' + tl.user.username" />
        </strong>

        <small>10 min ago</small>
        <br>
        <span class="has-text-weight-light">{{ tl.post }}</span>
      </p>
    </div>
    <nav class="level is-mobile">
      <div class="level-left">
        <a class="level-item">
          <span class="icon m-r-5">
            <i class="mdi mdi-reply"></i>
            {{ tl.count.replies }}
          </span>
        </a>
        <a class="level-item">
          <span class="icon m-r-5">
            <i class="mdi mdi-twitter-retweet"></i>
            {{ tl.count.reposts }}
          </span>
        </a>
        <a class="level-item">
          <span class="icon m-r-5">
            <i class="mdi" 
                :class="{
                  'mdi-heart': tl.me.favorited, 
                  'mdi-heart-outline': !tl.me.favorited || !gUser() 
                }"></i>
            {{ tl.count.favorites }}
          </span>
        </a>
        <a class="level-item" v-if="tl.me.author">
          <span class="icon m-r-5">
            Admin
          </span>
        </a>
      </div>
    </nav>
  </div>
  <div class="media-right" v-if="tl.me.author">
    <button class="delete"></button>
  </div>
</article>
</div>
    <div v-if="timeline && timeline.length == 0" class="my-5 w-50 mx-auto">
        <h5> Este utilizador não tem nenhuma publicação </h5>
    </div>
</api-request>
</template>

<script>
export default {

  name: 'Timeline',
  props: ['user'],
  data () {
    return {
      showModal: true,
    	timeline: null,
    	response: null,
      option: {
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
      }
    }
  },
  methods: {
    toggleModal() {
        this.showModal = ! this.showModal
    },

    handleOpen() {
        console.log('Modal is about to open.');
    },

    handleClose() {
        console.log('Modal has closed.');
        
        this.showModal = false
    },
  	done(response){
  		this.timeline = response.data.data
      console.log(JSON.stringify(this.timeline))
      this.handleOptions(this.timeline)
      //  //#ffcc4d
  	},
    gUser(){
      return Global.user
    },
    handleOptions(timeline = {}) {

    }
  }
}
</script>

<style lang="scss" scoped>
.post:not(:last-child) {
  border-bottom: 1px solid #dbdbdb;
  margin-bottom: 5px;
  padding-bottom: 5px;
}
.media-content {
  overflow: hidden !important;
}
.level-item {
  margin-left: 2px;
  span {
    font-size: 18px;
    cursor: pointer;
    color: #b4b4b4;
    margin-left: 10px;
    margin-right: 10px;
  }

  span > i {
    margin-right: 5px;
  }
}
.level-item > span:hover,
.level-item > span:focus {
  color: #5a6169;
}


.level-item span {
  font-weight: 600;
  color: #b4b4b4;
}

.p-favorite i {
  color: #f4900c;
}
</style>