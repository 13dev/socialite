<template>
	<article class="media">
	  <figure class="media-left">
	    <p class="image is-64x64">
	      <img class="is-rounded" style="border: 2px solid #fff;" :src="'/' + post.user.avatar.medium">
	    </p>
	  </figure>
	  <div class="media-content">
	    <div class="content m-b-2">     
	      <p>
	        <strong>
	          {{ post.user.name }}
	          <a :href="'/u/' + post.user.username" v-html="'@' + post.user.username" />
	        </strong>
	        <small class="has-text-grey has-text-weight-light">&#8226; {{ post.created_at.humans }}</small>
	        <br>
	        <span class="has-text-weight-light">
	        	<render-emojis :message="post.post"></render-emojis>
	    	</span>
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
				    <api-request 
					@success="doneRepost"
				 	@error="handleErrorsRepost"
					:resource="$api.repostPost"
					:params="{
				      id: post.id, 
				      user_id: $user().id
				    }"
					v-model="responseRepost"
					:trigger.sync="triggerRepost">
					<div slot="waiting">
						<div @click="triggerRepost=true" :class="{ 'reposted': isReposted }"> 
							<b-icon icon="twitter-retweet"></b-icon>
				            <span class="count">{{ countRepostt }}</span>
						</div>
					</div>
					<div slot="loading">
						<small-spinner></small-spinner>
					</div>
				    </api-request>
	    	    </div>
	        </a>
	        <!-- favorite -->
	        <a class="level-item favorite">
	          	<div class="m-r-10">
				    <api-request 
					@success="doneFavorite"
				 	@error="handleErrorsFavorite"
					:resource="$api.favoritePost"
					:params="{
				      id: post.id, 
				      user_id: $user().id
				    }"
					v-model="responseFavorite"
					:trigger.sync="triggerFavorite">
					<div slot="waiting">
						<div @click="triggerFavorite=true" :class="{ 'favorited': isFavorited}">
							<span class="icon">
				          		<i class="mdi mdi-24px" 
				          		:class="{
				          			'mdi-heart': isFavorited, 
				          			'mdi-heart-outline': !isFavorited
				          		}"></i>
				        	</span>
				            <span class="count">{{ countFavorite }}</span>
						</div>
					</div>
					<div slot="loading">
						<small-spinner></small-spinner>
					</div>
				    </api-request>
	    	    </div>
	        </a>
	        <!-- / favorite -->
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
import ReplieModal from '../modals/ReplieModal'
import SmallSpinner from '../SmallSpinner'
export default {
	props: {
		post: {
			default: null
		},
		canReply: {
			default: true
		},
	},
	components: {
		'small-spinner': SmallSpinner
	},
  	name: 'Post',
	data () {
		return {
			isFavorited: false,
			isReposted: false,
			countFavorite: 0,
			countRepostt: 0,
			triggerFavorite: false,
			responseFavorite: null,
			triggerRepost: false,
			responseRepost: null,

		}
	},
	mounted () {
		if(this.post.hasOwnProperty("me")){
			this.isReposted = this.post.me.reposted
			this.isFavorited = this.post.me.favorited
		}

		this.countFavorite = this.post.count.favorites
		this.countRepostt = this.post.count.reposts
	},
	methods: {
		doneFavorite(response){
			this.isFavorited = response.data.favorited
			if(this.isFavorited)
					this.countFavorite++
				else
					this.countFavorite = (this.countFavorite > 0) ? this.countFavorite - 1 : 0
		},
		handleErrorsFavorite(response){
			//show error message
		},
		doneRepost(response){
			this.isReposted = response.data.reposted
			console.log(response.data.reposted)

			if(this.isReposted)
				this.countRepostt++
			else
				this.countRepostt = (this.countRepostt > 0) ? this.countRepostt - 1 : 0
		},
		handleErrorsRepost(response){
			//show error message
		},
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
.reposted {
	color: #00b108!important;
	span {
		color: #00b108!important;
	}
}

.favorited {
	color: #e32929!important;
	span {
		color: #e32929!important;
	}
}

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

figure img {
	width: 64px;
	height: 64px;
	object-fit:cover;
}
</style>