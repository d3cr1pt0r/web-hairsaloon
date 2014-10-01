@extends('backend.layouts.master')

@section('content')
	<div class="container">
		<div class="row well well-sm">
			<h2 style="float: left;">{{ $title }}</h2>
			
			<input style="float: right; margin: 20px;" type="submit" class="btn btn-primary btn-sm" value="Shrani">
		</div>
		<div class="col-md-4">
			<label>Vloga</label><br />
			<select class="form-control" name="role">
				<option value=1>Super Admin</option>
				<option value=2>Admin</option>
				<option value=3>Frizer</option>
				<option value=5>Stranka</option>
			</select>
		</div>
		<div class="col-md-4">
			<label>Uporabniško ime</label><br />
			<input class="form-control" type="text" name="-users-username" value="" /><br />
			<label>Geslo</label><br />
			<input class="form-control" type="password" name="-users-password" value="" /><br />
			<label>Ponovi geslo</label><br />
			<input class="form-control" type="password" name="check_password" value="" /><br />
		</div>
		<div class="col-md-4">
			<label>Ime</label><br />
			<input class="form-control" type="password" name="-users-name" value="" /><br />
			<label>Priimek</label><br />
			<input class="form-control" type="password" name="-users-surname" value="" /><br />
			<label>Email</label><br />
			<input class="form-control" type="password" name="-users-email" value="" /><br />
		</div>
	</div>
@stop