@extends('backend::layouts.master')

@section('content')
	<div class="container">
		@if(isset($user))
		{{ Form::open(array('url' => 'admin/'.$controller.'/update', 'method' => 'post')) }}
		@else
		{{ Form::open(array('url' => 'admin/'.$controller.'/save', 'method' => 'post')) }}
		@endif
			<div class="row well well-sm">
				<h2 style="float: left;">{{ $title }}</h2>
				
				<input style="float: right; margin: 20px;" type="submit" class="btn btn-primary btn-sm" value="Shrani">
			</div>
			<input type="hidden" name="access_type" value="{{ $access_type }}" />
			<div class="col-md-4">
				<label>Email</label><br />
				<input class="form-control" type="email" name="email" value="{{ $user->email or '' }}" required /><br />
				<label>Geslo</label><br />
				<input class="form-control" type="password" name="password" value="" {{ (($add) ? 'required':'') }} /><br />
				<label>Ponovi geslo</label><br />
				<input class="form-control" type="password" name="check_password" value="" {{ (($add) ? 'required':'') }} /><br />
			</div>
			<div class="col-md-4">
				<label>Ime</label><br />
				<input class="form-control" type="text" name="name" value="{{ $user->name or '' }}" required /><br />
				<label>Priimek</label><br />
				<input class="form-control" type="text" name="lastname" value="{{ $user->lastname or '' }}" required /><br />
				<label>Telefon</label><br />
				<input class="form-control" type="tel" name="phone" value="{{ $user->phone or '' }}" /><br />
				<label>Datum rojstva</label><br />
				<input class="form-control" type="date" name="birthdate" value="{{ $user->birthdate or '' }}" /><br />
				@if(isset($user))
				<input type="hidden" name="id" value="{{ $user->id }}" />
				@endif
			</div>
			<div class="col-md-4">
				<label>Skupine</label><br />
				@foreach($usersGroups as $group)
					<input type="checkbox" name="group_id[]" value="{{ $group->id }}" {{ (in_array($group->id, $checkedUsersGroups) ? 'checked=checked':'') }} /> {{ $group->name }}<br />
				@endforeach
			</div>
		{{ Form::close() }}
	</div>
@stop