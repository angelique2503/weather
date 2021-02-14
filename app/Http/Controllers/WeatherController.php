<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Managers\WeatherManager;

class WeatherController extends Controller
{
	public function __construct()
	{
		$this->weatherManager = new WeatherManager();
	}

    public function index(Request $request)
    {
    	return view('home');
    }

    public function search(Request $request)
    {
    	try {
    		$forecast = $this->weatherManager->forecast($request->all());

    		return $this->ajaxViewResponse('partials.weather', [
    			'forecast' => $forecast,
    		]);
    	} catch(\Exception $e) {

    		dd($e->getMessage());
    		return $this->ajaxError($e);
    	}
    }
}