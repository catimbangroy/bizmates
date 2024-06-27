<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getWeather(array $data): ?array
    {
        $weatherMap = config('services.weathermap');
        $data['appid'] = $weatherMap['api_token'];
        $data['cnt'] = $weatherMap['cnt'];
        $data['units'] = 'metric';
        $query = http_build_query($data);
        $url = $weatherMap['base_url'] . '?' . $query;
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get($url);
            $response->throw();
            $responseData = $response->json();
            if (isset($responseData['list'])) {
                $responseData['list'] = array_map(function ($list) {
                    $list['dt_txt'] = date(config('services.date.format'), strtotime($list['dt_txt'])); 
                    return $list;
                }, $responseData['list']);
            }

            return $responseData;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
