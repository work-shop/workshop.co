
	</div><!--/#content-->

	
	<?php if(!is_home()): get_template_part('signpost'); endif; ?>
	
	<?php if(is_page(8)): 
	
		 get_template_part('contact');
		 get_template_part('invitation');
	 
	 else:
	 
	 	get_template_part('invitation');	
	 	get_template_part('contact'); 
	 	
	 	endif; ?>	
  
</div><!-- /#state -->

<div id="foot" class="hidden">

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43897729-3', 'auto');
  ga('send', 'pageview');

</script>

</div>

<?php wp_footer(); ?>

</body>

</html>