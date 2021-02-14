<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function ajaxResponse($data)
    {
    	return response()->json(['data' => $data], 200);
    }

    public function ajaxViewResponse(string $view, array $data)
    {
    	return response()->json(['view' => view($view, $data)->render()], 200);
    }

    public function ajaxError($e)
    {
    	return response()->json(['error' => $e->getMessage()], $e->getCode());
    }
}
