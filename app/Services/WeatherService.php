<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getWeather(array $data): ?array
    {
        $weatherMap = config('services.weathermap');
        $data['appid'] = $weatherMap['api_token'];
        $data['units'] = 'metric';
        $query = http_build_query($data);
        $url = $weatherMap['base_url'] . '?' . $query;
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get($url);
            $response->throw();

            return $response->json();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}