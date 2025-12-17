<?php
/**
 * Template Tags
 * Custom template tags for the theme
 *
 * @package Mason
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Display breadcrumbs
 *
 * @return void
 */
function mason_breadcrumbs() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<nav class="mason-breadcrumbs">', '</nav>' );
	} elseif ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
		rank_math_the_breadcrumbs();
	}
}

/**
 * Get reading time for a post
 *
 * @param int $post_id Post ID.
 * @return int Reading time in minutes.
 */
function mason_get_reading_time( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$content = get_post_field( 'post_content', $post_id );
	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	$reading_time = ceil( $word_count / 200 ); // Average reading speed: 200 words/minute

	return $reading_time;
}

/**
 * Display reading time
 *
 * @param int $post_id Post ID.
 * @return void
 */
function mason_the_reading_time( $post_id = null ) {
	$reading_time = mason_get_reading_time( $post_id );
	printf(
		/* translators: %d: reading time in minutes */
		esc_html( _n( '%d min read', '%d mins read', $reading_time, 'mason' ) ),
		absint( $reading_time )
	);
}

/**
 * Check if WooCommerce is active
 *
 * @return bool
 */
function mason_is_woocommerce_active() {
	return class_exists( 'WooCommerce' );
}

/**
 * Get theme mod with default
 *
 * @param string $key Theme mod key.
 * @param mixed  $default Default value.
 * @return mixed
 */
function mason_get_theme_mod( $key, $default = false ) {
	return get_theme_mod( 'mason_' . $key, $default );
}

/**
 * Display post meta (date, author, categories, etc.)
 *
 * @return void
 */
function mason_post_meta() {
	?>
	<div class="mason-post-meta">
		<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="mason-post-meta__date">
			<?php echo esc_html( get_the_date() ); ?>
		</time>
		
		<span class="mason-post-meta__separator">·</span>
		
		<span class="mason-post-meta__author">
			<?php
			printf(
				/* translators: %s: author name */
				esc_html__( 'by %s', 'mason' ),
				'<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
			);
			?>
		</span>
		
		<?php if ( has_category() ) : ?>
			<span class="mason-post-meta__separator">·</span>
			<span class="mason-post-meta__categories">
				<?php the_category( ', ' ); ?>
			</span>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Display share buttons
 *
 * @return void
 */
function mason_share_buttons() {
	$post_url = urlencode( get_permalink() );
	$post_title = urlencode( get_the_title() );
	?>
	<div class="mason-share-buttons">
		<span class="mason-share-buttons__label"><?php esc_html_e( 'Share:', 'mason' ); ?></span>
		
		<a href="https://twitter.com/intent/tweet?url=<?php echo $post_url; ?>&text=<?php echo $post_title; ?>" 
		   target="_blank" 
		   rel="noopener noreferrer"
		   class="mason-share-buttons__button mason-share-buttons__button--twitter"
		   aria-label="<?php esc_attr_e( 'Share on Twitter', 'mason' ); ?>">
			<span>Twitter</span>
		</a>
		
		<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $post_url; ?>" 
		   target="_blank" 
		   rel="noopener noreferrer"
		   class="mason-share-buttons__button mason-share-buttons__button--facebook"
		   aria-label="<?php esc_attr_e( 'Share on Facebook', 'mason' ); ?>">
			<span>Facebook</span>
		</a>
		
		<a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $post_url; ?>" 
		   target="_blank" 
		   rel="noopener noreferrer"
		   class="mason-share-buttons__button mason-share-buttons__button--linkedin"
		   aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'mason' ); ?>">
			<span>LinkedIn</span>
		</a>
	</div>
	<?php
}

/**
 * Get SVG icon
 *
 * @param string $icon Icon name.
 * @param string $class CSS class.
 * @return string
 */
function mason_get_icon( $icon, $class = '' ) {
	$icons = array(
		'arrow-right' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
		'check'       => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>',
		'star'        => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>',
	);

	$svg = isset( $icons[ $icon ] ) ? $icons[ $icon ] : '';
	
	if ( $class ) {
		$svg = str_replace( '<svg ', '<svg class="' . esc_attr( $class ) . '" ', $svg );
	}

	return $svg;
}

/**
 * Display SVG icon
 *
 * @param string $icon Icon name.
 * @param string $class CSS class.
 * @return void
 */
function mason_icon( $icon, $class = '' ) {
	echo mason_get_icon( $icon, $class );
}
