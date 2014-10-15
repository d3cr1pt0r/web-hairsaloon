@extends('backend::layouts.master')

@section('content')
	<div class="container">
		<table class="table-calendar noselect" style="background-color: white; margin-top: 20px;">
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
							<td>
								<div class="calendar-day-content" data-day="{{ $day['mday'] }}" data-month="{{ $day['mon'] }}" data-year="{{ $day['year'] }}" data-unix="{{ $day[0] }}">
									<div style="position: relative;">{{ $day['mday'] }}</div>
									@if(isset($day['data']))
										@foreach($day['data'] as $data)
											<div style="position: relative; background-color: {{ $data['color'] }}; color: black; width: {{ $data['total'] }}%; height: 7px; font-size: 12px; line-height: 15px; border: 1px solid #585858; border-radius: 3px; margin-bottom: 2px;"></div>
										@endforeach
									@endif
								</div>
							</td>
						@endif
					@endforeach
					</tr>
				@endforeach
			</tbody>
		</table>

		<div class="form-group" style="width: 700px; margin: auto; margin-top: 10px; margin-bottom: 20px;">
			<label for="exampleInputEmail1">Izberi uporabnika</label>
			<select class="form-control" name="user">
				@foreach($users as $user)
					<option value="{{ $user->id }}">{{ $user->name." ".$user->lastname }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group" style="width: 700px; margin: auto;">
			<label for="exampleInputEmail1">Izmene</label>
			@foreach($shifts as $shift)
				<span style="display: block; text-indent: 25px; width: 20px; height: 20px; background-color: {{ $shift->color }}; border: 1px solid #585858; border-radius: 3px; margin-top: 5px; margin-bottom: 7px;">
					<b>{{ $shift->name }}</b>
				</span>
			@endforeach
		</div>

		<!-- MODAL -->
		<div class="modal fade" id="schedule-modal">
			<div class="modal-dialog">
				<div class="modal-content">
					{{ Form::open(array('url' => 'admin/'.$controller.'/save', 'method' => 'post', 'id' => 'myForm')) }}
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
													<button type="button" class="btn btn-primary slider-dropdown" style="margin-top: 6px; margin-bottom: 6px; display: block;" data-toggle="button">{{ $shift->name }}</button>
													<div class="slider-container well" style="display: none;">
														<div style="float: left;">{{ date('H:i', $shift->from) }}</div>
														<div style="float: right;">{{ date('H:i', $shift->to) }}</div>
														<div class="selected-range" style="float: right; margin-right: 42%;"></div>
														<input id="ex2" type="text" name="slider[]" class="span2 my-slider" value="" data-slider-min="{{ $shift->from }}" data-slider-max="{{ $shift->to }}" data-slider-step="900" data-slider-value="[{{ $shift->from }},{{ $shift->to }}]"/>
														<input type="hidden" name="user-id[]" value="{{ $user->id }}"/>
														<input type="hidden" name="shift-id[]" value="{{ $shift->id }}"/>
														<input type="hidden" name="shift-active[]" value="0"/>
													</div>
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
							<button type="submit" class="btn btn-primary">Save changes</button>
						</div>
						<input type="hidden" name="day-from"/>
						<input type="hidden" name="day-to"/>
					{{ Form::close() }}
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

	</div>

	<script>
		$(".slider-dropdown").click(function() {
			$(this).next().slideToggle();

			var element = $(this).next().find('[name="shift-active[]"]');
			if($(element).val() == "0") $(element).val("1");
			else $(element).val("0");
		});

		$(".my-slider").slider({
			formatter: function(value) {
				if(value.length != undefined)
				{
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

		$("#myForm").submit(function() {
			$(".my-slider").each(function(i,e) {
				var val = $(this).slider('getValue');
				$(this).attr('value', val[0].toString() + ":" + val[1].toString());
			});
			return true;
		});

		var isSelecting = false;
		var startIndex;
		var endIndex;

		function makeSelection(start, end, element) {
			var selectedElements = [];

			$(element).each(function(index, element) {
				if(index >= startIndex && index <= endIndex) {
					$(element).addClass('selected');
					selectedElements.push($(element));
				}
				else {
					$(element).removeClass('selected');
				}
			});

			return selectedElements;
		}

		$('.table-calendar div').mousedown(function() {
			if(event.which == 1) {
				isSelecting = true;
				startIndex = $('.table-calendar div').index($(this));
			}
		});
		$('.table-calendar div').mouseup(function(event) {
			if(event.which == 1) {
				var selectedElements;
				endIndex = $('.table-calendar div').index($(this));

				if(isSelecting)
					selectedElements = makeSelection(startIndex, endIndex, '.table-calendar div');

				isSelecting = false;

				$("[name='day-from']").attr('value', selectedElements[startIndex - startIndex].attr('data-unix'));
				$("[name='day-to']").attr('value', selectedElements[endIndex - startIndex].attr('data-unix'));

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