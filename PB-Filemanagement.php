<?php
/*
*Plugin Name: PB File Management System 
*Plugin URI: https://pinoybuilders.ph
*Description: Customize Pinoybuilder Plugin
*Version: 1.0
*Author: Automattic
*Author URI:  https://pinoybuilders.ph
*License: GPLv2 or later
*Text Domain: PB File Management System
*/

if( !defined('PBFILEMANAGEMENT_BASE_DIR') ){
    define( 'PBFILEMANAGEMENT_BASE_DIR',dirname(__FILE__) );
}
if( !defined('PBFILEMANAGEMENT_BASE_URL') ){
    define( 'PBFILEMANAGEMENT_BASE_URL',plugins_url('',PBFILEMANAGEMENT_BASE_DIR,'/PB-Filemanagement.php') );
}
if( !defined('PBFILEMANAGEMENT_BASE_BASENAME') ){
    define( 'PBFILEMANAGEMENT_BASE_BASENAME',plugin_basename(PBFILEMANAGEMENT_BASE_DIR,'/PB-Filemanagement.php') );
}
/**
 * Activation Hook
 */
function pbfilemanagement_install(){
   

}
register_activation_hook(PBFILEMANAGEMENT_BASE_DIR,'/PB-Filemanagement.php','pbfilemanagement_install');

/**
 * Deactivation hook
 */
function pbfilemanagement_uninstall(){
 
}
register_deactivation_hook(PBFILEMANAGEMENT_BASE_DIR,'/PB-Filemanagement.php','pbfilemanagement_uninstall');

/**
 * Load user scripts
 */
function pbfilemanagement_enqueue() {
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'pbfilemanagement',  plugin_dir_url( __FILE__ ) . 'assets/js/main.js',array('jquery'),'1.0.0',true  );
    wp_enqueue_script( 'simplepagination',  plugin_dir_url( __FILE__ ) . 'assets/js/simple-pagination.js',array('jquery'),'1.0.0',true  );
  
    wp_localize_script('pbfilemanagement','pbfm_localize_script',array(
        'pbfilemanagement_ajax' => admin_url( 'admin-ajax.php' ),
        'pbfilemanagement_nonce' => wp_create_nonce('pbfilemanagement_nonce'),
    ));
    wp_enqueue_style('pbfilemanagement-css',plugin_dir_url( __FILE__ ).'assets/css/styles.css','1','all');        
    wp_enqueue_style('simplepagination-css',plugin_dir_url( __FILE__ ).'assets/css/simple-pagination.css','1','all');        
    // wp_register_style('pbfilemanagement-css');
}
add_action( 'wp_enqueue_scripts', 'pbfilemanagement_enqueue' );
/**
 * Load admin scripts
 */
function admin_pbfilemanagement_enqueue(){
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'admin-pbfilemanagement',  plugin_dir_url( __FILE__ ) . 'admin/assets/js/admin-main.js',array('jquery'),'1.0.0',true  );  

}
add_action('admin_enqueue_scripts','admin_pbfilemanagement_enqueue');

// Register Custom Post Type PBFM
// Register Custom Post Type PBFM
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

function pbfm_save_files( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	if ( isset( $_POST['pbfm_uploaded_file'] ) ){
		update_post_meta( $post_id, 'pbfm_uploaded_file', esc_attr( $_POST['pbfm_uploaded_file'] ) );
	}
	
}
add_action( 'save_post', 'pbfm_save_files' );

function callback_filter_category(){
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

        $nonce = $_POST['security'];
        
        if ( empty($_POST) || !wp_verify_nonce( $nonce, 'pbfilemanagement_nonce' ) ) die('An error occurred. Please contact the Administrator.');
        wp_send_json($_POST['data']);
    }
}
add_action( 'wp_ajax_filter_category', 'callback_filter_category' );
add_action( 'wp_ajax_nopriv_filter_category', 'callback_filter_category' );

include(PBFILEMANAGEMENT_BASE_DIR.'/shortcodes/pb-shortcode.php');


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




function pbfm_html($atts){
	global $post;
	$btpgid=get_queried_object_id();
	$btmetanm=get_post_meta( $btpgid, 'WP_Catid','true' );
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

	$get_term = shortcode_atts( array(
		'term_id' => null,
		'per_page' => -1,
	), $atts );

	$cats = array(
		'post_type' => 'pbfm',
		'post_status' => 'publish',
		'posts_per_page' => $get_term['per_page'],
		'paged' => $paged,
		'tax_query' => array(
			array(
			  'taxonomy' => 'free_resources',
			  'field' => $get_term['term_id'], //term id
			  'terms' => $get_term['term_id'], //term id
			  'include_children' => false
			)
		  )
	);
	$postslist = new WP_Query( $cats );
	if ( $postslist->have_posts() ) :
		$html = '';
		$html .= '<div class="pbfm-container">';
			$html .= '<div class="pbfm-dflex pbfm-row">';
        while ( $postslist->have_posts() ) : $postslist->the_post(); 
		$meta = get_post_meta($post->ID,'pbfm_uploaded_file');
		$html .= '<div class="pbfm-col-3 download-file">';
		$terms = '';
			$html .= '<a href="'.$meta[0].'" target="_blank">';
				$html .=  '<div class="pbfm-img-container">';
				$html .=  '<img src="https://pinoybuilders.ph/wp-content/uploads/2022/04/Commercial-Architect.jpg" />';
				$html .= '<p>'.get_the_title($post->ID).'</p>';
				$html .= '<i class="fa fa-arrow-circle-down" aria-hidden="true"></i>';
				$html .= '</div>';
			$html .= '</a>';
		$html .= '</div>';
         endwhile;  

			$html .= '<div class="ajax-modal"></div>';
			$html .= '</div>';
		$html .= '</div>';
		// $html .= '<div id="pagination-container">';
		// $html .= '<button class="pbfm-pagination-next">'.get_next_posts_link( 'Next &raquo;', $postslist->max_num_pages ).'</button>';
		// $html .= '<button class="pbfm-pagination-prev">'.get_previous_posts_link( 'Previous &raquo;' ).'</button>'; 
		// $html .= wp_reset_postdata();
		// $html .= '</div>';
    endif;
return $html;
}

add_shortcode('pbfm','pbfm_html');

function get_custom_post_type_template( $template ) {
	global $post;
	$term = get_queried_object();
	if ( is_tax('free_resources') ) {
		$term = get_queried_object();
		$template  = dirname( __FILE__ ) . '/templates/category_template.php';
		}
	return $template;
}

add_filter( 'template_include', 'get_custom_post_type_template' ) ;






