@extends('layouts.app-admin')

@section('content')
    <h1 class="text-3xl font-bold text-[#00A181]">Settings</h1>
    <p class="mb-4">Halaman Settings SIMPEG</p>

    <div class="mb-4 mt-8">
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
        <div class="p-8 rounded-b-md bg-white shadow">
            <div data-content="admin" class="tab-content">
                @include('admin.settings.admin.index', ['admins' => $admins ?? null])
            </div>
            <div data-content="jabatan" class="tab-content hidden">
                @include('admin.settings.jabatan.index', ['jabatans' => $jabatans ?? null])
            </div>
            <div data-content="golongan" class="tab-content hidden">
                @include('admin.settings.golongan.index')
            </div>
            <div data-content="unitkerja" class="tab-content hidden">
                @include('admin.settings.unitkerja.index', ['unitkerjas' => $unitkerjas ?? null])
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
                    btn.classList.toggle('bg-[#00A181]', btn.dataset.tab === tabName);
                    btn.classList.toggle('text-white', btn.dataset.tab === tabName);
                    btn.classList.toggle('text-gray-600', btn.dataset.tab !== tabName);
                });

                contents.forEach(content => {
                    const isActive = content.dataset.content === tabName;
                    content.classList.toggle('hidden', !isActive);

                    if (isActive) {
                        setTimeout(() => initializeTabScripts(tabName), 50);
                    }
                });
            }

            function initializeTabScripts(tabName) {
                const currentContent = document.querySelector(`[data-content="${tabName}"]`);
                if (!currentContent) return;

                const checkAll = currentContent.querySelector('.check-all');
                const checkboxes = currentContent.querySelectorAll('.checkbox-item');
                const bulkDeleteBtn = currentContent.querySelector('.bulk-delete-btn');

                // Prevent duplicate listener
                if (bulkDeleteBtn && !bulkDeleteBtn.dataset.listenerAttached) {
                    bulkDeleteBtn.addEventListener('click', function() {
                        const selected = Array.from(checkboxes)
                            .filter(cb => cb.checked)
                            .map(cb => cb.value);

                        if (selected.length === 0) return;

                        Swal.fire({
                            title: 'Yakin ingin menghapus data terpilih?',
                            text: `${selected.length} data akan dihapus!`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = this.dataset.action;

                                // CSRF token
                                const token = document.createElement('input');
                                token.type = 'hidden';
                                token.name = '_token';
                                token.value = this.dataset.token;
                                form.appendChild(token);

                                selected.forEach(id => {
                                    const input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = 'id[]';
                                    input.value = id;
                                    form.appendChild(input);
                                });

                                document.body.appendChild(form);
                                form.submit();
                            }
                        });
                    });

                    bulkDeleteBtn.dataset.listenerAttached = 'true';
                }

                if (checkAll && checkboxes.length) {
                    checkAll.addEventListener('change', function() {
                        checkboxes.forEach(cb => cb.checked = this.checked);
                        updateBulkDeleteButton();
                    });

                    checkboxes.forEach(cb => {
                        cb.addEventListener('change', updateBulkDeleteButton);
                    });

                    function updateBulkDeleteButton() {
                        const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                        if (bulkDeleteBtn) {
                            bulkDeleteBtn.disabled = !anyChecked;
                            bulkDeleteBtn.classList.toggle('opacity-50', !anyChecked);
                            bulkDeleteBtn.classList.toggle('cursor-not-allowed', !anyChecked);
                        }
                    }
                }

                // Handle Single Delete
                currentContent.querySelectorAll('.btn-delete').forEach(button => {
                    if (!button.dataset.listenerAttached) {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            const form = this.closest('form');
                            Swal.fire({
                                title: 'Yakin ingin menghapus?',
                                text: "Data yang dihapus tidak bisa dikembalikan!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Ya, hapus!',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    form.submit();
                                }
                            });
                        });

                        button.dataset.listenerAttached = 'true';
                    }
                });
            }

            tabs.forEach(btn => {
                btn.addEventListener('click', () => activateTab(btn.dataset.tab));
            });

            const savedTab = localStorage.getItem('activeSettingsTab') || 'admin';
            activateTab(savedTab);
        });
    </script>
@endsection
