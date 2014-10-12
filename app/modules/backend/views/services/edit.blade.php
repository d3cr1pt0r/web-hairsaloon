@extends('backend::layouts.master')

@section('content')
	<div class="container">
		@if(isset($service))
		{{ Form::open(array('url' => 'admin/'.$controller.'/update', 'method' => 'post')) }}
		@else
		{{ Form::open(array('url' => 'admin/'.$controller.'/save', 'method' => 'post')) }}
		@endif
			<div class="panel panel-default">
				<div class="panel-heading">Dodaj storitev</div>
				<div class="panel-body">
					<div class="form-group">
						<label for="exampleInputEmail1">Ime storitve</label>
						<input type="text" class="form-control" name="name" placeholder="Vnesi ime storitve" value="{{ $service->name or '' }}">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Cena storitve</label>
						<input type="text" class="form-control" name="price" placeholder="Vnesi ceno storitve" value="{{ $service->price or '' }}">
					</div>
					<div class="form-group intervals">
						<label for="exampleInputEmail1">Trajanje storitve</label> <br />
						@foreach($time_periods as $time_period)
							<input type="hidden" name="interval-id[]" value="{{ $time_period->id }}" />
							<div class="col-md-4">
								<input type="text" class="form-control" name="desc[]" placeholder="Vnesi opis intervala" value="{{ $time_period->desc or '' }}">
							</div>
							<div class="col-md-4">
								<input type="time" class="form-control" name="time[]" placeholder="Vnesi trajanje storitve" value="{{ date('H:i',  $time_period->time) }}">
							</div>
							<div class="col-md-4">
								<input class="true" type="checkbox" name="active_time[]" value="1" {{ ($time_period->active_time==1 ? 'checked':'') }}>
								<input class="false" style="display: none;" type="checkbox" name="active_time[]" value="0" {{ ($time_period->active_time==0 ? 'checked':'') }}>
								Frizer zaseden
							</div><br /><br />
						@endforeach
					</div>
					@if(isset($service))
					<input type="hidden" name="id" value="{{ $service->id }}" />
					@endif
					<button type="submit" class="btn btn-success">Shrani</button> <button type="button" class="btn btn-default addInterval">+ Dodaj interval</button>
				</div>
			</div>
		{{ Form::close() }}
	</div>
	<script>
		$(document).ready(function () {
			$(document).on("click", ".addInterval", function() {
				$(".intervals").append('<div class="col-md-4"> \
											<input type="text" class="form-control" name="desc[]" placeholder="Vnesi opis intervala" value=""> \
										</div> \
										<div class="col-md-4"> \
											<input type="time" class="form-control" name="time[]" placeholder="Vnesi trajanje intervala" value=""> \
										</div> \
										<div class="col-md-4"> \
											<input class="true"  type="checkbox" name="active_time[]" value="1"> \
											<input class="false" style="display: none;"  type="checkbox" name="active_time[]" value="0" checked="checked"> \
											Frizer zaseden \
										</div><br /><br />');
			});

			$(document).on("click", ".true", function() {
				var falceCheckbox = $(this).next();
				var currentVal = $(this).attr("checked");
				console.log(currentVal);
				if(currentVal == 'checked') {
					$(this).removeAttr("checked");
					falceCheckbox.attr("checked", "checked");
				}
				else {
					$(this).attr("checked", "checked");
					falceCheckbox.removeAttr("checked");
				}

			});
		});
	</script>
@stop