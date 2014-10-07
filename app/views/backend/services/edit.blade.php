@extends('backend.layouts.master')

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
					<div class="form-group">
						<label for="exampleInputEmail1">Trajanje storitve</label>
						<input type="time" class="form-control" name="time" placeholder="Vnesi trajanje storitve" value="{{ $service->time or '' }}">
					</div>
					@if(isset($service))
					<input type="hidden" name="id" value="{{ $service->id }}" />
					@endif
					<button type="submit" class="btn btn-success">Shrani</button>
				</div>
			</div>
		{{ Form::close() }}
	</div>
@stop