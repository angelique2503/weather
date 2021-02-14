@extends('layouts.master')

@section('title', 'Météo pour :')

@section('sidebar')
    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
	<form method="GET" action="{{ route('weather.search') }}">
		@csrf
		<input type="search" name="q">
		<input type="submit" value="Rechercher">
	</form>

	<div id="weather"></div>
@endsection

@push('scripts')
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script>
		$('form').submit(function(e) {
			e.preventDefault();
			let action = $(this).attr('action'),
				data = {q: $('[name="q"]').val()},
				method = $(this).attr('method');

			/*$.ajax({
				url: action,
				dataType: 'JSON',
				type: method,
				success: function(result) {
					$("#div1").html(result);
				}
			});*/

			$.get(action, data, function(data, status) {
				$('#weather').html(data.view);
			});

			/*$.getJSON(
				action,
				data,
				function(data, status) {
					$('#weather').html(data.view);
				}
			);*/
		});
	</script>
@endpush