<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class WebGisController extends Controller
{
    /**
     * Display the main WebGIS interactive dashboard.
     */
    public function index(): View
    {
        $ringkasan = $this->loadRingkasanData();
        $ruteGeoJson = $this->loadRuteGeoJsonData();
        $titikUjungGeoJson = $this->loadTitikUjungGeoJsonData();
        $gpsData = $this->loadGpsCsvData();

        $trips = [];
        if (isset($ruteGeoJson['features']) && is_array($ruteGeoJson['features'])) {
            foreach ($ruteGeoJson['features'] as $feature) {
                $trips[] = $feature['properties'];
            }
        }

        $studentInfo = [
            'nama' => 'Ryan Adiputra Darmawan',
            'kode_caas' => '2671',
            'tugas' => 'Tugas Minggu 5 - WebGIS Analisis Konsumsi BBM',
        ];

        return view('webgis', [
            'ringkasan' => $ringkasan,
            'ruteGeoJson' => $ruteGeoJson,
            'titikUjungGeoJson' => $titikUjungGeoJson,
            'gpsData' => $gpsData,
            'trips' => $trips,
            'studentInfo' => $studentInfo,
        ]);
    }

    /**
     * API endpoint to return route GeoJSON data.
     */
    public function getRuteGeoJson(): JsonResponse
    {
        return response()->json($this->loadRuteGeoJsonData());
    }

    /**
     * API endpoint to return endpoint marker GeoJSON data.
     */
    public function getTitikUjungGeoJson(): JsonResponse
    {
        return response()->json($this->loadTitikUjungGeoJsonData());
    }

    /**
     * API endpoint to return summary JSON data.
     */
    public function getRingkasan(): JsonResponse
    {
        return response()->json($this->loadRingkasanData());
    }

    /**
     * API endpoint to return parsed raw GPS data.
     */
    public function getGpsMentah(): JsonResponse
    {
        return response()->json($this->loadGpsCsvData());
    }

    /**
     * Read and decode ringkasan.json.
     *
     * @return array<string, mixed>
     */
    private function loadRingkasanData(): array
    {
        $path = public_path('data/ringkasan.json');
        if (! File::exists($path)) {
            return [];
        }

        $content = File::get($path);
        $decoded = json_decode($content, true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Read and decode rute.geojson.
     *
     * @return array<string, mixed>
     */
    private function loadRuteGeoJsonData(): array
    {
        $path = public_path('data/rute.geojson');
        if (! File::exists($path)) {
            return [];
        }

        $content = File::get($path);
        $decoded = json_decode($content, true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Read and decode titik_ujung.geojson.
     *
     * @return array<string, mixed>
     */
    private function loadTitikUjungGeoJsonData(): array
    {
        $path = public_path('data/titik_ujung.geojson');
        if (! File::exists($path)) {
            return [];
        }

        $content = File::get($path);
        $decoded = json_decode($content, true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Read and parse gps_mentah.csv into structured arrays and statistics.
     *
     * @return array{
     *     total_points: int,
     *     points_by_trip: array<int, array<int, array<string, mixed>>>,
     *     speed_series_by_trip: array<int, array{labels: array<int, string>, speeds: array<int, float>, distances: array<int, float>}>,
     *     speed_summary: array<int, array{min: float, max: float, avg: float, count: int}>
     * }
     */
    private function loadGpsCsvData(): array
    {
        $path = public_path('data/gps_mentah.csv');
        if (! File::exists($path)) {
            return [
                'total_points' => 0,
                'points_by_trip' => [],
                'speed_series_by_trip' => [],
                'speed_summary' => [],
            ];
        }

        $file = fopen($path, 'r');
        if ($file === false) {
            return [
                'total_points' => 0,
                'points_by_trip' => [],
                'speed_series_by_trip' => [],
                'speed_summary' => [],
            ];
        }

        $header = fgetcsv($file);
        $pointsByTrip = [];
        $speedSeriesByTrip = [];
        $speedsByTrip = [];
        $totalPoints = 0;

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < 6) {
                continue;
            }

            $point = [
                'trip_id' => (int) $row[0],
                'waktu' => $row[1],
                'latitude' => (float) $row[2],
                'longitude' => (float) $row[3],
                'kecepatan_kmh' => (float) $row[4],
                'jarak_km' => (float) $row[5],
            ];

            $tripId = $point['trip_id'];
            $pointsByTrip[$tripId][] = $point;
            $speedsByTrip[$tripId][] = $point['kecepatan_kmh'];

            $timeFormatted = date('H:i:s', strtotime($point['waktu']));
            $speedSeriesByTrip[$tripId]['labels'][] = $timeFormatted;
            $speedSeriesByTrip[$tripId]['speeds'][] = $point['kecepatan_kmh'];
            $speedSeriesByTrip[$tripId]['distances'][] = $point['jarak_km'];

            $totalPoints++;
        }

        fclose($file);

        $speedSummary = [];
        foreach ($speedsByTrip as $tripId => $speeds) {
            $count = count($speeds);
            if ($count > 0) {
                $speedSummary[$tripId] = [
                    'min' => min($speeds),
                    'max' => max($speeds),
                    'avg' => round(array_sum($speeds) / $count, 2),
                    'count' => $count,
                ];
            }
        }

        return [
            'total_points' => $totalPoints,
            'points_by_trip' => $pointsByTrip,
            'speed_series_by_trip' => $speedSeriesByTrip,
            'speed_summary' => $speedSummary,
        ];
    }
}
