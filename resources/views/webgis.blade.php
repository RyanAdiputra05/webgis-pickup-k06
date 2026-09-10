<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebGIS Analisis Konsumsi BBM Pickup K-06 | Ryan Adiputra Darmawan (Kode CaAs: 2671)</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                            950: '#0f172a'
                        }
                    }
                }
            }
        }
    </script>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }

        #map {
            height: 580px;
            width: 100%;
            border-radius: 1rem;
            z-index: 1;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 0.75rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            padding: 0;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .leaflet-popup-content {
            margin: 0 !important;
            line-height: 1.5;
            font-family: inherit;
        }

        .custom-start-marker, .custom-end-marker {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: white;
            font-weight: 700;
            font-size: 11px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -1px rgba(0, 0, 0, 0.1);
            border: 2px solid white;
            transition: transform 0.2s ease;
        }

        .custom-start-marker:hover, .custom-end-marker:hover {
            transform: scale(1.15);
        }

        .custom-start-marker {
            background: linear-gradient(135deg, #10b981, #047857);
        }

        .custom-end-marker {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
        }

        .pulse-marker {
            position: relative;
        }

        .pulse-marker::after {
            content: '';
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            border-radius: 50%;
            border: 2px solid currentColor;
            opacity: 0.6;
            animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
        }

        @keyframes ping {
            75%, 100% {
                transform: scale(1.6);
                opacity: 0;
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-slate-50 text-slate-800">

    <!-- Top Navigation -->
    <header class="bg-slate-900 text-white sticky top-0 z-50 shadow-md border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A2 2 0 013 15.485V5.515a2 2 0 011.553-1.956L9 2m0 18l6 3m-6-3V2m6 21l5.447-2.724A2 2 0 0021 18.485V8.515a2 2 0 00-1.553-1.956L15 5m0 16V5m0 0L9 2"></path>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="text-lg font-extrabold tracking-tight text-white">WebGIS BBM Pickup K-06</h1>
                        <span class="px-2 py-0.5 text-xs font-semibold bg-blue-500/20 text-blue-400 border border-blue-500/30 rounded-full">Tugas Minggu 5</span>
                    </div>
                    <p class="text-xs text-slate-400 font-medium">Trayek Serang – Cilegon | Analisis Spasial GPS & Konsumsi Bahan Bakar</p>
                </div>
            </div>

            <!-- Student Identity Pill -->
            <div class="flex items-center gap-3 bg-slate-800/90 border border-slate-700/80 rounded-xl px-3.5 py-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 flex items-center justify-center font-bold text-xs">
                    RA
                </div>
                <div class="text-left">
                    <div class="text-xs font-bold text-white tracking-wide">Ryan Adiputra Darmawan</div>
                    <div class="text-[11px] text-emerald-400 font-semibold">Kode CaAs: 2671</div>
                </div>
                <div class="hidden sm:block pl-3 border-l border-slate-700 text-right">
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-950/60 text-emerald-300 border border-emerald-800">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        4 Dataset Aktif
                    </span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6 flex-1 w-full">

        <!-- Title & Subtitle Banner -->
        <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 rounded-2xl p-6 text-white shadow-xl border border-slate-700/50 relative overflow-hidden">
            <div class="absolute right-0 top-0 bottom-0 w-1/3 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-blue-500/10 via-transparent to-transparent pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="space-y-2 max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md bg-blue-500/20 text-blue-300 border border-blue-400/30 text-xs font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Sistem Pemantauan Telematika & Konsumsi Energi Kendaraan
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white leading-tight">
                        WebGIS Analisis Konsumsi BBM Pickup K-06
                    </h2>
                    <p class="text-sm sm:text-base text-slate-300 font-normal">
                        Analisis Perjalanan dan Efisiensi BBM Trayek Serang – Cilegon
                    </p>
                    <div class="flex flex-wrap items-center gap-y-2 gap-x-4 pt-1 text-xs text-slate-300">
                        <span class="flex items-center gap-1.5">
                            <span class="font-semibold text-white">Identitas:</span> 
                            <strong class="text-amber-400">Ryan Adiputra Darmawan</strong> (Kode CaAs: <strong class="text-amber-400">2671</strong>)
                        </span>
                        <span class="text-slate-500">•</span>
                        <span>Tanggal Uji: <strong>Senin, 03 Maret 2025</strong></span>
                        <span class="text-slate-500">•</span>
                        <span>Metode: <strong>GPS Tracking + Analisis Volumetrik BBM</strong></span>
                    </div>
                </div>

                <!-- Vehicle Info Box -->
                <div class="bg-slate-800/80 backdrop-blur border border-slate-700/80 rounded-xl p-4 min-w-[260px] shadow-lg">
                    <div class="text-[11px] font-bold text-blue-400 tracking-wider uppercase mb-2 flex items-center justify-between">
                        <span>Spesifikasi Unit K-06</span>
                        <span class="px-1.5 py-0.5 rounded text-[10px] bg-blue-500/20 text-blue-300">Aktif</span>
                    </div>
                    <div class="space-y-1.5 text-xs">
                        <div class="flex justify-between py-0.5 border-b border-slate-700/60">
                            <span class="text-slate-400">Jenis Armada:</span>
                            <span class="font-semibold text-white">{{ ucwords($ringkasan['kendaraan'] ?? 'Pickup Boks') }}</span>
                        </div>
                        <div class="flex justify-between py-0.5 border-b border-slate-700/60">
                            <span class="text-slate-400">Kode Kendaraan:</span>
                            <span class="font-semibold text-amber-300">{{ $ringkasan['kode_kendaraan'] ?? 'K-06' }}</span>
                        </div>
                        <div class="flex justify-between py-0.5 border-b border-slate-700/60">
                            <span class="text-slate-400">Trayek:</span>
                            <span class="font-semibold text-white">{{ $ringkasan['trayek'] ?? 'Serang – Cilegon' }}</span>
                        </div>
                        <div class="flex justify-between py-0.5 border-b border-slate-700/60">
                            <span class="text-slate-400">Bahan Bakar:</span>
                            <span class="font-semibold text-emerald-400">{{ $ringkasan['jenis_bbm'] ?? 'Biosolar' }} (Rp{{ number_format($ringkasan['harga_per_liter'] ?? 6800, 0, ',', '.') }}/L)</span>
                        </div>
                        <div class="flex justify-between py-0.5">
                            <span class="text-slate-400">Efisiensi Acuan:</span>
                            <span class="font-bold text-blue-400">{{ number_format($ringkasan['efisiensi_acuan'] ?? 9.0, 1, ',', '.') }} km/liter</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Summary Cards Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            
            <!-- Card 1: Total Jarak -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="text-[11px] font-semibold uppercase tracking-wider text-slate-500 mb-1">Total Jarak</div>
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ number_format($ringkasan['total_km'] ?? 85.6, 1, ',', '.') }}</span>
                    <span class="text-xs font-semibold text-slate-500">km</span>
                </div>
                <div class="mt-2 flex items-center gap-1.5 text-xs text-blue-600 font-medium">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A2 2 0 013 15.485V5.515a2 2 0 011.553-1.956L9 2m0 18l6 3m-6-3V2m6 21l5.447-2.724A2 2 0 0021 18.485V8.515a2 2 0 00-1.553-1.956L15 5m0 16V5m0 0L9 2"></path></svg>
                    <span>{{ $ringkasan['jumlah_trip'] ?? 3 }} Trip Perjalanan</span>
                </div>
                <div class="absolute top-3 right-3 w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
            </div>

            <!-- Card 2: Total BBM -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="text-[11px] font-semibold uppercase tracking-wider text-slate-500 mb-1">Total BBM Terpakai</div>
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ number_format($ringkasan['total_liter'] ?? 10.3, 1, ',', '.') }}</span>
                    <span class="text-xs font-semibold text-slate-500">liter</span>
                </div>
                <div class="mt-2 flex items-center gap-1.5 text-xs text-amber-600 font-medium">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span>Biosolar</span>
                </div>
                <div class="absolute top-3 right-3 w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
            </div>

            <!-- Card 3: Total Biaya BBM -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="text-[11px] font-semibold uppercase tracking-wider text-slate-500 mb-1">Total Biaya BBM</div>
                <div class="flex items-baseline gap-1">
                    <span class="text-xs font-bold text-slate-500">Rp</span>
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ number_format($ringkasan['total_biaya'] ?? 69923, 0, ',', '.') }}</span>
                </div>
                <div class="mt-2 flex items-center gap-1.5 text-xs text-emerald-600 font-medium">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Rp6.800 / liter</span>
                </div>
                <div class="absolute top-3 right-3 w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>

            <!-- Card 4: Efisiensi Aktual -->
            @php
                $totalKm = $ringkasan['total_km'] ?? 85.6;
                $totalLiter = $ringkasan['total_liter'] ?? 10.3;
                $efisiensiAktual = $totalLiter > 0 ? round($totalKm / $totalLiter, 2) : 8.31;
                $efisiensiAcuan = $ringkasan['efisiensi_acuan'] ?? 9.0;
                $persenDeviasi = round((($efisiensiAktual - $efisiensiAcuan) / $efisiensiAcuan) * 100, 2);
            @endphp
            <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="text-[11px] font-semibold uppercase tracking-wider text-slate-500 mb-1">Efisiensi Aktual</div>
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl sm:text-3xl font-extrabold text-amber-600">{{ number_format($efisiensiAktual, 2, ',', '.') }}</span>
                    <span class="text-xs font-semibold text-slate-500">km/L</span>
                </div>
                <div class="mt-2 flex items-center gap-1.5 text-xs text-rose-600 font-semibold">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    <span>Acuan: {{ number_format($efisiensiAcuan, 1, ',', '.') }} km/L ({{ $persenDeviasi }}%)</span>
                </div>
                <div class="absolute top-3 right-3 w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
            </div>

            <!-- Card 5: BBM Boros -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="text-[11px] font-semibold uppercase tracking-wider text-slate-500 mb-1">BBM Boros (Lebih)</div>
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl sm:text-3xl font-extrabold text-rose-600">{{ number_format($ringkasan['liter_boros'] ?? 0.8, 1, ',', '.') }}</span>
                    <span class="text-xs font-semibold text-slate-500">liter</span>
                </div>
                <div class="mt-2 flex items-center gap-1.5 text-xs text-rose-500 font-medium">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span>7,7% dari total BBM</span>
                </div>
                <div class="absolute top-3 right-3 w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                </div>
            </div>

            <!-- Card 6: Biaya Pemborosan -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="text-[11px] font-semibold uppercase tracking-wider text-slate-500 mb-1">Biaya Pemborosan</div>
                <div class="flex items-baseline gap-1">
                    <span class="text-xs font-bold text-rose-500">Rp</span>
                    <span class="text-2xl sm:text-3xl font-extrabold text-rose-600">{{ number_format($ringkasan['biaya_boros'] ?? 5234, 0, ',', '.') }}</span>
                </div>
                <div class="mt-2 flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Potensi Hemat Biaya</span>
                </div>
                <div class="absolute top-3 right-3 w-8 h-8 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

        </div>

        <!-- Filter & Control Toolbar -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex flex-wrap items-center justify-between gap-4">
            <!-- Trip Filter Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500 mr-1 flex items-center gap-1">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filter Trip:
                </span>
                <button type="button" onclick="filterTrip('all')" id="btn-filter-all" class="trip-filter-btn px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all bg-slate-900 text-white shadow-sm border border-slate-900">
                    Semua Trip (3)
                </button>
                <button type="button" onclick="filterTrip(1)" id="btn-filter-1" class="trip-filter-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                    Trip 1 (Pagi 06:20)
                </button>
                <button type="button" onclick="filterTrip(2)" id="btn-filter-2" class="trip-filter-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                    Trip 2 (Siang 11:34)
                </button>
                <button type="button" onclick="filterTrip(3)" id="btn-filter-3" class="trip-filter-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-600"></span>
                    Trip 3 (Sore 15:00)
                </button>
            </div>

            <!-- Layer Toggles & Map Tools -->
            <div class="flex flex-wrap items-center gap-2">
                <!-- Toggle GPS Points Checkbox -->
                <label class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700 cursor-pointer hover:bg-slate-100 select-none">
                    <input type="checkbox" id="toggle-gps-points" class="rounded text-blue-600 focus:ring-blue-500 w-3.5 h-3.5">
                    <span>Titik GPS Mentah (283)</span>
                </label>

                <!-- Basemap Selector -->
                <select id="basemap-selector" onchange="changeBasemap(this.value)" class="bg-slate-50 border border-slate-200 text-slate-700 text-xs rounded-lg px-2.5 py-1.5 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    <option value="carto-light">Peta: Carto Positron (Terang)</option>
                    <option value="osm">Peta: OpenStreetMap Standar</option>
                    <option value="satellite">Peta: Citra Satelit (Esri)</option>
                    <option value="carto-dark">Peta: Carto Dark (Gelap)</option>
                </select>

                <!-- Fit Bounds Button -->
                <button type="button" onclick="resetMapBounds()" title="Reset Tampilan Peta ke Seluruh Rute" class="px-3 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-semibold flex items-center gap-1.5 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                    Fit Bounds
                </button>

                <!-- Raw GPS Data Modal Button -->
                <button type="button" onclick="openGpsModal()" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold flex items-center gap-1.5 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Data Mentah GPS
                </button>
            </div>
        </div>

        <!-- Map Section with Floating Legend & Info -->
        <div class="relative bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <!-- Map Element -->
            <div id="map"></div>

            <!-- Floating Trip Quick Status Badge -->
            <div id="floating-trip-badge" class="absolute top-4 left-14 z-[400] bg-white/95 backdrop-blur-md px-3.5 py-2 rounded-xl shadow-lg border border-slate-200/80 text-xs transition-all pointer-events-none hidden sm:flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <span id="trip-badge-indicator" class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                    <span id="trip-badge-title" class="font-bold text-slate-800">Menampilkan Semua Trip</span>
                </div>
                <span class="text-slate-300">|</span>
                <span id="trip-badge-distance" class="text-slate-600">85,6 km</span>
                <span class="text-slate-300">|</span>
                <span id="trip-badge-fuel" class="font-semibold text-amber-600">10,3 Liter</span>
            </div>

            <!-- Floating Map Legend -->
            <div class="absolute bottom-6 right-6 z-[400] bg-white/95 backdrop-blur-md p-4 rounded-xl shadow-xl border border-slate-200/90 max-w-xs text-xs space-y-3">
                <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                    <span class="font-bold text-slate-900 tracking-tight flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A2 2 0 013 15.485V5.515a2 2 0 011.553-1.956L9 2m0 18l6 3m-6-3V2m6 21l5.447-2.724A2 2 0 0021 18.485V8.515a2 2 0 00-1.553-1.956L15 5m0 16V5m0 0L9 2"></path></svg>
                        Legenda Peta WebGIS
                    </span>
                    <span class="text-[10px] text-slate-400">Trayek Cilegon – Serang</span>
                </div>

                <div class="space-y-2">
                    <!-- Trip 1 -->
                    <div class="flex items-center justify-between cursor-pointer hover:bg-slate-50 p-1 rounded" onclick="filterTrip(1)">
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-1.5 rounded-full bg-blue-600 inline-block"></span>
                            <span class="font-semibold text-slate-800">Trip 1 (Pagi 06:20)</span>
                        </div>
                        <span class="text-[11px] font-mono text-slate-500">28.58 km | 8.29 km/L</span>
                    </div>

                    <!-- Trip 2 -->
                    <div class="flex items-center justify-between cursor-pointer hover:bg-slate-50 p-1 rounded" onclick="filterTrip(2)">
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                            <span class="font-semibold text-slate-800">Trip 2 (Siang 11:34)</span>
                        </div>
                        <span class="text-[11px] font-mono text-emerald-600 font-semibold">28.60 km | 8.67 km/L</span>
                    </div>

                    <!-- Trip 3 -->
                    <div class="flex items-center justify-between cursor-pointer hover:bg-slate-50 p-1 rounded" onclick="filterTrip(3)">
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-1.5 rounded-full bg-amber-500 inline-block"></span>
                            <span class="font-semibold text-slate-800">Trip 3 (Sore 15:00)</span>
                        </div>
                        <span class="text-[11px] font-mono text-rose-600 font-semibold">28.43 km | 8.03 km/L</span>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-200/80 space-y-1.5">
                    <div class="flex items-center gap-2">
                        <div class="w-3.5 h-3.5 rounded-full bg-emerald-600 border border-white shadow-sm flex items-center justify-center text-[8px] text-white font-bold">A</div>
                        <span class="text-slate-600 text-[11px]">Titik Awal (Cilegon, Pagi/Siang/Sore)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3.5 h-3.5 rounded-full bg-rose-600 border border-white shadow-sm flex items-center justify-center text-[8px] text-white font-bold">B</div>
                        <span class="text-slate-600 text-[11px]">Titik Akhir (Serang, Selesai Perjalanan)</span>
                    </div>
                    <div id="legend-speed-wrapper" class="hidden pt-1.5 border-t border-slate-100">
                        <div class="text-[10px] font-semibold text-slate-400 mb-1">Kecepatan GPS (km/jam):</div>
                        <div class="flex items-center justify-between text-[10px] text-slate-500">
                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-rose-500 inline-block"></span> &lt; 30 (Macet)</span>
                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-amber-500 inline-block"></span> 30 - 40</span>
                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span> &gt; 40 (Lancar)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trip Comparison Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Tabel Perbandingan Operasional & Efisiensi Setiap Trip</h3>
                    <p class="text-xs text-slate-500">Berdasarkan data atribut spasial pada rute.geojson dan perhitungan konsumsi Biosolar acuan 9,0 km/liter</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-500 font-medium">Satuan Acuan: <strong>9,0 km/liter</strong> | Harga: <strong>Rp6.800/liter</strong></span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-[11px] font-bold text-slate-600 uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">Trip</th>
                            <th class="py-3 px-4">Waktu (Mulai - Selesai)</th>
                            <th class="py-3 px-4 text-center">Durasi</th>
                            <th class="py-3 px-4 text-right">Jarak</th>
                            <th class="py-3 px-4 text-center">Kecepatan (Rata / Maks)</th>
                            <th class="py-3 px-4 text-right">Konsumsi BBM</th>
                            <th class="py-3 px-4 text-center">Efisiensi Aktual</th>
                            <th class="py-3 px-4 text-right">Total Biaya</th>
                            <th class="py-3 px-4 text-right">BBM & Biaya Boros</th>
                            <th class="py-3 px-4 text-center">Evaluasi</th>
                            <th class="py-3 px-4 text-center">Aksi Peta</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($trips as $trip)
                            @php
                                $tId = $trip['trip_id'] ?? 1;
                                $colorClass = $tId == 1 ? 'border-l-4 border-blue-500' : ($tId == 2 ? 'border-l-4 border-emerald-500' : 'border-l-4 border-amber-500');
                                $isMostEfficient = ($tId == 2);
                                $isLeastEfficient = ($tId == 3);
                            @endphp
                            <tr id="table-row-{{ $tId }}" class="hover:bg-slate-50/80 transition-colors {{ $colorClass }}">
                                <td class="py-3.5 px-4 font-bold text-slate-900 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span class="w-6 h-6 rounded-full {{ $tId == 1 ? 'bg-blue-100 text-blue-700' : ($tId == 2 ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700') }} flex items-center justify-center font-bold text-xs">
                                            {{ $tId }}
                                        </span>
                                        <div>
                                            <div class="font-bold">{{ $trip['nama'] ?? 'Trip '.$tId }}</div>
                                            <div class="text-[10px] text-slate-400">{{ $trip['arah'] ?? 'Cilegon ke Serang' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <div class="font-medium text-slate-800">{{ $trip['jam_mulai'] ?? '-' }} - {{ $trip['jam_selesai'] ?? '-' }} WIB</div>
                                    <div class="text-[11px] text-slate-500">{{ $trip['hari'] ?? 'Senin' }}, {{ $trip['tanggal'] ?? '03-03-2025' }}</div>
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    <span class="font-semibold text-slate-800">{{ number_format($trip['durasi_menit'] ?? 0, 1, ',', '.') }}</span> menit
                                </td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap font-bold text-slate-900">
                                    {{ number_format($trip['jarak_km'] ?? 0, 2, ',', '.') }} km
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    <span class="font-semibold text-slate-800">{{ number_format($trip['kecepatan_rata'] ?? 0, 1, ',', '.') }}</span> / 
                                    <span class="text-slate-500">{{ number_format($trip['kecepatan_maks'] ?? 0, 1, ',', '.') }}</span> km/jam
                                </td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap font-bold text-amber-700">
                                    {{ number_format($trip['liter_total'] ?? 0, 2, ',', '.') }} L
                                    <div class="text-[10px] font-normal text-slate-500">{{ number_format($trip['liter_per_100km'] ?? 0, 2, ',', '.') }} L/100km</div>
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap font-bold">
                                    <span class="px-2 py-0.5 rounded text-xs {{ $isMostEfficient ? 'bg-emerald-100 text-emerald-800' : ($isLeastEfficient ? 'bg-rose-100 text-rose-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ number_format($trip['km_per_liter'] ?? 0, 2, ',', '.') }} km/L
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap font-semibold text-slate-900">
                                    Rp{{ number_format($trip['biaya_rp'] ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <span class="font-bold text-rose-600">{{ number_format($trip['liter_boros'] ?? 0, 2, ',', '.') }} L</span>
                                    <div class="text-[10px] text-rose-500 font-semibold">Rp{{ number_format($trip['biaya_boros_rp'] ?? 0, 0, ',', '.') }}</div>
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    @if($isMostEfficient)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Paling Efisien (Siang)
                                        </span>
                                    @elseif($isLeastEfficient)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            Paling Boros (Sore)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                            Sedang (Pagi)
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    <button type="button" onclick="focusTripOnMap({{ $tId }})" class="px-2.5 py-1 rounded bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-700 font-semibold text-[11px] transition-colors inline-flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Fokus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-slate-100/80 font-bold text-slate-900 border-t-2 border-slate-300">
                        <tr>
                            <td class="py-3 px-4" colspan="2">TOTAL KESELURUHAN (1 HARI)</td>
                            <td class="py-3 px-4 text-center">140,0 menit</td>
                            <td class="py-3 px-4 text-right">85,6 km</td>
                            <td class="py-3 px-4 text-center">37,1 km/jam (Rata)</td>
                            <td class="py-3 px-4 text-right text-amber-800">10,3 L</td>
                            <td class="py-3 px-4 text-center text-blue-800">8,31 km/L</td>
                            <td class="py-3 px-4 text-right text-emerald-800">Rp69.923</td>
                            <td class="py-3 px-4 text-right text-rose-800">0,8 L (Rp5.234)</td>
                            <td class="py-3 px-4 text-center text-rose-700">Deviasi: -7,7%</td>
                            <td class="py-3 px-4 text-center">
                                <button type="button" onclick="filterTrip('all')" class="px-2.5 py-1 rounded bg-slate-900 text-white font-semibold text-[11px]">
                                    Semua
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Charts Grid (4 Analytical Visualizations) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Chart 1: Konsumsi BBM & BBM Boros per Trip -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">1. Konsumsi BBM & Pemborosan per Trip</h4>
                        <p class="text-xs text-slate-500">Volume BBM terpakai vs porsi pemborosan terhadap acuan 9 km/liter</p>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">Liter</span>
                </div>
                <div class="h-64">
                    <canvas id="chart-fuel-consumption"></canvas>
                </div>
            </div>

            <!-- Chart 2: Efisiensi Aktual vs Acuan 9.0 km/L -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">2. Efisiensi Bahan Bakar Aktual vs Acuan</h4>
                        <p class="text-xs text-slate-500">Perbandingan km/liter tiap trip dengan garis batas acuan standar</p>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">km/Liter</span>
                </div>
                <div class="h-64">
                    <canvas id="chart-efficiency-benchmark"></canvas>
                </div>
            </div>

            <!-- Chart 3: Profil Kecepatan GPS per Detik dari gps_mentah.csv -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">3. Profil Kecepatan GPS (gps_mentah.csv)</h4>
                        <p class="text-xs text-slate-500">Analisis fluktuasi kecepatan setiap interval 30 detik (283 titik pengamatan)</p>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">km/jam</span>
                </div>
                <div class="h-64">
                    <canvas id="chart-speed-profile"></canvas>
                </div>
            </div>

            <!-- Chart 4: Biaya Operasional BBM & Penghematan Potensial -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">4. Analisis Biaya Operasional BBM (Rupiah)</h4>
                        <p class="text-xs text-slate-500">Biaya dasar acuan vs biaya pemborosan akibat ketidakefisienan rute</p>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Rupiah (Rp)</span>
                </div>
                <div class="h-64">
                    <canvas id="chart-cost-breakdown"></canvas>
                </div>
            </div>

        </div>

        <!-- Academic Analysis & Insights Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200 space-y-2.5">
                <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm">
                    01
                </div>
                <h4 class="text-sm font-bold text-slate-900">Pengaruh Jam Operasional (Pagi vs Siang vs Sore)</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Trip 2 pada siang hari (11:34) mencatatkan efisiensi tertinggi yaitu <strong>8,67 km/liter</strong> dengan durasi tercepat (<strong>40 menit</strong>) dan kecepatan rata-rata tertinggi (<strong>42,9 km/jam</strong>). Sebaliknya, Trip 3 pada jam sibuk sore (15:00) mengalami hambatan lalu lintas dengan durasi terpanjang (<strong>52,5 menit</strong>) dan konsumsi BBM paling boros (<strong>8,03 km/liter</strong>).
                </p>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200 space-y-2.5">
                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">
                    02
                </div>
                <h4 class="text-sm font-bold text-slate-900">Analisis Deviasi terhadap Standar Acuan 9 km/L</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Berdasarkan perhitungan aktual (85,6 km / 10,3 L = <strong>8,31 km/liter</strong>), unit Pickup K-06 mengalami defisit efisiensi sebesar <strong>-7,67%</strong> di bawah standar acuan 9,0 km/liter. Total pemborosan bahan bakar adalah <strong>0,8 liter Biosolar</strong> atau setara dengan <strong>Rp5.234</strong> untuk 3 trip dalam satu hari kerja.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200 space-y-2.5">
                <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-sm">
                    03
                </div>
                <h4 class="text-sm font-bold text-slate-900">Rekomendasi Manajemen Rute & Eco-Driving</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Untuk mencapai efisiensi target 9,0 km/liter, disarankan melakukan penjadwalan armada di luar jam puncak sore hari Serang–Cilegon, mempertahankan kecepatan jelajah optimal di rentang 40–50 km/jam, dan meminimalkan siklus akselerasi-deselerasi mendadak sebagaimana terindikasi pada profil kecepatan GPS mentah.
                </p>
            </div>
        </div>

    </main>

    <!-- Raw GPS Data Modal -->
    <div id="gps-modal" class="fixed inset-0 z-[1000] bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden">
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-slate-900 text-white flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Inspeksi Data Mentah GPS (gps_mentah.csv)
                    </h3>
                    <p class="text-xs text-slate-400">Total 283 titik koordinat telematika rekaman perjalanan Pickup K-06</p>
                </div>
                <button type="button" onclick="closeGpsModal()" class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Modal Filter & Stats Bar -->
            <div class="px-6 py-3 bg-slate-50 border-b border-slate-200 flex flex-wrap items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2">
                    <label class="font-semibold text-slate-700">Filter Trip:</label>
                    <select id="modal-trip-filter" onchange="filterModalGpsTable()" class="bg-white border border-slate-300 rounded px-2.5 py-1 text-xs">
                        <option value="all">Semua Trip (283 Titik)</option>
                        <option value="1">Trip 1 (96 Titik)</option>
                        <option value="2">Trip 2 (81 Titik)</option>
                        <option value="3">Trip 3 (106 Titik)</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="text" id="modal-search" onkeyup="filterModalGpsTable()" placeholder="Cari waktu / koordinat..." class="bg-white border border-slate-300 rounded px-3 py-1 text-xs w-48">
                    <span id="modal-row-count" class="text-slate-500 font-medium">Menampilkan: 283 titik</span>
                </div>
            </div>

            <!-- Modal Table -->
            <div class="flex-1 overflow-y-auto p-6">
                <table class="w-full text-left text-xs text-slate-700" id="raw-gps-table">
                    <thead class="bg-slate-100 sticky top-0 text-[11px] font-bold text-slate-600 uppercase tracking-wider">
                        <tr>
                            <th class="py-2.5 px-3">No</th>
                            <th class="py-2.5 px-3">Trip</th>
                            <th class="py-2.5 px-3">Waktu (WIB)</th>
                            <th class="py-2.5 px-3">Latitude</th>
                            <th class="py-2.5 px-3">Longitude</th>
                            <th class="py-2.5 px-3 text-right">Kecepatan (km/jam)</th>
                            <th class="py-2.5 px-3 text-right">Jarak Segmen (km)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-mono text-[11px]" id="raw-gps-tbody">
                    </tbody>
                </table>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 flex justify-between items-center text-xs">
                <span class="text-slate-500">Sumber: <code>public/data/gps_mentah.csv</code></span>
                <button type="button" onclick="closeGpsModal()" class="px-4 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-900 text-white font-semibold">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white border-t border-slate-800 mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
            <div>
                <span class="font-bold text-white">Tugas Minggu 5 - Sistem Informasi Geografis (WebGIS)</span>
                <span class="mx-2">•</span>
                <span>Program Studi Teknik / Sistem Informasi</span>
            </div>
            <div class="text-center sm:text-right">
                Dikembangkan oleh <strong class="text-white">Ryan Adiputra Darmawan</strong> (Kode CaAs: <strong class="text-emerald-400">2671</strong>)
            </div>
        </div>
    </footer>

    <!-- Scripts: Leaflet & Chart.js -->
    <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('vendor/chartjs/chart.min.js') }}"></script>

    <!-- Data Injection from Controller -->
    <script>
        window.WEBGIS_DATA = {
            ringkasan: @json($ringkasan),
            ruteGeoJson: @json($ruteGeoJson),
            titikUjungGeoJson: @json($titikUjungGeoJson),
            gpsData: @json($gpsData),
            trips: @json($trips),
            studentInfo: @json($studentInfo)
        };
    </script>

    <!-- WebGIS Main Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            initWebGisApp();
        });

        // Global map state
        let map;
        let basemaps = {};
        let currentBasemap;
        let ruteLayers = {};
        let endpointLayers = {};
        let rawGpsLayers = {};
        let gpsPointsLayerGroup = L.layerGroup();
        let allTripBounds = L.latLngBounds([]);
        let activeTripFilter = 'all';

        // Colors per trip
        const tripColors = {
            1: '#2563eb', // Blue
            2: '#059669', // Emerald
            3: '#d97706'  // Amber
        };

        const tripNames = {
            1: 'Trip 1 (Pagi: 06:20)',
            2: 'Trip 2 (Siang: 11:34)',
            3: 'Trip 3 (Sore: 15:00)'
        };

        function initWebGisApp() {
            initLeafletMap();
            loadRuteGeoJson();
            loadTitikUjungGeoJson();
            loadRawGpsPoints();
            initCharts();
            populateGpsModalTable();
        }

        function initLeafletMap() {
            basemaps = {
                'carto-light': L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="https://carto.com/">CARTO</a> &copy; OpenStreetMap'
                }),
                'osm': L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }),
                'satellite': L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 19,
                    attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS'
                }),
                'carto-dark': L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="https://carto.com/">CARTO</a>'
                })
            };

            map = L.map('map', {
                center: [-6.06, 106.10],
                zoom: 12,
                layers: [basemaps['carto-light']]
            });
            currentBasemap = basemaps['carto-light'];

            L.control.scale({ imperial: false, position: 'bottomleft' }).addTo(map);

            gpsPointsLayerGroup.addTo(map);
            map.removeLayer(gpsPointsLayerGroup);

            document.getElementById('toggle-gps-points').addEventListener('change', function (e) {
                const legendSpeed = document.getElementById('legend-speed-wrapper');
                if (e.target.checked) {
                    map.addLayer(gpsPointsLayerGroup);
                    if (legendSpeed) legendSpeed.classList.remove('hidden');
                } else {
                    map.removeLayer(gpsPointsLayerGroup);
                    if (legendSpeed) legendSpeed.classList.add('hidden');
                }
            });
        }

        function changeBasemap(key) {
            if (basemaps[key]) {
                map.removeLayer(currentBasemap);
                map.addLayer(basemaps[key]);
                currentBasemap = basemaps[key];
            }
        }

        function loadRuteGeoJson() {
            const geojsonData = window.WEBGIS_DATA.ruteGeoJson;
            if (!geojsonData || !geojsonData.features) return;

            geojsonData.features.forEach(function (feature) {
                const props = feature.properties;
                const tripId = props.trip_id;
                const color = tripColors[tripId] || '#2563eb';

                const layer = L.geoJSON(feature, {
                    style: {
                        color: color,
                        weight: 5,
                        opacity: 0.85,
                        lineJoin: 'round',
                        lineCap: 'round'
                    },
                    onEachFeature: function (feat, lyr) {
                        const p = feat.properties;
                        const popupHtml = `
                            <div class="p-4 space-y-2.5 max-w-xs text-xs">
                                <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full" style="background-color: ${color}"></span>
                                        <strong class="text-slate-900 text-sm">${p.nama || 'Trip ' + tripId}</strong>
                                    </div>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700">${p.arah || 'Cilegon - Serang'}</span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-slate-600">
                                    <div>
                                        <span class="text-[10px] text-slate-400 block">Jam Operasional:</span>
                                        <strong class="text-slate-800">${p.jam_mulai} - ${p.jam_selesai}</strong>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 block">Durasi Tempuh:</span>
                                        <strong class="text-slate-800">${p.durasi_menit} menit</strong>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 block">Jarak Tempuh:</span>
                                        <strong class="text-slate-800">${p.jarak_km} km</strong>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 block">Kecepatan Rata-rata:</span>
                                        <strong class="text-slate-800">${p.kecepatan_rata} km/jam</strong>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 block">Konsumsi Biosolar:</span>
                                        <strong class="text-amber-700">${p.liter_total} Liter</strong>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 block">Efisiensi Aktual:</span>
                                        <strong class="text-blue-700">${p.km_per_liter} km/L</strong>
                                    </div>
                                </div>
                                <div class="p-2 rounded bg-rose-50 border border-rose-200 text-rose-800 flex justify-between">
                                    <span>Pemborosan BBM:</span>
                                    <strong>${p.liter_boros} L (Rp${Number(p.biaya_boros_rp).toLocaleString('id-ID')})</strong>
                                </div>
                                <div class="flex justify-between items-center text-[11px] font-semibold text-slate-700 pt-1">
                                    <span>Total Biaya Trip:</span>
                                    <strong class="text-emerald-700 text-sm">Rp${Number(p.biaya_rp).toLocaleString('id-ID')}</strong>
                                </div>
                            </div>
                        `;
                        lyr.bindPopup(popupHtml);

                        lyr.on('mouseover', function () {
                            lyr.setStyle({ weight: 8, opacity: 1.0 });
                        });
                        lyr.on('mouseout', function () {
                            lyr.setStyle({ weight: 5, opacity: 0.85 });
                        });
                    }
                });

                layer.addTo(map);
                ruteLayers[tripId] = layer;

                const bounds = layer.getBounds();
                allTripBounds.extend(bounds);
            });

            if (allTripBounds.isValid()) {
                map.fitBounds(allTripBounds, { padding: [40, 40] });
            }
        }

        function loadTitikUjungGeoJson() {
            const geojsonData = window.WEBGIS_DATA.titikUjungGeoJson;
            if (!geojsonData || !geojsonData.features) return;

            geojsonData.features.forEach(function (feature) {
                const props = feature.properties;
                const tripId = props.trip_id;
                const isStart = props.jenis === 'Titik Awal';
                const coords = [feature.geometry.coordinates[1], feature.geometry.coordinates[0]];

                const iconHtml = isStart
                    ? `<div class="custom-start-marker pulse-marker" style="width: 26px; height: 26px;">A</div>`
                    : `<div class="custom-end-marker pulse-marker" style="width: 26px; height: 26px;">B</div>`;

                const customIcon = L.divIcon({
                    html: iconHtml,
                    className: 'custom-leaflet-marker',
                    iconSize: [26, 26],
                    iconAnchor: [13, 13]
                });

                const marker = L.marker(coords, { icon: customIcon });

                const popupHtml = `
                    <div class="p-3 text-xs space-y-2 max-w-xs">
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold ${isStart ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'}">
                                ${props.jenis}
                            </span>
                            <strong class="text-slate-900 font-bold">Trip ${tripId}</strong>
                        </div>
                        <div class="space-y-1 text-slate-600">
                            <div><strong>Waktu:</strong> ${props.waktu} WIB</div>
                            <div><strong>Jarak Trip:</strong> ${props.jarak_km} km</div>
                            <div><strong>Total Biaya:</strong> Rp${Number(props.biaya_rp).toLocaleString('id-ID')}</div>
                            <div class="text-[10px] text-slate-400 font-mono">Koordinat: ${coords[0].toFixed(5)}, ${coords[1].toFixed(5)}</div>
                        </div>
                    </div>
                `;
                marker.bindPopup(popupHtml);

                marker.addTo(map);

                if (!endpointLayers[tripId]) {
                    endpointLayers[tripId] = [];
                }
                endpointLayers[tripId].push(marker);
            });
        }

        function loadRawGpsPoints() {
            const gpsData = window.WEBGIS_DATA.gpsData;
            if (!gpsData || !gpsData.points_by_trip) return;

            Object.keys(gpsData.points_by_trip).forEach(function (tripId) {
                const points = gpsData.points_by_trip[tripId];
                rawGpsLayers[tripId] = [];

                points.forEach(function (pt) {
                    const spd = pt.kecepatan_kmh;
                    let color = '#ef4444';
                    if (spd >= 40) {
                        color = '#10b981';
                    } else if (spd >= 30) {
                        color = '#f59e0b';
                    }

                    const circle = L.circleMarker([pt.latitude, pt.longitude], {
                        radius: 3.5,
                        fillColor: color,
                        color: '#ffffff',
                        weight: 1,
                        opacity: 0.9,
                        fillOpacity: 0.85
                    });

                    circle.bindTooltip(`Trip ${tripId} | Waktu: ${pt.waktu.split(' ')[1]} | Kec: ${spd} km/h`, {
                        direction: 'top',
                        offset: [0, -4]
                    });

                    gpsPointsLayerGroup.addLayer(circle);
                    rawGpsLayers[tripId].push(circle);
                });
            });
        }

        function filterTrip(tripId) {
            activeTripFilter = tripId;

            document.querySelectorAll('.trip-filter-btn').forEach(function (btn) {
                btn.className = 'trip-filter-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200';
            });

            const activeBtn = document.getElementById(tripId === 'all' ? 'btn-filter-all' : 'btn-filter-' + tripId);
            if (activeBtn) {
                activeBtn.className = 'trip-filter-btn px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all bg-slate-900 text-white shadow-sm border border-slate-900';
            }

            const badge = document.getElementById('floating-trip-badge');
            const title = document.getElementById('trip-badge-title');
            const distance = document.getElementById('trip-badge-distance');
            const fuel = document.getElementById('trip-badge-fuel');
            const indicator = document.getElementById('trip-badge-indicator');

            if (tripId === 'all') {
                Object.keys(ruteLayers).forEach(function (tid) {
                    if (!map.hasLayer(ruteLayers[tid])) map.addLayer(ruteLayers[tid]);
                });
                Object.keys(endpointLayers).forEach(function (tid) {
                    endpointLayers[tid].forEach(m => { if (!map.hasLayer(m)) map.addLayer(m); });
                });

                if (title) title.innerText = 'Menampilkan Semua Trip (3 Trip)';
                if (distance) distance.innerText = '85,6 km';
                if (fuel) fuel.innerText = '10,3 Liter';
                if (indicator) indicator.style.backgroundColor = '#2563eb';

                if (allTripBounds.isValid()) {
                    map.fitBounds(allTripBounds, { padding: [40, 40] });
                }

                document.querySelectorAll('tr[id^="table-row-"]').forEach(r => r.classList.remove('bg-blue-50/60', 'ring-2', 'ring-blue-400'));
            } else {
                Object.keys(ruteLayers).forEach(function (tid) {
                    if (tid == tripId) {
                        if (!map.hasLayer(ruteLayers[tid])) map.addLayer(ruteLayers[tid]);
                    } else {
                        if (map.hasLayer(ruteLayers[tid])) map.removeLayer(ruteLayers[tid]);
                    }
                });

                Object.keys(endpointLayers).forEach(function (tid) {
                    endpointLayers[tid].forEach(m => {
                        if (tid == tripId) {
                            if (!map.hasLayer(m)) map.addLayer(m);
                        } else {
                            if (map.hasLayer(m)) map.removeLayer(m);
                        }
                    });
                });

                if (ruteLayers[tripId]) {
                    const bounds = ruteLayers[tripId].getBounds();
                    map.fitBounds(bounds, { padding: [50, 50] });
                }

                const tripMeta = (window.WEBGIS_DATA.trips || []).find(t => t.trip_id == tripId) || {};
                if (title) title.innerText = tripNames[tripId] || 'Trip ' + tripId;
                if (distance) distance.innerText = (tripMeta.jarak_km || 28.5) + ' km';
                if (fuel) fuel.innerText = (tripMeta.liter_total || 3.4) + ' Liter';
                if (indicator) indicator.style.backgroundColor = tripColors[tripId] || '#2563eb';

                document.querySelectorAll('tr[id^="table-row-"]').forEach(r => r.classList.remove('bg-blue-50/60', 'ring-2', 'ring-blue-400'));
                const targetRow = document.getElementById('table-row-' + tripId);
                if (targetRow) {
                    targetRow.classList.add('bg-blue-50/60', 'ring-2', 'ring-blue-400');
                    targetRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            }
        }

        function focusTripOnMap(tripId) {
            filterTrip(tripId);
            if (ruteLayers[tripId]) {
                ruteLayers[tripId].openPopup();
            }
            window.scrollTo({ top: document.getElementById('map').offsetTop - 80, behavior: 'smooth' });
        }

        function resetMapBounds() {
            filterTrip('all');
        }

        function initCharts() {
            const trips = window.WEBGIS_DATA.trips || [];
            const labels = ['Trip 1 (Pagi)', 'Trip 2 (Siang)', 'Trip 3 (Sore)'];
            const fuelTotals = trips.map(t => t.liter_total || 0);
            const fuelWasted = trips.map(t => t.liter_boros || 0);
            const efficiencies = trips.map(t => t.km_per_liter || 0);
            const benchmark = 9.0;
            const costs = trips.map(t => t.biaya_rp || 0);
            const costWasted = trips.map(t => t.biaya_boros_rp || 0);

            // Chart 1: Konsumsi BBM & BBM Boros
            const ctxFuel = document.getElementById('chart-fuel-consumption');
            if (ctxFuel) {
                new Chart(ctxFuel, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'BBM Efisien Sesuai Acuan (Liter)',
                                data: fuelTotals.map((tot, idx) => Math.max(0, tot - fuelWasted[idx])),
                                backgroundColor: '#3b82f6',
                                borderRadius: 6
                            },
                            {
                                label: 'BBM Boros (Liter)',
                                data: fuelWasted,
                                backgroundColor: '#ef4444',
                                borderRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'top', labels: { boxWidth: 12, font: { size: 11 } } },
                            tooltip: {
                                callbacks: {
                                    footer: function (items) {
                                        const tot = fuelTotals[items[0].dataIndex];
                                        return 'Total BBM: ' + tot.toFixed(2) + ' Liter';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: { stacked: true },
                            y: { stacked: true, beginAtZero: true, title: { display: true, text: 'Liter Biosolar' } }
                        }
                    }
                });
            }

            // Chart 2: Efisiensi vs Acuan 9.0 km/L
            const ctxEff = document.getElementById('chart-efficiency-benchmark');
            if (ctxEff) {
                new Chart(ctxEff, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Efisiensi Aktual (km/L)',
                                data: efficiencies,
                                backgroundColor: ['#2563eb', '#10b981', '#f59e0b'],
                                borderRadius: 8,
                                order: 2
                            },
                            {
                                label: 'Standar Acuan (9.0 km/L)',
                                data: [benchmark, benchmark, benchmark],
                                type: 'line',
                                borderColor: '#dc2626',
                                borderWidth: 2,
                                borderDash: [6, 6],
                                pointRadius: 4,
                                pointBackgroundColor: '#dc2626',
                                fill: false,
                                order: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'top', labels: { boxWidth: 12, font: { size: 11 } } }
                        },
                        scales: {
                            y: {
                                min: 7.0,
                                max: 10.0,
                                title: { display: true, text: 'km / liter' }
                            }
                        }
                    }
                });
            }

            // Chart 3: Profil Kecepatan GPS dari gps_mentah.csv
            const ctxSpeed = document.getElementById('chart-speed-profile');
            const gpsSeries = window.WEBGIS_DATA.gpsData ? window.WEBGIS_DATA.gpsData.speed_series_by_trip : null;
            if (ctxSpeed && gpsSeries) {
                const trip1Speeds = (gpsSeries[1] ? gpsSeries[1].speeds : []);
                const trip2Speeds = (gpsSeries[2] ? gpsSeries[2].speeds : []);
                const trip3Speeds = (gpsSeries[3] ? gpsSeries[3].speeds : []);

                const maxLen = Math.max(trip1Speeds.length, trip2Speeds.length, trip3Speeds.length);
                const stepLabels = [];
                for (let i = 1; i <= maxLen; i += 2) {
                    stepLabels.push('+' + ((i - 1) * 30 / 60).toFixed(1) + 'm');
                }

                const s1 = [];
                const s2 = [];
                const s3 = [];
                for (let i = 0; i < maxLen; i += 2) {
                    s1.push(trip1Speeds[i] !== undefined ? trip1Speeds[i] : null);
                    s2.push(trip2Speeds[i] !== undefined ? trip2Speeds[i] : null);
                    s3.push(trip3Speeds[i] !== undefined ? trip3Speeds[i] : null);
                }

                new Chart(ctxSpeed, {
                    type: 'line',
                    data: {
                        labels: stepLabels,
                        datasets: [
                            {
                                label: 'Trip 1 (Pagi - Avg 36.1 km/h)',
                                data: s1,
                                borderColor: '#2563eb',
                                backgroundColor: 'rgba(37, 99, 235, 0.08)',
                                borderWidth: 2,
                                tension: 0.3,
                                pointRadius: 0
                            },
                            {
                                label: 'Trip 2 (Siang - Avg 42.9 km/h)',
                                data: s2,
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.08)',
                                borderWidth: 2,
                                tension: 0.3,
                                pointRadius: 0
                            },
                            {
                                label: 'Trip 3 (Sore - Avg 32.5 km/h)',
                                data: s3,
                                borderColor: '#f59e0b',
                                backgroundColor: 'rgba(245, 158, 11, 0.08)',
                                borderWidth: 2,
                                tension: 0.3,
                                pointRadius: 0
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'top', labels: { boxWidth: 12, font: { size: 11 } } }
                        },
                        scales: {
                            x: { title: { display: true, text: 'Waktu Tempuh Sejak Start (Menit)' } },
                            y: { title: { display: true, text: 'Kecepatan (km/jam)' }, beginAtZero: false, min: 15 }
                        }
                    }
                });
            }

            // Chart 4: Biaya Operasional BBM
            const ctxCost = document.getElementById('chart-cost-breakdown');
            if (ctxCost) {
                new Chart(ctxCost, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Biaya BBM Efisien (Rp)',
                                data: costs.map((c, idx) => c - costWasted[idx]),
                                backgroundColor: '#10b981',
                                borderRadius: 6
                            },
                            {
                                label: 'Biaya BBM Terbuang (Rp)',
                                data: costWasted,
                                backgroundColor: '#f43f5e',
                                borderRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'top', labels: { boxWidth: 12, font: { size: 11 } } },
                            tooltip: {
                                callbacks: {
                                    label: function (ctx) {
                                        return ctx.dataset.label + ': Rp' + ctx.parsed.y.toLocaleString('id-ID');
                                    },
                                    footer: function (items) {
                                        const tot = costs[items[0].dataIndex];
                                        return 'Total Biaya: Rp' + tot.toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        scales: {
                            x: { stacked: true },
                            y: {
                                stacked: true,
                                title: { display: true, text: 'Rupiah (Rp)' },
                                ticks: {
                                    callback: function (val) {
                                        return 'Rp' + (val / 1000) + 'k';
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }

        // GPS Modal Logic
        let rawGpsPointsData = [];
        function populateGpsModalTable() {
            const gpsData = window.WEBGIS_DATA.gpsData;
            if (!gpsData || !gpsData.points_by_trip) return;

            rawGpsPointsData = [];
            Object.keys(gpsData.points_by_trip).forEach(function (tid) {
                gpsData.points_by_trip[tid].forEach(function (p) {
                    rawGpsPointsData.push(p);
                });
            });

            renderModalGpsRows(rawGpsPointsData);
        }

        function renderModalGpsRows(items) {
            const tbody = document.getElementById('raw-gps-tbody');
            if (!tbody) return;

            tbody.innerHTML = '';
            const fragment = document.createDocumentFragment();
            items.forEach(function (p, idx) {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-slate-50 transition-colors';
                tr.innerHTML = `
                    <td class="py-2 px-3 text-slate-500">${idx + 1}</td>
                    <td class="py-2 px-3 font-bold text-slate-800">Trip ${p.trip_id}</td>
                    <td class="py-2 px-3">${p.waktu}</td>
                    <td class="py-2 px-3">${p.latitude.toFixed(6)}</td>
                    <td class="py-2 px-3">${p.longitude.toFixed(6)}</td>
                    <td class="py-2 px-3 text-right font-bold ${p.kecepatan_kmh >= 40 ? 'text-emerald-600' : (p.kecepatan_kmh < 30 ? 'text-rose-600' : 'text-amber-600')}">${p.kecepatan_kmh.toFixed(1)}</td>
                    <td class="py-2 px-3 text-right text-slate-600">${p.jarak_km.toFixed(4)}</td>
                `;
                fragment.appendChild(tr);
            });
            tbody.appendChild(fragment);

            const countEl = document.getElementById('modal-row-count');
            if (countEl) countEl.innerText = 'Menampilkan: ' + items.length + ' titik';
        }

        function filterModalGpsTable() {
            const selectedTrip = document.getElementById('modal-trip-filter').value;
            const query = (document.getElementById('modal-search').value || '').toLowerCase();

            const filtered = rawGpsPointsData.filter(function (p) {
                const matchTrip = (selectedTrip === 'all' || p.trip_id == selectedTrip);
                const matchSearch = !query || p.waktu.toLowerCase().includes(query) ||
                    p.latitude.toString().includes(query) || p.longitude.toString().includes(query);
                return matchTrip && matchSearch;
            });

            renderModalGpsRows(filtered);
        }

        function openGpsModal() {
            const modal = document.getElementById('gps-modal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeGpsModal() {
            const modal = document.getElementById('gps-modal');
            if (modal) modal.classList.add('hidden');
        }
    </script>
</body>
</html>

