<?php

	addHeaderGraphic();
	
	if(retrieveDefaultPost(get_query_var('cat'))){
		//default category id
		$did = retrieveDefaultPost(get_query_var('cat'));
		$categoryposts = allposts($did);
		addSubMenu($did);
	}
	else{
		$categoryposts = allposts(get_query_var('cat'));
		addSubMenu(get_query_var('cat'));
	}


	echo newline;

	//gets landing informations
	if($categoryposts->have_posts()) :
	  while ($categoryposts->have_posts()) :
	  	echo $categoryposts->the_post();

	  		if(get_post_meta($post->ID, 'landing-headline', true)){
	  			$haslanding = true;
	  			$subtitle = preg_match("/\w{10,}/i",$post->post_content);
	  			echo '<div id="section-graphic-title"><h1 ' . (($subtitle)?'class="withsubtitle"':'') .  '>'  . $post->post_title . newline;

	  			if($subtitle){
					echo '<span>'  . newline;
					//to use short codes with the post body "the_content()" function must be called within the loop
						the_content();
					echo '</span>'  . newline;
				}

				echo '</h1>' . newline;
				echo '</div>'  . newline;
	  		}

	   endwhile;
	endif;
	
	?>
	
	<div id="section-content"><!-- start section content -->

	<?php

	if($categoryposts->have_posts()) :
	  while ($categoryposts->have_posts()) :
	  	echo $categoryposts->the_post();

	  		if(!get_post_meta($post->ID, 'landing-headline', true)){
		  		$expanded = get_post_meta($post->ID, 'expanded', true);

		  		if($expanded){
		  			$postclass = "post_regular";
		  		}
		  		else{
		  			$postclass = "post_expanding";
		  		}

		  		// if(!$haslanding && $categoryposts->current_post==0){
		  		// 	$postclass .= " nolanding";
		  		// }

		  		echo '<div id="' . $post->post_name . '" class="' .  $postclass . '">' . newline;

		  		if($expanded){
		  			echo '<h1 class="fsn_post_title">' . $post->post_title . '</h1>' . newline;
		  		}
		  		else{	
					echo '<h1 class="fsn_post_title"><em></em>' . $post->post_title  . '</h1>' . newline;
				}

				echo '<div class="fsn_post_content">' .newline;
					//to use short codes with the post body "the_content()" function must be called within the loop
					the_content(); 

				echo '<div class="breaker"></div>' . newline;
				
	

				echo '</div>' . newline;
				echo '</div>' . newline;
			}

			

	   endwhile;
	endif;
?>
	</div><!-- end section content -->

<?php
	get_template_part('content', 'bumpertop');
?>
