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
						<div class="panel-group" id="accordion">
							@foreach($users as $user)
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse-{{ $user->id }}" style="font-size: 14px;">
												{{ $user->name." ".$user->lastname }}
											</a>
										</h4>
									</div>
									<div id="collapse-{{ $user->id }}" class="panel-collapse collapse">
										<div class="panel-body">
											@foreach($shifts as $shift)
												<h4>{{ $shift->name }}</h4>
												<div style="float: left;">{{ date('H:i', $shift->from) }}</div>
												<div style="float: right;">{{ date('H:i', $shift->to) }}</div>
												<div class="selected-range" style="float: right; margin-right: 42%;"></div>
												<input id="ex2" type="text" class="span2 my-slider" value="" data-slider-min="{{ $shift->from }}" data-slider-max="{{ $shift->to }}" data-slider-step="900" data-slider-value="[{{ $shift->from }},{{ $shift->to }}]"/>
											@endforeach
											<p></p>
										</div>
									</div>
								</div>
							@endforeach
						</div>
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
		$(".my-slider").slider({
			formatter: function(value) {
				if(value.length != undefined)
				{
					console.log($(this).parent());
					var from = [Math.floor(value[0] / 60 / 60).toString(), (((value[0] / 60 / 60) - Math.floor(value[0] / 60 / 60)) * 60).toString()];
					var to = [Math.floor(value[1] / 60 / 60).toString(), (((value[1] / 60 / 60) - Math.floor(value[1] / 60 / 60)) * 60).toString()];

					if(from[0].length == 1) from[0] = "0" + from[0];
					if(from[1].length == 1) from[1] = "0" + from[1];
					if(to[0].length == 1) to[0] = "0" + to[0];
					if(to[1].length == 1) to[1] = "0" + to[1];

					return from[0] + ':' + from[1] + ' - ' + to[0] + ':' + to[1];
				}
			}
		});

		$(".tooltip-main .tooltip-inner").bind("DOMSubtreeModified", function() {
			//console.log($(this).parent().find('input').slider('getValue'));

			var values = $(this).html().trim().split(":");
			var from = [Math.floor(values[0] / 60 / 60), ((values[0] / 60 / 60) - Math.floor(values[0] / 60 / 60)) * 60];
			var to = [Math.floor(values[1] / 60 / 60), ((values[1] / 60 / 60) - Math.floor(values[1] / 60 / 60)) * 60];
			//console.log(from[0].toString() + ':' + from[1].toString());
			//$(this).html(from[0].toString() + ':' + from[1].toString() + ' - ' + to[0].toString() + ':' + to[1].toString());
		});

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
			if(event.which == 1) {
				isSelecting = true;
				startIndex = $('.table-calendar div').index($(this));
			}
		});
		$('.table-calendar div').mouseup(function(event) {
			if(event.which == 1) {
				endIndex = $('.table-calendar div').index($(this));

				if(isSelecting)
					makeSelection(startIndex, endIndex, '.table-calendar div');

				isSelecting = false;
				$('#schedule-modal').modal();
			}
		});
		$('.table-calendar div').mouseenter(function() {
			endIndex = $('.table-calendar div').index($(this));

			if(isSelecting)
				makeSelection(startIndex, endIndex, '.table-calendar div');
		})

		// Deselect everything if clicked outside of the table
		$(document).mouseup(function(e) {
			if(event.which == 1) {
				var element = $('.table-calendar');

				if(!element.is(e.target) && element.has(e.target).length === 0) {
					$('.table-calendar div').each(function(index, element) {
						$(element).removeClass('selected');
					});
					isSelecting = false;
				}
			}
		});
	</script>
@stop