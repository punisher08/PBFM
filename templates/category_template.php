<?php
//get All post of custom category
$cats = get_posts(array(
    'post_type' => 'pbfm',
    'post_status' => 'publish',
    'tax_query' => array(
        array(
          'taxonomy' => 'pbfm_category',
          'field' => '58', //term id
          'terms' => 58, //term id
          'include_children' => false
        )
      )
));