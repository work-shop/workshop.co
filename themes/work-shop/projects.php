	
<section id="projects-grid" class="block">
	<div class="container">
		<div class="row grid" id="grid">

			<?php

			if( is_tax() ){
				$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
				$tax_query = array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'project_categories',
						'field' => 'slug',
						'terms' => $term->slug
						),
					array(
						'taxonomy' => 'project_categories',
						'field' => 'slug',
						'terms' => array( 'excluded' ),
						'operator' => 'NOT IN'
						)
					);
			} else{
				$tax_query = array(
					array(
						'taxonomy' => 'project_categories',
						'field' => 'slug',
						'terms' => array( 'excluded' ),
						'operator' => 'NOT IN'
						)
					);
			}

			$q = new WP_Query(
				array(
					'post_type' => 'projects',
					'posts_per_page' => -1, 	
					'tax_query' => $tax_query
					)
				);

			$i = 0;
			while ( $q->have_posts() ) : $q->the_post();

				// requesting all of the post's relevant values
				$title = get_the_title(); // title text
				$perma = get_permalink();
				?>

				<article class="project project-tile element <?php echo ws_derive_project_type($post); ?> <?php //echo ws_derive_scope_string( get_field('project_scope_tags') ); ?>">

					<a href="<?php the_permalink(); ?>">

						<div class="project-tile-image">
							<?php if(has_post_thumbnail()): the_post_thumbnail('project'); else: echo '<img src="' . get_bloginfo('template_directory') . '/_/img/default.png" alt="default image" />'; endif; ?>					
						</div>

						<div class="project-tile-info">

							<h3 class="centered"><?php echo ws_ifdef_show( $title ); ?></h3>
							<h5 class="centered hidden-xs"><?php
								echo ws_split_array_by_key( 
									get_field('project_scope_tags'), ', ',
									function( $cb_tag ) {
										return $cb_tag['scope_tag']->name;
									}); ?>
								</h5>
							</div>
						</a>

					</article>

					<?php $i++; endwhile; ?>

				</div>

			</div>

			<div id="projects-dash" class="dash static"></div>

		</section>
