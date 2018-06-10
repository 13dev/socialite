<template>
		<b-dropdown class="noti">
			<a class="navbar-item" slot="trigger" style="color: #000;">
				<b-icon icon="bell"></b-icon>
				<span :class="{'badge is-badge-warning is-badge-small': unread } " data-badge="">
					Notifications
				</span>
				
		     </a>
            <b-dropdown-item custom v-if="notifications" style="width: 400px;">
            	<div style="display: flex; justify-content: flex-end; margin-bottom: 2px; padding: 10px; box-shadow: 0 4px 2px -2px #d6d3d3;" v-show="notifications.length != 0">
					<a>Mark all as read.</a>
				</div>
            	<api-request
					@success="successNotifications"
					@error="success = false"
					:resource="$api.userNotifications"
					:params="{ id: $user().id }"
					v-model="response">
					<div style="max-height: 10rem; overflow-y: scroll;">
            			<div>
            				<div style="display: flex;flex-direction: column; justify-content: center;align-items: center;height: 10rem; opacity: 0.5;" v-show="notifications.length == 0">
								<span class="subtitle">No Notifications!</span>
								<img src="/assets/bell.png" style="max-width: 20%;">
							</div>
		            		<article class="media" :class="{'new-noti': noti.hasOwnProperty('new')}" v-for="noti in notifications" :type="noti.type">
								<figure class="media-left m-t-5 m-l-10" v-if="noti.from">
									<p class="image is-32x32">
									  	<img class="is-rounded" style="width:32px; height: 32px;" :src="'/' + noti.from.avatar.medium">
									</p>
								</figure>
								<div class="media-content">
									<div class="content">
										<!-- New message Notification! -->
										<div v-if="noti.type.includes('NewMessage')">
											<b-icon icon="message-text" size="is-small"></b-icon>
											<strong>
												<a href="/messages">New Message</a>
											</strong> &#8226;
											<small>{{ noti.created_at }}</small>
											<br> 
											<p><vue-markdown>{{noti.notification}}</vue-markdown></p>
										</div>
											<div v-if="noti.type.includes('NewPost')">
											<b-icon icon="comment-text" size="is-small"></b-icon>
											<strong>
												<a href="/u/username">New Post</a>
											</strong> &#8226;
											<small>{{ noti.created_at }}</small>
											<br> 
											<p><vue-markdown>{{noti.notification}}</vue-markdown></p>
										</div>
										<!-- ./New message Notification! -->
									</div>
								</div>
							</article>
            			</div>
          			</div>
				</api-request>
            </b-dropdown-item>
        </b-dropdown>
</template>

<script>
export default {

  name: 'Notifications',

  data () {
    return {
    	notifications: [],
    	unread: false,
    	success: false,
    	response: null
    }
  },
  mounted(){
  	Echo.private('App.User.' + this.$user().id)
	.notification((notification) => {
  		console.log('Notification')
  		console.log(notification)

  		// Dont add repeated notifications
  		if(this.notifications[0].notification == notification.notification)
  			return

  		// Add to begin of array
  		this.notifications.unshift(notification)
  		notification.new = true
  		this.unread = true
  	})
  },
  methods: {
  	successNotifications(response) {
  		this.notifications = response.data
  		this.success = true
  		if(this.notifications.length > 0)
  			this.unread = true
  	}
  }
}
</script>

<style lang="css">
.noti .dropdown-menu {
	left: initial;
	right: 0;
}

.noti .dropdown-content {
	padding: 0;
}

.noti .dropdown-item {
	padding: 0;
}

.noti article:hover {
	background-color: #c3c3c340;
}

.noti .media {
	padding-top: .5rem;
    padding-bottom: .5rem;
    margin-top: 0;
}

.new-noti {
	animation: colors 3s linear infinite;
	-webkit-animation: colors 3s linear infinite;
    -moz-animation: colors 3s linear infinite;
}

@keyframes colors {
    from {background-color: #c3c3c340;}  
    to {background-color: #4cff2c52;}  
}

@-webkit-keyframes colors{
    from {background-color: #c3c3c340;}  
    to {background-color: #4cff2c52;}  
}
@-moz-keyframes colors {
    from {background-color: #c3c3c340;}  
    to {background-color: #4cff2c52;}  
}
</style>