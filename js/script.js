(function($) {
	$(document).ready( function() {
		$( '#fcbkbttn_settings_form input' ).bind( "change click select", function() {
			if ( $( this ).attr( 'type' ) != 'submit' ) {
				$( '.updated.fade' ).css( 'display', 'none' );
				$( '#fcbkbttn_settings_notice' ).css( 'display', 'block' );
			};
		});
		$( '#fcbkbttn_settings_form select' ).bind( "change", function() {
			$( '.updated.fade' ).css( 'display', 'none' );
			$( '#fcbkbttn_settings_notice' ).css( 'display', 'block' );
		});

		$( 'input[name="fcbkbttn_my_page"]' ).change( function() {
			if ( $( this ).is( ":checked" ) ) {
				$( '.fcbkbttn_my_page' ).show();
			} else {
				$( '.fcbkbttn_my_page' ).hide();
			}
		});

		$( 'select[name="fcbkbttn_where"]' ).change( function() {
			if ( $( this ).val() == 'shortcode' ) {
				$( '#fcbkbttn_shortcode' ).show();
			} else {
				$( '#fcbkbttn_shortcode' ).hide();
			}
		});

		$( 'select[name="fcbkbttn_display_option"]' ).change( function() {
			if ( $( this ).val() == 'custom' ) {
				$( '#fcbkbttn_display_option_custom' ).show();
			} else {
				$( '#fcbkbttn_display_option_custom' ).hide();
			}
		});
	});
})(jQuery);