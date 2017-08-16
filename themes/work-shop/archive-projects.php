<?php get_header();?>

<div id="projects" class="template projects">

	<section id="projects-introduction" class="project-introduction introduction block padded bg-white">	
		<div class="blurby">
			<div class="container">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<h2 class="centered">
							<?php 
							if( get_field('projects_page_blurby','options') ): 
								the_field('projects_page_blurby','options'); 
							else: ?>
							We create meaningful experiences across physical and digital media
						<?php endif; ?>
					</h2>
				</div>
			</div>
		</div>

		<div id="projects-dash" class="dash static hidden"></div>

	</section>

	<?php if ( ! is_tax() ): get_template_part('/partials/filters_type'); endif; ?>	
	<?php get_template_part('projects'); ?>

</div>

<?php get_footer(); ?>