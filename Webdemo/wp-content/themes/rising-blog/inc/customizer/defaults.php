<?php
/**
 * Shadow Themes Customizer
 *
 * @package Shadow Themes
 */

/**
 * Get all the default values of the theme mods.
 */
function rising_blog_get_default_mods() {
	$rising_blog_default_mods = array(
		// Sliders
		'rising_blog_slider_custom_content' => esc_html__( 'We carve design in most  possible beautiful way.', 'rising-blog' ),
		'rising_blog_slider_custom_btn' => esc_html__( 'Know More', 'rising-blog' ),
		'rising_blog_slider_custom_subtitle' => esc_html__( 'Lorem Ipsum is simply dummy text.', 'rising-blog' ),
		'rising_blog_featured_slider_dot_enable'		=> true,
		'rising_blog_featured_slider_fade_enable'		=> false,
		'rising_blog_featured_slider_autoplay_enable'		=> true,
		'rising_blog_featured_slider_infinite_enable'		=> true,

		// Trending
		'rising_blog_trending_section_title' => esc_html__( 'The Art Of Nature', 'rising-blog' ),
		'rising_blog_trending_custom_content' => esc_html__( 'We carve design in most  possible beautiful way.', 'rising-blog' ),
		'rising_blog_trending_dot_enable'		=> true,
		'rising_blog_trending_fade_enable'		=> false,
		'rising_blog_trending_autoplay_enable'		=> true,
		'rising_blog_trending_infinite_enable'		=> true,



		// Recent posts
		'rising_blog_recent_posts_more' => esc_html__( 'See More', 'rising-blog' ),

		// Footer copyright
		'rising_blog_copyright_txt' => esc_html__( 'Theme: Rising Blog', 'rising-blog' ),

		
	);

	return apply_filters( 'rising_blog_default_mods', $rising_blog_default_mods );
}