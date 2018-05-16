
const api = {

	// User
	userUnreadMessages: (params = {}) => {
		return axios.get(Vue.prototype.$baseApiUrl + '/user/unreadmessages', params)
	},
	getUserTimeline: (params = {}) => {
		return axios.get(Vue.prototype.$baseApiUrl + '/user/' + params.id + '/timeline', params)
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

}

export default api