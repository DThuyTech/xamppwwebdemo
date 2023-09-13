<?php
/**
 * Template part for displaying front page trending.
 *
 * @package Shadow Themes
 */

/// Get default  mods value.
$trending_enable = get_theme_mod( 'rising_blog_trending_section_enable', true );

if ( false == $trending_enable ) {
    return;
}

$header_font_size = get_theme_mod( 'rising_blog_trending_header_font_size');
$button_font_size = get_theme_mod( 'rising_blog_trending_button_font_size');
$trending_content_opacity = get_theme_mod( 'rising_blog_trending_content_opacity',60);
$trending_background_opacity = get_theme_mod( 'rising_blog_trending_image_opacity',0);
$trending_decoration_image = get_theme_mod( 'rising_blog_trending_decoration_image',0);
$trending = get_theme_mod( 'rising_blog_trending_content_type', 'cat' );


$default = rising_blog_get_default_mods();
$trending_num = get_theme_mod( 'rising_blog_trending_num', 6 );
$trending_column = get_theme_mod( 'rising_blog_trending_column', 3 );
$section_title = get_theme_mod( 'rising_blog_trending_section_title', $default['rising_blog_trending_section_title'] ); 

?>
<div id="trending" class="page-section" >
	<div class="wrapper">
		<div class="shadow-section-header">
			<h2 class="shadow-section-title"><?php echo esc_html($section_title) ?></h2>
		</div>
		<div class="trending-wrapper column-3">
		    <?php
		    if (  in_array( $trending, array( 'post', 'page', 'cat' ) ) ) {

			    if ( 'cat' === $trending ) {
			        $trending_cat_id = get_theme_mod( 'rising_blog_trending_cat' );
			        $args = array(
			            'cat' => $trending_cat_id,   
			            'posts_per_page' => $trending_num,
			            'ignore_sticky_posts' => true,
			        );
			    } else {
			        $trending_id = array();
			        for ( $i=1; $i <= $trending_num; $i++ ) { 
			            $trending_id[] = get_theme_mod( "rising_blog_trending_{$trending}_" . $i );
			        }
			        $args = array(
			            'post_type' => $trending,
			            'post__in' => (array)$trending_id,   
		                'orderby'   => 'post__in',
			            'posts_per_page' => $trending_num,
			            'ignore_sticky_posts' => true,
			        );
			    }
			    $query = new WP_Query( $args );

			    $i = 1;
			    if ( $query->have_posts() ) :
			        while ( $query->have_posts() ) :
			            $query->the_post();
			            ?>
			            <article class="trending-container <?php echo has_post_thumbnail() ? 'has-post-thumbnail' : 'no-post-thumbnail' ; ?>"> 

			            	<div class="trending-inner" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
			                    <header class="shadow-entry-header">
			                        <h2 class="shadow-entry-title" style="font-size: <?php echo esc_attr($header_font_size); ?>px; " ><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
			                    </header>
			                </div>
		    	        </article>
			        <?php 
			        $i++;
			    	endwhile;
			        wp_reset_postdata();
			    endif;
			    } else {
			    for ( $i=1; $i <= $trending_num; $i++ ) { 
			        $trending_img_url = get_theme_mod( 'rising_blog_trending_image_' . $i );
			        $trending_content   = get_theme_mod( 'rising_blog_trending_custom_content_' . $i, $default['rising_blog_trending_custom_content'] );
			        $trending_btn_url = get_theme_mod( 'rising_blog_trending_custom_link_' . $i, '#' );
			        
			        
			        ?>
			        <article class="trending-container <?php if (empty($trending_img_url)) { ?> no-post-thumbnail<?php } ?>" <?php if (!empty($trending_img_url)) { ?> style="background-image: url('<?php echo esc_url( $trending_img_url ); ?>'); " <?php } ?>>
				            <div class="wrapper">
			                    <header class="shadow-entry-header">
			                        <h2 class="shadow-entry-title" style="font-size: <?php echo esc_attr($header_font_size); ?>px; " ><?php echo esc_html( $trending_content );?></h2>
			                    </header>
				            </div><!-- .wrapper -->
		    	        </article>
			<?php   
			    }
			} 
			?>
		</div><!-- #trending slider -->
	</div><!-- .wrapper-->
</div><!-- #trending -->