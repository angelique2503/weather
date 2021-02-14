<?php

namespace App\Managers;

use Carbon\Carbon;
use App\Services\OpenWeatherService;

/**
 * @author Angélique Allain
 */
class WeatherManager
{
	public function __construct()
	{
		$this->openWeatherService = new OpenWeatherService();
		$this->defaultParameters = [
			'units' => OpenWeatherService::TEMP_UNIT_METRIC,
			'lang' => 'fr',
		];
	}

	/**
	* Get weather from query search.
	* @param array $data 		List of parameters
	* @param bool $raw 			Used for debug to get the raw API response
	* @return array $response 	API response formatted or not
	*/
	public function currentWeather(array $data, bool $raw = false)
	{
		return $this->openWeatherService->get('weather', array_merge($data, $this->defaultParameters));
		/*if($raw) {
			return $response;
		}

		return static::response($response);*/
	}

	public function forecast(array $data, bool $raw = false)
	{
		$response = $this->openWeatherService->get('forecast', array_merge($data, $this->defaultParameters));
		return static::response($response);
	}

	private static function getTimeOfDay(Carbon $date) {
		$moment = 'moorning';
		$now = Carbon::now();
		$now->hour = $date->hour;
		$now->minute = $date->minute;

		$mapping = [
			'21:00|06:00' => 'night',
			'06:00|12:00' => 'moorning',
			'12:00|18:00' => 'afternoon',
			'18:00|21:00' => 'evening',
		];

		foreach($mapping as $hours => $value) {
			$hours = explode('|', $hours);
			$start = Carbon::createFromTimeString($hours[0]);
			$end = Carbon::createFromTimeString($hours[1]);

			if($now->between($start, $end)) {
				return $value;
			}
		}
	}

	private static function response($data) : array
	{
		$response = [
			'raw' => $data,
			'city' => [
				'name' => $data->city->name,
				'timezone' => $data->city->timezone,
				'country' => $data->city->country,
				'population' => $data->city->population,
			],
			'list' => [],
		];

		foreach($data->list as $item) {
			$weatherKey = strtolower($item->weather[0]->main);
			$date = Carbon::parse($item->dt_txt);
			$response['list'][$date->toDateString()][] = [
				'dateTime' => $date->toDateTimeString(),
				'timeOfDay' => self::getTimeOfDay($date),
				'dayOfWeek' => $date->format('D'),
				'weather' => [
					'key' => $weatherKey,
					'description' => ucfirst($item->weather[0]->description),
					'icon' => OpenWeatherService::getWeatherIcon($item->weather[0]->id),
				],
				'temperature' => [
					'current' => $item->main->temp,
					'feelsLike' => $item->main->feels_like,
					'min' => $item->main->temp_min,
					'max' => $item->main->temp_max,
					'pressure' => $item->main->pressure,
					'humidity' => $item->main->humidity,
				],
			];
		}

		return $response;
		/*$weatherKey = strtolower($data->weather[0]->main);
		return [
			'city' => [
				'name' => $data->name,
				'timezone' => $data->timezone,
				'country' => $data->sys->country,
			],
			'weather' => [
				'key' => $weatherKey,
				'description' => ucfirst($data->weather[0]->description),
				'icon' => asset('images/icons/'.$weatherKey.'.svg'),
			],
			'wind' => [
				'speed' => $data->wind->speed,
			],
			'temperature' => [
				'current' => $data->main->temp,
				'feelsLike' => $data->main->feels_like,
				'min' => $data->main->temp_min,
				'max' => $data->main->temp_max,
				'pressure' => $data->main->pressure,
				'humidity' => $data->main->humidity,
			],
		];*/
	}
}