<?php
/*
Plugin Name: Projectcharles plugin
Plugin URI: http://phoenix.sheridanc.on.ca/~ccit3679
Description: This plugin adds a custom post type, a widget, and a shortcode to a portfolio site.
Author: Charles Ezechukwu
Version: 1.0
Author URI: http://phoenix.sheridanc.on.ca/~ccit3679
License: GPLv2
*/
/*#######################################################################################
Obective: To create a plugin that adds a custom post type, a widget, and a shortcode to a 
portfolio site.The widget will display a set number of posts from the custom post type in a 
set order, and will also display the featured image for each post.
##########################################################################################*/

/*#######################################################################################
Seperate the portfolio custom post file from the widget creation and shortcode file 
for cleaener coding and reusability.
##########################################################################################*/

require('projectcharles_plugin_portfolio.php');

/*#######################################################################################
Create a new image size, which will be used with the portfolio Custom Post Type:
##########################################################################################*/

if ( function_exists( 'add_theme_support' ) ) {
add_theme_support( 'post-thumbnails');
add_image_size('Projectcharles', 1100, 640, true);
}

/*#######################################################################################
Create the widget that will give users the option to select a category for 
displaying the portfolio post type
##########################################################################################*/
 
class Projectcharles_widget extends WP_Widget {// this class extentds WordPress in-built class
function __construct() {/**This is the constructor method for calling each newly-created object*/
parent::__construct(
// The widget's main ID
'Projectcharles_widget', 

/**This is the name used for identifying this widget at WordPress widget options**/
__('Projectcharles Portfolio Widget', 'projectcharles_widget_setup'), 

// The description of the widget
array( 'description' => __( 'Projectcharles plugin', 'projectcharles_widget_setup' ), ) 
);
}
/*#######################################################################################
Create instances of form input to give users, the option for 
contents that will be displayed by the widget
##########################################################################################*/

/******************The actual functionalities of the widget begins *********************/
public function widget( $args, $inst ) {
$title = apply_filters( 'widget_title', $inst['title'] );
$category = apply_filters( 'widget_category', $inst['category'] );
// before and after widget arguments are defined by themes
if ( ! empty( $title ) ){
echo $args['before_title'] . $title . $args['after_title'];
}
if ( ! empty( $category ) ){
echo $args['before_category'] . "Category :".$category . $args['after_category'];
}
/**The only option given to users in the widget is "portfolio Title" and "Category name". 
The set number of posts from the custom post type and the set order is fixed at 5 and 
Ascending(ASC) order respectively. However, the portfolio post type is orderedby name in portfolio.php*/
$args = array(
'post_type' => 'portfolio', // Widget displays from portfolio custom post
'portfolio_category' =>$category, // Users select the category 
'posts_per_page' =>5, 
'order'=>"ASC"
);
$the_query = new WP_Query( $args );//To query the database
$the_query = new WP_Query( $args );
// The Loop
if ( $the_query->have_posts() ) {
echo '<ul>';
while ( $the_query->have_posts() ) {
$the_query->the_post();
			$result .= '<li>';
/**Display the featured image and the title. The display of the excerpt and 
the full content is ommitted just for users that may display the content in a narrower widget**/
			$result .= '<a href="' . get_the_permalink() .'" rel="bookmark">'.get_the_post_thumbnail($post_id, array( 50, 50) ).'<p>'.get_the_title().'(red more)</p></a></li><hr>';
}
echo '</ul>';
} else {
//Do nothing
}
/* Reset to original Post Data */
wp_reset_postdata();
echo __($result, 'projectcharles_widget_setup' );
echo $args['after_widget'];
}
		
/*#######################################################################################
Keep the user options of the widget actionable via backend
##########################################################################################*/ 
public function form( $represent ) {
if ( isset( $inst[ 'title' ] ) ) {
$title = $inst[ 'title' ];
}
else {
$title = __( 'Title', 'projectcharles_widget_setup' );
}

if ( isset( $inst[ 'category' ] ) ) {
$category = $inst[ 'category' ];
}
else {
$category = __( 'Category', 'projectcharles_widget_setup' );
}
?>