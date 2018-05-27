window.Vue = require('vue');

Vue.config.productionTip = false;
Vue.prototype.$selectedThread = null
Vue.prototype.$baseApiUrl = '/api/v1' 

import VueApiRequest from 'vue-api-request'
import { TweenLite, Power2 } from 'gsap'
import Api from './api'
import Global from './mixins/Global'
import Vuebar from 'vuebar'
import SmallSpinner from './components/SmallSpinner'
import Buefy from 'buefy'

Vue.use(require('vue-truncate-filter'))
Vue.use(Buefy)
Vue.mixin(Global)

VueApiRequest.addEffect('blur', el => {
  el.style.filter = 'blur(20px)'
  TweenLite.to(el, 1, {filter: 'blur(0)', ease: Power2.easeOut})
})

VueApiRequest.addLoader('smallspinner', SmallSpinner)

VueApiRequest.setAPI(Api)
Vue.use(VueApiRequest, {
  effect: 'blur',
  spinner: 'ClipLoader',
  spinnerColor: '#158ffe', //or #0000ff
  spinnerPadding: '3em',
  spinnerScale: 1.6,
  onSuccess: resp => {
    console.log('-> Success ', resp.data)
  },
  onError: resp => {
  	console.log('-> Error ', resp.data)
  }
})
Vue.use(Vuebar)
Vue.component('comment', require('./components/comments/Comment.vue'))
Vue.component('comment-list', require('./components/comments/Comment-list.vue'))
Vue.component('comment-form', require('./components/comments/Comment-form.vue'))
Vue.component('like', require('./components/Like.vue'))
Vue.component('unread-badge', require('./components/UnreadBadge.vue'))
Vue.component('messages', require('./components/Messages.vue'))
Vue.component('threads', require('./components/Threads.vue'))
Vue.component('message-send', require('./components/MessageSend.vue'))
Vue.component('user-profile', require('./components/user/Profile.vue'))
Vue.component('user-timeline', require('./components/user/Timeline.vue'))
Vue.component('post', require('./components/Post.vue'))
Vue.component('user-typing', require('./components/UserTyping.vue'))
Vue.component('user-online', require('./components/UserOnline.vue'))
Vue.component('thread-info', require('./components/ThreadInfo.vue'))
Vue.component('search-thread', require('./components/SearchThread.vue'))
Vue.component('render-emojis', require('./components/RenderEmojis.vue'))

window.Event = new Vue()
const app = new Vue({
  el: '#app',
  data() {
    return {
    }
  }
});
