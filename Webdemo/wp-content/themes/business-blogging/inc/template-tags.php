<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Business Blogging
 */
if ( ! function_exists( 'business_blogging_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function business_blogging_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}
		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);
		$timeIcon = '%1$s';
		$posted_on = sprintf(
			$timeIcon,
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$line = '<i class="line"></i>&nbsp;';

		echo '<span class="posted-on">'.$line.'' . $posted_on . '</span>'; // WPCS: XSS OK.
	}
endif;
if ( ! function_exists( 'business_blogging_time' ) ) {
	function business_blogging_time() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}
		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);
		echo '<i class="blog-time">' . wp_kses_post( $time_string ) . '</i>';
	}
}
if ( ! function_exists( 'business_blogging_posted_by' ) ) :
	function business_blogging_posted_by( $author_image = true ) {
		$posted_by_format = '<a href="%1$s">%2$s %3$s</a>';
		$post_author_id   = get_post_field( 'post_author', get_queried_object_id() );
		$get_author_image = '<span class="post-author-image"> ' . get_avatar( get_the_author_meta( 'ID' ), 30 ) . '</span> ';
		if ( false === $author_image ) {
			$get_author_image = __( 'Posted by', 'business-blogging' );
		}
		$postedBy = sprintf(
			$posted_by_format,
			esc_url( get_author_posts_url( get_the_author_meta( $post_author_id ), get_the_author_meta( 'user_nicename' ) ) ),
			$get_author_image,
			'<i>' . esc_html( get_the_author_meta( 'display_name', $post_author_id ) ) . '</i>'
		);
		echo '<span class="posted_by">' . wp_kses_post( $postedBy ) . '</span>';
	}
endif;
if ( ! function_exists( 'business_blogging_comment_popuplink' ) ) {
	function business_blogging_comment_popuplink() {
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			// $commentIcon = ;
			echo '<span class="comments-link"><i class="fa fa-comments-o" aria-hidden="true"></i>';
			$css_class = 'zero-comments';
			$number    = (int) get_comments_number( get_the_ID() );
			if ( 1 === $number ) {
				$css_class = 'one-comment';
			} elseif ( 1 < $number ) {
				$css_class = 'multiple-comments';
			}
			comments_popup_link(
				__( 'Post a Comment', 'business-blogging' ),
				__( '1 Comment', 'business-blogging' ),
				__( '% Comments', 'business-blogging' ),
				$css_class,
				__( 'Comments are Closed', 'business-blogging' )
			);
			echo '</span>';
		}
	}
}
function business_blogging_categories() {
		$categories_list = get_the_category_list( ' ' );
	if ( 'post' === get_post_type() && !is_single()) {
		/* translators: used between list items, there is a space after the comma */
		if ( $categories_list ) {
			printf( '<i class="fa fa-folder-open-o"></i><span class="categories">' . '%1$s' . '</span>', $categories_list ); // WPCS: XSS OK.
		}
	}else {
		if ( $categories_list ) {
			printf( '<span class="cat-links">' . '%1$s' . '</span>', $categories_list ); // WPCS: XSS OK.
		}
	}
	return;
}
if ( ! function_exists( 'business_blogging_post_tag' ) ) {
	function business_blogging_post_tag() {
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', '' );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . wp_kses_post($tags_list) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}
		return;
	}
}
if ( ! function_exists( 'business_blogging_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function business_blogging_post_thumbnail() {
		$get_blog_layout = get_theme_mod( 'blog_layout', 'grid' );
		$thumbnail_size  = 'business-blogging-grid-thumbnail';
		if ( is_single() || is_page() ) {
			$thumbnail_size = 'business-blogging-thumbnail-large';
		} else {
			if ( 'list' === $get_blog_layout ) {
				$thumbnail_size = 'business-blogging-thumbnail-large';
			} elseif ( 'grid' === $get_blog_layout ) {
				$thumbnail_size = 'business-blogging-grid-thumbnail';
			}
		}
		$post_thumnail = wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), 'full' );
		if ( is_single() || is_page() ) {
			 the_post_thumbnail( 'full' );
		} else {
			if ( has_post_thumbnail() ) :
				?>
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( 'full' ); ?>
				</a>
				<?php
			elseif ( $post_thumnail ) :
				echo '<a href="' . esc_url( get_the_permalink() ) . '"><img src="' . esc_url( $post_thumnail ) . '" alt=""></a>';
			endif;
		}
	}
endif;

function business_blogging_navigation() {
	$next_icon            = '<i class="fa fa-angle-right" aria-hidden="true"></i>';
	$prev_icon            = '<i class="fa fa-angle-left" aria-hidden="true"></i>';
	$pagination_alignment = get_theme_mod( 'blog_page_pagination', 'center' );
	echo '<div class="pagination-' . esc_attr( $pagination_alignment ) . '">';
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => $prev_icon,
				'next_text' => $next_icon,
			)
		);
	echo '</div>';
}
