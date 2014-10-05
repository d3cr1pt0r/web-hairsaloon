@extends('backend.layouts.master')

@section('content')
	<div class="row well well-sm">
	<h2 style="float: left;">{{ $title }}</h2>
	<a style="float: right; margin: 20px; margin-left: 5px;" href="{{ '/admin/'.$controller.'/add' }}">
		<button type="button" class="btn btn-primary btn-sm">Dodaj</button>
	</a>
	@if(isset($filters))
		<button style="float: right; margin: 20px; margin-right: 0px;" type="button" class="btn btn-default btn-sm hide_filters">Skrij filter</button>
		<button style="float: right; margin: 20px; margin-right: 0px; display: none;" type="button" class="btn btn-default btn-sm show_filters">Prikaži filter</button>
	@endif
</div>
@if(isset($filters))
	<div class="row well filters">
		<form role="form" action="/admin/{{ $controller }}" method="post">
			<div class="row">
				@foreach($filters as $filter)
					<div class="form-group col-md-3">
						<label for="exampleInputEmail1">{{ $filter['label'] }}</label>
						<input type="{{ $filter['type'] }}" class="form-control" name="{{ $filter['name'] }}" value="{{ (Input::has($filter['name']) ? Input::get($filter['name']):'') }}">
					</div>
				@endforeach
			</div>
			<div class=col-md-12>
				<button name="submit" style="margin: 2px;" class="btn btn-default pull-right" type="submit">
	              <span class="glyphicon glyphicon-ok"></span> Uporabi
	          	</button> 
				<a href="#!" onClick="location.reload(true)" type="button" style="margin: 2px;" class="btn btn-default pull-right">
	          		<span class="glyphicon glyphicon-repeat"></span> Počisti
	          	</a>
			</div>
		</form>
	</div>
@endif
<div class="table-responsive">
	<table class="table table-striped">
	    <thead>
	    	<tr>
	    	@foreach($headers as $d)
	    		<th>{{ $d["header"] }}</th>
	    	@endforeach
	    		<th></th>
	    	</tr>
	    </thead>
	    <tbody>
	    	@foreach($data as $d)
	    		<tr>
	    			@foreach($headers as $h)
	    				@if($h["type"] == "normal")
	    					<td><span>{{ $d->$h["db"] }}</span></td>
	    				@elseif($h["type"] == "checkbox")
	    					<td><input class="toggle" type="checkbox" table="{{ $table }}" item-id="{{ $d->id }}" name="{{ $h["db"] }}" {{ ($d->$h["db"]==1 ? 'checked=checked':'') }} /></td>
	    				@elseif($h["type"] == "mail_url")
	    					<td><a href="mailto: {{ $d->$h["db"] }}">{{ $d->$h["db"] }}</a></td>
	    				@elseif($h["type"] == "timeperiod")
	    					<td><span>{{ date('H:i:s',$d->$h["db"]); }}</span></td>
	    				@elseif($h["type"] == "price")
	    					<td><span>{{ $d->$h["db"] }} €</span></td>
	    				@endif
	    			@endforeach
	    			<td align="right">
	    				<a href="/admin/{{ $controller }}/open/{{ $d->id }}">
	    					<button type="button" class="btn btn-default btn-sm">Odpri</button>
	    				</a>
	    				<a href="/admin/{{ $controller }}/edit/{{ $d->id }}">
	    					<button type="button" class="btn btn-default btn-sm">Uredi</button>
	    				</a>
	    				<a href="/admin/{{ $controller }}/duplicate/{{ $d->id }}">
	    					<button type="button" class="btn btn-default btn-sm">Kopiraj</button>
	    				</a>
	    				<a href="/admin/{{ $controller }}/delete/{{ $d->id }}" onclick="return confirm('Ali res želite izbrisati vsebino?');">
	    					<button type="button" class="btn btn-danger btn-sm">Izbriši</button>
	    				</a>
	    			</td>
	    		</tr>
	    	@endforeach
	    </tbody>
	 </table>
 </div>
 
 
<script>
	$(".toggle").click(function() {
		$.post(toggleCheckboxAction, 
		{
			id: $(this).attr("item-id"),
			field: $(this).attr("name"),
			table: $(this).attr("table")
		},
		function(data,status) {
			location.reload();
		});
	});

	$(".hide_filters").click(function() {
		$('.filters').slideUp();
		$('.hide_filters').hide();
		$('.show_filters').show();
	});
	
	$(".show_filters").click(function() {
		$('.filters').slideDown();
		$('.hide_filters').show();
		$('.show_filters').hide();
	});

</script>	
@stop