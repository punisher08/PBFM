<?php
//get All post of custom category
get_header();
$category = get_term_by( 'slug', $term, 'free_resources' );
?>
<main id="content" class="site-main" role="main">
    <?php echo do_shortcode('[pbfm term_id="'.$category->term_id.'" ]'); ?>
</main>



