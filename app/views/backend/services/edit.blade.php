@extends('backend.layouts.master')

@section('content')
	<div class="container">
		{{ Form::open(array('url' => 'admin/'.$controller.'/save', 'method' => 'post')) }}
	</div>
@stop