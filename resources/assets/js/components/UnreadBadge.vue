<template>
	<div>
		<div v-if="isLoading">
			<i class="fa fa-circle-o-notch fa-spin" style="color: #fff"></i>
		</div>
		<div v-if="count != 0"> 
			(<span class="badge badge-primary badge-pill unread">{{ count }}</span>)
		</div>
	</div>
</template>
<script>
	export default {
		data () {
			return {
				count: 0,
				isLoading: false
			}
		},
		mounted() {
			console.log('unread mounted()')

			//this.getUnreadThreads()
			window.Echo.private('messages.' + Global.user.id)
			.listen('.new.message', (e) =>{
				this.isLoading = false
				console.log(e)
				// Check if user is in recive conv
				//if(!Global.convs.includes(e.convid))
				//	return;

	        	this.getUnreadThreads()

	        	blink('li.nav-item.message')
	        })
	        .listen('.new.message.thread', (e) => {
	        	this.isLoading = false
	        	console.log('.new.message.thread')
	        	//Global.convs.push(e.convid)
	        	this.getUnreadThreads()
	        	
	        	blink('li.nav-item.message')
	        })

		},
		methods: {
			getUnreadThreads(){
				this.isLoading = true
				axios.get('/api/v1/messages/unread')
				.then(response => {
					console.log(response)
					this.isLoading = false
			        this.count = response.data.count
			       	document.title = '(' + this.count + ') ' + document.title
		      	}).catch(response => {
		      		this.isLoading = false
					console.log(response)
		      	})
			}
		}
	}
</script>

<style scoped>
	div {
		display: inline;
	}
</style>