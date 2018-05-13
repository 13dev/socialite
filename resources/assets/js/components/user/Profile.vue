<template>
	<div class="profile">
		<div class="profile-cover"></div>
			<div class="profile-nav">
				<div class="columns">
					<div class="column is-one-quarter first-col">
						<div class="profile-avatar"></div>
						<div class="profile-about">
							<div class="profile-name">{{ user.name }}</div>
							<span style="username">
								@{{ user.username }}
							</span>
						</div>
					</div>

				<div class="column">
					<div class="columns profile-nav-itens">
						<div class="column item">
							<div>Posts</div>
							<span>{{ user.count.posts }}</span>
						</div>
						<div class="column item">
							<div>Followers</div>
							<span>{{ user.count.followers }}</span>
						</div>
						<div class="column item">
							<div>Following</div>
							<span>{{ user.count.following }}</span>
						</div>
					</div>

					<div class="profile-content">
						<nav class="panel">
						  <p class="panel-heading">
						    Timeline
						  </p>
						  	<div class="panel-block">
								<user-timeline :user="user"></user-timeline>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {

	name: 'Profile',
	props: ['user'],
	data () {
		return {
			show_modal: false
		}
	},
	monted() {
	}
}
</script>

<style lang="css" scoped>
.first-col {
	margin-left: 30px;
	margin-right: -30px;
}

.profile-name {
	text-transform: uppercase;
	font-size: 18px;
}

.username {
	font-weight: 400;
}

.profile-cover {
	height: 250px;
    width: 100%;
    background: url('http://placehold.it/200');
    background-size: cover;
}
.profile {
    margin-top: -20px;
}

.profile-nav .item {
    width: 20%;
    margin-top: 5px;
    display: inline-block;
}

.profile-nav .item > div{
    font-size: 16px;
    text-transform: uppercase;
    font-weight: 400;
}

.profile-nav {
    height: 60px;
    border-bottom: 1px solid #e5e5e5;
    background-color: #fff;
}

.profile-avatar {
    margin-top: -100px;
    background-image: url('http://placehold.it/150');
    width: 200px;
    height: 200px;
    background-position: center;
}

.profile-about {

}

.profile-content {
	margin-top: 30px;
}

.profile-avatar {
    border: 5px solid #e5e5e5;
}

.card-header, .profile-name {
	font-size: 18px; 
	font-weight: 600;
}

.profile-nav-itens {
	margin-top: -25px;
}

</style>