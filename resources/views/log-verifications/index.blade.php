@extends('layouts.app')

@section('title', 'Log Verifications')

@section('description')
    Memverifikasi log yang dilakukan oleh bawahan.
@endsection

@section('content')
    <div class="flex flex-col gap-5 mb-6 sm:flex-row sm:justify-between">
        <div class="w-full">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                @yield('title')
            </h3>
            <p class="mt-1 text-gray-500 text-theme-sm dark:text-gray-400">
                @yield('description')
            </p>
        </div>
    </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto p-6">
            <table id="verifications-table">
                <thead>
                    <tr>
                        <th>
                            <span class="flex items-center">
                                No
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Nama Staff
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Tanggal Pengajuan
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Aktivitas
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Bukti Pekerjaan
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Status
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Catatan
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Actions
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($verifications as $verif)
                        @php
                            $filePath = $verif->log->bukti_pekerjaan;
                            $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $verif->log->user->name }}</td>
                            <td>{{ $verif->log->tanggal }}</td>
                            <td class="capitalize">{{ $verif->log->aktivitas }}</td>
                            <td>
                                @if (!$filePath)
                                    <span class="text-gray-500 italic">Belum ada file</span>
                                @elseif (in_array($ext, ['jpg', 'jpeg', 'png']))
                                    <a href="{{ asset('storage/' . $filePath) }}" target="_blank" rel="noopener noreferrer">
                                        <img src="{{ asset('storage/' . $filePath) }}" target="_blank"
                                            class="max-w-40 max-h-40 rounded shadow hover:scale-150 duration-200" />
                                    </a>
                                @else
                                    <a href="{{ asset('storage/' . $filePath) }}" target="_blank"
                                        class="text-white text-sm px-2.5 text-nowrap py-1.5 rounded-xl text-center bg-blue-500">
                                        Download ({{ strtoupper($ext) }})
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if ($verif->status === 'pending')
                                    <span
                                        class="bg-yellow-400 px-2.5 py-1.5 rounded-xl text-white text-xs text-nowrap">Pending</span>
                                @elseif ($verif->status === 'disetujui')
                                    <span class="bg-green-500 px-2.5 py-1.5 rounded-xl text-white text-xs text-nowrap">Di
                                        Setujui</span>
                                @else
                                    <span class="bg-red-500 px-2.5 py-1.5 rounded-xl text-white text-xs text-nowrap">Di
                                        Tolak</span>
                                @endif
                            </td>
                            <td>
                                @if (!empty($verif->notes))
                                    {{ $verif->notes }}
                                @else
                                    <span class="text-gray-500 italic">Tidak ada catatan</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <button data-id="{{ $verif->id }}" data-jenis="disetujui"
                                        class="block text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-200 action"
                                        type="button">
                                        Setuju
                                    </button>
                                    <button data-id="{{ $verif->id }}" data-jenis="ditolak"
                                        class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 action"
                                        type="button">
                                        Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Add & Edit -->
    <div id="modal-action" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div id="modal-dialog" class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (document.getElementById("verifications-table") && typeof simpleDatatables.DataTable !==
                'undefined') {
                const dataTable = new simpleDatatables.DataTable("#verifications-table", {
                    searchable: true,
                });
            }

            const buttonAdd = document.getElementById('button-add');
            const modalAction = document.getElementById('modal-action');
            const modal = new Modal(modalAction);

            function updateSetuju(id) {
                $('#formVerif').on('submit', function(e) {
                    e.preventDefault();

                    const _form = this;
                    const formData = new FormData(_form);

                    $.ajax({
                        method: 'POST',
                        url: `log-verifications/${id}/update-setuju`,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            modal.hide();
                            Swal.fire({
                                title: 'Success',
                                text: 'Menyetujui catatan berhasil!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1200,
                            }).then(function() {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                Object.values(errors).forEach(err => {
                                    toastr.error(err[0], 'Input Field Error');
                                });
                            } else {
                                toastr.error('An error occurred while updating data.', 'Error');
                            }
                        }
                    });
                });
            }

            function updateTolak(id) {
                $('#formVerif').on('submit', function(e) {
                    e.preventDefault();

                    const _form = this;
                    const formData = new FormData(_form);

                    $.ajax({
                        method: 'POST',
                        url: `log-verifications/${id}/update-tolak`,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            modal.hide();
                            Swal.fire({
                                title: 'Success',
                                text: 'Menolak catatan berhasil!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1200,
                            }).then(function() {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                Object.values(errors).forEach(err => {
                                    toastr.error(err[0], 'Input Field Error');
                                });
                            } else {
                                toastr.error('An error occurred while updating data.', 'Error');
                            }
                        }
                    });
                });
            }

            $('#verifications-table').on('click', '.action', function() {
                let data = $(this).data();
                let id = data.id;
                let jenis = data.jenis;

                if (jenis === 'disetujui') {

                    $.ajax({
                        method: 'GET',
                        url: `/log-verifications/${id}/edit-setuju`,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {
                            modalAction.querySelector('#modal-dialog').innerHTML = res

                            const buttonClose = document.querySelectorAll('.button-close');
                            buttonClose.forEach(button => {
                                button.addEventListener('click', function() {
                                    modal.hide()
                                });
                            });

                            modal.show();
                            updateSetuju(id);
                        }
                    });
                } else if (jenis === 'ditolak') {
                    $.ajax({
                        method: 'GET',
                        url: `/log-verifications/${id}/edit-tolak`,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {
                            modalAction.querySelector('#modal-dialog').innerHTML = res

                            const buttonClose = document.querySelectorAll('.button-close');
                            buttonClose.forEach(button => {
                                button.addEventListener('click', function() {
                                    modal.hide()
                                });
                            });

                            modal.show();
                            updateTolak(id);
                        }
                    });
                }
            });
        });
    </script>
@endpush
