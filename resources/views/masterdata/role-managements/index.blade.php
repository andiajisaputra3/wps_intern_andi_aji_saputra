@extends('layouts.app')

@section('title', 'Role Managements')

@section('description')
    Set and customize user roles in the system. Roles are used to categorize permissions that will be given to certain
    users.
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
            <table id="role-managements-table">
                <thead>
                    <tr>
                        <th>
                            <span class="flex items-center">
                                No
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Name Roles
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Name Permissions
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
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td class="max-w-lg">
                                @if ($role->permissions->isNotEmpty())
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($role->permissions as $permission)
                                            <span
                                                class="bg-blue-500 px-2.5 py-1.5 rounded-xl text-white text-xs break-words">{{ $permission->name }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-500 italic">No permissions assigned</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <button data-id="{{ $role->id }}" data-jenis="edit"
                                        class="block text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-yellow-400 dark:hover:bg-yellow-500 dark:focus:ring-yellow-200 action"
                                        type="button">
                                        Add / Edit
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
        <div id="modal-dialog" class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (document.getElementById("role-managements-table") && typeof simpleDatatables.DataTable !==
                'undefined') {
                const dataTable = new simpleDatatables.DataTable("#role-managements-table", {
                    searchable: true,
                });
            }

            const modalAction = document.getElementById('modal-action');
            const modal = new Modal(modalAction);

            function update(id) {
                $('#formRoleManagement').on('submit', function(e) {
                    e.preventDefault();

                    const _form = this;
                    const formData = new FormData(_form);

                    $.ajax({
                        method: 'POST',
                        url: `/role-managements/${id}`,
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

            $('#role-managements-table').on('click', '.action', function() {
                let data = $(this).data();
                let id = data.id || null;
                let jenis = data.jenis;

                // Edit
                $.ajax({
                    method: 'GET',
                    url: `/role-managements/${id}/edit`,
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
