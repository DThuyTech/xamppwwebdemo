<?php
/**
 * Template part for displaying front page slider.
 *
 * @package Shadow Themes
 */

/// Get default  mods value.
$slider_enable = get_theme_mod( 'rising_blog_featured_slider_section_enable', true );

if ( false == $slider_enable ) {
    return;
}

$header_font_size = get_theme_mod( 'rising_blog_slider_header_font_size');
$button_font_size = get_theme_mod( 'rising_blog_slider_button_font_size');
$slider_speed = get_theme_mod( 'rising_blog_slider_speed',600);
$slider_infinite = get_theme_mod('rising_blog_featured_slider_infinite_enable', true);
$slider_dot = get_theme_mod('rising_blog_featured_slider_dot_enable', true);
$slider_autoplay = get_theme_mod('rising_blog_featured_slider_autoplay_enable', true);
$slider_arrow = get_theme_mod('rising_blog_featured_slider_arrow_enable', true);
$slider_fade = get_theme_mod('rising_blog_featured_slider_fade_enable', false);
$slider_content_opacity = get_theme_mod( 'rising_blog_slider_content_opacity',0);
$slider_background_opacity = get_theme_mod( 'rising_blog_slider_image_opacity',0);
$slider_decoration_image = get_theme_mod( 'rising_blog_slider_decoration_image',0);
$slider = get_theme_mod( 'rising_blog_slider_content_type', 'custom' );
$excerpt_length = get_theme_mod( 'rising_blog_slider_secion_excerpt',20); 


$default = rising_blog_get_default_mods();
$slider_num = get_theme_mod( 'rising_blog_slider_num', 4);
$slider_column = get_theme_mod( 'rising_blog_slider_column', 1 );
?>
<div id="featured-slider" class="<?php echo $slider_column==1 ? 'f-content-center': 'f-content-bottom'; ?>" data-slick='{"slidesToShow": <?php echo esc_attr($slider_column); ?>, "slidesToScroll": 1, "infinite": <?php echo $slider_infinite ? 'true': 'false'; ?>, "speed": <?php echo esc_attr($slider_speed); ?>, "dots": <?php echo $slider_dot ? 'true': 'false'; ?>, "arrows":<?php echo $slider_arrow ? 'true': 'false'; ?>, "autoplay": <?php echo $slider_autoplay ? 'true': 'false'; ?>, "draggable": true, "fade": <?php echo $slider_fade ? 'true': 'false'; ?> }'>
	<?php
        $slider_id = array();
	        for ( $i=1; $i <= $slider_num; $i++ ) { 
	            $slider_id[] = get_theme_mod( "rising_blog_slider_post_" . $i );
	        }
	        $args = array(
	            'post_type' =>'post',
	            'post__in' => (array)$slider_id,   
                'orderby'   => 'post__in',
	            'posts_per_page' => $slider_num,
	            'ignore_sticky_posts' => true,
	        );

	    $query = new WP_Query( $args );

	    $i = 1;
	    if ( $query->have_posts() ) :
	        while ( $query->have_posts() ) :
	            $query->the_post();
	            ?>
	        
	            <article style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
	            	<div class="overlay"></div>
	                <div class="featured-content-wrapper" style=" background-color: rgba(0, 0, 0, 0.<?php echo absint($slider_content_opacity); ?> )">
	                	<?php if (!empty($slider_decoration_image)): ?>
		                	<div class="slider-decoration-image">
		                		<img src="<?php echo esc_url($slider_decoration_image); ?>">
		                	</div>
		                <?php endif; ?>
	                    <header class="shadow-entry-header">
	                    	<?php 
		                    	$slider_subtitle = get_theme_mod( 'rising_blog_slider_custom_subtitle_' . $i, $default['rising_blog_slider_custom_subtitle'] ); 
		                    ?>
	                    	<?php if (!empty($slider_subtitle)): ?>
		                    	<p class="shadow-entry-subtitle"><?php echo esc_html($slider_subtitle) ?></p>
		                    <?php endif; ?>
	                        <h2 class="shadow-entry-title" style="font-size: <?php echo esc_attr($header_font_size); ?>px; " ><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
	                    </header>
	                    <div class="shadow-entry-content">
                        	<?php
                                $excerpt = rising_blog_the_excerpt( $excerpt_length );
                                echo wp_kses_post( wpautop( $excerpt ) );
                            ?>
                        </div>
	                    <?php 
	                    	$read_more = get_theme_mod( 'rising_blog_slider_custom_btn_' . $i, $default['rising_blog_slider_custom_btn'] ); 
	                    ?>
                    	<?php if ( ! empty( $read_more ) ) : ?>

		                    <a href="<?php the_permalink(); ?>" class="btn btn-fill" style="font-size: <?php echo esc_attr($button_font_size); ?>px; "><?php echo esc_html( $read_more ); ?>
		                    </a>
		                <?php endif; ?>
	                </div><!-- .featured-content-wrapper -->
    	        </article>
	        <?php 
	        $i++;
	    	endwhile;
	        wp_reset_postdata();
	    endif; ?>
</div><!-- #featured-slider -->