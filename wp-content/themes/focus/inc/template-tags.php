<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package focus
 * @since focus 1.0
 */

if ( ! function_exists( 'focus_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since focus 1.0
 */
function focus_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'focus' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'focus' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'focus' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'focus' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'focus' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // focus_content_nav

if ( ! function_exists( 'focus_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since focus 1.0
 */
function focus_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'focus' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'focus' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, $depth == 1 ? 60 : 35 ); ?>
			</div><!-- .comment-author .vcard -->

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php _e( 'Your comment is awaiting moderation.', 'focus' ); ?></em>
				<br />
			<?php endif; ?>

			<div class="comment-text-area">
				<div class="comment-meta commentmetadata">
					<cite class="fn"><?php comment_author_link() ?></cite>

					<div class="comment-text-area-right">
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="comment-permalink"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
							<?php
							/* translators: 1: date, 2: time */
							echo get_comment_date(); ?>
						</time></a>

						<?php if(current_user_can( 'edit_comment', $comment->comment_ID ) || ($depth != 0 && $args['max_depth'] > $depth) ) : ?>
							<span class="comment-links">
								-
								<?php
								edit_comment_link( __( 'Edit', 'focus' ), '' , ' ');
								comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
								?>
							</span><!-- .comment-links -->
						<?php endif ?>
					</div><!-- .comment-text-area-right -->
				</div><!-- .comment-meta .commentmetadata -->

				<div class="comment-content entry-content">
					<?php comment_text(); ?>
				</div>
			</div>
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for focus_comment()

if ( ! function_exists( 'focus_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since focus 1.0
 */
function focus_posted_on() {
	printf(
		__( 'Posted On %s in %s with %s.', 'focus' ),
		sprintf( '<time class="entry-date" datetime="%1$s">%2$s</time> <time class="updated" datetime="%3$s">%4$s</time>',
			esc_attr( get_the_date( 'c' ) ),
			apply_filters( 'focus_posted_on_date', esc_html( get_the_date() ) ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		),
		'<span class="post-categories">'. get_the_category_list( ', ' ) .'</span>',
		'<span class="post-comments">'. sprintf( _n( 'One Comment', '%s Comments', get_comments_number(), 'focus' ), get_comments_number() ) .'</span>'
	);

	the_tags( '<span class="post-tags"> '. __( 'Tagged: ', 'focus' ), ', ', '.</span>' );
}
endif;

/**
 * Returns true if a blog has more than 1 category
 *
 * @since focus 1.0
 */
function focus_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so focus_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so focus_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in focus_categorized_blog
 *
 * @since focus 1.0
 */
function focus_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'focus_category_transient_flusher' );
add_action( 'save_post', 'focus_category_transient_flusher' );

if ( !function_exists( 'focus_navigation_arrows' ) ):
/**
 * Display a custom icons from the settings
 */
function focus_navigation_arrows() {
	$previous_icon = focus_display_icon( 'previous' );
	$next_icon = focus_display_icon( 'next' );
	previous_post_link( '<div class="nav-previous-post">%link</div>', $previous_icon );
	next_post_link( '<div class="nav-next-post">%link</div>', $next_icon );
}
endif;

if ( !function_exists( 'focus_custom_icon' ) ):
/**
 * Display a custom icons from the settings
 */
function focus_custom_icon( $icon ) {
	$image_id = siteorigin_setting( $icon );

	if ( $icon == 'icons_search' ) {
		$attrs['id'] = "masthead-search-icon";
	} else {
		$attrs  = '';
	}

	return wp_get_attachment_image( $image_id, 'full', false, $attrs );
}
endif;

if ( !function_exists( 'focus_display_icon' ) ) :
/**
 * Displays icons or images.
 */
function focus_display_icon( $type ) {
	switch( $type ) {
		case 'search':
			if ( siteorigin_setting( 'icons_search' ) ) :
				echo focus_custom_icon( 'icons_search' );
			else :
				echo '<i class="focus-icon-search" id="masthead-search-icon"></i>';
			endif;
			break;

		case 'previous' :
			if ( siteorigin_setting( 'icons_post_previous' ) ) :
				return focus_custom_icon( 'icons_post_previous' );
			else :
				return '<i class="focus-icon-circle-left"></i>';
			endif;
			break;

		case 'next' :
			if ( siteorigin_setting( 'icons_post_next' ) ) :
				return focus_custom_icon( 'icons_post_next' );
			else :
				return '<i class="focus-icon-circle-right"></i>';
			endif;
			break;

	}
}
endif;

/**
 * Filter the Page Builder data to remove the first row of widgets in the Full Width - No Title template.
 *
 * @param $data
 * @param $post_id
 *
 * @return mixed
 */
function focus_replace_panels_data( $data, $post_id ){

	if ( is_page() && is_page_template( 'page-full-no-title.php' ) && get_the_ID() == $post_id && get_post_meta( get_the_ID(), 'panels_data', true ) != '' ) {

		$page_template = get_post_meta( get_the_ID(), 'focus-page-header', true );
		if ( isset( $page_template ) && $page_template == 'yes' ) {

			unset( $data['grids'][0] );
			$data['grids'] = array_values( $data['grids'] );

			$to = count( $data['grid_cells'] );
			for ( $i = 0; $i < $to; $i++ ) {
				if ( $data['grid_cells'][$i]['grid'] == 0 ){
					unset( $data['grid_cells'][$i] );
				}
				else {
					$data['grid_cells'][$i]['grid']--;
				}
			}
			$data['grid_cells'] = array_values( $data['grid_cells'] );

			$to = count( $data['widgets'] );
			for ( $i = 0; $i < $to; $i++ ) {
				if ( $data['widgets'][$i]['panels_info']['grid'] == 0 ) {
					unset( $data['widgets'][$i] );
				} else {
					$data['widgets'][$i]['panels_info']['grid']--;
				}
			}
			$data['widgets'] = array_values( $data['widgets'] );

		}

	}

	return $data;
}
add_filter( 'siteorigin_panels_data', 'focus_replace_panels_data', 10, 2 );

/**
 * Check if content area needs to be displayed
 *
 * It'll only ever not be displayed if there's no content, there's a video, the author isn't shown, the sidebar doesn't have any widgets and comments are disabled.
 */ 
function focus_display_content_area() {
	$the_content = get_the_content();
	$panels_data = get_post_meta( get_the_ID(), 'panels_data', true );
	if ( ! ( empty( $the_content ) && empty( $panels_data ) && focus_post_has_video() && !siteorigin_setting( 'general_display_author' ) && !is_active_sidebar( 'sidebar-' . ( is_page() ? 'page' : 'post') ) && !comments_open() ) ) {
		return true;
	} else {
		return false;
	}
}
