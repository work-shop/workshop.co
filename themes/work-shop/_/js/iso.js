
$(window).load(function() {

	// init Isotope
	var $grid = $('.grid').isotope({
		itemSelector: '.element',
		layoutMode: 'fitRows',
		percentPosition: true,		
	});

	// bind filter button click
	$('.filters').on( 'click', 'button', function() {
		var filterValue = $( this ).attr('data-filter');
		$grid.isotope({ filter: filterValue });
	});

	// change is-checked class on buttons
	$('.button-group').each( function( i, buttonGroup ) {
		var $buttonGroup = $( buttonGroup );
		$buttonGroup.on( 'click', 'button', function() {
			$buttonGroup.find('.is-checked').removeClass('is-checked');
			$( this ).addClass('is-checked');
		});
	});

});
