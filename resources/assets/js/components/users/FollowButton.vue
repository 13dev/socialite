<template>
	<div v-if="userToFollow != $user().id" style="margin-top: 7px;">
		<api-request
			@success="success1"
			:resource="$api.userIsFollowing"
			:params="{id: userToFollow}"
			v-model="responseUserIsFollowing"
			:spinner-scale="0.13"
			:spinner-padding="0">
			<button class="button" 
				:class="{
					'is-info': !userIsFollowing, 
					'is-warning': userIsFollowing
				}"
				@click="trigger=true" 
				:disabled="success === false || !responseUserIsFollowing">
				<api-request
					@success="successFollow"
					@error="success = false"
					:resource="$api.follow"
					:params="{id: userToFollow}"
					v-model="response"
					:trigger.sync="trigger"
					:spinner-scale="0.13"
					:spinner-padding="0">
					<span slot="waiting">
						<span v-if="userIsFollowing">UNFOLLOW</span>
						<span v-else>FOLLOW</span>
					</span>
					<span slot="loading">
						<span>WAIT..</span>
					</span>
				</api-request>
			</button>
		</api-request>
	</div>
</template>

<script>
export default {

  name: 'FollowButton',
  props:['userToFollow'],
  data () {
    return {
		response: null,
		trigger:false,
		success: true,
		userIsFollowing: false,
		responseUserIsFollowing: null
    }
  },
  methods: {
  	successFollow(response) {
		this.userIsFollowing = response.data.is_following
  	},
  	success1(response) {
  		this.userIsFollowing = response.data.is_following
  	}
  }
}
</script>

<style lang="css" scoped>
</style>