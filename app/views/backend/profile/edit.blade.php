@extends('backend.layouts.master')

@section('content')
{{ Form::open(array('url' => 'admin/profile/update', 'method' => 'post')) }}
<div class=container>
<div class="row well well-sm">
	<h2 style="float: left;">{{ $title }}</h2>
	<input style="float: right; margin: 20px;" type="submit" class="btn btn-primary btn-sm" value="Shrani" />
</div>
<div class=row>
	<div class=col-md-4>
		<label>Geslo</label><br />
		<input type="password" class="form-control" id="password" name="password" autocomplete="off" value="" placeholder="Vnesi samo ob spremembi gesla" /><br />
		<label>Ponovi geslo</label><br />
		<input type="password" class="form-control" id="check-password" name="check-password" autocomplete="off" value="" placeholder="Vnesi samo ob spremembi gesla" /><br />
	</div>
	<div class=col-md-4>
		<label>Ime</label><br />
		<input type="text" class="form-control" name="name" value="{{ $user->name or '' }}" required /><br />
		<label>Priimek</label><br />
		<input type="text" class="form-control" name="lastname" value="{{ $user->lastname or '' }}" required /><br />
		<label>Email</label><br />
		<input type="email" class="form-control" name="email" value="{{ $user->email or '' }}" required /><br />
		<label>Telefon</label><br />
		<input type="tel" class="form-control" name="phone" value="{{ $user->phone or '' }}" required /><br />
		<label>Datum rojstva</label><br />
		<input type="date" class="form-control" name="birthdate" value="{{ $user->birthdate or '' }}" required /><br />
	</div>
	<div class=col-md-4>
		<label>Naslov</label><br />
		<input type="text" class="form-control" name="address" value="{{ $user->address or '' }}" /><br />
		<label>Poštna številka</label><br />
		<input type="text" class="form-control" name="post_code" value="{{ $user->post_code or '' }}" /><br />
		<label>Pošta</label><br />
		<input type="text" class="form-control" name="city" value="{{ $user->city or '' }}" /><br />
		<label>Država</label><br />
		<input type="text" class="form-control" name="country" value="{{ $user->country or '' }}" /><br />
	</div>
</div>
 </div>
{{ Form::close() }}
 <script>
 $('input').change(function() {
	    $(window).bind('beforeunload', function(){
 	  return 'Na strani so bile storjene spremembe.';
 	});
 });

 $('form').submit(function() {
 	$(window).unbind('beforeunload');
 });

$('#password').change(function() {
	if($(this).val() != $('#check-password').val()) {
		$(this).after("<p class='password-error' style='color: red;'>Gesli se ne ujemata!</p>");
		$('input[type=submit]').attr('disabled', 'disabled');
	}
	else {
		$('input[type=submit]').removeAttr('disabled');
		$('.password-error').remove();
	}
});
 
$('#check-password').change(function() {
	if($(this).val() != $('#password').val()) {
		$(this).after("<p class='password-error' style='color: red;'>Gesli se ne ujemata!</p>");
		$('input[type=submit]').attr('disabled', 'disabled');
	}
	else {
		$('input[type=submit]').removeAttr('disabled');
		$('.password-error').remove();
	}
});
 </script>
 @stop