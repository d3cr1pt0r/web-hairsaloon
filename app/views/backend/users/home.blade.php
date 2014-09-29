@extends('backend.layouts.master')

@section('content')
	<div class="row well well-sm">
	<h2 style="float: left;">{{ $title }}</h2>
	<a style="float: right; margin: 20px; margin-left: 5px;" href="">
		<button type="button" class="btn btn-primary btn-sm">Dodaj</button>
	</a>
	<button style="float: right; margin: 20px; margin-right: 0px;" type="button" class="btn btn-default btn-sm hide_filters">Skrij filter</button>
	<button style="float: right; margin: 20px; margin-right: 0px; display: none;" type="button" class="btn btn-default btn-sm show_filters">Prikaži filter</button>
</div>
<div class="row well filters">
	{{ Form::open(array('url' => 'admin/login', 'method' => 'post')) }}
		<div class="row">
		
		</div>
		<div class=col-md-12>
			<button name="submit" style="margin: 2px;" class="btn btn-default pull-right" type="submit">
              <span class="glyphicon glyphicon-ok"></span> Uporabi</button>
			<button name="clear" style="margin: 2px;" class="btn btn-default pull-right" type="submit">
              <span class="glyphicon glyphicon-repeat"></span> Počisti</button>
		</div>
	{{ Form::close() }}
	</form>
</div>
<div class="table-responsive">
	<table class="table">
	    
	 </table>
 </div>
 
 
<script>
	$(".toggle").click(function() {
		$.post("", 
		{
			id: $(this).attr("item-id"),
			field: $(this).attr("name"),
			data: $(this).val()
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