@extends('layouts.app')

@section('title', 'Permissions')

@section('description')
    Manage the list of permissions that determine access to features in the system.
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

        <div class="flex items-start w-full gap-3 sm:justify-end">
            <!-- Modal Add -->
            <button id="button-add"
                class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="button">
                Add
            </button>
        </div>
    </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto p-6">
            <table id="permissions-table">
                <thead>
                    <tr>
                        <th>
                            <span class="flex items-center">
                                No
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Name
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Guard Name
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Created At
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Updated At
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
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->guard_name }}</td>
                            <td>{{ $permission->created_at }}</td>
                            <td>{{ $permission->updated_at }}</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <button data-id="{{ $permission->id }}" data-jenis="edit"
                                        class="block text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-yellow-400 dark:hover:bg-yellow-500 dark:focus:ring-yellow-200 action"
                                        type="button">
                                        Edit
                                    </button>
                                    <button data-id="{{ $permission->id }}" data-jenis="delete"
                                        class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 action"
                                        type="button">
                                        Delete
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
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-99999 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div id="modal-dialog" class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (document.getElementById("permissions-table") && typeof simpleDatatables.DataTable !== 'undefined') {
                const dataTable = new simpleDatatables.DataTable("#permissions-table", {
                    searchable: true,
                });
            }

            const buttonAdd = document.getElementById('button-add');
            const modalAction = document.getElementById('modal-action');
            const modal = new Modal(modalAction);

            buttonAdd.addEventListener('click', function() {
                $.ajax({
                    method: 'GET',
                    url: '/permissions/create',
                    headers: {
                        'CSRF_TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        modalAction.querySelector('#modal-dialog').innerHTML = res

                        const buttonClose = document.querySelectorAll('.button-close');
                        buttonClose.forEach(button => {
                            button.addEventListener('click', function() {
                                modal.hide()
                            });
                        });

                        modal.show()
                        store()
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            Object.values(errors).forEach(err => {
                                toastr.error(err[0], 'Input field error')
                            });
                        } else {
                            toastr.error('An error occured while loading the form', 'Error')
                        }
                    }
                })
            });

            function store() {
                $('#formPermission').on('submit', function(e) {
                    e.preventDefault()

                    const _form = this;
                    const formData = new FormData(_form);

                    $.ajax({
                        method: 'POST',
                        url: '/permissions',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            modal.hide();
                            Swal.fire({
                                title: 'Success',
                                text: 'Added data successfully!',
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
                                    toastr.error(err[0], 'Input field error')
                                })
                            } else {
                                toastr.error('An error occured while added data', 'Error')
                            }
                        }
                    });
                })
            }

            function update(id) {
                $('#formPermission').on('submit', function(e) {
                    e.preventDefault();

                    const _form = this;
                    const formData = new FormData(_form);

                    $.ajax({
                        method: 'POST',
                        url: `/permissions/${id}`,
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
                                text: 'Updated data successfully!',
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

            $('#permissions-table').on('click', '.action', function() {
                let data = $(this).data();
                let id = data.id || null;
                let jenis = data.jenis;

                if (jenis === 'delete') {
                    // console.log('delete masuk');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#9AA6B2',
                        confirmButtonText: 'Yes, delete it!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'DELETE',
                                url: `/permissions/${id}`,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                success: function(res) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: res.message,
                                        showConfirmButton: false,
                                        timer: 1200,
                                        didClose: () => {
                                            window.location.reload();
                                        }
                                    });
                                },
                                error: function(xhr) {
                                    toastr.error('Gagal menghapus data. Coba lagi.',
                                        'Error');
                                }
                            });
                        }
                    });
                    return;
                }

                // Edit
                $.ajax({
                    method: 'GET',
                    url: `/permissions/${id}/edit`,
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
                        update(id);
                    }
                });
            });
        });
    </script>
@endpush
