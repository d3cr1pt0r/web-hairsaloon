@extends('backend::layouts.master')

@section('content')
	<div class="container">
		@if(isset($usersGroup))
		{{ Form::open(array('url' => 'admin/'.$controller.'/update', 'method' => 'post')) }}
		@else
		{{ Form::open(array('url' => 'admin/'.$controller.'/save', 'method' => 'post')) }}
		@endif
			<div class="row well well-sm">
				<h2 style="float: left;">{{ $title }}</h2>
				
				<input style="float: right; margin: 20px;" type="submit" class="btn btn-primary btn-sm" value="Shrani">
			</div>
			<div class="col-md-4">
				<label>Ime</label><br />
				<input class="form-control" type="text" name="name" value="{{ $usersGroup->name or '' }}" required /><br />
				@if(isset($usersGroup))
				<input type="hidden" name="id" value="{{ $usersGroup->id }}" />
				@endif
			</div>
		{{ Form::close() }}
	</div>
@stop