<?php
defined('ABSPATH') or die("please don't run scripts");
/*
* @file           socialmag-comments.php
* @package        SocialMag
* @author         ThemesMatic
* @copyright      2017 ThemesMatic
*/

function socialmag_comment( $comment, $args, $depth ) {
switch ( $comment->comment_type ) :
	case 'pingback' :
	case 'trackback' :
?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php esc_html_e( 'Pingback:', 'socialmag' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html_e( '(Edit)', 'socialmag' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
		break;
		default :
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment comment-article">
			<div class="comment-author">
				<?php
					echo get_avatar( $comment, 54 );
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . esc_html_e( 'Post author', 'socialmag' ) . '</span>' : ''
					);
					printf( '<time datetime="%2$s">%3$s</time>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( esc_html__( '%1$s at %2$s', 'socialmag' ), get_comment_date(), get_comment_time() )
					);
				?>
			</div><!-- comment-meta ThemesMatic -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p><?php esc_html_e( 'Comment is awaiting moderation.', 'socialmag' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( esc_html__( 'Edit', 'socialmag' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- /.comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__( 'Reply to ', 'socialmag' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?><?php echo comment_author(); ?>
			</div><!-- /.reply -->
		</article><!-- /#comment-<?php comment_ID(); ?> -->
	<?php
		break;
	endswitch; // end comment_type check
}