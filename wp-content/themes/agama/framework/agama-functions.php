<?php

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Content Width
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1200;
}

/**
 * Agama Thumb Title
 * Get post-page article title and separates it on two halfs
 *
 * @since 1.0.1
 * @return string
 */
function agama_thumb_title() {
	$title = get_the_title();
	$findme   = ' ';
	$pos = strpos($title, $findme);
	if( $pos === false ) {
			$output = '<h2>'.$title.'</h2>';
		} else {
			// isolate part 1 and part 2.
			$title_part_one = strstr($title, ' ', true); // As of PHP 5.3.0
			$title_part_two = strstr($title, ' ');
			$output = '<h2>'.$title_part_one.'<span>'.$title_part_two.'</span></h2>';
		}
	echo $output;
}

/**
 * Get Attachment Image Src
 *
 * @since 1.0.1
 * @return string
 */
function agama_return_image_src( $thumb_size ) {
	$att_id	 = get_post_thumbnail_id();
	$att_src = wp_get_attachment_image_src( $att_id, $thumb_size );
	return esc_url( $att_src[0] );
}

/**
 * Check if $page is template page
 *
 * @since 1.0.1
 * @return string
 */
function agama_is_page_template( $page ) {
	if( is_page_template( 'page-templates/'.$page ) ) {
		return true;
	}
	return false;
}

/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since 1.0
 */
if ( ! function_exists( 'agama_content_nav' ) ) {
    function agama_content_nav( $html_id ) {
        global $wp_query;

        if ( $wp_query->max_num_pages > 1 ) : ?>
            <nav id="<?php echo esc_attr( $html_id ); ?>" class="navigation clearfix" role="navigation">
                <h2 class="assistive-text"><?php esc_html_e( 'Post navigation', 'agama' ); ?></h2>
                <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'agama' ) ); ?></div>
                <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'agama' ) ); ?></div>
            </nav>
        <?php endif;
    }
}

/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own agama_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since 1.0
 */
if ( ! function_exists( 'agama_comment' ) ) {
    function agama_comment( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment;
        switch ( $comment->comment_type ) :
            case 'pingback' :
            case 'trackback' :
            // Display trackbacks differently than normal comments.
        ?>
        <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
            <p><?php _e( 'Pingback:', 'agama' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'agama' ), '<span class="edit-link">', '</span>' ); ?></p>
        <?php
                break;
            default :
            // Proceed with normal comments.
            global $post;
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <div id="comment-<?php comment_ID(); ?>" class="comment-wrap clearfix">

                <div class="comment-meta">
                    <div class="comment-author vcard">
                        <span class="comment-avatar clearfix">
                            <?php echo get_avatar( $comment, 44 ); ?>
                        </span>
                    </div>
                </div><!-- .comment-meta -->

                <div class="comment-content comment">
                    <div class="comment-author">
                    <?php
                    printf( '<a href="%1$s">%2$s %3$s</a>', get_permalink(), get_comment_author_link(),
                                // If current post author is also comment author, make it known visually.
                                ( $comment->user_id === $post->post_author ) ? '<cite>' . __( 'author', 'agama' ) . '</cite>' : ''
                    );
                    printf( '<span><a href="%1$s"><time datetime="%2$s">%3$s</time></a></span>',
                            esc_url( get_comment_link( $comment->comment_ID ) ),
                            get_comment_time( 'c' ),
                            /* translators: 1: date, 2: time */
                            sprintf( __( '%1$s at %2$s', 'agama' ), get_comment_date(), get_comment_time() )
                    );
                    ?>
                    </div>
                    <?php comment_text(); ?>
                    <?php //edit_comment_link( __( '<i class="fa fa-edit"></i> Edit', 'agama' ), '<p class="edit-link">', '</p>' ); ?>
                    <?php comment_reply_link( array_merge( $args, array( 'reply_text' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </div><!-- .comment-content -->

                <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'agama' ); ?></p>
                <?php endif; ?>

            </div><!-- #comment-## -->
        <?php
            break;
        endswitch; // end comment_type check
    }
}

/**
 * Set up post entry meta.
 *
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own agama_entry_meta() to override in a child theme.
 *
 * @since 1.0
 */
if ( ! function_exists( 'agama_entry_meta' ) ) {
    function agama_entry_meta() {
        // Translators: used between list items, there is a space after the comma.
        $categories_list = get_the_category_list( __( ', ', 'agama' ) );

        // Translators: used between list items, there is a space after the comma.
        $tag_list = get_the_tag_list( '', __( ', ', 'agama' ) );

        $date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
            esc_url( get_permalink() ),
            esc_attr( get_the_time() ),
            esc_attr( get_the_date('c') ),
            esc_html( get_the_date() )
        );

        $author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_attr( sprintf( __( 'View all posts by %s', 'agama' ), get_the_author() ) ),
            get_the_author()
        );

        // Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
        if ( $tag_list ) {
            $utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'agama' );
        } elseif ( $categories_list ) {
            $utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'agama' );
        } else {
            $utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'agama' );
        }

        printf(
            $utility_text,
            $categories_list,
            $tag_list,
            $date,
            $author
        );
    }
}

/**
 * .article-wrapper Grid, List - Style
 *
 * @since 1.0.1
 */
function agama_article_wrapper_class() {
	$blog_layout = esc_attr( get_theme_mod( 'agama_blog_layout', 'list' ) );
	
    switch( $blog_layout ):
		case 'list':
			echo 'list-style';
		break;
		
		case 'grid':
			echo 'grid-style';
		break;
		
		case 'small_thumbs':
			echo 'small_thumbs';
		break;
	endswitch;
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
