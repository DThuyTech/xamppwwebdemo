<?php
/**
 * @package Web Developer
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="listarticle">
    	<?php if (has_post_thumbnail() ){ ?>
            <div class="post-thumb">
               <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
            </div>
	    <?php } ?>
        <header class="entry-header">
            <h2 class="single_title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
        </header>
        <?php if ( is_search() || !is_single() ) : // Only display Excerpts for Search ?>
        <div class="entry-summary">
           	<?php
                $content = get_the_content();
            ?>
            <p><?php echo wpautop($content); ?></p>
            <div class="pagemore" >
                <a href="<?php the_permalink(); ?>"><?php esc_html_e('Read More','web-developer'); ?></a>
            </div>
        </div>
        <?php else : ?>
        <div class="entry-content">
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'web-developer' ) ); ?>
            <?php
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . __( 'Pages:', 'web-developer' ),
                    'after'  => '</div>',
                ) );
            ?>
        </div>
        <?php endif; ?>
        <div class="clear"></div>    
    </div>
</article>