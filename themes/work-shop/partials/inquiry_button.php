
	<?php if(get_field('show_inquiry_button')): ?>
		<section class="block bg-light padded" id="inquiry">
			<div class="container">
				<div class="row mb4">
					<div class="col-sm-5 col-sm-offset-7 col-md-4 col-xs-10 col-xs-offset-1">
						<div class="inquiry-button">
							<a href="#contact" data-toggle="modal" data-target="#contactModal" class="">
							<h4 class="white">Contact Us</h4>							
							<h3 class="white">
								<?php if(get_field('inquiry_custom_text')): ?>
									<?php the_field('inquiry_custom_text'); ?>
								<?php else: ?>
									Are you interested in commissioning a project like this? Send us a quick note and we'll discuss it with you.	
								<?php endif; ?>
							</h3>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php else: ?>
		<section class="block bg-light padded-less">
			<div id="project-dash" class="dash static"></div>
		</section>
	<?php endif; ?>
