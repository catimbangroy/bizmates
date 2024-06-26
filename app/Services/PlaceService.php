<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PlaceService
{
    public function getPlaces(array $data): ?array
    {
        $fourSquare = config('services.foursquare');
        $data['limit'] = $fourSquare['limit'];
        $query = http_build_query($data);
        $url = $fourSquare['base_url'] . '/places/search?' . $query;
        try {
            $response = Http::withHeaders([
                'Authorization' => $fourSquare['api_token'],
                'Accept' => 'application/json',
            ])->get($url);
            $response->throw();

            return $response->json();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}