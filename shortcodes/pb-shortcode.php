    <?php
    /**
     * Shortcode registration Scripts
     */
    function print_cpt_categories(){
        ob_start();
        $tax_terms = get_terms('free_resources', array('hide_empty' => false));
        $html = '';
        $html .= '<div class="pbfm-cat-list-container">';
            $html .= '<div class="pbfm-cat-list">';
            $html .= '<h4 class="pbfm-cat-heading">Categories</h4>';
            $html .= '<ul>';
            $html .= '<li class="pbfm-cat-link" term-id="all"><span class="dashicons dashicons-arrow-right-alt"></span>All</li>';
            foreach($tax_terms as $term){
                $html .= '<a href="'.get_category_link($term->term_id).'"><li class="pbfm-cat-link" term-id="'.$term->term_id.'"><span class="dashicons dashicons-arrow-right-alt"></span>'.$term->name.'</li></a>';
            }
            $html .= '</ul>';
            $html .= '</div>';
        $html .= '</div>';
        return $html;

    }
    add_shortcode('pbfm_categories','print_cpt_categories');
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
