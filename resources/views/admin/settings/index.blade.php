@extends('layouts.app-admin')

@section('content')
    <h1 class="text-3xl font-bold text-[#00A181]">Settings</h1>
    <p class="mb-4">Halaman Settings SIMPEG</p>

    <div class="mb-4 mt-8">
        <!-- Tab Buttons -->
        <!-- Tab Buttons -->
        <div id="tabs" class="flex space-x-2 border-b border-gray-300 mb-4">
            <button data-tab="admin"
                class="cursor-pointer tab-btn px-4 py-2 rounded-t-lg transition text-gray-600 hover:bg-gray-200 hover:text-black">
                Admin
            </button>
            <button data-tab="jabatan"
                class="cursor-pointer tab-btn px-4 py-2 rounded-t-lg transition text-gray-600 hover:bg-gray-200 hover:text-black ">
                Jabatan
            </button>
            <button data-tab="golongan"
                class="cursor-pointer tab-btn px-4 py-2 rounded-t-lg transition text-gray-600 hover:bg-gray-200 hover:text-black">
                Golongan
            </button>
            <button data-tab="unitkerja"
                class="cursor-pointer tab-btn px-4 py-2 rounded-t-lg transition text-gray-600 hover:bg-gray-200 hover:text-black">
                Unit Kerja
            </button>
        </div>


        <!-- Tab Contents -->
        <div class="p-4 rounded-b-md bg-white shadow">
            <div data-content="admin" class="tab-content">
                @include('admin.settings.admin.index')
            </div>
            <div data-content="jabatan" class="tab-content hidden">
                @include('admin.settings.jabatan.index', ['jabatans' => $jabatans ?? null])
            </div>
            <div data-content="golongan" class="tab-content hidden">
                @include('admin.settings.golongan.index')
            </div>
            <div data-content="unitkerja" class="tab-content hidden">
                @include('admin.settings.unitkerja.index')
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-btn');
            const contents = document.querySelectorAll('.tab-content');

            function activateTab(tabName) {
                localStorage.setItem('activeSettingsTab', tabName);

                tabs.forEach(btn => {
                    if (btn.dataset.tab === tabName) {
                        btn.classList.add('bg-[#00A181]', 'text-white');
                        btn.classList.remove('text-gray-600');
                    } else {
                        btn.classList.remove('bg-[#00A181]', 'text-white');
                        btn.classList.add('text-gray-600');
                    }
                });

                contents.forEach(content => {
                    content.classList.toggle('hidden', content.dataset.content !== tabName);
                });
            }

            tabs.forEach(btn => {
                btn.addEventListener('click', () => {
                    activateTab(btn.dataset.tab);
                });
            });

            const savedTab = localStorage.getItem('activeSettingsTab') || 'admin';
            activateTab(savedTab);
        });
    </script>
@endsection
