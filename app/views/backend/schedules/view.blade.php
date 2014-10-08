@extends('backend.layouts.master')

@section('content')
	<div class="container">
		<table class="table-calendar noselect" style="background-color: white;">
			<thead>
				<tr>
					<th>Pon</th>
					<th>Tor</th>
					<th>Sre</th>
					<th>Čet</th>
					<th>Pet</th>
					<th>Sob</th>
					<th>Ned</th>
				</tr>
			</thead>
			<tbody>
				@foreach($calendar as $key=>$val)
					<tr>
					@foreach($val as $day)
						@if($day == 0)
							<td><div></div></td>
						@else
							<td><div>{{ $day['mday'] }}</div></td>
						@endif
					@endforeach
					</tr>
				@endforeach
			</tbody>
		</table>

		<!-- MODAL -->
		<div class="modal fade" id="schedule-modal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">Zapolni urnik</h4>
					</div>
					<div class="modal-body">
						<p><strong>Izberi frizerje</strong></p>
						<button type="button" class="btn btn-default btn-sm" data-toggle="button">Klemen Brajkovič</button>
						<button type="button" class="btn btn-default btn-sm" data-toggle="button">Tomaž Silič</button>
						<button type="button" class="btn btn-default btn-sm" data-toggle="button">Eva Kaštrun</button>
						<button type="button" class="btn btn-default btn-sm" data-toggle="button">Jordana Suljanovič</button>

						<br><br>
						<p><strong>Izberi izmeno</strong></p>
						<button type="button" class="btn btn-default btn-sm" data-toggle="button">Dopoldan</button>
						<button type="button" class="btn btn-default btn-sm" data-toggle="button">Popoldan</button>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

	</div>

	<script>
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
	</script>
@stop