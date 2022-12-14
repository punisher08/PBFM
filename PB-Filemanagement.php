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
		'name' => _x( 'PBFM', 'Post Type General Name', 'textdomain' ),
		'singular_name' => _x( 'PBFM', 'Post Type Singular Name', 'textdomain' ),
		'menu_name' => _x( 'PBFM', 'Admin Menu text', 'textdomain' ),
		'name_admin_bar' => _x( 'PBFM', 'Add New on Toolbar', 'textdomain' ),
		'archives' => __( 'PBFM Archives', 'textdomain' ),
		'attributes' => __( 'PBFM Attributes', 'textdomain' ),
		'parent_item_colon' => __( 'Parent PBFM:', 'textdomain' ),
		'all_items' => __( 'All PBFM', 'textdomain' ),
		'add_new_item' => __( 'Add New PBFM', 'textdomain' ),
		'add_new' => __( 'Add New', 'textdomain' ),
		'new_item' => __( 'New PBFM', 'textdomain' ),
		'edit_item' => __( 'Edit PBFM', 'textdomain' ),
		'update_item' => __( 'Update PBFM', 'textdomain' ),
		'view_item' => __( 'View PBFM', 'textdomain' ),
		'view_items' => __( 'View PBFM', 'textdomain' ),
		'search_items' => __( 'Search PBFM', 'textdomain' ),
		'not_found' => __( 'Not found', 'textdomain' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
		'featured_image' => __( 'Featured Image', 'textdomain' ),
		'set_featured_image' => __( 'Set featured image', 'textdomain' ),
		'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
		'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
		'insert_into_item' => __( 'Insert into PBFM', 'textdomain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this PBFM', 'textdomain' ),
		'items_list' => __( 'PBFM list', 'textdomain' ),
		'items_list_navigation' => __( 'PBFM list navigation', 'textdomain' ),
		'filter_items_list' => __( 'Filter PBFM list', 'textdomain' ),
	);
	$args = array(
		'label' => __( 'PBFM', 'textdomain' ),
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
		'has_archive' => false,
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
        $html .= '<input id="pbfm_uploaded_file" type="text" name="pbfm_uploaded_file" value="'.$file[0].'"style="width:100%; border:none;"/>';
    }else{
        $html .= '<input id="pbfm_uploaded_file" type="text" name="pbfm_uploaded_file" style="width:100%; border:none;"/>';
    }
    $html .= '<br />';
    $html .= '<br />';
    $html .= '<input id="wp_custom_attachment" type="button" value="Upload File" />';
     
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
	register_taxonomy( 'pbfm_category', array('pbfm'), $args );

}
add_action( 'init', 'create_category_tax' );


function oawutojao(){
	$tax_terms = get_terms('pbfm_category', array('hide_empty' => false));
	$term_ids = get_the_terms(45,'pbfm_category');
	echo '<pre>';
	print_r(explode($term_ids));
	echo '<pre>';
	die();

}
// add_action('admin_init','oawutojao');	







