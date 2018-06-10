<template>
	<div id="threads">
		<api-request 
		@success="done" 
		:resource="$api.getThreads" 
		v-model="response">
		<article
			v-if="response"
			class="media thread p-l-10 p-t-5 p-b-5 m-0"
			:class="{
				'active-thread': selectedThread == thread.id, 
				'thread-unread': thread.unreadmessagescount > 0
			}"
			@click="clickThread(thread.id)"
			v-for="thread in filterThreads">
			  <figure class="media-left">
			    <p class="image is-48x48">
					<span 
					v-if="thread.unreadmessagescount <= 9 && thread.unreadmessagescount > 0" 
					class="notify-badge" >{{ thread.unreadmessagescount }}</span>
					<span class="notify-badge" 
					v-if="thread.unreadmessagescount > 9 && thread.unreadmessagescount > 0">+9</span>
			      <img class="is-rounded" src="https://bulma.io/images/placeholders/48x48.png">
			    </p>
			  </figure>
			  <div class="media-content">
			    <div class="content">
			        <strong>{{ thread.subject | truncate(20) }}</strong>
			        <br>
			        <div style="display: flex; justify-content: space-between;">
			        	<div>
			        		<render-emojis :truncate="true" :size="18" :message="thread.last_message.body"></render-emojis>
			        	</div>
			        	<div style="justify-content: flex-end;" class="m-r-10">
			        		<small class="has-text-grey-light">{{ thread.last_message.created_at }}</small>
			        	</div>
			        </div>
			    </div>
			  </div>
			</article>
			<div class="centerall" v-if="filterThreads && filterThreads.length == 0">
				<h3 class="subtitle" style="display: flex;">
					No Threads Found <render-emojis :message="':unamused:'"></render-emojis>!
				</h3>
			</div>
			<div class="centerall" v-show="threads && threads.length == 0" v-else>
				<h3 class="subtitle" style="display: flex;">
					Omg! No threads <render-emojis :message="':scream:'"></render-emojis>!
				</h3>
			</div>
		</api-request>
	</div>
</template>
<script>

export default {
	data () {
		return {
			response: null,
			threads: null,
			selectedThread: null,
			unreadmessages: null,
			filterThreads: null
		}
	},
	methods: {
		done(response){
			this.threads = response.data.data
			this.filterThreads = response.data.data
			console.log('unreadmessages');

			// Map Thread unread messages to simply array
			// this.unreadmessages = $.map(this.threads,(element,index) => {

			// 	let arr = $.map(element.unreadmessages,(e,i) => {
			// 		// Get only the neccessary data
			// 		return {
			// 			id: e.id,
			// 			thread_id: e.thread_id,
			// 			body: e.body
			// 		}
			// 	})

			// 	if(arr.length <= 0) return

			// 	return [ arr ]
			// })

		},
		clickThread(threadId){
			// if user is in the same thread that click in
			if(this.selectedThread == threadId)
				return;

			// Leave last channel in
			if(Vue.prototype.$selectedThread != null){
				Echo.leave('thread.' + Vue.prototype.$selectedThread)
			}
			this.selectedThread = threadId
			Vue.prototype.$selectedThread = threadId

			// Search the correct thread and set unreadmessagescount
			for (let thread in this.threads) {
			    if (this.threads[thread].id == threadId) {
			    	Event.$emit('change-thread', { 
			    		id: threadId, 
			    		thread: this.threads[thread] 
			    	})

			    	Event.$emit(`is-online:remove-all-users`)

			    	this.threads[thread].unreadmessagescount = 0
			       	break; //Stop this loop, we found it!
			    }
		   	}
			 
		}
	},
	mounted () {
		Event.$on('update-thread', (data) => {
			// Update thread
			// Search the correct thread and set unreadmessagescount
			for (let thread in this.threads) {
			    if (this.threads[thread].id == data.convid) {

			    	if(!data.me)
			    		this.threads[thread].unreadmessagescount++

			    	this.threads[thread].last_message = data.message
			       	break //Stop this loop, we found it!
			    }
		   	}
		})

		Event.$on('search-threads', data => {
			if(data.data == '' || data.data == null){
				this.filterThreads = this.threads
				return
			}

			this.filterThreads = this.threads.filter(thread => {
				return thread.subject
					.toLowerCase()
					.includes(data.data.toLowerCase())
	        })
		})
	}
}
</script>

<style lang="scss" scoped>
.notify-badge{
	position: absolute;
	right: -4px;
	bottom: 0;
	background: #168efe;
	text-align: center;
	border-radius: 10px;
	color: white;
	padding: 1px 6px;
	font-size: 11px;
	font-weight: 500;
}

.thread {
	&:hover {
		cursor:pointer;
		background-color: #efeded99;
		transition: background-color 0.5s ease;
		transition: color 0.4s ease;
		color: #4b4848;
	}
}

.thread-unread {
	background-color: #efeded99;
	img {
		border: 2px solid #168efe;
	}
}

.threads:not(:last-child) {
  border-bottom: 1px solid #dbdbdb;
  margin-bottom: 5px;
  padding-bottom: 5px;
}
</style>