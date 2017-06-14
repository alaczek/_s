<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.com/
 *
 * @package _s
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 */
function _s_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => '_s_infinite_scroll_render',
		'footer'    => 'page',
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Content Options.
	add_theme_support( 'jetpack-content-options', array(
		'blog-display'       => 'content', // the default setting of the theme: 'content', 'excerpt' or array( 'content', 'excerpt' ) for themes mixing both display.
		'author-bio'         => true, // display or not the author bio: true or false.
		'author-bio-default' => false, // the default setting of the author bio, if it's being displayed or not: true or false (only required if false).
		'masonry'            => '.site-main', // a CSS selector matching the elements that triggers a masonry refresh if the theme is using a masonry layout.
		'post-details'       => array(
			'stylesheet'      => 'themeslug-style', // name of the theme's stylesheet.
			'date'            => '.posted-on', // a CSS selector matching the elements that display the post date.
			'categories'      => '.cat-links', // a CSS selector matching the elements that display the post categories.
			'tags'            => '.tags-links', // a CSS selector matching the elements that display the post tags.
			'author'          => '.byline', // a CSS selector matching the elements that display the post author.
			'comment'         => '.comments-link', // a CSS selector matching the elements that display the comment link.
		),
		'featured-images'    => array(
			'archive'         => true, // enable or not the featured image check for archive pages: true or false.
			'archive-default' => false, // the default setting of the featured image on archive pages, if it's being displayed or not: true or false (only required if false).
			'post'            => true, // enable or not the featured image check for single posts: true or false.
			'post-default'    => false, // the default setting of the featured image on single posts, if it's being displayed or not: true or false (only required if false).
			'page'            => true, // enable or not the featured image check for single pages: true or false.
			'page-default'    => false, // the default setting of the featured image on single pages, if it's being displayed or not: true or false (only required if false).
			'fallback'		  => true, // enable fallack to first image used in the post.
		),
	) );
}
add_action( 'after_setup_theme', '_s_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function _s_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
			get_template_part( 'template-parts/content', 'search' );
		else :
			get_template_part( 'template-parts/content', get_post_format() );
		endif;
	}
}

/**
 * Custom function to check for a post thumbnail;
 * If Jetpack is not available, fall back to has_post_thumbnail()
 */
function _s_has_post_thumbnail( $post = null ) {
	if ( function_exists( 'jetpack_has_featured_image' ) ) {
		return jetpack_has_featured_image( $post );
	} else {
		return has_post_thumbnail( $post );
	}
}

/**
 * Return early if Author Bio is not available.
 */
function _s_author_bio() {
	if ( ! function_exists( 'jetpack_author_bio' ) ) {
		get_template_part( 'content', 'author' );
	} else {
		jetpack_author_bio();
	}
}
