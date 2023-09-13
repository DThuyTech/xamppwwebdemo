<?php
$post_author_id   = get_post_field( 'post_author', get_queried_object_id() );
$get_post_column_layout = get_theme_mod( 'post_column', 1 );
$post_column_layout = 'col-sm-12 col-md-6 col-lg-4';
if ( $get_post_column_layout == 2 ) {
	$post_column_layout = 'col-lg-6 col-md-12';
} elseif ( $get_post_column_layout == 3 ) {
	$post_column_layout = 'col-sm-12 col-md-6 col-lg-4';
} elseif ( $get_post_column_layout == 4 ) {
	$post_column_layout = 'col-sm-12 col-md-6 col-lg-3';
}else{
	$post_column_layout = 'col-sm-12 grid-layout';
}
$post_classes = 'business-blogging-standard-post';
if ( ! has_post_thumbnail() ) {
	$post_classes = 'business-blogging-standard-post no-post-thumbnail ';
}

$post_el_is_on = array(
	'show_post_category' => get_theme_mod('show_post_category', true),
	'show_post_thumbnail' => get_theme_mod('show_post_thumbnail', true),
	'show_post_date' => get_theme_mod('show_post_date', true),
	'show_post_author' => get_theme_mod('show_post_author', true),
	'show_post_title' => get_theme_mod('show_post_title', true),
	'show_post_excerpt' => get_theme_mod('show_post_excerpt', true),
);
?>
<div class="<?php echo esc_attr( $post_column_layout ); ?> blog-grid-layout">
	<article id="post-<?php the_ID(); ?>" <?php post_class( $post_classes ); ?>>
		<div class="business-blogging-standard-post__entry-content text-left">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="business-blogging-standard-post__thumbnail post-header">
					<?php
					if (true == $post_el_is_on['show_post_thumbnail']) :
						business_blogging_post_thumbnail();
					endif;
					?>
				</div>
			<?php endif;?>
			<div class="business-blogging-standard-post__content-wrapper">
				<div class="business-blogging-standard-post__post-title">
					<div class="post-heading">
						<div class="post__col-date">
							<?php
								if(true == $post_el_is_on['show_post_date']) :
									?>
									<div class="post__date-day">
										<?php
											echo date("j", strtotime(get_the_date()));
										?>
									</div>
									<div class="post__date-month">
										<?php
											echo date(" M", strtotime(get_the_date()));
										?>
									</div>
								<?php
								endif;
							?>
						</div>
						<div class="post__col-contents">
							<?php
							if(true == $post_el_is_on['show_post_title']) :?>
								<a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
							<?php
								endif;
								$nolinebetweenmeta = ' no-line-between-meta';
							?>
							<div class="business-blogging-standard-post__blog-meta<?php echo esc_attr($nolinebetweenmeta);?>">
								<?php
								if (true == $post_el_is_on['show_post_author']) :
									?>
									<div class="post__blog-col">
										<i class="fa fa-user-o"></i>
										<?php
										$url = esc_url( get_author_posts_url( get_the_author_meta('ID', $post_author_id) ) );
										?>
										<a href="<?php echo $url; ?>">
										<?php
											echo esc_html( get_the_author_meta( 'display_name', $post_author_id ) );
										?>
										</a>
									</div>
									<?php
								endif;
								?>
								<div class="post__blog-col">
									<?php business_blogging_categories(); ?>
								</div>
							</div>
						</div>
						
					</div>
					<?php
					if(true == $post_el_is_on['show_post_excerpt']) :
						the_excerpt();
					endif;
				?>
				</div>
			</div>
		</div>
	</article><!-- #post-<?php the_ID(); ?> -->
</div>
