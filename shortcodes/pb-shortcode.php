    <?php
    /**
     * Shortcode registration Scripts
     */
    ob_start();
    function pbfm_html($atts){

        global $wpdb;
        $metas = $wpdb->get_results( 
        $wpdb->prepare("SELECT * FROM $wpdb->postmeta where meta_key = %s", 'pbfm_uploaded_file')
        );
        $html = '';
        $html .= print_cpt_categories();
        $html .= '<div class="pbfm-container">';
            $html .= '<div class="pbfm-dflex pbfm-row">';
            foreach($metas as $meta){
                $post_id = $meta->post_id;
                $term_ids = get_the_terms($post_id,'pbfm_category');
                $term = '';
                foreach($term_ids as $term){
                    $terms .= "$term->term_id ";
                }
                $html .= '<div class="pbfm-col-3 download-file '.$terms.'">';
                $terms = '';
                    $html .= '<a href="'.$meta->meta_value.'" target="_blank">';
                        $html .=  '<div>';
                        $html .=  '<img src="https://pinoybuilders.ph/wp-content/uploads/2022/04/Commercial-Architect.jpg" />';
                        $html .= '<p>'.get_the_title($post_id).'</p>';
                        $html .= '</div>';
                    $html .= '</a>';
                $html .= '</div>';
            }
            $html .= '<div class="ajax-modal"></div>';
            $html .= '</div>';
        $html .= '</div>';
        $html .= '<div id="pagination-container"></div>';
    return $html;
    }
    ob_clean();
    add_shortcode('pbfm','pbfm_html');


    function print_cpt_categories(){
        $tax_terms = get_terms('pbfm_category', array('hide_empty' => false));
        $html = '';
        $html .= '<div class="pbfm-cat-list-container">';
            $html .= '<div class="pbfm-cat-list">';
            $html .= '<ul>';
            $html .= '<li class="pbfm-cat-link" term-id="all"><span class="dashicons dashicons-arrow-right-alt"></span>All</li>';
            foreach($tax_terms as $term){
                $html .= '<li class="pbfm-cat-link" term-id="'.$term->term_id.'"><span class="dashicons dashicons-arrow-right-alt"></span>'.$term->name.'</li>';
            }
            $html .= '</ul>';
            $html .= '</div>';
        $html .= '</div>';
        return $html;

    }
