<?php
/**
 * The template for displaying posts in the Link post format
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */
?>

<?php
$postclass = '';
if( is_single() && get_cfield('centered_text') == 1) { $postclass = 'text-center'; } 
?>

<!-- Begin Article -->
<article id="post-<?php the_ID(); ?>" <?php post_class(array($postclass)); ?>>

	<?php if(!is_single() || (is_single() && kleo_postmeta_enabled())): ?>
		<div class="article-meta">
			<span class="post-meta">
				<?php kleo_entry_meta();?>
			</span>
			<?php edit_post_link( __( 'Edit', 'kleo_framework' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!--end article-meta-->
	<?php endif;?>
	
	<div class="article-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'kleo_framework' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'kleo_framework' ), 'after' => '</div>' ) ); ?>
	</div><!--end article-content-->
	
</article>
<!-- End  Article -->