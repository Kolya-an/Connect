<?php

namespace App\Services;

class GeocodingService
{
    public static function geocode(string $fullAddress): ?array
    {
        $url = "https://nominatim.openstreetmap.org/search?"
            . http_build_query([
                'q' => $fullAddress,
                'format' => 'json',
                'limit' => 1
            ]);

        $opts = [
            "http" => [
                "header" => "User-Agent: LaravelApp/1.0\r\n"
            ]
        ];

        $context = stream_context_create($opts);

        $response = file_get_contents($url, false, $context);

        if (!$response) {
            return null;
        }

        $data = json_decode($response, true);

        if (empty($data[0])) {
            return null;
        }

        return [
            'lat' => $data[0]['lat'],
            'lng' => $data[0]['lon'],
        ];
    }
}
