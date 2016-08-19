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
/*#######################################################################################
The admin form of the widget is created
##########################################################################################*/ 
?>
<p>
<!----------------------------Widget Fields: Title---------------------------------------->
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</P>
<P>
<!----------------------------Widget Fields: Category---------------------------------------->
<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" type="text" value="<?php echo esc_attr( $category ); ?>" />
</P>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$inst = array();
$inst['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$inst['category'] = ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category'] ) : '';
return $inst;
}
} // Class Projectcharles_widget ends here

// Register and load the widget
function Projectcharles_load_widget() {
	register_widget( 'Projectcharles_widget' );
}
add_action( 'widgets_init', 'Projectcharles_load_widget' );


/*##################################################################################################
The shortcode is created here with the aim of giving users the option to select a specific category, 
the set order, and post per page for dispalying the portfolio custom post type. The users can use 
the following shortcode anywhere in the post or page: 
[custom_post_category name="" how_many_posts=  show_what_order=""]. Remember, post per page is set to 5, 
set order is ASC, and orderedby name are fixed in the backend for non shortcode options. 
##########################################################################################*/
function Projectcharles_postsbycategory($atts) {
   extract(shortcode_atts(array(
      'name' => "",
	  'how_many_posts'=>"",
	  'show_what_order'=>""
   ), $atts));

// the query
$the_query = new WP_Query( array( 'category_name' =>$name, 'posts_per_page' =>$how_many_posts, 'order'=>$show_what_order)); 

// The Loop
if ( $the_query->have_posts() ) {
	$result .= '<ul>';
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
			if ( has_post_thumbnail() ) {
			$result .= '<li>';
			$result .= '<a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_post_thumbnail($post_id, array( 50, 50) ) . get_the_title() .'</a></li>';
			} else { 
			// if no featured image is found
			$result .= '<li><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() .'</a></li>';
			}
			}
	} else {
	// no posts found
}
$result .= '</ul>';

return $result;

/* Restore original Post Data */
wp_reset_postdata();
}
// Add a shortcode
add_shortcode('custom_post_category', 'Projectcharles_postsbycategory');

// Enable shortcodes in text widgets
add_filter('widget_text', 'do_shortcode');
?>