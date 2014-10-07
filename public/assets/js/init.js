$(document).ready(function() {
	$(".table").tablesorter();

	// Execute only if on schedules page
	if(document.URL.indexOf('schedules') != -1)
	{
		var isSelecting = false;
		var startIndex;
		var endIndex;

		function makeSelection(start, end, element) {
			$(element).each(function(index, element) {
				if(index >= startIndex && index <= endIndex) {
					$(element).addClass('selected');
				}
				else {
					$(element).removeClass('selected');
				}
			});
		}

		$('.table-calendar div').mousedown(function() {
			isSelecting = true;
			startIndex = $('.table-calendar div').index($(this));
		});
		$('.table-calendar div').mouseup(function() {
			endIndex = $('.table-calendar div').index($(this));

			if(isSelecting)
				makeSelection(startIndex, endIndex, '.table-calendar div');

			isSelecting = false;
			$('#schedule-modal').modal();
		});
		$('.table-calendar div').mouseenter(function() {
			endIndex = $('.table-calendar div').index($(this));

			if(isSelecting)
				makeSelection(startIndex, endIndex, '.table-calendar div');
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