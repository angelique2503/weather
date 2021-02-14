<section class="row">
	<div class="col-12 text-center">
		<h2>{{ $forecast['city']['name'] . ', ' . $forecast['city']['country'] }}</h2>
		<div class="row">
			@foreach($forecast['list'] as $d => $days)
				<div class="col-md-{{ \Carbon\Carbon::parse($d)->isSameDay(\Carbon\Carbon::now()) ? '12' : '3' }}">
					@foreach($days as $item)
						@include('partials.icon')
						<strong>{{ $item['temperature']['current'] }}°C</strong>
						<ul>
							<li>{{ $item['dateTime'] }} // {{ $item['dayOfWeek'] }} // {{ $item['timeOfDay'] }}</li>
							<li>Ressenti : {{ $item['temperature']['feelsLike'] }}</li>
							<li>Humidité : {{ $item['temperature']['humidity'] }}%</li>
						</ul>
					@endforeach
				</div>
			@endforeach
		</div>
	</div>
	<hr/>
	<pre>{{ print_r($forecast) }}</pre>
</section>