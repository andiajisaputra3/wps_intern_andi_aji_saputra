<div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
    <!-- Modal header -->
    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            {{ $log->id ? 'Edit Log' : 'Add Log' }}
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
    <form id="formLog" action="{{ $log->id ? route('logs.update', $log->id) : route('logs.store') }}" method="POST">
        @csrf
        @if ($log->id)
            @method('PUT')
        @endif

        <div class="p-4 md:p-5 space-y-4 flex flex-col items-center justify-center">
            <div class="w-80 mx-auto">
                <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Pilih Tanggal
                </label>
                <div class="relative w-full z-999">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input id="tanggal" name="tanggal" type="text"
                        value="{{ old('tanggal', $log->tanggal ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Select date" />
                </div>
                <div class="flex justify-between items-center mt-3">
                    <span class="text-sm text-gray-500 dark:text-gray-300">Reset tanggal menjadi hari ini</span>
                    <button id="resetButton" type="button"
                        class="text-white flex items-center bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center dark:bg-gray-800 dark:hover:bg-gray-900 dark:focus:ring-gray-800">Reset</button>
                </div>
            </div>
            <div class="w-80 mx-auto">
                <label for="aktivitas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Aktivitas
                </label>
                <input type="text" name="aktivitas" id="aktivitas"
                    value="{{ old('aktivitas', $log->aktivitas ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>

            <div class="w-80 mx-auto">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="bukti_pekerjaan">Upload
                    file</label>
                <input
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    aria-describedby="bukti_pekerjaan_help" id="bukti_pekerjaan" name="bukti_pekerjaan" type="file">
                <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="bukti_pekerjaan_help">
                    Silakan unggah dokumen bukti kerja. Hanya file dengan format berikut yang diperbolehkan: DOC, DOCX,
                    PDF, JPG, JPEG, PNG.
                </div>
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
                @if ($log->id)
                    <svg class="mr-1 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M17.707 2.293a1 1 0 00-1.414 0L13 5.586 14.414 7 17 4.414a1 1 0 000-1.414zM3 13v4h4l6-6-4-4-6 6H3z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Edit
                @else
                    <svg class="mr-1 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Add
                @endif
            </button>
        </div>
    </form>
</div>
