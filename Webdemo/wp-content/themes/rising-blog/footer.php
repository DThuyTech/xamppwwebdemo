<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Shadow Themes
 */

$default = rising_blog_get_default_mods();
?> 
	<?php get_template_part( 'inc/homepage/must-read' );  ?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<!-- supports column-1, column-2, column-3 and column-4 -->
		<!-- supports unequal-width and equal-width -->
		<?php  
		$count = 0;
		for ( $i=1; $i <=4 ; $i++ ) { 
			if ( is_active_sidebar( 'footer-' . $i ) ) {
				$count++;
			}
		}
		
		if ( 0 !== $count ) : ?>
			<div class="footer-widgets-area page-section column-<?php echo esc_attr( $count );?>">
			    <div class="wrapper">
					<?php 
					for ( $j=1; $j <=4; $j++ ) { 
						if ( is_active_sidebar( 'footer-' . $j ) ) {
			    			echo '<div class="column-wrapper">';
							dynamic_sidebar( 'footer-' . $j ); 
			    			echo '</div>';
						}
					}
					?>
				</div><!-- .wrapper -->
			</div><!-- .footer-widget-area -->

		<?php endif;
		 
		$footer_menu = get_theme_mod( 'rising_blog_enable_footer_social_menu', true );
		$footer_text_enable = get_theme_mod( 'rising_blog_enable_footer_text', true );
		$footer_text = get_theme_mod( 'rising_blog_copyright_txt' );

		if ( $footer_menu || $footer_text_enable ) :
			$class = ( $footer_menu && $footer_text_enable ) ? 'column-2' : 'column-1' ;
			?>
			<div class="site-info column-1">
				<!-- supports column-1 and column-2 -->
				<?php 

				?>
				<div class="wrapper">
					
					    <span class="footer-copyright">
					    	<?php if ( $footer_text_enable && !empty($footer_text) ) { ?>
					      		<?php echo wp_kses_post($footer_text ); ?>
					      	<?php } ?>
					      	<?php printf( esc_html__( 'Copyright © All rights reserved. %1$s by %2$s. ', 'rising-blog' ), 'Rising Blog', '<a href="' . esc_url( 'http://shadowthemes.com/' ) . '">Shadow Themes</a>' ); ?>
					    </span><!-- .footer-copyright -->				    

				</div><!-- .wrapper -->    
				
			</div><!-- .site-info -->
		<?php endif; ?>
	</footer><!-- #colophon -->
	<div class="popup-overlay"></div>
	<?php  
	$backtop = get_theme_mod( 'rising_blog_back_to_top_enable', true );
	if ( $backtop ) { ?>
		<div class="totop"><?php echo rising_blog_get_icon_svg( 'keyboard_arrow_down' ); ?></div>
	<?php }	?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
