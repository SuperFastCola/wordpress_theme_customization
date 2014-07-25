<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

if(!isset($_SESSION["device"])){
	require_once 'Mobile_Detect.php';
	$detect = new Mobile_Detect;
	$_SESSION["device"] = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'desktop');
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>  class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<?php

switch($_SESSION["device"]){
	case 'phone':
		$mobile = true;
		echo '<meta name="viewport" content="width=1010, user-scalable=yes, initial-scale=0.30" />' . newline;
	break;	
	case 'tablet':
		$mobile = true;
		echo '<meta name="viewport" content="width=1010, user-scalable=yes" />' .newline;
	break;
}

?>

<title><?=bloginfo('name')?></title>

<script type="text/javascript">
	var devicetype ="<?=$_SESSION["device"]?>";
	var ismobile = <?=(($mobile)?"true":"false")?>;
</script>
<!--
/* @license
 * MyFonts Webfont Build ID 2510114, 2013-03-20T14:54:41-0400
 * 
 * The fonts listed in this notice are subject to the End User License
 * Agreement(s) entered into by the website owner. All other parties are 
 * explicitly restricted from using the Licensed Webfonts(s).
 * 
 * You may obtain a valid license at the URLs below.
 * 
 * Webfont: Century Gothic Std Italic by Monotype Imaging
 * URL: http://www.myfonts.com/fonts/mti/century-gothic/std-italic/
 * 
 * Webfont: Century Gothic Std Bold Italic by Monotype Imaging
 * URL: http://www.myfonts.com/fonts/mti/century-gothic/std-bold-italic/
 * 
 * Webfont: Century Gothic Std Bold by Monotype Imaging
 * URL: http://www.myfonts.com/fonts/mti/century-gothic/std-bold/
 * 
 * Webfont: Century Gothic Std Regular by Monotype Imaging
 * URL: http://www.myfonts.com/fonts/mti/century-gothic/std-regular/
 * 
 * 
 * License: http://www.myfonts.com/viewlicense?type=web&buildid=2510114
 * Webfonts copyright: Copyright The Monotype Corporation. All rights reserved.
 * 
 * © 2013 MyFonts Inc
*/
-->
<?php

 	wp_head();	
?>

<?php
if($mobile){
?>
	<style type="text/css">
	* {-webkit-text-size-adjust: none}
	</style>
<?php
}
?>
</head>

<body>
	<a id="top"></a>
	<div id='test'></div>
	<div id="container">

	<div id="header">
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header-image" style="border:none;"><img src="<?php echo esc_url( $header_image ); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" style="border:none;"></a>
		<?php endif; ?>

		<?php
			//in functions.php
			addmenu(single_cat_title('',false),true);

			getSocialMediaIcons();
		?>	
	</div>
	<div class="breaker"></div>
	<div id="content">
