<?php
/**
 * Shortcode registration Scripts
 */
ob_start();
function pblsider_html($atts){

    global $wpdb;
    $metas = $wpdb->get_results( 
    $wpdb->prepare("SELECT * FROM $wpdb->postmeta where meta_key = %s", 'pbfm_uploaded_file')
    );
    $html = '';
    $html .= '<div class="pbfm-container">';
        $html .= '<div class="pbfm-dflex pbfm-row">';
        foreach($metas as $meta){
            $html .= '<div class="pbfm-col-3 download-file">';
                $html .= '<a href="'.$meta->meta_value.'">';
                    $html .=  '<div>';
                    $html .=  '<img src="https://pinoybuilders.ph/wp-content/uploads/2022/04/Commercial-Architect.jpg" />';
                    $html .= '</div>';
                $html .= '</a>';
            $html .= '</div>';
        }
        $html .= '</div>';
    $html .= '</div>';
   return $html;
}
ob_clean();
add_shortcode('pbfm','pblsider_html');
// add_action('admin_init','pblsider_html');
