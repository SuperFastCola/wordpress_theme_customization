<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
 get_header(); 
 ?>
 		<script type="text/javascript">
			<?php
			//used for the showcase items
			$hero_query = new WP_Query(array('category_name'=>'heros','orderby' =>'date','order' => 'ASC','posts_per_page'=>-1));
			foreach($hero_query->posts as $hero){
				$hero->image = returnAttachment($hero->ID);
				$herolink = get_post_meta($hero->ID, 'post-link', true);
				$hero_windows[] = array($hero,$herolink);
			}// end foreach
			echo 'var hero_window_backgrounds = new Array();' . newline;
			for($g=0;$g<sizeof($hero_windows);$g++){
				echo 'hero_window_backgrounds.push("' . $hero_windows[$g][0]->image->src . '");' . newline;
			}
			?>
 		</script>


		<div id="heroarea">
			<?php

				//used to name files
				$i = 1;
				foreach($hero_windows as $hero){
					//$backgroundImage = "background-image:url(" . $hero[0]->image->src  . ");";
					$backgroundImage = "";
					$heroCaption = $hero[0]->image->caption;
					echo '<a ' . ((preg_match("/\w/",$hero[1]))?'href="' . $hero[1]  . '"':'') .  ' class="herowindow" id="herowindow' . $i .  '"><span>' . $heroCaption  . '</span></a>' . newline;
					$i++;
				}// end foreach
				$heroNavWidth = 22;
				echo '<div id="heronav" style="width:' . ($i*$heroNavWidth) . 'px; margin-left:-' . (($i*$heroNavWidth) + $heroNavWidth) . 'px;">' .newline;
				$g=1;
				while($g<$i){
					echo '<a id="heronav_butn' .  $g  . '" ' . (($g==1)?'class="selected"':"") . '></a>' .newline;
					$g++;
				}
				echo '<a id="heronav_next"></a>' .newline;
				echo '</div>' . newline;
			?>
		</div>

		<?php
			//returnAttachment in functions.php
			$solutions = new WP_Query(array('category_name'=>'featured-solutions','orderby'=>'date','order' => 'DESC','posts_per_page'=>1));
			$solutions = $solutions->post;
			$solutions->image = returnAttachment($solutions->ID);
			
			$products = new WP_Query(array('category_name'=>'featured-products','orderby'=>'date','order' => 'DESC','posts_per_page'=>1));
			$products = $products->post;
			$products->image = returnAttachment($products->ID);
			
			$spotlight = new WP_Query(array('category_name'=>'featured-spotlight','orderby'=>'date','order' => 'DESC','posts_per_page'=>1));
			$spotlight = $spotlight->post;
			$spotlight->image = returnAttachment($spotlight->ID);
			
			function outputContent($obj){
				$link = get_post_meta($obj->ID, 'post-link', true);
				echo '<h1>' . $obj->post_title .'</h1>';
				
				if(isset($link)){
					echo '<p><a href="'  .  $link  .  '">' . $obj->post_content . '</a></p>';
				}
				else{
					echo '<p>' . $obj->post_content . '</p>';
				}
			}
		?>
		<div id="showcasearea">
			<div id="showcase_solutions" <?=((isset($solutions->image))?'style="background-image:url(' . $solutions->image->src . ');"':'class="gradback"')?>>
				<?php
					outputContent($solutions);
				?>
			</div>
			<div id="showcase_products" <?=((isset($products->image))?'style="background-image:url(' . $products->image->src . ');"':'class="gradback"')?>>
				<?php
					outputContent($products);
				?>
			</div>
			<div id="showcase_spotlight" <?=((isset($spotlight->image))?'style="background-image:url(' . $spotlight->image->src . ');"':'class="gradback"')?>>
				<?php
					outputContent($spotlight);
				?>
			</div>
		</div>

<?php get_footer(); ?>