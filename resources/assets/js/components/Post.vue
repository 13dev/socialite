<template>
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
	          {{ post.user.name }}
	          <a :href="'/u/' + post.user.username" v-html="'@' + post.user.username" />
	        </strong>

	        <small>10 min ago</small>
	        <br>
	        <span class="has-text-weight-light">{{ post.post }}</span>
	      </p>
	    </div>
	    <nav class="level is-mobile" v-if="$user()">
	      <div class="level-left">
	        <a class="level-item">
	          <div class="m-r-10 reply" 
	          :class="{'cannotReply': !canReply }" 
	          @click="openReplieModal(post)">
	            <b-icon icon="reply" ></b-icon>
	              <span class="count">{{ post.count.replies }}</span>
	          </div>
	        </a>
	        <a class="level-item">
	          <div class="m-r-10 repost">
	            <b-icon icon="twitter-retweet"></b-icon>
	            <span class="count">{{ post.count.reposts }}</span>
	          </div>
	        </a>
	        <a class="level-item favorite">
	          <div class="m-r-10" v-if="post.me.favorited">
	            <b-icon icon="heart"></b-icon>
	              <span class="count">{{ post.count.favorites }}</span>
	          </div>
	          <div class="m-r-10" v-else>
	              <b-icon icon="heart-outline"></b-icon>
	              <span class="count">{{ post.count.favorites }}</span>
	          </div>
	        </a>
	        <a class="level-item" v-if="post.me.author">
	          <span class="icon m-r-5">
				<b-icon icon="dots-horizontal"></b-icon>
	          </span>
	        </a>
	      </div>
	    </nav>
	  </div>
	  <div v-if="post.me">
		  <div class="media-right" v-if="post.me.author">
		    <button class="delete"></button>
		  </div>
	  </div>
	</article>
</template>

<script>
import ReplieModal from './modals/ReplieModal'

export default {
	props: {
		post: {
			default: null
		},
		canReply: {
			default: true
		}
	},
  	name: 'Post',
	data () {
		return {
		}
	},
	mounted () {
		console.log(this.canReply)
	},
	methods: {
	    openReplieModal(post) {
	    	if(!this.canReply)
	    		return;
	    	const loading = this.$loading.open()

	      	this.$api.getPostReplies(post)
	      	.then(response => {
	        	//Stop loading
	        	loading.close()

	        	//Open Modal
		        this.modal = this.$modal.open({
		          parent: this,
		          component: ReplieModal,
		          props:{
		            data: response.data,
		            post: post
		          },
		          canCancel: false,
		          hasModalCard: true
		        })
			}).catch((error) => {
				this.handleErrors(error)
			})

	    },
	    handleErrors(error) {
	        this.$snackbarError({
	            message: 'Something wen\'t wrong (' + error.message + '), please try again...',
	        })
	    }
	}
}
</script>

<style lang="scss" scoped>
.cannotReply span {
	color: #d2d2d2!important;
}
.cannotReply span:hover,
.cannotReply span:focus {
	cursor: default!important;
}
.media-content {
  overflow: hidden !important;
}
.level-item {
  .count {
    font-size: 18px;
    vertical-align: bottom;
    font-weight: 400;
    cursor: pointer;
    color: #b4b4b4;
  }
}
.reply-active, .reply:hover,
.reply:focus{
  span.count, .icon {
    color: #5a6169;
  }
}
.repost-active, .repost:hover,
.repost:focus {
  span.count, .icon {
    color: #00b108;
  }
}

.favorite-active, .favorite:hover,
.favorite:focus {
  span.count, .icon {
    color: #e32929;
  }
}

.level-item span {
  font-weight: 600;
  color: #b4b4b4;
}
</style>