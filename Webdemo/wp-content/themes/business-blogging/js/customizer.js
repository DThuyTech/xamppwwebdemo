/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );

	wp.customize( 'color_setting_hex', function( value ) {
		// When the value changes.
		value.bind( function( newval ) {
			// Add CSS to elements.
			jQuery( '.copyright-menu ul li a' ).css( 'color', newval );
		} );
	} );

    wp.customize('banner_button_colors', function(value) {
        value.bind(function(newval) {
            var cssContent = `.hero-content .discover-me-button a{
                    background-color: ${newval['btn_bg']};
                    color: ${newval['btn_text']};
                }
                .hero-content .discover-me-button a:hover{
                    background-color: ${newval['btn_hover_bg']};
                    color: ${newval['btn_hover_text']};
                }`;
            if (
                null === document.getElementById('kirki-postmessage-banner_button_colors') ||
                'undefined' === typeof document.getElementById('kirki-postmessage-banner_button_colors')
            ) {
                // Append the <style> to the <head>.
                jQuery('head').append('<style id="kirki-postmessage-banner_button_colors"></style>');
            }
            // Add the CSS to the <style> and append.
            jQuery('#kirki-postmessage-banner_button_colors').text(cssContent);
            jQuery('#kirki-postmessage-banner_button_colors').appendTo('head');
        });
    });

} )( jQuery );