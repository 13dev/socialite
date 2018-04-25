<template>
	<div>
		<api-request @success="done" :resource="$api.getThreads" v-model="response">

			<li v-if="response"
			:class="{'active-thread': selectedThread == thread.id, 'thread-unread': thread.unreadmessagescount > 0}"
			@click="clickThread(thread.id)"
			class="pt-2 media border-light border-bottom thread"
			v-for="thread in threads"

			data-toggle="tooltip"
			data-placement="bottom"
			:title="'Creator: ' + thread.creator.name"
			>
				<input type="hidden" id="_participants" :value="thread.participants_string">
				<img class="rounded-circle mb-2 ml-2 mr-2" src="http://placehold.it/50" 
				:alt="thread.subject">
				<div class="media-body">
					<h6 class="m-0 border-light border-bottom" style="font-weight: 400;">{{ thread.subject }}
					</h6>
					<div class="">
						<small class="float-left mt-1">{{ thread.last_message.body }}</small>
						<div  v-show="thread.unreadmessagescount > 0">
							<span v-if="thread.unreadmessagescount <= 9" class="float-right mt-1 mr-3 badge badge-primary badge-pill">{{ thread.unreadmessagescount }}</span>
							<span v-else class="float-right mt-1 mr-3 badge badge-primary badge-pill">+9</span>
						</div>
						
					</div>
					<!-- participants_string thread.creator.name -->
				</div>
			</li>
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
			unreadmessages: null
		}
	},
	methods: {
		done(response){
			this.threads = response.data.data
			console.log('unreadmessages');

			// Map Thread unread messages to simply array
			this.unreadmessages = $.map(this.threads,(element,index) => {

				let arr = $.map(element.unreadmessages,(e,i) => {
					// Get only the neccessary data
					return {
						id: e.id,
						thread_id: e.thread_id,
						body: e.body
					}
				})

				if(arr.length <= 0) return

				return [ arr ]
			})

		},
		clickThread(threadId){
			this.selectedThread = threadId
			Vue.prototype.$selectedThread = threadId
			Event.$emit('change-thread', {id: threadId})
			 
		}
	}
}
</script>

<style lang="scss" scoped>
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
}

</style>