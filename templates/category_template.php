<?php
//get All post of custom category
get_header();
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$category = get_term_by( 'slug', $term, 'free_resources' );
// $posts = get_posts(array(
//   'post_type' => 'pbfm',
//   'post_status' => 'publish',
//   'tax_query' => array(
//       array(
//         'taxonomy' => 'free_resources',
//         'field' => $category->term_id, //term id
//         'terms' => $category->term_id, //term id
//         'include_children' => false
//       )
//     )
// ));
?>
<main id="content" class="site-main" role="main">
	<?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
		<header class="page-header">
			<?php
			the_archive_title( '<h1 class="entry-title">', '</h1>' );
			the_archive_description( '<p class="archive-description">', '</p>' );
			?>
		</header>
	<?php endif; ?>
	<div class="page-content">
    <?php echo do_shortcode('[pbfm term_id="'.$category->term_id.'" ]'); ?>
	</div>
</main>



