
<section id="project-website-slideshow" class="block bg-light padded-less">
	<div class="container">
		<div class="flexslider-website-wrapper">
			<div class="flexslider flexslider-website">
				<ul class="slides clearfix">
					<?php $website_slideshow = get_field('website_slideshow'); ?>
					<?php foreach( $website_slideshow as $image ): ?>
						<li class="website-slide">
							<img src="<?php bloginfo('template_directory'); ?>/_/img/browser.png" / class="website-browser">
							<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="website-slide-image"/>
							<!-- <p><?php echo $image['caption']; ?></p> -->
						</li>
					<?php endforeach; ?>
				</ul>
				<div id="previous-website-slideshow" class="flexslider-direction previous flex-previous">
					<span class="icon" data-icon="&#8216;"></span>
				</div>
				<div id="next-website-slideshow" class="flexslider-direction next flex-next">
					<span class="icon" data-icon="&#8212;"></span>
				</div>
			</div>
		</div>
	</div>
</section>