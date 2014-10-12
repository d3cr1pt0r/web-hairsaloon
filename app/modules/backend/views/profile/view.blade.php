@extends('backend::layouts.master')

@section('content')
<div class=container>
	<div class="row well well-sm">
		<h2 style="float: left;">{{ $title }}</h2>
		<a style="float: right; margin: 20px; margin-left: 5px;" href="/admin/profile/edit">
			<button type="button" class="btn btn-primary btn-sm">Uredi</button>
		</a>
	</div>
	<label for="name">Ime</label><br />
	{{ $user->name }}<br />
	<label for="lastname">Priimek</label><br />
	{{ $user->lastname }}<br />
	<label for="email">Email</label><br />
	{{ $user->email }}<br />
	<label for="phone">Telefon</label><br />
	{{ $user->phone }}<br />
	<label for="birthdate">Datum rojstva</label><br />
	{{ $user->birthdate }}<br /><br />

	<label>Naslov</label><br />
	{{ $user->address }}<br />
	{{ $user->post_code }} {{ $user->city }}<br />
	{{ $user->country }}
</div>
@stop