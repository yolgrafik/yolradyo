<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RadioStatusController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $data = Cache::remember('radio_status', 5, function () {
            return $this->fetchStatus();
        });

        return response()->json($data);
    }

    private function fetchStatus(): array
    {
        $settings = Setting::getSettings();
        $baseUrl = $settings?->shoutcast_base_url ?? '';
        $sid = (int) ($settings?->shoutcast_sid ?? 1);

        if (empty($baseUrl)) {
            return [
                'ok' => false,
                'song' => '-',
                'listeners' => 0,
                'status' => 'offline',
            ];
        }

        $baseUrl = rtrim($baseUrl, '/');

        $urls = [
            "{$baseUrl}/stats?sid={$sid}&json=1",
            "{$baseUrl}/stats?json=1",
            "{$baseUrl}/status-json.xsl",
        ];

        foreach ($urls as $url) {
            try {
                $response = Http::timeout(3)->get($url);
                if ($response->successful()) {
                    $json = $response->json();
                    return $this->normalizeResponse($json);
                }
            } catch (\Throwable $e) {
                continue;
            }
        }

        return [
            'ok' => false,
            'song' => '-',
            'listeners' => 0,
            'status' => 'offline',
        ];
    }

    private function normalizeResponse(?array $json): array
    {
        if (!is_array($json)) {
            return [
                'ok' => false,
                'song' => '-',
                'listeners' => 0,
                'status' => 'offline',
            ];
        }

        $song = '-';
        $listeners = 0;
        $status = 'offline';

        if (isset($json['song'])) {
            $song = (string) $json['song'];
        } elseif (isset($json['currentsong'])) {
            $song = (string) $json['currentsong'];
        } elseif (isset($json['streams'][0]['song'])) {
            $song = (string) $json['streams'][0]['song'];
        } elseif (isset($json['icestats']['source'])) {
            $src = $json['icestats']['source'];
            $src = is_array($src) && isset($src[0]) ? $src[0] : $src;
            $song = (string) ($src['title'] ?? $src['yp_current'] ?? '-');
        }

        if (isset($json['listeners'])) {
            $listeners = (int) $json['listeners'];
        } elseif (isset($json['currentlisteners'])) {
            $listeners = (int) $json['currentlisteners'];
        } elseif (isset($json['streams'][0]['listeners'])) {
            $listeners = (int) $json['streams'][0]['listeners'];
        } elseif (isset($json['icestats']['source'])) {
            $src = $json['icestats']['source'];
            $src = is_array($src) && isset($src[0]) ? $src[0] : $src;
            $listeners = (int) ($src['listeners'] ?? 0);
        }

        if ($listeners > 0 || !empty($song) && $song !== '-') {
            $status = 'online';
        }

        return [
            'ok' => true,
            'song' => $song ?: '-',
            'listeners' => max(0, $listeners),
            'status' => $status,
        ];
    }
}
