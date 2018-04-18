window.Vue = require('vue');

Vue.config.productionTip = false;

Vue.component('comment', require('./components/comments/Comment.vue'));
Vue.component('comment-list', require('./components/comments/Comment-list.vue'));
Vue.component('comment-form', require('./components/comments/Comment-form.vue'));

Vue.component('like', require('./components/Like.vue'));
Vue.component('unread-badge', require('./components/UnreadBadge.vue'));
Vue.component('messages', require('./components/Messages.vue'));
Vue.component('threads', require('./components/Threads.vue'));

window.Event = new Vue();
Vue.prototype.$selectedThread = 2

const app = new Vue({
  el: '#app',

  mounted() {
    $('[data-confirm]').on('click', function () {
      return confirm($(this).data('confirm'))
    })
  }
});
