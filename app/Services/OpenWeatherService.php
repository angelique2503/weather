<?php

namespace App\Services;

use GuzzleHttp\Client;

class OpenWeatherService extends Service
{
	const TEMP_UNIT_STANDARD = 'standard';
	const TEMP_UNIT_IMPERIAL = 'imperial';
	const TEMP_UNIT_METRIC = 'metric';

	const ID_PARTLY_CLOUDY = 801;
	const ID_PARTIALLY_CLOUDY = 802;
	const ID_CLOUDY = 803;
	const ID_OVERCAST = 804;
	const ID_CLEAR = 800;
	const ID_LIGHT_RAIN = 500;

	public function __construct()
	{
		$this->secretKey = config('services.open_weather.secret');
		$this->baseUri = config('services.open_weather.base_uri');
	}

	public function get(string $endPoint, array $data = [])
	{
		$data['appid'] = $this->secretKey;
		return $this->send('GET', $endPoint.'?'.http_build_query($data));
	}

	// Helpers

	public static function getWeatherIcons()
	{
		return [
			self::ID_PARTLY_CLOUDY => asset('images/icons/partially-cloundy.svg'),
			self::ID_PARTIALLY_CLOUDY => asset('images/icons/partially-cloundy.svg'),
			self::ID_CLOUDY => asset('images/icons/partially-cloundy.svg'),
			self::ID_OVERCAST => asset('images/icons/overcast.svg'),
			self::ID_CLEAR => asset('images/icons/clear.svg'),
			self::ID_LIGHT_RAIN => asset('images/icons/light-rain.svg')
		];
	}

	public static function getWeatherIcon(int $id)
	{
		return isset(static::getWeatherIcons()[$id]) ? static::getWeatherIcons()[$id] : null;
	}
	
	public static function getTemperatureUnits()
	{
		return [
			self::TEMP_UNIT_METRIC => 'celsius',
			self::TEMP_UNIT_IMPERIAL => 'fahrenheit',
			self::TEMP_UNIT_STANDARD => 'kelvin',
		];
	}

	public static function getTemperatureUnit(string $unit)
	{
		return isset(static::getUnits()[$unit]) ? static::getUnits()[$unit] : null;
	}
}