@extends('backend.layouts.master')

@section('content')
	<div class="container">
		<table class="table-calendar noselect" style="background-color: white;">
			<thead>
				<tr>
					<th>Pon</th>
					<th>Tor</th>
					<th>Sre</th>
					<th>Čet</th>
					<th>Pet</th>
					<th>Sob</th>
					<th>Ned</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><div>1</div></td>
					<td><div>2</div></td>
					<td><div>3</div></td>
					<td><div>4</div></td>
					<td><div>5</div></td>
					<td><div>6</div></td>
					<td><div>7</div></td>
				</tr>
				<tr>
					<td><div>1</div></td>
					<td><div>2</div></td>
					<td><div>3</div></td>
					<td><div>4</div></td>
					<td><div>5</div></td>
					<td><div>6</div></td>
					<td><div>7</div></td>
				</tr>
				<tr>
					<td><div>1</div></td>
					<td><div>2</div></td>
					<td><div>3</div></td>
					<td><div>4</div></td>
					<td><div>5</div></td>
					<td><div>6</div></td>
					<td><div>7</div></td>
				</tr>
				<tr>
					<td><div>1</div></td>
					<td><div>2</div></td>
					<td><div>3</div></td>
					<td><div>4</div></td>
					<td><div>5</div></td>
					<td><div>6</div></td>
					<td><div>7</div></td>
				</tr>

			</tbody>
		</table>

		<!-- MODAL -->
		<div class="modal fade" id="schedule-modal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">Zapolni urnik</h4>
					</div>
					<div class="modal-body">
						<p><strong>Izberi frizerje</strong></p>
						<button type="button" class="btn btn-default btn-sm" data-toggle="button">Klemen Brajkovič</button>
						<button type="button" class="btn btn-default btn-sm" data-toggle="button">Tomaž Silič</button>
						<button type="button" class="btn btn-default btn-sm" data-toggle="button">Eva Kaštrun</button>
						<button type="button" class="btn btn-default btn-sm" data-toggle="button">Jordana Suljanovič</button>

						<br><br>
						<p><strong>Izberi izmeno</strong></p>
						<button type="button" class="btn btn-default btn-sm" data-toggle="button">Dopoldan</button>
						<button type="button" class="btn btn-default btn-sm" data-toggle="button">Popoldan</button>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

	</div>
@stop