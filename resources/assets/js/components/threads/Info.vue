<template>
  <div>
    <div style="display: flex;" class="p-t-5" v-if="show">
      {{ thread.subject }}
      <small class="has-text-grey-light"> (creator: {{ thread.creator.name }})</small>
    </div>
    <div style="display: flex;" v-else>
      <div style="line-height: 2;">
        Select One Thread &nbsp;
      </div>
      <render-emojis :message="':grin::+1:'"></render-emojis>
    </div>
  </div>
</template>

<script>
export default {

  name: 'Info',

  data () {
    return {
    	show: false,
    	thread: null
    }
  },
  mounted(){
  	Event.$on('change-thread', (data) => {
  		this.show = true
  		this.thread = data.thread
  		//console.log(JSON.stringify(this.thread) )
  	})
  }
}
</script>

<style lang="css" scoped>
</style>