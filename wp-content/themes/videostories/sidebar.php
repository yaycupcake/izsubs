<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package VideoStories
 */

if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'blog-sidebar' ); ?>
</aside><!-- #secondary -->
