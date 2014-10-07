@extends('backend.layouts.master')

@section('content')
	<div class="container">
		@if(isset($shift))
		{{ Form::open(array('url' => 'admin/'.$controller.'/update', 'method' => 'post')) }}
		@else
		{{ Form::open(array('url' => 'admin/'.$controller.'/save', 'method' => 'post')) }}
		@endif
			<div class="panel panel-default">
				<div class="panel-heading">Dodaj izmeno</div>
				<div class="panel-body">
					<div class="form-group">
						<label for="exampleInputEmail1">Ime izmene</label>
						<input type="text" class="form-control" name="name" placeholder="Vnesi ime izmene" value="{{ $shift->name or '' }}">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Od</label>
						<input type="time" class="form-control" name="from" placeholder="Vnesi začetek izmene" value="{{ $shift->from or '' }}">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Do</label>
						<input type="time" class="form-control" name="to" placeholder="Vnesi konec izmene" value="{{ $shift->to or '' }}">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Barva</label>
						<input type="color" class="form-control" style="width: 34px; padding: 2px;" name="color" placeholder="Vnesi barvo izmene" value="{{ $shift->color or '' }}">
					</div>
					@if(isset($shift))
					<input type="hidden" name="id" value="{{ $shift->id }}" />
					@endif
					<button type="submit" class="btn btn-success">Shrani</button>
				</div>
			</div>
		{{ Form::close() }}
	</div>
@stop