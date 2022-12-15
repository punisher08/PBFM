<?php

function callback_filter_category(){
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

        $nonce = $_POST['security'];
        
        if ( empty($_POST) || !wp_verify_nonce( $nonce, 'pbfilemanagement_nonce' ) ) die('An error occurred. Please contact the Administrator.');
        wp_send_json($_POST['data']);
    }
}
add_action( 'wp_ajax_filter_category', 'callback_filter_category' );
add_action( 'wp_ajax_nopriv_filter_category', 'callback_filter_category' );