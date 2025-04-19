<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://unpkg.com/htmx.org@1.9.5"></script>

    @vite('resources/css/app.css')
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .scrollbar-hidden {
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE 10+ */
        }

        .scrollbar-hidden::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }

        #notifBox {
            max-height: min(80vh, 400px);
            /* Tinggi maksimum diperbesar */
            min-height: 200px;
            width: 380px;
            position: absolute;
            right: 0;
            top: calc(100% + 0.5rem);
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: none;
        }

        #notifBox.active {
            display: flex;
            flex-direction: column;
        }

        .notification-list {
            flex: 1;
            overflow-y: auto;
            padding: 0.5rem;
        }

        .notification-modal {
            position: absolute;
            top: 0;
            left: 100%;
            width: 100%;
            height: 100%;
            background: white;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 1rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .modal-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        #notifModalContent {
            flex: 1;
            overflow-y: auto;
        }

        .notification-modal.active {
            transform: translateX(-100%);
        }

        .notification-modal .absolute {
            backdrop-filter: blur(2px);
        }

        .notification-item {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .notification-item:hover {
            background-color: #f3f4f6;
        }


        .preview-image {
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .preview-image:hover {
            transform: scale(1.1);
        }

        /* Preview overlay */
        .image-preview-overlay {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(3px);
        }

        /* Animation */
        @keyframes gentleScale {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1.1);
                opacity: 1;
            }
        }

        .enlarged-image {
            animation: gentleScale 0.3s ease-out;
        }
    </style>
    <script>
        window.asset = function(path) {
            return '{{ asset('') }}' + path;
        }
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body class="bg-gray-100">

    {{-- Navbar --}}

    <nav
        class="fixed top-0 z-4 w-full sm:w-[calc(100%-256px)] sm:ml-64 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-4 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end ">
                    <button id="toggleSidebar" type="button" data-drawer-target="logo-sidebar"
                        data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                </div>

                <div class="flex items-center">
                    <div class="flex items-center ms-4 gap-8 sm:gap-2 relative">
                        <button id="mailButton" type="button"
                            class="cursor-pointer flex sm:mr-8 text-sm bg-transparent rounded-full  focus:ring-gray-300 dark:focus:ring-gray-600 
                                active:scale-90 transition-transform duration-400 ease-in-out">
                            <svg class="h-8 w-8 text-gray-500" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                <polyline points="3 7 12 13 21 7" />
                            </svg>
                        </button>
                        <div id="notifBox">
                            <div id="notificationList" class="notification-list">
                                <!-- Daftar notifikasi akan dimuat di sini -->
                            </div>

                            <div id="notificationModal" class="notification-modal">
                                <div class="modal-content">
                                    <button id="modalBack"
                                        class="cursor-pointer mb-4 flex items-center text-gray-600 hover:text-gray-800">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                        Kembali ke List
                                    </button>
                                    <div id="notifModalContent"></div>
                                </div>
                            </div>
                        </div>


                        <div class="relative">
                            <!-- Button Foto Profil -->
                            <button id="profileButton" type="button"
                                class="cursor-pointer flex text-sm bg-[#F0F0F0] rounded-full  focus:ring-gray-300 dark:focus:ring-gray-600 
                                active:scale-90 transition-transform duration-400 ease-in-out items-center justify-center sm:pr-4 sm:py-2 sm:pl-3 gap-4">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-10 h-10 rounded-full"
                                    src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                    alt="user photo">
                                <h3
                                    class="hidden md:block items-center justify-center font-poppins text-[16px] text-gray-900 font-medium ">
                                    {{ Auth::user()->name }}
                                </h3>
                                <svg id="arrowDown" class="h-8 w-8 text-neutral-500 md:block hidden" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                                <svg id="arrowUp" class="h-8 w-8 text-neutral-500 md:block hidden" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <polyline points="6 15 12 9 18 15" />
                                </svg>
                            </button>


                            <!-- Dropdown Menu -->
                            <div id="profileDropdown"
                                class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg dark:bg-gray-700 dark:shadow-md 
                                opacity-0 scale-95 transform transition-all duration-300 ease-out pointer-events-none">
                                <div class="px-4 py-3 border-b dark:border-gray-600">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ Auth::user()->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-300 truncate">
                                        {{ Auth::user()->email }}
                                    </p>
                                </div>
                                <ul class="py-1">
                                    <li>
                                        <a href="{{ route('admin.profile') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600">
                                            Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.ubahpassword.index') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600">
                                            Ubah Password
                                        </a>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                                            @csrf
                                            <button type="button" id="logoutBtn"
                                                class="cursor-pointer w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-600">
                                                Log Out
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-72  h-screen pt-10 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidebar">
        <button id="closeSidebar"
            class="absolute top-2 right-2 p-2 text-gray-500 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 sm:hidden">
            <span class="sr-only">Close sidebar</span>
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z">
                </path>
            </svg>
        </button>
        <div class="h-full px-8 pb-4 pt-0 overflow-y-auto bg-white dark:bg-gray-800">

            <ul class="space-y-2 font-medium">
                <a href="{{ route('admin.home') }}" class="flex ms-2 md:me-24 items-center mb-8">
                    <img src="{{ asset('image/logo.png') }}" class="h-auto w-16 me-3 md:w-16" alt="FlowBite Logo" />
                    <span
                        class="self-center text-2xl md:text-3xl font-bold sm:text-4xl whitespace-nowrap text-[#555555]">SIMPEG</span>
                </a>
                <li>
                    <a href="{{ route('admin.home') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M3 10.5V21a1 1 0 0 0 1 1h6v-7h4v7h6a1 1 0 0 0 1-1V10.5l-9-7-9 7Z" />
                        </svg>

                        <span class="ms-3">Home</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pegawai.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M12 2a4 4 0 1 1-4 4 4 4 0 0 1 4-4Z" />
                            <path d="M4 20c0-3 4-5 8-5s8 2 8 5v2H4v-2Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Pegawai</span>
                        <span
                            class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300"></span>
                    </a>
                </li>

                <li x-data="{ open: {{ Route::is('admin.cuti.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M12 2a4 4 0 1 1-4 4 4 4 0 0 1 4-4Z" />
                                <path d="M4 20c0-3 4-5 8-5s8 2 8 5v2H4v-2Z" />
                                <path d="M8 10h8v2H8zM8 14h8v2H8z" />
                            </svg>
                            <span class="ms-3">Cuti</span>
                        </div>
                        <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform transform"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <ul x-show="open" x-transition class="pl-8 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.cuti.jeniscuti.index') }}"
                                class="flex items-center gap-2 p-2 text-sm rounded-lg
                                    {{ Request::routeIs('admin.provinsi') ? 'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2l4 -4" />
                                    <path d="M3 6h18" />
                                    <path d="M3 12h6" />
                                    <path d="M3 18h6" />
                                </svg>

                                Jenis Cuti
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.cuti.riwayatcuti.index') }}"
                                class="flex items-center gap-2 p-2 text-sm rounded-lg
                                    {{ Request::routeIs('admin.kabupaten') ? 'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M12 8v4l3 3" />
                                    <circle cx="12" cy="12" r="10" />
                                </svg>

                                Riwayat Cuti
                            </a>
                        </li>

                    </ul>
                </li>
                <li x-data="{ open: {{ Route::is('admin.diklat.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M2 20h20v2H2v-2ZM4 4h16v2H4V4ZM6 8h12v2H6V8ZM8 12h8v2H8v-2Z" />
                            </svg>
                            <span class="ms-3">Diklat</span>
                        </div>
                        <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform transform"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <ul x-show="open" x-transition class="pl-8 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.diklat.master.index') }}"
                                class="flex items-center gap-2 p-2 text-sm rounded-lg
                                    {{ Request::routeIs('admin.provinsi') ? 'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M4 4h16v2H4z" />
                                    <path d="M6 6v14h12V6" />
                                </svg>
                                Master Diklat
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.diklat.riwayat.index') }}"
                                class="flex items-center gap-2 p-2 text-sm rounded-lg
                                    {{ Request::routeIs('admin.kabupaten') ? 'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="3" />
                                    <path d="M19.4 15a7 7 0 00-14.8 0" />
                                    <path d="M4.6 9a9 9 0 0114.8 0" />
                                </svg>
                                Riwayat Diklat
                            </a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="{{ route('admin.mutasi.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            viewBox="0 0 24 24">
                            <polyline points="5 9 2 12 5 15" />
                            <polyline points="9 5 12 2 15 5" />
                            <polyline points="15 19 12 22 9 19" />
                            <polyline points="19 9 22 12 19 15" />
                            <line x1="2" y1="12" x2="22" y2="12" />
                            <line x1="12" y1="2" x2="12" y2="22" />
                        </svg>

                        <span class="flex-1 ms-3 whitespace-nowrap">Mutasi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.kepangkatan.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            viewBox="0 0 24 24">
                            <polyline points="17 11 12 6 7 11" />
                            <polyline points="17 18 12 13 7 18" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Kepangkatan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.laporan') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Laporan</span>
                    </a>
                </li>
                <li x-data="{ open: {{ Route::is('admin.provinsi.*', 'admin.kabupaten.*', 'admin.kecamatan.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M1 6l7-2 7 2 7-2v13l-7 2-7-2-7 2V6" />
                                <path d="M8 4v13" />
                                <path d="M16 6v13" />
                            </svg>
                            <span class="ms-3">Daerah</span>
                        </div>
                        <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform transform"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <ul x-show="open" x-transition class="pl-8 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.provinsi.index') }}"
                                class="flex items-center gap-2 p-2 text-sm rounded-lg
                                    {{ Request::routeIs('admin.provinsi') ? 'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M4 4h16v2H4z" />
                                    <path d="M6 6v14h12V6" />
                                </svg>
                                Provinsi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.kabupaten.index') }}"
                                class="flex items-center gap-2 p-2 text-sm rounded-lg
                                    {{ Request::routeIs('admin.kabupaten') ? 'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="3" />
                                    <path d="M19.4 15a7 7 0 00-14.8 0" />
                                    <path d="M4.6 9a9 9 0 0114.8 0" />
                                </svg>
                                Kabupaten
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.kecamatan.index') }}"
                                class="flex items-center gap-2 p-2 text-sm rounded-lg
                                    {{ Request::routeIs('admin.kecamatan') ? 'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M12 2C8.1 2 5 5.1 5 9c0 5.3 7 13 7 13s7-7.7 7-13c0-3.9-3.1-7-7-7z" />
                                    <circle cx="12" cy="9" r="2.5" />
                                </svg>
                                Kecamatan
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('admin.settings.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="3" />
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Pengaturan</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    {{-- Main Content --}}
    <div class="container mx-auto sm:ml-80">
        <div class="p-8  border-dashed rounded-lg dark:border-gray-700 mt-24">
            @yield('content')
        </div>
    </div>
    <script>
        document.getElementById("toggleSidebar").addEventListener("click", function() {
            document.getElementById("logo-sidebar").classList.toggle("-translate-x-full");
        });

        document.getElementById("closeSidebar").addEventListener("click", function() {
            document.getElementById("logo-sidebar").classList.add("-translate-x-full");
        });

        // untuk buka profile di navbar
        document.addEventListener("DOMContentLoaded", function() {
            const profileButton = document.getElementById("profileButton");
            const profileDropdown = document.getElementById("profileDropdown");
            const arrowUp = document.getElementById("arrowUp");
            const arrowDown = document.getElementById("arrowDown");
            const mailButton = document.getElementById("mailButton");
            const mailDropdown = document.getElementById("mailDropdown");

            function isMobile() {
                return window.innerWidth <= 768;
            }

            function updateArrowVisibility() {
                if (isMobile()) {
                    arrowUp.style.display = "none";
                    arrowDown.style.display = "none";
                } else {
                    arrowUp.style.display = "none";
                    arrowDown.style.display = "block";
                }
            }

            updateArrowVisibility();
            window.addEventListener("resize", updateArrowVisibility);

            profileButton.addEventListener("click", function() {
                if (profileDropdown.classList.contains("opacity-0")) {
                    profileDropdown.classList.remove("opacity-0", "scale-95", "pointer-events-none");
                    profileDropdown.classList.add("opacity-100", "scale-100");
                    if (!isMobile()) {
                        arrowUp.style.display = "block";
                        arrowDown.style.display = "none";
                    }
                } else {
                    profileDropdown.classList.add("opacity-0", "scale-95", "pointer-events-none");
                    profileDropdown.classList.remove("opacity-100", "scale-100");
                    if (!isMobile()) {
                        arrowUp.style.display = "none";
                        arrowDown.style.display = "block";
                    }
                }
            });
            mailButton.addEventListener("click", function() {
                if (mailDropdown.classList.contains("opacity-0")) {
                    mailDropdown.classList.remove("opacity-0", "scale-95", "pointer-events-none");
                    mailDropdown.classList.add("opacity-100", "scale-100");
                } else {
                    mailDropdown.classList.add("opacity-0", "scale-95", "pointer-events-none");
                    mailDropdown.classList.remove("opacity-100", "scale-100");
                }
            });

            document.addEventListener("click", function(event) {
                if (!profileButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.add("opacity-0", "scale-95", "pointer-events-none");
                    profileDropdown.classList.remove("opacity-100", "scale-100");
                    if (!isMobile()) {
                        arrowUp.style.display = "none";
                        arrowDown.style.display = "block";
                    }
                }
                if (!mailButton.contains(event.target) && !mailDropdown.contains(event.target)) {
                    mailDropdown.classList.add("opacity-0", "scale-95", "pointer-events-none");
                    mailDropdown.classList.remove("opacity-100", "scale-100");
                }
            });
        });

        // logout
        document.addEventListener("DOMContentLoaded", function() {
            const logoutBtn = document.getElementById("logoutBtn");
            const logoutForm = document.getElementById("logoutForm");

            if (logoutBtn) {
                logoutBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Yakin ingin logout?',
                        text: "Anda akan keluar dari dashboard.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#00A180',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Logout',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            logoutForm.submit();
                        }
                    });
                });
            }

            // Tampilkan SweetAlert jika logout berhasil
            @if (session('logout_success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Logout Berhasil',
                    text: "{{ session('logout_success') }}",
                    confirmButtonColor: '#00A180'
                });
            @elseif (session('logout_failed'))
                Swal.fire({
                    icon: 'error',
                    title: 'Logout Gagal',
                    text: "{{ session('logout_failed') }}",
                    confirmButtonColor: '#00A180'
                });
            @endif
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Pastikan semua element ada sebelum diakses
            const mailButton = document.getElementById('mailButton');
            const notifBox = document.getElementById('notifBox');
            const notificationList = document.getElementById('notificationList');
            const notificationModal = document.getElementById('notificationModal');

            // Tambahkan pengecekan null
            if (!mailButton || !notifBox || !notificationList || !notificationModal) {
                console.error('Elemen penting tidak ditemukan!');
                return;
            }

            // Toggle notifikasi dengan pengecekan classList
            mailButton.addEventListener('click', (e) => {
                e.stopPropagation();
                if (notifBox) {
                    notifBox.classList.toggle('active');

                    if (notifBox.classList.contains('active') && notificationList.children.length === 0) {
                        loadNotifications();
                    }
                }
            });

            // Tutup saat klik di luar dengan pengecekan null
            document.addEventListener('click', (e) => {
                if (notifBox && mailButton) {
                    if (!notifBox.contains(e.target) && !mailButton.contains(e.target)) {
                        notifBox.classList.remove('active');
                        if (notificationModal) {
                            notificationModal.classList.remove('active');
                        }
                    }
                }
            });

            async function loadNotifications() {
                try {
                    notificationList.innerHTML = '<div class="p-4 text-gray-500">Memuat notifikasi...</div>';

                    const response = await fetch("{{ route('admin.notifikasi') }}", {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    notificationList.innerHTML = data.map(p => `
                        <div class="notification-item open-notif-modal"
                            data-nama="${p.nama}"
                            data-nip="${p.nip}"
                            data-tgl_lahir="${p.tgl_lahir}"
                            data-tgl="${p.tgl_pensiun}"
                            data-sisa="${p.sisa_hari}"
                            data-foto="${p.foto}">
                            <img src="${p.foto}" 
                                class="w-12 h-12 rounded-full object-cover mr-3"
                                onerror="this.src='{{ asset('/image/logo.png') }}'">
                            <div>
                                <div class="font-medium text-gray-900">${p.nama}</div>
                                <div class="text-sm text-gray-500">${p.nip}</div>
                                <div class="text-bold text-yellow-500 mt-1">
                                    Pensiun dalam ${p.sisa_hari} hari
                                </div>
                            </div>
                        </div>
                    `).join('');

                    // Event delegation untuk dynamic elements
                    notificationList.addEventListener('click', (e) => {
                        const target = e.target.closest('.open-notif-modal');
                        if (target && notificationModal) {
                            const dataset = target.dataset;
                            notificationModal.innerHTML = `
                                <div class="space-y-4">
                                    <button id="modalBack" class="cursor-pointer mb-4 flex items-center text-gray-600 hover:text-gray-800">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                        Kembali ke List
                                    </button>
                                    <div class="text-center">
                                       <div class="relative inline-block group">
                        <img src="${dataset.foto || '{{ asset('/image/logo.png') }}'}" 
                            class="preview-image w-24 h-24 rounded-full mx-auto mb-4 object-cover 
                            cursor-pointer transition-transform duration-200 hover:scale-105">
                    </div>
                                        <h2 class="text-xl font-bold text-gray-800">${dataset.nama}</h2>
                                        <p class="text-gray-600">NIP: ${dataset.nip}</p>
                                    </div>
                                    
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                       <div class="flex justify-between items-center">
                                            <span class="font-medium">Tanggal Lahir:</span>
                                            <span class="text-gray-600">${formatTanggalIndoFromISO(dataset.tgl_lahir)}</span>
                                        </div>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="font-medium">Tanggal Pensiun:</span>
                                            <span class="text-gray-600">${formatTanggalIndoFromISO(dataset.tgl)}</span>
                                        </div>

                                        <div class="flex justify-center items-center mt-2">
                                            <span class="font-normal italic text-gray-500">Sisa Waktu</span>
                                        </div>
                                        <div class="flex justify-center items-center mt-2">
                                            <span id="countdownTimer" class="justify-center text-blue-600 font-bold text-[18px]">Menghitung...</span>
                                        </div>

                                    </div>
                                </div>
                            `;
                            // Fungsi preview gambar
                            const previewImage = notificationModal.querySelector('.preview-image');
                            if (previewImage) {
                                previewImage.addEventListener('click', (e) => {
                                    e.stopPropagation();

                                    // Create preview container
                                    const previewContainer = document.createElement('div');
                                    previewContainer.className =
                                        'fixed inset-0 bg-black/50 flex items-center justify-center z-50';

                                    // Wrapper untuk mencegah close saat klik gambar
                                    const imageWrapper = document.createElement('div');
                                    imageWrapper.className = 'relative';

                                    // Gambar bulat
                                    const enlargedImg = document.createElement('img');
                                    enlargedImg.src = previewImage.src;
                                    enlargedImg.className =
                                        'w-80 h-80 object-cover rounded-full shadow-2xl border-4 border-white transition-transform duration-300 transform hover:scale-105';

                                    // Susun elemen
                                    imageWrapper.appendChild(enlargedImg);
                                    previewContainer.appendChild(imageWrapper);
                                    notificationModal.appendChild(previewContainer);

                                    // Tutup preview
                                    const closePreview = () => {
                                        previewContainer.remove();
                                    };

                                    // Tambahkan event klik untuk overlay
                                    previewContainer.addEventListener('click', (e) => {
                                        e
                                            .stopPropagation(); // ⛔ Mencegah event ini naik ke document
                                        closePreview(); // ✅ Cuma tutup preview gambar
                                    });
                                    // Cegah klik di dalam gambar menutup preview
                                    imageWrapper.addEventListener('click', (e) => e
                                        .stopPropagation());

                                    // Ganti ini:
                                    document.body.appendChild(previewContainer); // ⬅️ penting!

                                });
                            }

                            notificationModal.classList.add('active');
                            const countdownEl = document.getElementById('countdownTimer');

                            if (dataset.tgl) {
                                const [year, month, day] = dataset.tgl.split('-');
                                const targetDate = new Date(year, month - 1, day);

                                function updateCountdown() {
                                    const now = new Date();
                                    const totalSeconds = Math.floor((targetDate - now) / 1000);

                                    if (totalSeconds <= 0) {
                                        countdownEl.textContent = 'Sudah Pensiun';
                                        clearInterval(interval);
                                        return;
                                    }

                                    const days = Math.floor(totalSeconds / 86400);
                                    const hours = Math.floor((totalSeconds % 86400) / 3600);
                                    const minutes = Math.floor((totalSeconds % 3600) / 60);
                                    const seconds = totalSeconds % 60;

                                    countdownEl.textContent =
                                        `${days} Hari ${hours} Jam ${minutes} Menit ${seconds} Detik`;
                                }

                                updateCountdown(); // Initial run
                                const interval = setInterval(updateCountdown, 1000);

                                // Clear interval ketika modal ditutup
                                document.getElementById('modalBack')?.addEventListener('click', () => {
                                    clearInterval(interval);
                                    notificationModal.classList.remove('active');
                                });

                            }

                            // Handle tombol kembali
                            document.getElementById('modalBack')?.addEventListener('click', () => {
                                notificationModal.classList.remove('active');
                            });

                        }
                    });

                    function formatTanggalIndoFromISO(isoDate) {
                        const bulanIndo = [
                            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                        ];

                        const [year, month, day] = isoDate.split('-');
                        return `${parseInt(day)} ${bulanIndo[parseInt(month) - 1]} ${year}`;
                    }



                } catch (err) {
                    notificationList.innerHTML = '<div class="p-4 text-red-500">Gagal memuat notifikasi</div>';
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    @stack('scripts')
</body>

</html>
