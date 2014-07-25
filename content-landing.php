<?php

echo newline;

	//gets landing informations
	if($categoryposts->have_posts()) :
	  while ($categoryposts->have_posts()) :
	  	echo $categoryposts->the_post();

	  		if(get_post_meta($post->ID, 'landing-headline', true)){
	  			$haslanding = true;
	  			$subtitle = preg_match("/\w/i",$post->post_content);

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