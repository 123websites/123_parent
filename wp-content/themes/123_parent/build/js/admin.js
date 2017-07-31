var Admin = {};

;(function ( $, Admin, window, document, undefined ) {

	$(document).ready(function(){

		Admin.Training = {
			_init: function(){
				if( $('body').is('.toplevel_page_general-settings') ){
					$('#side-sortables').append(
						'<div class="postbox">' +
							'<a target="_blank" href="http://www.123websites.com/training">' +
								'<img style="width: 100%;" src="http://123websites.com/images/training-ad.png"/>' +
							'</a>' +
						'</div>'
					);
				}
			},
		};

		Admin.Training._init();

	});

})( jQuery, Admin, window, document );
