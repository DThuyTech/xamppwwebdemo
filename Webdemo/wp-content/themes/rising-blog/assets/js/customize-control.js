/**
 * Scripts within the customizer controls window.
 *
 * Contextually shows the color hue control and informs the preview
 * when users open or close the front page sections section.
 */

(function( $, api ) {
    wp.customize.bind('ready', function() {
    	// Show message on change.
        var rising_blog_settings = ['rising_blog_slider_num', 'rising_blog_latest_num', 'rising_blog_services_num', 'rising_blogjects_num', 'rising_blog_testimonial_num', 'rising_blog_blog_section_num', 'rising_blog_reset_settings', 'rising_blog_testimonial_num', 'rising_blog_partner_num'];
        _.each( rising_blog_settings, function( rising_blog_setting ) {
            wp.customize( rising_blog_setting, function( setting ) {
                var blogRiderNotice = function( value ) {
                    var name = 'needs_refresh';
                    if ( value && rising_blog_setting == 'rising_blog_reset_settings' ) {
                        setting.notifications.add( 'needs_refresh', new wp.customize.Notification(
                            name,
                            {
                                type: 'warning',
                                message: localized_data.reset_msg,
                            }
                        ) );
                    } else if( value ){
                        setting.notifications.add( 'reset_name', new wp.customize.Notification(
                            name,
                            {
                                type: 'info',
                                message: localized_data.refresh_msg,
                            }
                        ) );
                    } else {
                        setting.notifications.remove( name );
                    }
                };

                setting.bind( blogRiderNotice );
            });
        });

        /* === Radio Image Control === */
        api.controlConstructor['radio-color'] = api.Control.extend( {
            ready: function() {
                var control = this;

                $( 'input:radio', control.container ).change(
                    function() {
                        control.setting.set( $( this ).val() );
                    }
                );
            }
        } );

        

        // Sortable sections
        jQuery( "body" ).on( 'hover', '.rising-blog-drag-handle', function() {
            jQuery( 'ul.rising-blog-sortable-list' ).sortable({
                handle: '.rising-blog-drag-handle',
                axis: 'y',
                update: function( e, ui ){
                    jQuery('input.rising-blog-sortable-input').trigger( 'change' );
                }
            });
        });

        /* On changing the value. */
        jQuery( "body" ).on( 'change', 'input.rising-blog-sortable-input', function() {
            /* Get the value, and convert to string. */
            this_checkboxes_values = jQuery( this ).parents( 'ul.rising-blog-sortable-list' ).find( 'input.rising-blog-sortable-input' ).map( function() {
                return this.value;
            }).get().join( ',' );

            /* Add the value to hidden input. */
            jQuery( this ).parents( 'ul.rising-blog-sortable-list' ).find( 'input.rising-blog-sortable-value' ).val( this_checkboxes_values ).trigger( 'change' );

        });

        // Deep linking for counter section to about section.
        jQuery('.rising-blog-edit').click(function(e) {
            e.preventDefault();
            var jump_to = jQuery(this).attr( 'data-jump' );
            wp.customize.section( jump_to ).focus()
        });

        wp.customize.bind('ready', function() {
            jQuery('a[data-open="rising-blog-recent-posts"]').click(function(e) {
                e.preventDefault();
                wp.customize.section( 'sidebar-widgets-homepage-sidebar' ).focus()
            });
        });
        
    });
})( jQuery, wp.customize );
