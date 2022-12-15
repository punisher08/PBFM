<?php
// Register CPT
function create_pbfm_cpt() {

	$labels = array(
		'name' => _x( 'Free Resources', 'Post Type General Name', 'textdomain' ),
		'singular_name' => _x( 'Free Resources', 'Post Type Singular Name', 'textdomain' ),
		'menu_name' => _x( 'Free Resources', 'Admin Menu text', 'textdomain' ),
		'name_admin_bar' => _x( 'Free Resources', 'Add New on Toolbar', 'textdomain' ),
		'archives' => __( 'Free Resources Archives', 'textdomain' ),
		'attributes' => __( 'Free Resources Attributes', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Free Resources:', 'textdomain' ),
		'all_items' => __( 'All Free Resources', 'textdomain' ),
		'add_new_item' => __( 'Add New Free Resources', 'textdomain' ),
		'add_new' => __( 'Add New', 'textdomain' ),
		'new_item' => __( 'New Free Resources', 'textdomain' ),
		'edit_item' => __( 'Edit Free Resources', 'textdomain' ),
		'update_item' => __( 'Update Free Resources', 'textdomain' ),
		'view_item' => __( 'View Free Resources', 'textdomain' ),
		'view_items' => __( 'View Free Resources', 'textdomain' ),
		'search_items' => __( 'Search Free Resources', 'textdomain' ),
		'not_found' => __( 'Not found', 'textdomain' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
		'featured_image' => __( 'Featured Image', 'textdomain' ),
		'set_featured_image' => __( 'Set featured image', 'textdomain' ),
		'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
		'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
		'insert_into_item' => __( 'Insert into Free Resources', 'textdomain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Free Resources', 'textdomain' ),
		'items_list' => __( 'Free Resources list', 'textdomain' ),
		'items_list_navigation' => __( 'Free Resources list navigation', 'textdomain' ),
		'filter_items_list' => __( 'Filter Free Resources list', 'textdomain' ),
	);
	$args = array(
		'label' => __( 'Free Resources', 'textdomain' ),
		'description' => __( 'create file management system', 'textdomain' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-media-code',
		'supports' => array('title', 'thumbnail', 'page-attributes'),
		'taxonomies' => array(),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'rest_base' => 'pbfm',
		'rest_controller_class' => 'PBFM',
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'pbfm', $args );

}
add_action( 'init', 'create_pbfm_cpt', 0 );


// Register Taxonomy category
function create_category_tax() {

	$labels = array(
		'name'              => _x( 'Category', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Category', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Category', 'textdomain' ),
		'all_items'         => __( 'All Category', 'textdomain' ),
		'parent_item'       => __( 'Parent Category', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Category:', 'textdomain' ),
		'edit_item'         => __( 'Edit Category', 'textdomain' ),
		'update_item'       => __( 'Update Category', 'textdomain' ),
		'add_new_item'      => __( 'Add New Category', 'textdomain' ),
		'new_item_name'     => __( 'New Category Name', 'textdomain' ),
		'menu_name'         => __( 'Category', 'textdomain' ),
	);
	$args = array(
		'labels' => $labels,
		'description' => __( '', 'textdomain' ),
		'hierarchical' => true,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'show_in_quick_edit' => true,
		'show_admin_column' => false,
		'show_in_rest' => true,
	);
	register_taxonomy( 'free_resources', array('pbfm'), $args );

}
add_action( 'init', 'create_category_tax' );

function add_custom_meta_boxes() {
    add_meta_box(
        'wp_custom_attachment',
        'Custom Attachment',
        'wp_custom_attachment',
        'pbfm',
        'advanced'
    );
 
} // end add_custom_meta_boxes
add_action('add_meta_boxes', 'add_custom_meta_boxes');

function wp_custom_attachment() {
 
    wp_nonce_field(plugin_basename(__FILE__), 'wp_custom_attachment_nonce');
    global $post;
    $file = get_post_meta($post->ID,'pbfm_uploaded_file');
    $html = '<p class="description">';
    $html .= 'Upload your File here.';
    $html .= '</p>';
   
    if(!empty($file[0])){
        $html .= '<input id="pbfm_uploaded_file" type="text" name="pbfm_uploaded_file" value="'.$file[0].'" style="width:80%; margin:auto;"/>';
    }else{
        $html .= '<input id="pbfm_uploaded_file" type="text" name="pbfm_uploaded_file" style="width:80%; margin:auto;" />';
    }
 
    $html .= '<br />';
    $html .= '<br />';
    $html .= '<div class="pbfm-btn">';
    $html .= '<input id="wp_custom_attachment" type="button" value="Upload File" />';
    $html .= '</div>';
     
    echo $html;
 
} // end wp_custom_attachment


function pbfm_change_entries_sortable_columns( $columns )
{
    $columns['title'] = 'File Name';
    return $columns;
}

add_filter( 'manage_pbfm_posts_columns', 'pbfm_change_entries_sortable_columns' );

add_filter('manage_posts_columns', 'thumbnail_column');

function thumbnail_column($columns) {
  $new = array();
  foreach($columns as $key => $title) {
    if ($key=='date') // Put the Thumbnail column before the Author column
      $new['category'] = 'Category';
    $new[$key] = $title;
  }
  return $new;
}