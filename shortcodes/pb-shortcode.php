    <?php
    /**
     * Shortcode registration Scripts
     */
    ob_start();
    function print_cpt_categories(){
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
    ob_clean();
