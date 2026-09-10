<?php

namespace Tests\Feature;

use Tests\TestCase;

class WebGisFeatureTest extends TestCase
{
    /**
     * Test that the main WebGIS dashboard loads successfully with required titles and identity.
     */
    public function test_webgis_dashboard_loads_with_required_information(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('WebGIS Analisis Konsumsi BBM Pickup K-06');
        $response->assertSee('Analisis Perjalanan dan Efisiensi BBM Trayek Serang – Cilegon');
        $response->assertSee('Ryan Adiputra Darmawan');
        $response->assertSee('Kode CaAs: 2671');
        $response->assertDontSee('NPM: 2671');
        $response->assertDontSee('NPM 2671');
        $response->assertSee('Pickup Boks');
        $response->assertSee('K-06');
        $response->assertSee('Serang – Cilegon');
        $response->assertSee('Biosolar');
        $response->assertSee('85,6');
        $response->assertSee('10,3');
        $response->assertSee('69.923');
        $response->assertSee('8,31');
        $response->assertSee('0,8');
        $response->assertSee('5.234');
    }

    /**
     * Test that the ringkasan API returns accurate dataset values.
     */
    public function test_ringkasan_api_endpoint(): void
    {
        $response = $this->getJson('/api/ringkasan');

        $response->assertStatus(200);
        $response->assertJson([
            'kode_kendaraan' => 'K-06',
            'kendaraan' => 'Pickup boks',
            'trayek' => 'Serang – Cilegon',
            'jenis_bbm' => 'Biosolar',
            'harga_per_liter' => 6800,
            'efisiensi_acuan' => 9.0,
            'jumlah_trip' => 3,
            'total_km' => 85.6,
            'total_liter' => 10.3,
            'total_biaya' => 69923,
            'liter_boros' => 0.8,
            'biaya_boros' => 5234,
        ]);
    }

    /**
     * Test that the route GeoJSON API returns valid FeatureCollection with 3 trips.
     */
    public function test_route_geojson_api_endpoint(): void
    {
        $response = $this->getJson('/api/geojson/rute');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'type',
            'name',
            'features' => [
                '*' => [
                    'type',
                    'properties' => [
                        'trip_id',
                        'nama',
                        'jarak_km',
                        'liter_total',
                        'km_per_liter',
                        'biaya_rp',
                    ],
                    'geometry',
                ],
            ],
        ]);

        $features = $response->json('features');
        $this->assertCount(3, $features);
    }

    /**
     * Test that the endpoints GeoJSON API returns 6 features (3 start points, 3 end points).
     */
    public function test_titik_ujung_geojson_api_endpoint(): void
    {
        $response = $this->getJson('/api/geojson/titik-ujung');

        $response->assertStatus(200);
        $features = $response->json('features');
        $this->assertCount(6, $features);
    }

    /**
     * Test that raw GPS endpoint parses all 283 data points.
     */
    public function test_raw_gps_api_endpoint(): void
    {
        $response = $this->getJson('/api/gps-mentah');

        $response->assertStatus(200);
        $response->assertJsonPath('total_points', 283);
    }

    /**
     * Test that all 4 dataset files exist in public/data directory.
     */
    public function test_all_four_dataset_files_exist_in_public_data(): void
    {
        $this->assertFileExists(public_path('data/gps_mentah.csv'));
        $this->assertFileExists(public_path('data/rute.geojson'));
        $this->assertFileExists(public_path('data/titik_ujung.geojson'));
        $this->assertFileExists(public_path('data/ringkasan.json'));
    }
}
