<?php
/**
 * The template for displaying featured content
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */
?>

<?php
$before_featured = '';
$after_featured = '';
if('grid' == sq_option( 'featured_content_layout', 'carousel' )) {
	$before_featured = '<div class="row"><div class="grid-posts kleo-isotope masonry">';
	$after_featured = '</div></div>';
} 
else 
{
	$before_featured = '<div class="kleo-carousel-container">
				<div class="kleo-carousel-items kleo-carousel-post" data-min-items="3" data-max-items="3">
					<ul class="kleo-carousel">';
	$after_featured = '</ul></div>';
	$after_featured .= '<div class="carousel-arrow">
			<a class="carousel-prev" href="#"><i class="icon-angle-left"></i></a>
			<a class="carousel-next" href="#"><i class="icon-angle-right"></i></a>
		</div> ';
	$after_featured .= '</div>';
}

?>

<div id="featured-content" class="featured-content">
	
	<?php
		/**
		 * Fires before the featured content.
		 *
		 * @since Kleo 1.0
		 */
		do_action( 'kleo_featured_posts_before' );

		echo $before_featured;
		
		$featured_posts = kleo_get_featured_posts();
		foreach ( (array) $featured_posts as $order => $post ) :
			setup_postdata( $post );

			// Include the featured content template.
			if('grid' == sq_option( 'featured_content_layout', 'carousel' )) {
				get_template_part( 'page-parts/post-content-masonry');
			}
			else {
				get_template_part( 'page-parts/post-content-carousel');
			}
		endforeach;

		echo $after_featured;
		
		/**
		 * Fires after the Kleo featured content.
		 *
		 * @since Kleo 1.0
		 */
		do_action( 'kleo_featured_posts_after' );

		wp_reset_postdata();
	?>
</div><!-- #featured-content .featured-content -->
