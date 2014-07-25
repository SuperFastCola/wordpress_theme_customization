<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- content -->

	<?php
		$footerinfo = new WP_Query(array('category_name'=>'footer','orderby'=>'date','order'=>'DESC','posts_per_page'=>1));
		$logos = new WP_Query(array('category_name'=>'network-logos','orderby'=>'date','order' => 'DESC','posts_per_page'=>1));
		$logos->image = returnAttachment($logos->post->ID);
	?>
	<div id="home_logos" style="background-image:url(<?=$logos->image->src?>);"></div>
	
	<div id="footer">
		<?php

			// newline is defined in functions.php
			echo '<div id="footer_menu">' . newline;
			addmenu(single_cat_title('',false),false,true,true);
			echo '</div>' . newline;

			$footerinfo = new WP_Query(array('category_name'=>'footer','orderby'=>'date','order'=>'DESC','posts_per_page'=>1));
			echo '<div id="copyright">' . $footerinfo->post->post_content . "</div>" . newline;

		?>
	</div>

	<?php
		wp_footer();
	?>

	</div><!-- container -->

</body>
</html>