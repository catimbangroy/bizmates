<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function __construct(protected WeatherService $weatherService)
    {

    }

    public function index(Request $request)
    {
        return $this->weatherService->getWeather($request->data);
    }
}
