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
ob_start();
error_reporting(0);
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
    // wp_enqueue_script( 'simplepagination',  plugin_dir_url( __FILE__ ) . 'assets/js/simple-pagination.js',array('jquery'),'1.0.0',true  );
  
    wp_localize_script('pbfilemanagement','pbfm_localize_script',array(
        'pbfilemanagement_ajax' => admin_url( 'admin-ajax.php' ),
        'pbfilemanagement_nonce' => wp_create_nonce('pbfilemanagement_nonce'),
    ));
    wp_enqueue_style('pbfilemanagement-css',plugin_dir_url( __FILE__ ).'assets/css/styles.css','1','all');        
    // wp_enqueue_style('simplepagination-css',plugin_dir_url( __FILE__ ).'assets/css/simple-pagination.css','1','all');        
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




function pbfm_save_files( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	if ( isset( $_POST['pbfm_uploaded_file'] ) ){
		update_post_meta( $post_id, 'pbfm_uploaded_file', esc_attr( $_POST['pbfm_uploaded_file'] ) );
	}
	
}
add_action( 'save_post_pbfm', 'pbfm_save_files' );

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

include(PBFILEMANAGEMENT_BASE_DIR.'/shortcodes/pb-shortcode.php');
include(PBFILEMANAGEMENT_BASE_DIR.'/register_cpt.php');
include(PBFILEMANAGEMENT_BASE_DIR.'/ajax_handle.php');



