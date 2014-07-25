<?php
/**
 * Twenty Twelve functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Fresh Solutions
 * @since 2013
 */


//ADDED BY ANTHONY BAKER 3-20-2013

define("newline", "\n");

function _t($var){
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}

function theme_styles()  
{ 
  // Register the style like this for a theme:  
  // (First the unique name for the style (custom-style) then the src, 
  // then dependencies and ver no. and media type)
  wp_register_style( 'fonts-style', get_template_directory_uri() . '/MyFontsWebfontsKit.css', array(), null, 'all' );
  wp_register_style( 'site-style', get_template_directory_uri() . '/style.css', array(), 'v1', 'all' );

  wp_enqueue_style('fonts-style');
  wp_enqueue_style('site-style');

    //http://wordpress.stackexchange.com/questions/48581/enqueue-different-stylesheets-using-ie-conditionals
  if ( !is_admin() ) { 
    	$theme  = get_theme(get_current_theme());
    	wp_register_style( 'ie-style', get_template_directory_uri() . '/style_ie.css', false, $theme['Version'] );
    	$GLOBALS['wp_styles']->add_data( 'ie-style', 'conditional', 'lte IE 8' );
    	wp_enqueue_style( 'ie-style' );

    	//IE 7 styles
    	// wp_register_style( 'ie7-style', get_template_directory_uri() . '/style_ie7.css', false, $theme['Version'] );
    	// $GLOBALS['wp_styles']->add_data( 'ie7-style', 'conditional', 'lte IE 7' );
    	// wp_enqueue_style( 'ie7-style' );
	}
}

function load_fsn_scripts() {
	wp_enqueue_script('base_functions',get_template_directory_uri() . '/js/base_functions.js',array());
	wp_enqueue_script('modernizr',get_template_directory_uri() . '/js/modernizr-latest.js',array('jquery'));
	wp_enqueue_script('fresh_solutions',get_template_directory_uri() . '/js/fresh_solutions.js',array('jquery'));
}

function addmenu($category="",$bullet=true,$homebutton=false,$footer=false){
	
	$separator = "<em>" . (($bullet)?"&bull;":"|") . "</em>";
	//$current = single_cat_title('', false );
	$current = $category;

	$namespace = ($footer)?"f_":"";

	$homecategory = get_category(14);
	$categories = get_categories(array('orderby'=>'ID','hide_empty'=>0,'orderby'=>ID,'parent'=>'0','include'=>'2,3,4,5,6,7,8'));

	if(preg_match("/\w/",$current) && $homebutton){
		echo '<a href="/" id="' . $namespace . $homecategory->slug . '">'. $homecategory->name . '</a>' . newline;
		echo $separator . newline;
	}

	foreach($categories as $cat){
		echo (!preg_match("/about/",$cat->slug))?$separator:"";

		//checks if categorey has parent
		$parent = get_category(get_query_var('cat'));

		unset($selected);

		//if no parent
		if($parent->category_parent==0){
			//and current category variable matches this category id
			if(get_query_var('cat')==$cat->cat_ID){
				$selected = 'class="selected"';
			}
		}
		else{
			//has parent and parent matches this menu item catgeory id
			if($parent->category_parent==$cat->cat_ID){
				$selected = 'class="selected"';	
			}
		}
	

	 	echo '<a href="/category/' . $cat->slug . '" id="' . $namespace . $cat->slug . '" ' . $selected . '>' . $cat->name . '</a>' . newline;
	}
}


function getSocialMediaIcons(){
	//gets all uncategorized posts
	$posts = allposts(1);
	$social_links = array();

	foreach($posts->posts as $p){

		if(preg_match("/facebook/i",$p->post_title)){
			echo '<a href="' . $p->post_content . '" target= "_blank" class="butn_social_media facebook"><span>' . $p->post_title . '</span></a>' . newline;
		}

		if(preg_match("/linkedin/i",$p->post_title)){
			echo '<a href="' . $p->post_content . '" target= "_blank" class="butn_social_media linkedin"><span>' . $p->post_title . '</span></a>' . newline;
		}
	}
}

function returnAttachment($postid){

	$attachments = new Attachments('attachments',$postid);
	if($attachments->exist()){
		while($attachments->get()){ 
			$img->src = $attachments->src('full');
			$img->caption = $attachments->field('caption');
			break;
		}
	}
	return $img;
}

function returnPDFLink($postid){
	$attachments = new Attachments('attachments',$post->ID);
		if($attachments->exist()){
			while($attachments->get()){ 
				return $attachments->url();
			break;
		}
	}
}

function addSubMenu($catid){

	//checks if categorey has parent
	$parent = get_category($catid);

	//if no parent
	if($parent->category_parent==0){
		$getsubcategories = get_categories(array('parent'=>$catid,'orderby'=>'id','order'=>'ASC','hide_empty'=>0));
	}
	else{
		$getsubcategories = get_categories(array('parent'=>$parent->category_parent,'orderby'=>'id','order'=>'ASC','hide_empty'=>0));
	}

	if(sizeof($getsubcategories)>1){
	
		echo '<div id="submenu">' . newline;
		
		foreach($getsubcategories as $subcat) 
		{
			if(!preg_match("/hidemenu/i",$subcat->slug)){

				$selected = ($subcat->cat_ID==$catid)?'class="selected"':"";

				$subcat_link = get_category_link($subcat->cat_ID);
				echo '<a href="' . $subcat_link  . '" id="sub_' . $subcat->slug . '" ' . $selected .'>' . $subcat->name . '</a>' . newline;
			}
		}// end for each

		echo '</div>' . newline;
	}//end if
	else{
		echo '<div class="nosubmenu"></div>' . newline;
	}
}

function retrieveDefaultPost($catid){
	$posts = allposts($catid);
	$subcategories;

	if(sizeof($posts->posts)==0){
		$subcategories = get_categories(array('parent'=>$catid,'orderby'=>'id','order'=>'ASC'));

		foreach($subcategories as $sub){
			$test = allposts($sub->cat_ID);	

			if(sizeof($test->posts)>0){
				return $sub->cat_ID;
				break;
			}
		}// for each
	}
	else{
		return false;
	}

	// if(!$categoryposts->have_posts()) :
	//   while ($categoryposts->have_posts()) :
	  		
	//    endwhile;
	// endif;

}

function allposts($catid,$desc=false,$nolimit=-1,$page=1){
	$catID =  get_category($catid);

	if($desc){
		$order = "DESC";
	}
	else{
		$order = "ASC";
	}

	return new WP_Query(array('category_name'=>$catID->slug, 'category__in'=>$catid,'orderby'=>'date','order'=>$order,'posts_per_page'=>$nolimit,'paged'=>$page));
}

function backimg($imgsrc){
	return "background-image:url(" . rawurldecode($imgsrc) . ");";
}

function addHeaderGraphic(){

	//get all posts for header graphic
	$headerposts = allposts(25);

	foreach($headerposts->posts as $header){
		if(get_post_meta($header->ID, 'header-graphic', true)){
			$headerposts = $header;
			$headerposts->image = returnAttachment($headerposts->ID);
			break;
		}
	}

	echo '<div id="section-graphic" style="' .  ((isset($headerposts->image))?backimg($headerposts->image->src):"") . '"></div>';
}


function videolist($atts, $content = null){

	extract(shortcode_atts(array(
		'videos' => 'no videos',
		'title' => 'Please select one of our videos from the drop down below',
		'width' => '320',
		'height' => '240'
	), $atts));

	$tosplit = split(",", $videos);

	foreach($tosplit as $vid){
		$fsn_videos["videos"][] = split(":",$vid);
	}

	$inlinestylebox = 'style="width:' . $width  . 'px; height:'. $height . 'px;"';
	$inlinestyle = 'style="width:' . $width  . 'px;"';

	$output = '<div id="fsn-video-list" ' .  $inlinestyle . '><div id="fsn-video-area" ' .  $inlinestylebox . '></div>' . newline;

	$output .= '<h1>' . $title . '</h1>' . newline;
	$output .= '<select id="fsn-select-box" ' .  $inlinestyle . '>' . newline;

	$count=0;
	foreach($fsn_videos["videos"] as $video){
  		$output .= '<option value="' .  $video[1]  . '" ' . (($count==0)?"selected":"")  . '  ' .  $inlinestyle . '>' .  $video[0]  . '</option>' . newline;
  		$count++;
  	}

	$output .= '</select>' . newline;
  	$output .= '<script type="text/javascript">fsn_createVideoList(' . $width  . ','. $height . ');</script></div>' . newline;

	return $output;
} 


add_shortcode('fsn_video_list', 'videolist');
add_action('wp_enqueue_scripts', 'theme_styles');
add_action( 'wp_enqueue_scripts', 'load_fsn_scripts');
add_theme_support('custom-header');

