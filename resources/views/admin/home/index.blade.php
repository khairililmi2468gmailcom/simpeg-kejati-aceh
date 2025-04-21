@extends('layouts.app-admin')

@section('content')
    <div class="container mx-auto px-4">

        <h1 class="text-3xl font-bold text-[#00A181]">Dashboard</h1>
        <p class="mb-8 text-gray-500">Halaman dashboard simpeg Kejaksaan Tinggi</p>
        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">
            {{-- Total Pegawai --}}
            <div
                class="relative flex items-center bg-blue-100 border-l-8 border-blue-500 text-blue-800 shadow-lg rounded-xl p-6 pl-20 overflow-hidden">
                <div class="absolute left-2 top-1/2 transform -translate-y-1/2">
                    <i class="fas fa-users fa-3x text-blue-400"></i>
                </div>
                <div>
                    <div class="text-base font-semibold">Total Pegawai</div>
                    <div class="text-3xl font-bold count-up" data-target="{{ $totalPegawai }}">0</div>
                </div>
            </div>

            {{-- Total Unit Kerja --}}
            <div
                class="relative flex items-center bg-green-100 border-l-8 border-green-500 text-green-800 shadow-lg rounded-xl p-6 pl-20 overflow-hidden">
                <div class="absolute left-2 top-1/2 transform -translate-y-1/2">
                    <i class="fas fa-building fa-3x text-green-400"></i>
                </div>
                <div>
                    <div class="text-base font-semibold">Total Unit Kerja</div>
                    <div class="text-3xl font-bold count-up" data-target="{{ $totalUnit }}">0</div>
                </div>
            </div>

            {{-- Total Jabatan --}}
            <div
                class="relative flex items-center bg-yellow-100 border-l-8 border-yellow-500 text-yellow-800 shadow-lg rounded-xl p-6 pl-20 overflow-hidden">
                <div class="absolute left-2 top-1/2 transform -translate-y-1/2">
                    <i class="fas fa-user-tie fa-3x text-yellow-400"></i>
                </div>
                <div>
                    <div class="text-base font-semibold">Total Jabatan</div>
                    <div class="text-3xl font-bold count-up" data-target="{{ $totalJabatan }}">0</div>
                </div>
            </div>

            {{-- Total Golongan --}}
            <div
                class="relative flex items-center bg-red-100 border-l-8 border-red-500 text-red-800 shadow-lg rounded-xl p-6 pl-20 overflow-hidden">
                <div class="absolute left-2 top-1/2 transform -translate-y-1/2">
                    <i class="fas fa-layer-group fa-3x text-red-400"></i>
                </div>
                <div>
                    <div class="text-base font-semibold">Total Golongan</div>
                    <div class="text-3xl font-bold count-up" data-target="{{ $totalGolongan }}">0</div>
                </div>
            </div>
            {{-- Total Diklat --}}
            <div
                class="relative flex items-center bg-orange-100 border-l-8 border-orange-500 text-orange-800 shadow-lg rounded-xl p-6 pl-20 overflow-hidden">
                <div class="absolute left-2 top-1/2 transform -translate-y-1/2">
                    <i class="fas fa-chalkboard-teacher fa-3x text-orange-400"></i>
                </div>
                <div>
                    <div class="text-base font-semibold">Total Diklat</div>
                    <div class="text-3xl font-bold count-up" data-target="{{ $totalDiklat }}">0</div>
                </div>
            </div>
            {{-- Jumlah Provinsi --}}
            <div
                class="relative flex items-center bg-pink-100 border-l-8 border-pink-500 text-pink-800 shadow-lg rounded-xl p-6 pl-20 overflow-hidden">
                <div class="absolute left-2 top-1/2 transform -translate-y-1/2">
                    <i class="fas fa-flag fa-3x text-pink-400"></i>
                </div>
                <div>
                    <div class="text-base font-semibold">Jumlah Provinsi</div>
                    <div class="text-3xl font-bold count-up" data-target="{{ $totalProvinsi }}">0</div>
                </div>
            </div>
            {{-- Jumlah Kabupaten --}}
            <div
                class="relative flex items-center bg-purple-100 border-l-8 border-purple-500 text-purple-800 shadow-lg rounded-xl p-6 pl-20 overflow-hidden">
                <div class="absolute left-2 top-1/2 transform -translate-y-1/2">
                    <i class="fas fa-map-marker-alt fa-3x text-purple-400"></i>
                </div>
                <div>
                    <div class="text-base font-semibold">Jumlah Kabupaten</div>
                    <div class="text-3xl font-bold count-up" data-target="{{ $totalKabupaten }}">0</div>
                </div>
            </div>



            {{-- Jumlah Kecamatan --}}
            <div
                class="relative flex items-center bg-indigo-100 border-l-8 border-indigo-500 text-indigo-800 shadow-lg rounded-xl p-6 pl-20 overflow-hidden">
                <div class="absolute left-2 top-1/2 transform -translate-y-1/2">
                    <i class="fas fa-road fa-3x text-indigo-400"></i>
                </div>
                <div>
                    <div class="text-base font-semibold">Jumlah Kecamatan</div>
                    <div class="text-3xl font-bold count-up" data-target="{{ $totalKecamatan }}">0</div>
                </div>
            </div>
        </div>

        {{-- Filter Toggle Button --}}
        <div class="flex justify-end mb-4">
            <button id="filterButton"
                class="cursor-pointer flex items-center bg-white hover:bg-gray-200 text-gray-700 px-4 py-2 rounded   shadow-2xl ">
                <i class="fas fa-filter mr-2 text-blue-500"></i> Filter
            </button>
        </div>

        {{-- Filters Panel --}}
        <div id="filterDropdown" class="mb-6 hidden">
            <form method="GET" action="{{ route('admin.home') }}" class="bg-white p-6 rounded-md shadow-md">
                <div class="flex flex-col sm:flex-row gap-6 mb-4">
                    {{-- Filter Options --}}
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-gray-700">Pilih Jenis Filter:</label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="filter_type" value="unit" class="filter-type" checked>
                            <span class="ml-2 text-sm text-gray-700">Unit Kerja</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="filter_type" value="warna" class="filter-type">
                            <span class="ml-2 text-sm text-gray-700">Warna</span>
                        </label>
                    </div>

                    {{-- Filter Fields --}}
                    <div class="flex-1 grid grid-cols-1 gap-4" id="filterFields">
                        {{-- Unit Kerja --}}
                        <div class="filter-field" data-filter="unit">
                            <label for="unit_kerja" class="block text-sm font-medium text-gray-700 mb-1">Unit Kerja</label>
                            <select name="unit_kerja" id="unit_kerja"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua</option>
                                @foreach ($unitKerjaList as $unit)
                                    <option value="{{ $unit->kode_kantor }}"
                                        {{ $unitKerjaFilter == $unit->kode_kantor ? 'selected' : '' }}>
                                        {{ $unit->nama_kantor }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Warna --}}
                        <div class="filter-field hidden" data-filter="warna">
                            <label for="warna" class="block text-sm font-medium text-gray-700 mb-1">Warna</label>
                            <select name="warna" id="warna"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                <option value="">Default</option>
                                <option value="unik" {{ request('warna') == 'unik' ? 'selected' : '' }}>Unik</option>
                                <option value="biru" {{ request('warna') == 'biru' ? 'selected' : '' }}>Biru</option>
                                <option value="hijau" {{ request('warna') == 'hijau' ? 'selected' : '' }}>Hijau</option>
                                <option value="merah" {{ request('warna') == 'merah' ? 'selected' : '' }}>Merah</option>
                            </select>

                        </div>
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                            class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow">
                            Terapkan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Bar Chart --}}
        <div class="flex flex-col items-center mb-10 w-full">
            <div class="w-full max-w-8xl p-6 bg-white rounded-2xl shadow-lg">
                <canvas id="barChart" class="w-full h-[200px] max-h-[250px]"></canvas>
            </div>
            <div id="legend"
                class="bg-white w-full p-8 flex-wrap sm:justify-center justify-between mt-4 sm:space-x-4 sm:space-y-4 sm:grid sm:grid-cols-4 gap-2 grid grid-cols-2">
            </div>
        </div>
    </div>
@endsection
<style>
    #barChart {
        width: 100% !important;
        height: auto !important;
    }

    @media (max-width: 768px) {
        #barChart {
            height: 180px !important;
        }
    }
</style>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle filter panel
            document.getElementById('filterButton').addEventListener('click', () => {
                const dropdown = document.getElementById('filterDropdown');
                dropdown.classList.toggle('hidden');
            });

            // Toggle filter field by selected radio
            const radios = document.querySelectorAll('.filter-type');
            radios.forEach(radio => {
                radio.addEventListener('change', () => {
                    document.querySelectorAll('.filter-field').forEach(field => {
                        field.classList.add('hidden');
                    });
                    document.querySelector(`.filter-field[data-filter="${radio.value}"]`).classList
                        .remove('hidden');
                });
            });

            // Chart.js setup
            const labels = {!! json_encode($pegawaiPerUnit->pluck('unit')) !!};
            const data = {!! json_encode($pegawaiPerUnit->pluck('total')) !!};
            const selectedWarna = '{{ request('warna') }}';

            if (labels.length && data.length) {
                const singkatUnit = singkatUnitFactory(labels);
                const shortLabels = labels.map(label => singkatUnit(label));
                const barColors = getBarColors(selectedWarna, data.length);
                const chart = createBarChart(shortLabels, data, barColors, labels);

                // Custom Legend
                const legendContainer = document.getElementById('legend');
                legendContainer.innerHTML = '';
                labels.forEach((label, index) => {
                    const short = singkatUnit(label);
                    const item = document.createElement('div');
                    item.className =
                        'flex items-center gap-2 text-sm bg-gray-100 sm:px-3 px-4 py-4 sm:py-2 rounded shadow-sm';
                    item.innerHTML = `
                    <div class="w-8 h-4 sm:w-6 sm:h-6 rounded" style="background-color: ${barColors[index]}"></div>
                    <div class="flex flex-col">
                        <span class="text-gray-700 font-medium">${short}</span>
                        <span class="text-gray-500 text-xs">${label}</span>
                    </div>
                `;
                    legendContainer.appendChild(item);
                });
            }

            function getBarColors(warna, count) {
                if (warna === 'unik') {
                    const palette = [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                        '#9966FF', '#FF9F40', '#00A181', '#B8860B', '#8B0000', '#00CED1'
                    ];
                    return Array.from({
                        length: count
                    }, (_, i) => palette[i % palette.length]);
                }

                const baseColor = getSingleBarColor(warna);
                return Array(count).fill(baseColor);
            }

            function getSingleBarColor(warna) {
                switch (warna) {
                    case 'biru':
                        return '#3b82f6';
                    case 'hijau':
                        return '#10b981';
                    case 'merah':
                        return '#ef4444';
                    default:
                        return '#00A181';
                }
            }

            function singkatUnitFactory(labels) {
                const hasilInisialUnik = {};
                const grupInisialDasar = {};
                const setInisialFinal = new Set();

                // Fase 1: Buat inisial dasar dan kelompokkan
                labels.forEach(label => {
                    const labelKapital = label.toUpperCase();
                    const kata = labelKapital.split(' ');
                    let inisial = '';

                    if (label.includes('Kejaksaan Negeri')) {
                        inisial = 'KN';
                    } else if (label.includes('Kejaksaan Tinggi')) {
                        inisial = 'KT';
                    } else if (label.includes('Kejaksaan Provinsi')) {
                        inisial = 'KP';
                    }

                    let inisialDasar = '';
                    const kabIndex = kata.indexOf('KABUPATEN');
                    const kotaIndex = kata.indexOf('KOTA');

                    if (kabIndex !== -1 && kata[kabIndex + 1]) {
                        inisialDasar = kata[kabIndex + 1][0];
                        if (kata[kabIndex + 2]) inisialDasar += kata[kabIndex + 2][0];
                    } else if (kotaIndex !== -1 && kata[kotaIndex + 1]) {
                        inisialDasar = kata[kotaIndex + 1][0];
                        if (kata[kotaIndex + 2]) inisialDasar += kata[kotaIndex + 2][0];
                    }

                    inisialDasar = inisialDasar.toUpperCase();
                    const key = `${inisial} ${inisialDasar}`;
                    if (!grupInisialDasar[key]) grupInisialDasar[key] = [];
                    grupInisialDasar[key].push(label);
                });

                // Fase 2: Selesaikan konflik
                for (const [inisialDasar, listLabel] of Object.entries(grupInisialDasar)) {
                    if (listLabel.length === 1) {
                        let inisialFinal = inisialDasar;
                        let i = 1;
                        while (setInisialFinal.has(inisialFinal)) {
                            inisialFinal = inisialDasar + i;
                            i++;
                        }
                        hasilInisialUnik[listLabel[0]] = inisialFinal;
                        setInisialFinal.add(inisialFinal);
                    } else {
                        const kapitalList = listLabel.map(label => label.toUpperCase());
                        listLabel.forEach((label, i) => {
                            const current = kapitalList[i];
                            let pembedaIndex = 0;

                            while (true) {
                                let charPembeda = current[pembedaIndex] || (i + 1).toString();
                                let kandidat = inisialDasar + charPembeda;
                                let loopIndex = pembedaIndex;

                                while (setInisialFinal.has(kandidat)) {
                                    loopIndex++;
                                    charPembeda = current[loopIndex];
                                    if (!charPembeda) {
                                        charPembeda = (i + 1).toString();
                                    }
                                    kandidat = inisialDasar + charPembeda;
                                }

                                hasilInisialUnik[label] = kandidat;
                                setInisialFinal.add(kandidat);
                                break;
                            }
                        });
                    }
                }

                return function(label) {
                    return hasilInisialUnik[label] || label;
                };
            }

            function createBarChart(shortLabels, data, colors, fullLabels) {
                const ctx = document.getElementById('barChart').getContext('2d');
                return new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: shortLabels,
                        datasets: [{
                            label: 'Jumlah Pegawai',
                            data,
                            backgroundColor: colors,
                            borderRadius: 10,
                            barThickness: 30
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Jumlah Pegawai per Unit Kerja',
                                font: {
                                    size: 18,
                                    weight: 'bold'
                                },
                                padding: {
                                    top: 10,
                                    bottom: 20
                                }
                            },
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const fullLabel = fullLabels[context.dataIndex];
                                        return `${fullLabel}: ${context.raw}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        size: 12
                                    },
                                    maxRotation: 60,
                                    minRotation: 0,
                                    autoSkip: window.innerWidth <
                                    768, // autoSkip hanya diaktifkan di mobile
                                    maxTicksLimit: labels.length,
                                    callback: function(value, index, ticks) {
                                        const label = this.getLabelForValue(value);
                                        return label.length > 10 ? label.slice(0, 10) + '…' : label;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Count Up Animation
            const counters = document.querySelectorAll('.count-up');
            const speed = 60;

            counters.forEach(counter => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;
                    const increment = Math.ceil(target / speed);

                    if (count < target) {
                        counter.innerText = count + increment > target ? target : count + increment;
                        setTimeout(updateCount, 20);
                    } else {
                        counter.innerText = target;
                    }
                };

                updateCount();
            });
        });
    </script>
@endpush
