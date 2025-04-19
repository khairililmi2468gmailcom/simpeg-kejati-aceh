@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center bg-white px-4">
        <div class="max-w-2xl text-center">
            <!-- Ilustrasi SVG -->
            <svg class="mx-auto h-64" viewBox="0 0 500 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M166.667 125H133.333C128.477 125 124.333 129.144 124.333 134V166C124.333 170.856 128.477 175 133.333 175H166.667C171.523 175 175.667 170.856 175.667 166V134C175.667 129.144 171.523 125 166.667 125Z"
                    fill="#00A181" />
                <path
                    d="M366.667 125H333.333C328.477 125 324.333 129.144 324.333 134V166C324.333 170.856 328.477 175 333.333 175H366.667C371.523 175 375.667 170.856 375.667 166V134C375.667 129.144 371.523 125 366.667 125Z"
                    fill="#00A181" />
                <path
                    d="M458.333 62.5H41.6667C33.09 62.5 26.0833 69.5067 26.0833 78.0833V221.917C26.0833 230.493 33.09 237.5 41.6667 237.5H458.333C466.91 237.5 473.917 230.493 473.917 221.917V78.0833C473.917 69.5067 466.91 62.5 458.333 62.5Z"
                    stroke="#00A181" stroke-width="8.33333" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M250 175V208.333" stroke="#00A181" stroke-width="8.33333" stroke-linecap="round" />
                <path d="M250 91.6667V125" stroke="#00A181" stroke-width="8.33333" stroke-linecap="round" />
            </svg>

            <h1 class="text-9xl font-bold text-[#00A181] mb-4">404</h1>
            <h2 class="text-3xl font-semibold text-gray-800 mb-4">Halaman Tidak Ditemukan</h2>
            <p class="text-lg text-gray-600 mb-8">
                Oops! Sepertinya halaman yang Anda cari telah menghilang atau tidak tersedia.
            </p>

            <a href="{{ url()->previous() }}"
                class="inline-block px-8 py-3 bg-[#00A181] text-white rounded-lg hover:bg-[#008F70] transition duration-300">
                Kembali ke Halaman Sebelumnya
            </a>
            @if (Auth::check())
                <div class="mt-6">
                    <span class="text-gray-600">atau</span>
                    <a href="{{ route('admin.home') }}" class="ml-2 text-[#00A181] hover:underline">
                        Kembali ke Beranda
                    </a>
                </div>
            @endif


        </div>
    </div>
@endsection
