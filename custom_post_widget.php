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

?>