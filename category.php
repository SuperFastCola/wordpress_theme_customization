<?php
/**
 * The template for displaying Category pages.
 *
 * Used to display archive-type pages for posts in a category.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
		
		<div id="post_container">

		<?php

			$triage = get_category(get_query_var('cat'));
	
			//about us section
			if(preg_match("/network-partners/i",$triage->slug)){
				get_template_part('content', 'network');
			}
			else if(preg_match("/news|blog/i",$triage->slug)){
				get_template_part('content', 'news');	
			}
			else{
				get_template_part('content', 'about');	
			}
			

		?>
		</div><!-- end post container -->


<?php get_footer(); ?>