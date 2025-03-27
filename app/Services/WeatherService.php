<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getWeather($city = 'Dublin')
    {
        $apiKey = config('services.openweather.key');
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";

        $response = Http::withOptions([
            'verify' => false, // Disable SSL verification
        ])->get($url);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}

