<?php
$grid_link = $grid_layout_mode = $title = $filter= '';
$posts = array();
extract(shortcode_atts(array(
    'title' => '',
    'el_class' => '',
    'orderby' => NULL,
    'order' => 'DESC',
    'loop' => '',
), $atts));


if(empty($loop)) return;
$this->getLoop($loop);
$my_query = $this->query;
$args = $this->loop_args;

$el_class = $el_class != "" ? " ".$el_class : ""; 
?>

<?php
	query_posts($args);

	if ( have_posts() ) : ?>

		<div class="masonry-listing">
			<div class="grid-posts kleo-isotope masonry<?php echo $el_class;?>">

				<?php
				while ( have_posts() ) : the_post();

					get_template_part('page-parts/post-content-masonry');

				endwhile;
				?>


		</div>

	</div><!--end row-->

<?php
endif;
// Reset Query
wp_reset_query();