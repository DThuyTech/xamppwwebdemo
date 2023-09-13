<?php
/**
 * Metabox file
 *
 * @package Shadow Themes
 */

/**
 * Register meta box(es).
 */
function rising_blog_register_meta_boxes() {
    add_meta_box( 'rising-blog-select-sidebar', __( 'Sidebar position', 'rising-blog' ), 'rising_blog_display_metabox', array( 'post', 'page' ), 'side' );
}
add_action( 'add_meta_boxes', 'rising_blog_register_meta_boxes' );
 
/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function rising_blog_display_metabox( $post ) {
    // Display code/markup goes here. Don't forget to include nonces!

    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'rising_blog_select_sidebar_save_meta_box', 'rising_blog_select_sidebar_meta_box_nonce' );

    $rising_blog_sidebar_meta = get_post_meta( $post->ID, 'rising-blog-select-sidebar', true );
	$choices = array( 
			'right' => esc_html__( 'Right', 'rising-blog' ), 
			'no'    => esc_html__( 'No Sidebar', 'rising-blog' ), 
		);

		foreach ( $choices as $value => $name ) : ?>
	    	<p>
	    		<label>
					<input value="<?php echo esc_attr( $value ); ?>" <?php checked( $rising_blog_sidebar_meta, $value, true ); ?> name="rising-blog-select-sidebar" type="radio" />
					<?php echo esc_html( $name ); ?>
	    		</label>
			</p>	
		<?php endforeach; 

}
 
/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function rising_blog_save_meta_box( $post_id ) {
    // Save logic goes here. Don't forget to include nonce checks!

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['rising-blog-select-sidebar'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( sanitize_key( $_POST['rising_blog_select_sidebar_meta_box_nonce'] ), 'rising_blog_select_sidebar_save_meta_box' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    /* OK, it's safe for us to save the data now. */
    
    // Make sure that it is set.
    if ( isset( $_POST['rising-blog-select-sidebar'] ) ) {
        // Sanitize user input.
        $rising_blog_sidebar_meta = sanitize_text_field( wp_unslash( $_POST['rising-blog-select-sidebar'] ) );
        // Update the meta field in the database.
        update_post_meta( $post_id, 'rising-blog-select-sidebar', $rising_blog_sidebar_meta );
    }
}
add_action( 'save_post', 'rising_blog_save_meta_box' );