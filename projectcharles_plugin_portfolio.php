<?php
/*
This file for displaying the portfolio post type is required in "custom_post_widget.php",
the widget creating and shortcode file
*/

/*#######################################################################################
To reister the portfolio post type
##########################################################################################*/ 
add_action( 'init', 'projectcharles_custom_post_setting' );
function projectcharles_custom_post_setting() {
    $args = array(
                  'description' => 'Portfolio Post Type',
                  'show_ui' => true,
                  'menu_position' => 4,
                  'exclude_from_search' => true,
                  'labels' => array(
                                    'name'=> 'Portfolios',
                                    'singular_name' => 'Portfolios',
                                    'add_new' => 'Add New Portfolio',
                                    'add_new_item' => 'Add New Portfolio',
                                    'edit' => 'Edit Portfolios',
                                    'edit_item' => 'Edit Portfolio',
                                    'new-item' => 'New Portfolio',
                                    'view' => 'View Portfolios',
                                    'view_item' => 'View Portfolio',
                                    'search_items' => 'Search Portfolios',
                                    'not_found' => 'No Portfolios Found',
                                    'not_found_in_trash' => 'No Portfolios Found in Trash',
                                    'parent' => 'Parent Portfolio'
                                   ),
                 'public' => true,
                 'capability_type' => 'post',
                 'hierarchical' => false,
                 'rewrite' => true,
                 'supports' => array('title', 'editor', 'thumbnail', 'comments')
                 );
    register_post_type( 'portfolio' , $args );
}
/*#######################################################################################
The portfolio post type taxonomy
##########################################################################################*/ 

//Register Custom Taxonomies


add_action('init', 'projectcharles_identify_taxonomy');

function projectcharles_identify_taxonomy() {
  register_taxonomy('portfolio_category',
                    'portfolio',
                     array (
                           'labels' => array (
                                              'name' => 'Portfolio Categories',
                                              'singular_name' => 'Portfolio Categories',
                                              'search_items' => 'Search Portfolio Categories',
                                              'popular_items' => 'Popular Portfolio Categories',
                                              'all_items' => 'All Portfolio Categories',
                                              'parent_item' => 'Parent Portfolio Category',
                                              'parent_item_colon' => 'Parent Portfolio Category:',
                                              'edit_item' => 'Edit Portfolio Category',
                                              'update_item' => 'Update Portfolio Category',
                                              'add_new_item' => 'Add New Portfolio Category',
                                              'new_item_name' => 'New Portfolio Category',
                                            ),
                            'hierarchical' =>true,
                            'show_ui' => true,
                            'show_tagcloud' => true,
                            'rewrite' => false,
                            'public'=>true
                            )
                     );
}
?>