<?php

	addHeaderGraphic();
	
	$categoryposts = allposts(get_query_var('cat'));
	addSubMenu(get_query_var('cat'));

	echo newline;

	//gets landing informations
	if($categoryposts->have_posts()) :
	  while ($categoryposts->have_posts()) :
	  	echo $categoryposts->the_post();

	  		if(get_post_meta($post->ID, 'landing-headline', true)){

	  			echo '<div id="post-' . $post->ID . '" class="post-network-partners-map">' . newline;
				echo '<div class="fsn_post_content">' .newline;
					//to use short codes with the post body "the_content()" function must be called within the loop
					the_content();
				echo '<div class="breaker"></div>' . newline;
				echo '</div>' . newline;
				echo '</div>' . newline . newline;

				//retrieve map zoom image
				$zoomimage = returnAttachment($post->ID);

				echo '<script type="text/javascript" >' . newline;
				echo 'var mapzoom = "' . $zoomimage->src . '";' . newline;
				echo '</script>' . newline;

				$mapcoords = get_post_meta($post->ID, 'map-coordinates', true);

				if(isset($mapcoords)){
					echo $mapcoords;
				}
	  		}

	   endwhile;
	endif;
	
	?>
	
	<div id="section-content"><!-- start section content -->

	<?php

	$count = 0;
	$totalposts = sizeof($categoryposts->posts);

	if($categoryposts->have_posts()) :
	  while ($categoryposts->have_posts()) :
	  	echo $categoryposts->the_post();

	  		if(!get_post_meta($post->ID, 'landing-headline', true)){

	  			echo '<a id="' . substr($post->post_name,0,3) .'"></a>' . newline;

		  		echo '<div id="post-' . $post->ID . '" class="post_regular open">' . newline;


				echo '<div class="fsn_post_content">' .newline;
					//to use short codes with the post body "the_content()" function must be called within the loop

					$partnerlogo = returnAttachment($post->ID);

					if(isset($partnerlogo)){
						$partnerbackgrnd = 'background-image: url(' . $partnerlogo->src  .  ');';
						echo '<div class="network-partners-column1" style="' . $partnerbackgrnd  . '"></div>' . newline;					
						echo '<div class="network-partners-column2">' . newline;

					}

					echo '<h2>' . $post->post_title . '</h2>' . newline;
					the_content(); 

					if(isset($partnerlogo)){
						echo '</div>' . newline;
					}


				echo '<div class="breaker"></div>' . newline;

	//			$count++;

	//			if($count>2){
	//				if($count % 2 || $count==$totalposts-1){
						get_template_part('content', 'topbutn');
	//				}
	//			}

				echo '</div>' . newline;
				echo '</div>' . newline;
			}	      
	   endwhile;
	endif;


?>
	</div><!-- end section content -->

<?php
	get_template_part('content', 'bumper');
?>
