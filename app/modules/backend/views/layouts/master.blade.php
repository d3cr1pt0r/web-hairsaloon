<!doctype html>
<html lang="en">
<head>
	@include('backend::parts.header')
</head>
<body>
	@if(Auth::check() && Auth::user()->access_type < 5)
		@include('backend::parts.navigation')
	@endif
	@include('backend::parts.alerts')
	<div class="container">
		@yield('content')
	</div>
</body>
</html>