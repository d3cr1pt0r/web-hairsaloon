@extends('backend::layouts.master')

@section('content')
<div class="container" style="padding-top: 10%;">
	<div class="panel panel-default" style="width: 400px; margin: auto;">
		<div class="panel-body">
			{{ Form::open(array('url' => 'admin/auth/login', 'method' => 'post')) }}
				<div class="form-group">
					<label for="exampleInputEmail1">Email address</label>
					<input type="email" class="form-control" name="email" placeholder="Enter email">
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Password</label>
					<input type="password" class="form-control" name="password" placeholder="Password">
				</div>

				@if($captcha)
				<div>
					{{ HTML::image(Captcha::img(), 'Captcha image') }}
		       		{{ Form::text('captcha') }}<br /><br />
		   		 </div>
		   		 @endif

				<button type="submit" class="btn btn-default">Submit</button>
			{{ Form::close() }}
		</div>
	</div>
</div>
@stop