$(document).ready(function() {
	$(".table").tablesorter();

	// Execute only if on schedules page
	if(document.URL.indexOf('schedules') != -1)
	{
		var isSelecting = false;
		var startIndex;
		var endIndex;

		$('.table-calendar div').mousedown(function() {
			isSelecting = true;
			// Get selected div index
			startIndex = $('.table-calendar div').index($(this));
		});
		$('.table-calendar div').mouseup(function() {
			// Get selected div index
			endIndex = $('.table-calendar div').index($(this));

			// Mark all elements that match the index range as selected
			if(isSelecting) {
				$('.table-calendar div').each(function(index, element) {
					if(index >= startIndex && index <= endIndex) {
						$(element).addClass('selected');
						console.log(index);
					}
					else {
						$(element).removeClass('selected');
					}
				});
			}

			isSelecting = false;
		});
		$('.table-calendar div').mouseenter(function() {
			// Get selected div index
			endIndex = $('.table-calendar div').index($(this));

			// Mark all elements that match the index range as selected
			if(isSelecting) {
				$('.table-calendar div').each(function(index, element) {
					if(index >= startIndex && index <= endIndex) {
						$(element).addClass('selected');
						console.log(index);
					}
					else {
						$(element).removeClass('selected');
					}
				});
			}
		})

		// Deselect everything if clicked outside of the table
		$(document).mouseup(function(e) {
			var element = $('.table-calendar');

			if(!element.is(e.target) && element.has(e.target).length === 0) {
				$('.table-calendar div').each(function(index, element) {
					$(element).removeClass('selected');
				});
			}
		});
	}
});