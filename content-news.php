<?php

	addHeaderGraphic();

	$page = (get_query_var('paged')) ? get_query_var('paged') : 1;

	if(retrieveDefaultPost(get_query_var('cat'))){
		//default category id
		$did = retrieveDefaultPost(get_query_var('cat'));
		$categoryposts = allposts($did,true,null,$page);
		addSubMenu($did);
	}
	else{
		$categoryposts = allposts(get_query_var('cat'),true,null,$page);
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
	<div id="section-news-gradient"><!-- section-news-gradient -->
	<?php

	if($categoryposts->have_posts()) :
	  while ($categoryposts->have_posts()) :
	  	echo $categoryposts->the_post();

	  		if(!get_post_meta($post->ID, 'landing-headline', true)){

	  			echo '<a name="' . $post->post_name .'"></a>' . newline;

		  		echo '<div id="post-' . $post->ID . '" class="post_news">' . newline;

		  		//the_date('F j, Y', '<div class="fsn_post_date">', "</div>");

		  		$pdflink = returnPDFLink($post->ID);

				if($pdflink){
					$readmore = '<a href="' . $pdflink   . '" class="butn" target="new">Read More</a>' . newline;
				}
				else{
					$readmore = "";
				}

				echo '<div class="fsn_post_content">' .newline;
					//to use short codes with the post body "the_content()" function must be called within the loop
					//$image = the_content(); 
					$posttitle = '<h1 class="fsn_post_title">' . $post->post_title . '</h1>' . newline;
					$postdate = the_date('F j, Y', '<div class="fsn_post_date">', "</div>", false);

					if(preg_match("/<img/i",$post->post_content)){
						$replacedContent = $post->post_content;
						$replacedContent = preg_replace("/(<img.*\/>)+?/i","<div class='news-image'>$1<div class='breaker'></div></div>$postdate$posttitle",$replacedContent);
						echo $replacedContent;

						echo '<div class="butn_news_img">' . $readmore . '</div>' . newline;
					}
					else{
						echo $postdate . newline;
						echo $posttitle;
						the_content();	
						echo $readmore;
					}


			
				echo '<div class="breaker"></div>' . newline;
				

				echo '</div>' . newline;
				echo '</div>' . newline;
			}


	   endwhile;

	echo '<div id="page-nav">' . newline;
	
		echo '<div id="newer_pages">' . newline;
			previous_posts_link("<< Newer");
		echo '</div>' . newline;

		echo '<div id="older_pages">' . newline;
			next_posts_link("Older >>");
		echo '</div>' . newline;


	echo '</div>' . newline;

	endif;


?>
	</div> <!-- end section-news-gradient -->
	</div><!-- end section content -->

<?php
	get_template_part('content', 'bumpertop');
?>
