<?php 
	/**
	 *
	 * Active callbacks.
	 * 
	 */


	/**=============================== Slide Section ====================================**/

	/**
	 * Check if Featured Slider is enabled
	 */
	function rising_blog_is_featured_slider_enable( $control ) {
		return $control->manager->get_setting( 'rising_blog_featured_slider_section_enable' )->value();
	}

	/**
	 * Check if the Featured Slider is page
	 */
	function rising_blog_if_slider_page( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_slider_content_type' )->value();
	    return ( rising_blog_is_featured_slider_enable( $control ) && ( 'page' == $content_type ) );
	}

	/**
	 * Check if the Featured Slider is post
	 */
	function rising_blog_if_slider_post( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_slider_content_type' )->value();
	    return ( rising_blog_is_featured_slider_enable( $control ) && ( 'post' == $content_type ) );
	}

	/**
	 * Check if the Featured Slider is cat
	 */
	function rising_blog_if_slider_cat( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_slider_content_type' )->value();
	    return ( rising_blog_is_featured_slider_enable( $control ) && ( 'cat' == $content_type ) );
	}

	/**
	 * Check if the Featured Slider is custom
	 */
	function rising_blog_if_slider_custom( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_slider_content_type' )->value();
	    return ( rising_blog_is_featured_slider_enable( $control ) && ( 'custom' == $content_type ) );
	}

	/**=========================================================================================**/

/**=============================== Trending Section ====================================**/

	/**
	 * Check if Trending is enabled
	 */
	function rising_blog_is_trending_enable( $control ) {
		return $control->manager->get_setting( 'rising_blog_trending_section_enable' )->value();
	}

	/**
	 * Check if the Trending is page
	 */
	function rising_blog_if_trending_page( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_trending_content_type' )->value();
	    return ( rising_blog_is_trending_enable( $control ) && ( 'page' == $content_type ) );
	}

	/**
	 * Check if the Trending is post
	 */
	function rising_blog_if_trending_post( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_trending_content_type' )->value();
	    return ( rising_blog_is_trending_enable( $control ) && ( 'post' == $content_type ) );
	}

	/**
	 * Check if the Trending is cat
	 */
	function rising_blog_if_trending_cat( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_trending_content_type' )->value();
	    return ( rising_blog_is_trending_enable( $control ) && ( 'cat' == $content_type ) );
	}

	/**
	 * Check if the Trending is custom
	 */
	function rising_blog_if_trending_custom( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_trending_content_type' )->value();
	    return ( rising_blog_is_trending_enable( $control ) && ( 'custom' == $content_type ) );
	}

	/**=========================================================================================**/




	/**=============================== List Article Section ====================================**/

	/**
	 * Check if List Article is enabled
	 */
	function rising_blog_is_list_articles_enable( $control ) {
		return $control->manager->get_setting( 'rising_blog_list_articles_section_enable' )->value();
	}


		/**
	 * Check if the List Articles is page
	 */
	function rising_blog_if_list_articles_page( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_list_articles_content_type' )->value();
	    return ( rising_blog_is_list_articles_enable( $control ) && ( 'page' == $content_type ) );
	}

	/**
	 * Check if the List Articles is post
	 */
	function rising_blog_if_list_articles_post( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_list_articles_content_type' )->value();
	    return ( rising_blog_is_list_articles_enable( $control ) && ( 'post' == $content_type ) );
	}

	/**
	 * Check if the List Articles is cat
	 */
	function rising_blog_if_list_articles_cat( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_list_articles_content_type' )->value();
	    return ( rising_blog_is_list_articles_enable( $control ) && ( 'cat' == $content_type ) );
	}


	/**=========================================================================================**/

	


	/**=============================== Featured Collection ====================================**/

	/**
	 * Check if Featured Collection is enabled
	 */
	function rising_blog_is_featured_collection_enable( $control ) {
		return $control->manager->get_setting( 'rising_blog_featured_collection_section_enable' )->value();
	}

	/**
	 * Check if the Featured Collection is page
	 */
	function rising_blog_if_featured_collection_page( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_featured_collection_content_type' )->value();
	    return ( rising_blog_is_featured_collection_enable( $control ) && ( 'page' == $content_type ) );
	}

	/**
	 * Check if the Featured Collection is post
	 */
	function rising_blog_if_featured_collection_post( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_featured_collection_content_type' )->value();
	    return ( rising_blog_is_featured_collection_enable( $control ) && ( 'post' == $content_type ) );
	}

	/**
	 * Check if the Featured Collection is cat
	 */
	function rising_blog_if_featured_collection_cat( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_featured_collection_content_type' )->value();
	    return ( rising_blog_is_featured_collection_enable( $control ) && ( 'cat' == $content_type ) );
	}

	/**
	 * Check if the Featured Collection is custom
	 */
	function rising_blog_if_featured_collection_custom( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_featured_collection_content_type' )->value();
	    return ( rising_blog_is_featured_collection_enable( $control ) && ( 'custom' == $content_type ) );
	}

	/**=========================================================================================**/	


	/**=============================== Featured Post ====================================**/

	/**
	 * Check if Featured Post is enabled
	 */
	function rising_blog_is_featured_post_enable( $control ) {
		return $control->manager->get_setting( 'rising_blog_featured_post_section_enable' )->value();
	}

	/**
	 * Check if the Featured Post is page
	 */
	function rising_blog_if_featured_post_page( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_featured_post_content_type' )->value();
	    return ( rising_blog_is_featured_post_enable( $control ) && ( 'page' == $content_type ) );
	}

	/**
	 * Check if the Featured Post is post
	 */
	function rising_blog_if_featured_post_post( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_featured_post_content_type' )->value();
	    return ( rising_blog_is_featured_post_enable( $control ) && ( 'post' == $content_type ) );
	}

	/**
	 * Check if the Featured Post is cat
	 */
	function rising_blog_if_featured_post_cat( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_featured_post_content_type' )->value();
	    return ( rising_blog_is_featured_post_enable( $control ) && ( 'cat' == $content_type ) );
	}

	/**
	 * Check if the Featured Post is custom
	 */
	function rising_blog_if_featured_post_custom( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_featured_post_content_type' )->value();
	    return ( rising_blog_is_featured_post_enable( $control ) && ( 'custom' == $content_type ) );
	}

	/**=========================================================================================**/





	/**=============================== Author Section ====================================**/

	/**
	 * Check if Author is enabled
	 */
	function rising_blog_is_author_enable( $control ) {
		return $control->manager->get_setting( 'rising_blog_author_section_enable' )->value();
	}

	/**
	 * Check if the Author is page
	 */
	function rising_blog_if_author_page( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_author_content_type' )->value();
	    return ( rising_blog_is_author_enable( $control ) && ( 'page' == $content_type ) );
	}

	/**
	 * Check if the Author is post
	 */
	function rising_blog_if_author_post( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_author_content_type' )->value();
	    return ( rising_blog_is_author_enable( $control ) && ( 'post' == $content_type ) );
	}


	/**
	 * Check if the Author is custom
	 */
	function rising_blog_if_author_custom( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_author_content_type' )->value();
	    return ( rising_blog_is_author_enable( $control ) && ( 'custom' == $content_type ) );
	}

	/**=========================================================================================**/

	

	/**=============================== Popular Section ====================================**/

	/**
	 * Check if Popular POst is enabled
	 */
	function rising_blog_is_popular_enable( $control ) {
		return $control->manager->get_setting( 'rising_blog_popular_section_enable' )->value();
	}

	/**
	 * Check if the Popular POst is page
	 */
	function rising_blog_if_popular_page( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_popular_content_type' )->value();
	    return ( rising_blog_is_popular_enable( $control ) && ( 'page' == $content_type ) );
	}

	/**
	 * Check if the Popular POst is post
	 */
	function rising_blog_if_popular_post( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_popular_content_type' )->value();
	    return ( rising_blog_is_popular_enable( $control ) && ( 'post' == $content_type ) );
	}

	/**
	 * Check if the Popular POst is cat
	 */
	function rising_blog_if_popular_cat( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_popular_content_type' )->value();
	    return ( rising_blog_is_popular_enable( $control ) && ( 'cat' == $content_type ) );
	}


	/**=========================================================================================**/



	/**=============================== Featured Section ====================================**/

	/**
	 * Check if Featured POst is enabled
	 */
	function rising_blog_is_featured_enable( $control ) {
		return $control->manager->get_setting( 'rising_blog_featured_section_enable' )->value();
	}

	/**
	 * Check if the Featured POst is page
	 */
	function rising_blog_if_featured_page( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_featured_content_type' )->value();
	    return ( rising_blog_is_featured_enable( $control ) && ( 'page' == $content_type ) );
	}

	/**
	 * Check if the Featured POst is post
	 */
	function rising_blog_if_featured_post( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_featured_content_type' )->value();
	    return ( rising_blog_is_featured_enable( $control ) && ( 'post' == $content_type ) );
	}

	/**
	 * Check if the Featured POst is cat
	 */
	function rising_blog_if_featured_cat( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_featured_content_type' )->value();
	    return ( rising_blog_is_featured_enable( $control ) && ( 'cat' == $content_type ) );
	}


	/**=========================================================================================**/

	/**=============================== Must Read Section ====================================**/

	/**
	 * Check if Must Read POst is enabled
	 */
	function rising_blog_is_must_read_enable( $control ) {
		return $control->manager->get_setting( 'rising_blog_must_read_section_enable' )->value();
	}

	/**
	 * Check if the Must Read POst is page
	 */
	function rising_blog_if_must_read_page( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_must_read_content_type' )->value();
	    return ( rising_blog_is_must_read_enable( $control ) && ( 'page' == $content_type ) );
	}

	/**
	 * Check if the Must Read POst is post
	 */
	function rising_blog_if_must_read_post( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_must_read_content_type' )->value();
	    return ( rising_blog_is_must_read_enable( $control ) && ( 'post' == $content_type ) );
	}

	/**
	 * Check if the Must Read POst is cat
	 */
	function rising_blog_if_must_read_cat( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_must_read_content_type' )->value();
	    return ( rising_blog_is_must_read_enable( $control ) && ( 'cat' == $content_type ) );
	}


	/**=========================================================================================**/

	/**=============================== Video Section ====================================**/

	/**
	 * Check if Video is enabled
	 */
	function rising_blog_is_video_enable( $control ) {
		return $control->manager->get_setting( 'rising_blog_video_section_enable' )->value();
	}

	/**
	 * Check if the Video is page
	 */
	function rising_blog_if_video_page( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_video_content_type' )->value();
	    return ( rising_blog_is_video_enable( $control ) && ( 'page' == $content_type ) );
	}

	/**
	 * Check if the Video is post
	 */
	function rising_blog_if_video_post( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_video_content_type' )->value();
	    return ( rising_blog_is_video_enable( $control ) && ( 'post' == $content_type ) );
	}


	/**
	 * Check if the Video is custom
	 */
	function rising_blog_if_video_custom( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_video_content_type' )->value();
	    return ( rising_blog_is_video_enable( $control ) && ( 'custom' == $content_type ) );
	}

	/**=========================================================================================**/


	/**=============================== List Article Section ====================================**/

	/**
	 * Check if Latest Featured is enabled
	 */
	function rising_blog_is_latest_featured_enable( $control ) {
		return $control->manager->get_setting( 'rising_blog_latest_featured_section_enable' )->value();
	}


		/**
	 * Check if the Latest Featured is page
	 */
	function rising_blog_if_latest_featured_page( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_latest_featured_content_type' )->value();
	    return ( rising_blog_is_latest_featured_enable( $control ) && ( 'page' == $content_type ) );
	}

	/**
	 * Check if the Latest Featured is post
	 */
	function rising_blog_if_latest_featured_post( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_latest_featured_content_type' )->value();
	    return ( rising_blog_is_latest_featured_enable( $control ) && ( 'post' == $content_type ) );
	}

	/**
	 * Check if the Latest Featured is cat
	 */
	function rising_blog_if_latest_featured_cat( $control ) {
		$content_type = $control->manager->get_setting( 'rising_blog_latest_featured_content_type' )->value();
	    return ( rising_blog_is_latest_featured_enable( $control ) && ( 'cat' == $content_type ) );
	}


	/**=========================================================================================**/


/**==========================================================================================**/



	/**
	 * Check if the latest is not disabled
	 */
	function rising_blog_if_latest_not_disabled( $control ) {
		return 'disable' != $control->manager->get_setting( 'rising_blog_latest' )->value();
	}

	/**
	 * Check if the latest is page
	 */
	function rising_blog_if_latest_page( $control ) {
		return 'page' === $control->manager->get_setting( 'rising_blog_latest' )->value();
	}

	/**
	 * Check if the latest is post
	 */
	function rising_blog_if_latest_post( $control ) {
		return 'post' === $control->manager->get_setting( 'rising_blog_latest' )->value();
	}

	/**
	 * Check if the latest is cat
	 */
	function rising_blog_if_latest_cat( $control ) {
		return 'cat' === $control->manager->get_setting( 'rising_blog_latest' )->value();
	}

	/**
	 * Check if the latest is custom
	 */
	function rising_blog_if_latest_custom( $control ) {
		return 'custom' === $control->manager->get_setting( 'rising_blog_latest' )->value();
	}

	/**
	 * Check if the latest is not disabled or category.
	 */
	function rising_blog_if_latest_not_cat_disabled( $control ) {
		return ( ! rising_blog_if_latest_cat( $control ) && rising_blog_if_latest_not_disabled( $control ) );
	}

	/**
	 * Check if the slider is not disabled
	 */
	function rising_blog_if_slider_not_disabled( $control ) {
		return 'disable' != $control->manager->get_setting( 'rising_blog_slider_content_type' )->value();
	}



	/**
	 * Check if the footer text is enabled
	 */
	function rising_blog_if_footer_text_enable( $control ) {
		return $control->manager->get_setting( 'rising_blog_enable_footer_text' )->value();
	}

	/**
	 * Check if custom color scheme is enabled
	 */
	function rising_blog_if_custom_color_scheme( $control ) {
		return 'custom' === $control->manager->get_setting( 'rising_blog_color_scheme' )->value();
	} 
?>