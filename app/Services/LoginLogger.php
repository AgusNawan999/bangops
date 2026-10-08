<?php

namespace App\Services;

use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LoginLogger
{
    public static function record($user, Request $request, string $method = 'manual'): void
    {
        $ip = $request->ip();

        // Mengatasi local loopback IP (127.0.0.1) saat pengujian lokal
        $geoIp = ($ip === '127.0.0.1' || $ip === '::1') ? '103.28.12.1' : $ip; // IP dummy ID buat dev

        $country = 'Unknown';
        $city = 'Unknown';
        $lat = null;
        $lon = null;

        try {
            $response = Http::timeout(3)->get("http://ip-api.com/json/{$geoIp}");
            if ($response->successful() && $response->json('status') === 'success') {
                $data = $response->json();
                $country = $data['country'] ?? 'Unknown';
                $city = $data['city'] ?? 'Unknown';
                $lat = $data['lat'] ?? null;
                $lon = $data['lon'] ?? null;
            }
        } catch (\Exception $e) {
            Log::error("GeoIP Error: " . $e->getMessage());
        }

        LoginLog::create([
            'user_id' => $user->id,
            'ip_address' => $ip,
            'user_agent' => substr($request->userAgent() ?? '', 0, 255),
            'login_method' => $method,
            'country' => $country,
            'city' => $city,
            'latitude' => $lat,
            'longitude' => $lon,
            'login_at' => now(),
        ]);
    }
}