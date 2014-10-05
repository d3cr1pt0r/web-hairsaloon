@extends('backend.layouts.master')

@section('content')
	<div class="container">
		{{ Form::open(array('url' => 'admin/'.$controller.'/save', 'method' => 'post')) }}
			<div class="row well well-sm">
				<h2 style="float: left;">{{ $title }}</h2>
				
				<input style="float: right; margin: 20px;" type="submit" class="btn btn-primary btn-sm" value="Shrani">
			</div>
			<div class="col-md-4">
				<label>Vloga</label><br />
				<select class="form-control" name="access_type">
					<option value=1 {{ ((isset($user)) ? (($user->access_type==1) ? 'selected':'') : '') }}>Super Admin</option>
					<option value=2 {{ ((isset($user)) ? (($user->access_type==2) ? 'selected':'') : '') }}>Admin</option>
					<option value=3 {{ ((isset($user)) ? (($user->access_type==3) ? 'selected':'') : '') }}>Frizer</option>
					<option value=5 {{ ((isset($user)) ? (($user->access_type==5) ? 'selected':'') : '') }}>Stranka</option>
				</select>
			</div>
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
		{{ Form::close() }}
	</div>
@stop