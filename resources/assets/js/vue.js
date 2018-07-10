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
import VueMarkdown from 'vue-markdown'

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
Vue.component('unread-badge', require('./components/users/UnreadCountBadge.vue'))
Vue.component('messages', require('./components/messages/Messages.vue'))
Vue.component('threads', require('./components/threads/Threads.vue'))
Vue.component('message-send', require('./components/messages/Send.vue'))
Vue.component('user-profile', require('./components/users/Profile.vue'))
Vue.component('user-timeline', require('./components/users/Timeline.vue'))
Vue.component('post', require('./components/posts/Post.vue'))
Vue.component('post-form', require('./components/posts/Form.vue'))
Vue.component('user-typing', require('./components/messages/UserTyping.vue'))
Vue.component('user-online', require('./components/messages/UserOnline.vue'))
Vue.component('thread-info', require('./components/threads/Info.vue'))
Vue.component('search-thread', require('./components/threads/Search.vue'))
Vue.component('render-emojis', require('./components/RenderEmojis.vue'))
Vue.component('feed', require('./components/Feed.vue'))
Vue.component('notifications', require('./components/users/Notifications.vue'))
Vue.component('follow-button', require('./components/users/FollowButton.vue'))
Vue.component('vue-markdown', VueMarkdown)

window.Event = new Vue()
const app = new Vue({
  el: '#app',
  data() {
    return {
    }
  }
});
