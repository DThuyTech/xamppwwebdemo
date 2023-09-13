<?php
/**
 * Template part for displaying content  in post.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Shadow Themes
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'hentry' ); ?>>
	<?php $single_image_enable = get_theme_mod( 'rising_blog_enable_single_image', false );
	if ( $single_image_enable ) { ?>
		<div class="featured-image">
	        <?php the_post_thumbnail( 'full', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
		</div><!-- .featured-post-image -->
	<?php } ?>
	<div class="entry-meta">
	    <?php 
	    
	    $single_author_enable = get_theme_mod( 'rising_blog_enable_single_author', true );
	    if ( $single_author_enable ) {
	    	rising_blog_post_author(); 
	    }
	    $single_date_enable = get_theme_mod( 'rising_blog_enable_single_date', true );
		if ( $single_date_enable ) {
    		rising_blog_posted_on();
    	}

	    ?>
	</div><!-- .entry-meta -->


	<div class="shadow-entry-container">
	    <div class="shadow-entry-content">
	        <?php
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'rising-blog' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'rising-blog' ),
				'after'  => '</div>',
			) );
			?>
	    </div><!-- .shadow-entry-content -->

	    <?php
	    $single_category_enable = get_theme_mod( 'rising_blog_enable_single_category', true );
	    $single_tag_enable = get_theme_mod( 'rising_blog_enable_single_tag', true ); 
	    if ( $single_category_enable ) {
	    	rising_blog_cats();
	    }
	    if ( $single_tag_enable  ) {
	    	rising_blog_tags();

	    } ?>
	    
	</div><!-- .shadow-entry-container -->
</article><!-- #post-<?php the_ID(); ?> -->
