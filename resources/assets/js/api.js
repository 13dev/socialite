
const api = {

	// User
	userUnreadMessages: (params = {}) => {
		return axios.get(Vue.prototype.$baseApiUrl + '/user/unreadmessages', params)
	},
	getUserTimeline: (params = {}) => {
		return axios.get(Vue.prototype.$baseApiUrl + '/user/' + params.id + '/timeline', params)
	},
	getUserFeed: (params = {}) => {
		return axios.get(Vue.prototype.$baseApiUrl + '/user/' + params.id + '/feed', params)
	},
	userNotifications: (params = {}) => {
		return axios.get(Vue.prototype.$baseApiUrl + '/user/' + params.id + '/notifications', params)
	},
	follow: (params = {}) => {
		return axios.post(Vue.prototype.$baseApiUrl + '/user/' + params.id + '/follow', params)
	},
	userIsFollowing: (params = {}) => {
		return axios.get(Vue.prototype.$baseApiUrl + '/user/' + params.id + '/follow', params)
	},

	// Messages
	sendMessage: (params = {}) => {
		return axios.post(Vue.prototype.$baseApiUrl + '/messages', params)
	},
	getMessages: (params = {}) => {
		return axios.get(Vue.prototype.$baseApiUrl + '/threads/'+ params.id +'/messages', params)
	},
	getMessage: (params = {}) => {
		return axios.get(Vue.prototype.$baseApiUrl + '/messages/' + params.id, params)
	},

	// Threads
	getThreads: (params = {}) => {
		return axios.get(Vue.prototype.$baseApiUrl + '/threads', params)
	},
	getThread: (params = {}) => {
		return axios.get(Vue.prototype.$baseApiUrl + '/threads/' + params.id, params)
	},
	createThread: (params = {}) => {
		return axios.post(Vue.prototype.$baseApiUrl + '/threads/', params)
	},

	//Posts
	getPost: (params = {}) => {
		return axios.get(Vue.prototype.$baseApiUrl + '/posts/' + params.id, params)
	},
	getPostReplies: (params = {}) => {
		return axios.get(Vue.prototype.$baseApiUrl + '/posts/' + params.id + '/replies', params)
	},
	insertPost: (params = {}) => {
		return axios.post(Vue.prototype.$baseApiUrl + '/posts', params)
	},
	repostPost: (params = {}) => {
		return axios.post(Vue.prototype.$baseApiUrl + '/posts/' + params.id + '/repost', params)
	},
	favoritePost: (params = {}) => {
		return axios.post(Vue.prototype.$baseApiUrl + '/posts/' + params.id + '/favorite', params)
	},

}

export default api