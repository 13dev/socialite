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
    },
};