<div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
    <!-- Modal header -->
    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Add User Managements
        </h3>
        <button type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white button-close">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
        </button>
    </div>
    <!-- Modal body -->
    <form id="formUserManagement" action="{{ route('user-managements.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="p-4 md:p-5 space-y-4 flex flex-col items-center justify-center">
            <div class="mb-5 w-full">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Name
                </label>
                <input type="text" name="name" id="name" value="{{ $user->name }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    readonly />
            </div>
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Select Roles
                </label>
                <ul
                    class="w-full py-2 flex flex-wrap md:justify-between gap-4 text-sm font-medium text-gray-900 bg-gray-50 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @foreach ($roles as $role)
                        <li class="w-full sm:w-1/2 md:w-1/4 lg:w-1/4 flex justify-center">
                            <label class="flex items-center w-full p-2 cursor-pointer">
                                <input type="checkbox" value="{{ $role->name }}" name="role[]" class="sr-only peer"
                                    {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'checked' : '' }}>

                                <div
                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-400 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                </div>
                                <span
                                    class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $role->name }}</span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Modal footer -->
        <div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
            <button type="button"
                class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 button-close">
                Close
            </button>
            <button type="submit"
                class="text-white flex items-center bg-blue-700 ms-3 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="mr-1 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M17.707 2.293a1 1 0 00-1.414 0L13 5.586 14.414 7 17 4.414a1 1 0 000-1.414zM3 13v4h4l6-6-4-4-6 6H3z"
                        clip-rule="evenodd"></path>
                </svg>
                Add / Edit
            </button>
        </div>
    </form>
</div>
