import api from '../api.js'

export default {
    methods: {
        $scrollAllBottom(id) {
        	setTimeout(function () {
        		$('#' + id).animate({
	        	 	scrollTop:
	        	 		$('#' + id).prop('scrollHeight')
	        	},600);
        	}, 100);
        },
        $snackbarError(params = {}) {
            let _message = ('message' in params) ? params.message : 'Something wen\'t wrong, please try again...'
            let _type = ('type' in params) ? params.type : 'is-danger'
            let _position = ('position' in params) ? params.position : 'is-bottom-right'
            let _action_text = ('actionText' in params) ? params.actionText : 'reload'
            let _indefinite = ('indefinite' in params) ? params.indefinite : true
            let _reload = ('reload' in params) ? params.reload : true
            let _queue = ('queue' in params) ? params.queue : false

            this.$snackbar.open({
                message: _message,
                type: _type,
                position: _position,
                actionText: _action_text,
                queue: _queue,
                indefinite: _indefinite,
                onAction: () => {
                    if(_reload) {

                        this.$toast.open({
                            message: 'Reloading page...',
                            queue: false
                        })

                        setTimeout(() => {
                            window.location.href = '/';
                        }, 2000)
                    }
                }
            })
        },
        $user(){
            return Global.user
        },
        $apiG() {
            return api
        }
    },
};