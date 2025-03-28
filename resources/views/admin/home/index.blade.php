@extends('layouts.app-admin')

@section('content')
    <div class="grid sm:grid-cols-2 gap-4 mb-16">
        <h1 class="flex items-left justify-left sm:text-5xl text-2xl text-[#00A181] font-bold">
            Sistem Informasi Kepegawaian
            Kejaksaan Tinggi Aceh
        </h1>
    </div>
    <div class="flex justify-end w-full sm:w-auto mb-4">
        <button id="filterToggle"
            class=" sm:static sm:px-4 sm:py-2 p-2 bg-[#00A181] text-white  rounded-lg shadow-md focus:outline-none flex items-center justify-center">
            <i class="fas fa-filter text-lg sm:mr-2"></i>
            <span class="hidden sm:inline">Filter</span>
        </button>
    </div>
    <div id="filterContainer"
        class="hidden absolute right-4 mt-2 bg-white dark:bg-gray-800 p-3 rounded-lg shadow-lg w-56 sm:w-64">
        <!-- Filter Kabupaten -->
        <div class="relative w-full mb-2 sm:mb-3 dropdown">
            <i
                class="absolute left-3 top-1/2 -translate-y-1/2 text-blue-500 fas fa-map-marker-alt text-sm sm:text-lg pointer-events-none"></i>
            <select id="filterKabupaten"
                class="appearance-none px-3 py-1 sm:px-4 sm:py-2 pl-8 sm:pl-10 border border-blue-500 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring focus:ring-blue-500 focus:outline-none w-full text-sm sm:text-base">
                <option value="all">Semua Kabupaten</option>
                @foreach ($data as $row)
                    <option value="{{ $row['kabupaten'] }}">{{ $row['kabupaten'] }}</option>
                @endforeach
            </select>
        </div>

        <!-- Sorting -->
        <div class="relative w-full mb-2 sm:mb-3 dropdown">
            <i
                class="absolute left-3 top-1/2 -translate-y-1/2 text-green-500 fas fa-sort-amount-down text-sm sm:text-lg pointer-events-none"></i>
            <select id="sortOrder"
                class="appearance-none px-3 py-1 sm:px-4 sm:py-2 pl-8 sm:pl-10 border border-green-500 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring focus:ring-green-500 focus:outline-none w-full text-sm sm:text-base">
                <option value="default">Urutan Default</option>
                <option value="desc">Besar → Kecil</option>
                <option value="asc">Kecil → Besar</option>
            </select>
        </div>

        <!-- Tema Warna -->
        <div class="relative w-full dropdown">
            <i
                class="absolute left-3 top-1/2 -translate-y-1/2 text-red-500 fas fa-palette text-sm sm:text-lg pointer-events-none"></i>
            <select id="colorTheme"
                class="appearance-none px-3 py-1 sm:px-4 sm:py-2 pl-8 sm:pl-10 border border-red-500 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring focus:ring-red-500 focus:outline-none w-full text-sm sm:text-base">
                <option value="default">Warna Default</option>
                <option value="blue">Biru</option>
                <option value="green">Hijau</option>
                <option value="red">Merah</option>
            </select>
        </div>
    </div>
    <div class="flex flex-col items-center mb-4 w-full">
        <div class="w-full max-w-8xl p-4 bg-white dark:bg-gray-800 rounded-md">
            <canvas id="barChart" class="w-full h-[350px]"></canvas>
        </div>
        <div id="legend"
            class="bg-white w-full p-8 flex flex-wrap sm:justify-center justify-between mt-4 sm:space-x-4 sm:grid sm:grid-cols-8 gap-2 grid grid-cols-3">
        </div>
    </div>
    {{-- <div class="flex items-center justify-center h-48 mb-4 rounded-sm bg-gray-50 dark:bg-gray-800">
        <p class="text-2xl text-gray-400 dark:text-gray-500">
            <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 1v16M1 9h16" />
            </svg>
        </p>
    </div>
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div class="flex items-center justify-center rounded-sm bg-gray-50 h-28 dark:bg-gray-800">
            <p class="text-2xl text-gray-400 dark:text-gray-500">

            </p>
        </div>
        <div class="flex items-center justify-center rounded-sm bg-gray-50 h-28 dark:bg-gray-800">
            <p class="text-2xl text-gray-400 dark:text-gray-500">
                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 1v16M1 9h16" />
                </svg>
            </p>
        </div>
        <div class="flex items-center justify-center rounded-sm bg-gray-50 h-28 dark:bg-gray-800">
            <p class="text-2xl text-gray-400 dark:text-gray-500">
                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 1v16M1 9h16" />
                </svg>
            </p>
        </div>
        <div class="flex items-center justify-center rounded-sm bg-gray-50 h-28 dark:bg-gray-800">
            <p class="text-2xl text-gray-400 dark:text-gray-500">
                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 1v16M1 9h16" />
                </svg>
            </p>
        </div>
    </div>
    <div class="flex items-center justify-center h-48 mb-4 rounded-sm bg-gray-50 dark:bg-gray-800">
        <p class="text-2xl text-gray-400 dark:text-gray-500">
            <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 1v16M1 9h16" />
            </svg>
        </p>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div class="flex items-center justify-center rounded-sm bg-gray-50 h-28 dark:bg-gray-800">
            <p class="text-2xl text-gray-400 dark:text-gray-500">
                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 1v16M1 9h16" />
                </svg>
            </p>
        </div>
        <div class="flex items-center justify-center rounded-sm bg-gray-50 h-28 dark:bg-gray-800">
            <p class="text-2xl text-gray-400 dark:text-gray-500">
                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 1v16M1 9h16" />
                </svg>
            </p>
        </div>
        <div class="flex items-center justify-center rounded-sm bg-gray-50 h-28 dark:bg-gray-800">
            <p class="text-2xl text-gray-400 dark:text-gray-500">
                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 1v16M1 9h16" />
                </svg>
            </p>
        </div>
        <div class="flex items-center justify-center rounded-sm bg-gray-50 h-28 dark:bg-gray-800">
            <p class="text-2xl text-gray-400 dark:text-gray-500">
                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 1v16M1 9h16" />
                </svg>
            </p>
        </div>
    </div> --}}
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('filterToggle').addEventListener('click', () => {
                document.getElementById('filterContainer').classList.toggle('hidden');
            });

            document.addEventListener('click', (event) => {
                const filterContainer = document.getElementById('filterContainer');
                const filterButton = document.getElementById('filterToggle');

                if (!filterButton.contains(event.target) && !filterContainer.contains(event.target)) {
                    filterContainer.classList.add('hidden');
                }
            });
            const ctx = document.getElementById('barChart').getContext('2d');
            const legendContainer = document.getElementById('legend');

            let labels = @json($data->pluck('kabupaten'));
            let values = @json($data->pluck('jumlah'));

            // Warna default
            const colorThemes = {
                default: labels.map((_, i) => `hsl(${(i * 50) % 360}, 70%, 50%)`),
                blue: labels.map(() => `rgba(54, 162, 235, 0.7)`),
                green: labels.map(() => `rgba(75, 192, 192, 0.7)`),
                red: labels.map(() => `rgba(255, 99, 132, 0.7)`)
            };

            let currentColors = [...colorThemes.default];

            function createChart() {
                return new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Pegawai',
                            data: values,
                            backgroundColor: currentColors,
                            borderColor: currentColors.map(color => color.replace("0.7", "1")),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: "Kabupaten",
                                    font: {
                                        size: 16
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: "Jumlah Pegawai",
                                    font: {
                                        size: 16
                                    }
                                },
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {
                                        return value >= 1000 ? value.toLocaleString() : value;
                                    },
                                    stepSize: 50,
                                    suggestedMax: Math.max(...values) > 1000 ? undefined : 1000
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return `${tooltipItem.raw.toLocaleString()} Pegawai`;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            let myChart = createChart();

            function updateLegend() {
                legendContainer.innerHTML = "";
                labels.forEach((label, index) => {
                    let item = document.createElement("div");
                    item.className = "flex items-center space-x-2 text-sm";
                    item.innerHTML =
                        `<div class="w-4 h-4 rounded" style="background-color: ${currentColors[index]}"></div> <span>${label}</span>`;
                    legendContainer.appendChild(item);
                });
            }
            updateLegend();

            // Filter Kabupaten
            document.getElementById('filterKabupaten').addEventListener('change', function() {
                let selected = this.value;
                if (selected === 'all') {
                    myChart.data.labels = labels;
                    myChart.data.datasets[0].data = values;
                    myChart.data.datasets[0].backgroundColor = currentColors;
                } else {
                    let index = labels.indexOf(selected);
                    if (index !== -1) {
                        myChart.data.labels = [labels[index]];
                        myChart.data.datasets[0].data = [values[index]];
                        myChart.data.datasets[0].backgroundColor = [currentColors[index]];
                    }
                }
                myChart.update();
                updateLegend();
            });

            // Sorting
            document.getElementById('sortOrder').addEventListener('change', function() {
                if (this.value === "default") {
                    labels = @json($data->pluck('kabupaten'));
                    values = @json($data->pluck('jumlah'));
                    currentColors = [...colorThemes.default];
                } else {
                    let sorted = labels.map((_, i) => ({
                        label: labels[i],
                        value: values[i],
                        color: currentColors[i]
                    }));
                    sorted.sort((a, b) => this.value === "asc" ? a.value - b.value : b.value - a.value);

                    labels = sorted.map(item => item.label);
                    values = sorted.map(item => item.value);
                    currentColors = sorted.map(item => item.color);
                }

                myChart.destroy();
                myChart = createChart();
                updateLegend();
            });

            // Ganti Tema Warna
            document.getElementById('colorTheme').addEventListener('change', function() {
                currentColors = [...colorThemes[this.value]];
                myChart.data.datasets[0].backgroundColor = currentColors;
                myChart.update();
                updateLegend();
            });
        });
        document.querySelectorAll('.dropdown').forEach(container => {
            let trigger = container.querySelector('.dropdown-trigger');
            let menu = container.querySelector('.dropdown-menu');
            let icon = container.querySelector('.dropdown-icon');

            trigger.addEventListener('click', (event) => {
                event.stopPropagation(); // Mencegah event click bubble ke document
                let isOpen = menu.classList.contains('open');

                // Tutup semua dropdown sebelum membuka yang baru
                document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('open'));
                document.querySelectorAll('.dropdown-icon').forEach(i => i.classList.replace(
                    'fa-chevron-up', 'fa-chevron-down'));

                if (!isOpen) {
                    menu.classList.add('open');
                    icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
                }
            });
        });

        document.addEventListener('click', () => {
            document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('open'));
            document.querySelectorAll('.dropdown-icon').forEach(i => i.classList.replace('fa-chevron-up',
                'fa-chevron-down'));
        });
    </script>
@endpush
