@extends('backend.layouts.master')

@section('content')
	<div class="container">
		{{ Form::open(array('url' => 'admin/login', 'method' => 'post')) }}
			<div class="form-group">
				<label for="exampleInputEmail1">Email address</label>
				<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Password</label>
				<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
			</div>
			<button type="submit" class="btn btn-default">Submit</button>
		{{ Form::close() }}
	</div>
@stop