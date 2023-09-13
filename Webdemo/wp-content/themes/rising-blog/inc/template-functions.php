<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Shadow Themes
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function rising_blog_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

  // When  color scheme is light or dark.
  $menu_sticky = get_theme_mod( 'rising_blog_make_menu_sticky', false );
  if (true==$menu_sticky) {  
    $classes[] = 'menu-sticky'; 
  }

	// When  color scheme is light or dark.
	$text_hover = get_theme_mod( 'rising_blog_text_hover_type', 'hover-default' );
	$classes[] = esc_attr( $text_hover );

  // When  color scheme is light or dark.
  $btn_hover = get_theme_mod( 'rising_blog_btn_hover_type', 'btn-hover-default' );
  $classes[] = esc_attr( $btn_hover );
	
	// When global archive layout is checked.
	if ( is_archive() || is_404() || is_search() ) {
		$archive_sidebar = get_theme_mod( 'rising_blog_archive_sidebar', 'no' ); 
		$classes[] = esc_attr( $archive_sidebar ) . '-sidebar';   

  } else if ( rising_blog_is_latest_posts() ) { // When global post sidebar is checked.
      $rising_blog_page_sidebar_meta = get_post_meta( get_the_ID(), 'rising-blog-select-sidebar', true );
      if ( ! empty( $rising_blog_page_sidebar_meta ) ) {
      $classes[] = esc_attr( $rising_blog_page_sidebar_meta ) . '-sidebar';
      } else {
      $blog_post_sidebar = get_theme_mod( 'rising_blog_blog_sidebar', 'no' ); 
      $classes[] = esc_attr( $blog_post_sidebar ) . '-sidebar';
    }
  } else if ( is_single() ) { // When global post sidebar is checked.
    	$rising_blog_post_sidebar_meta = get_post_meta( get_the_ID(), 'rising-blog-select-sidebar', true );
    	if ( ! empty( $rising_blog_post_sidebar_meta ) ) {
			$classes[] = esc_attr( $rising_blog_post_sidebar_meta ) . '-sidebar';
    	} else {
			$global_post_sidebar = get_theme_mod( 'rising_blog_global_post_layout', 'no' ); 
			$classes[] = esc_attr( $global_post_sidebar ) . '-sidebar';
    	}
	} elseif ( rising_blog_is_frontpage_blog() || is_page() ) {
		if ( rising_blog_is_frontpage_blog() ) {
			$page_id = get_option( 'page_for_posts' );
		} else {
			$page_id = get_the_ID();
		}

    	$rising_blog_page_sidebar_meta = get_post_meta( $page_id, 'rising-blog-select-sidebar', true );
		if ( ! empty( $rising_blog_page_sidebar_meta ) ) {
			$classes[] = esc_attr( $rising_blog_page_sidebar_meta ) . '-sidebar';
		} else {
			$global_page_sidebar = get_theme_mod( 'rising_blog_global_page_layout', 'no' ); 
			$classes[] = esc_attr( $global_page_sidebar ) . '-sidebar';
		}
	}

	// Site layout classes
	$site_layout = get_theme_mod( 'rising_blog_site_layout', 'wide' );
	$classes[] = esc_attr( $site_layout ) . '-layout';


	return $classes;
}
add_filter( 'body_class', 'rising_blog_body_classes' );

function rising_blog_post_classes( $classes ) {
	if ( rising_blog_is_page_displays_posts() ) {
		// Search 'has-post-thumbnail' returned by default and remove it.
		$key = array_search( 'has-post-thumbnail', $classes );
		unset( $classes[ $key ] );
		
		$archive_img_enable = get_theme_mod( 'rising_blog_enable_archive_featured_img', true );

		if( has_post_thumbnail() && $archive_img_enable ) {
			$classes[] = 'has-post-thumbnail';
		} else {
			$classes[] = 'grid-item no-post-thumbnail';
		}
	}
  
	return $classes;
}
add_filter( 'post_class', 'rising_blog_post_classes' );

/**
 * Excerpt length
 * 
 * @since Shadow Themes 1.0.0
 * @return Excerpt length
 */
function rising_blog_excerpt_length( $length ){
	if ( is_admin() ) {
		return $length;
	}

	$length = get_theme_mod( 'rising_blog_archive_excerpt_length', 30 );
	return $length;
}
add_filter( 'excerpt_length', 'rising_blog_excerpt_length', 999 );

if ( ! function_exists( 'rising_blog_the_excerpt' ) ) :

  /**
   * Generate excerpt.
   *
   * @since 1.0.0
   *
   * @param int     $length Excerpt length in words.
   * @param WP_Post $post_obj WP_Post instance (Optional).
   * @return string Excerpt.
   */
  function rising_blog_the_excerpt( $length = 0, $post_obj = null ) {

    global $post;

    if ( is_null( $post_obj ) ) {
      $post_obj = $post;
    }

    $length = absint( $length );

    if ( 0 === $length ) {
      return;
    }

    $source_content = $post_obj->post_content;

    if ( ! empty( $post_obj->post_excerpt ) ) {
      $source_content = $post_obj->post_excerpt;
    }

    $source_content = preg_replace( '`\[[^\]]*\]`', '', $source_content );
    $trimmed_content = wp_trim_words( $source_content, $length, '&hellip;' );
    return $trimmed_content;

  }

endif;

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function rising_blog_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'rising_blog_pingback_header' );

/**
 * Get an array of post id and title.
 * 
 */
function rising_blog_get_post_choices() {
	$choices = array( '' => esc_html__( '--Select Post--', 'rising-blog' ) );
	$args = array( 'numberposts' => -1, );
	$posts = get_posts( $args );

	foreach ( $posts as $post ) {
		$id = $post->ID;
		$title = $post->post_title;
		$choices[ $id ] = $title;
	}

	return $choices;
}

if( !function_exists( 'rising_blog_get_page_choices' ) ) :
  /*
   * Function to get pages
   */
  function rising_blog_get_page_choices() {

    $pages  =  get_pages();
    $page_list = array();
    $page_list[0] = esc_html__( '--Select Page--', 'rising-blog' );

    foreach( $pages as $page ){
      $page_list[ $page->ID ] = $page->post_title;
    }

    return $page_list;

  }
endif;

/**
 * Get an array of cat id and title.
 * 
 */

if( !function_exists( 'rising_blog_get_post_cat_choices' ) ) :
  /*
   * Function to get categories
   */
  function rising_blog_get_post_cat_choices() {
    $categories = get_terms( 'category' );
    $choices = array('' => esc_html__( '--Select Category--', 'rising-blog' ));

    foreach( $categories as $category ) {
      $choices[$category->term_id] = $category->name;
    }

    return $choices;
  }
endif;


/**
 * Checks to see if we're on the homepage or not.
 */
function rising_blog_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}

/**
 * Checks to see if Static Front Page is set to "Your latest posts".
 */
function rising_blog_is_latest_posts() {
	return ( is_front_page() && is_home() );
}

/**
 * Checks to see if Static Front Page is set to "Posts page".
 */
function rising_blog_is_frontpage_blog() {
	return ( is_home() && ! is_front_page() );
}

/**
 * Checks to see if the current page displays any kind of post listing.
 */
function rising_blog_is_page_displays_posts() {
	return ( rising_blog_is_frontpage_blog() || is_search() || is_archive() || rising_blog_is_latest_posts() );
}

/**
 * Shows a breadcrumb for all types of pages.  This is a wrapper function for the Breadcrumb_Trail class,
 * which should be used in theme templates.
 *
 * @since  1.0.0
 * @access public
 * @param  array $args Arguments to pass to Breadcrumb_Trail.
 * @return void
 */
function rising_blog_breadcrumb( $args = array() ) {
	$breadcrumb = apply_filters( 'breadcrumb_trail_object', null, $args );

	if ( ! is_object( $breadcrumb ) )
		$breadcrumb = new Breadcrumb_Trail( $args );

	return $breadcrumb->trail();
}

/**
 * Pagination in archive/blog/search pages.
 */
function rising_blog_posts_pagination() { 
	$archive_pagination = get_theme_mod( 'rising_blog_archive_pagination_type', 'numeric' );
	if ( 'disable' === $archive_pagination ) {
		return;
	}
	if ( 'numeric' === $archive_pagination ) {
		the_posts_pagination( array(
            'prev_text'          => rising_blog_get_icon_svg( 'menu_icon_up' ),
            'next_text'          => rising_blog_get_icon_svg( 'menu_icon_up' ),
        ) );
	} elseif ( 'older_newer' === $archive_pagination ) {
        the_posts_navigation( array(
            'prev_text'          => rising_blog_get_icon_svg( 'menu_icon_up' ) . '<span>'. esc_html__( 'Older', 'rising-blog' ) .'</span>',
            'next_text'          => '<span>'. esc_html__( 'Newer', 'rising-blog' ) .'</span>' . rising_blog_get_icon_svg( 'menu_icon_up' ),
        )  );
	}
}

/**
 * Get an array of google fonts.
 * 
 */
function rising_blog_font_choices() {
  $font_family_arr = array();
  $font_family_arr[''] = esc_html__( '--Default--', 'rising-blog' );

  // Make the request
    $request = wp_remote_get( get_theme_file_uri( 'assets/js/webfonts.json' ) );

    if( is_wp_error( $request ) ) {
      return false; // Bail early
    }
  // Retrieve the data
    $body = wp_remote_retrieve_body( $request );
    $data = json_decode( $body );
    if ( ! empty( $data ) ) {
      foreach ( $data->items as $items => $fonts ) {
        $family_str_arr = explode( ' ', $fonts->family );
        $family_value = implode( '-', array_map( 'strtolower', $family_str_arr ) );
        $font_family_arr[ $family_value ] = $fonts->family;
      }
    }

    return apply_filters( 'rising_blog_font_choices', $font_family_arr );
}

// Add auto p to the palces where get_the_excerpt is being called.
add_filter( 'get_the_excerpt', 'wpautop' );


if ( ! class_exists( 'WP_Customize_Control' ) ) {
  return null;
}

class rising_blog_Range_Value_Control extends WP_Customize_Control {
  public $type = 'range-value';
  /**
   * Enqueue scripts/styles.
   *
   * @since 3.4.0
   */
  public function enqueue() {
    wp_enqueue_script( 'rising-blog-customizer-range', get_template_directory_uri() . '/assets/js/customizer-range.js', array( 'jquery' ), rand(), true );
  }
  /**
   * Render the control's content.
   *
   * @author soderlind
   * @version 1.2.0
   */
  public function render_content() {
    ?>
    <label>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
      <div class="range-slider"  style="width:100%; display:flex;flex-direction: row;justify-content: flex-start;">
        <span  style="width:100%; flex: 1 0 0; vertical-align: middle;"><input class="range-slider__range" type="range" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->input_attrs(); $this->link(); ?>>
        <span class="range-slider__value">0</span></span>
      </div>
      <?php if ( ! empty( $this->description ) ) : ?>
      <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
      <?php endif; ?>
    </label>
    <?php
  }
}



class rising_blog_Multi_Input_Custom_Control extends WP_Customize_Control {
    /**
     * Control type
     *
     * @var string
     */
    public $type = 'multi-input';

    /**
     * Control button text.
     *
     * @var string
     */
    public $button_text;

    /**
     * Control method
     *
     * @since 1.0.0
     */
    public function render_content() {
        ?>
        <label class="customize_multi_input">
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <p><?php echo esc_html( $this->description ); ?></p>
            <input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize_multi_value_field" <?php $this->link(); ?> />
            <div class="customize_multi_fields">
                <div class="set">
                    <input type="text" value="" class="customize_multi_single_field"/>
                    <span class="customize_multi_remove_field"><span class="dashicons dashicons-no-alt"></span></span>
                </div>
            </div>
            <a href="#" class="button button-primary customize_multi_add_field"><?php echo esc_html( $this->button_text ); ?></a>
        </label>
        <?php
    }
}