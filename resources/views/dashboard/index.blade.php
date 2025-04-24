@extends('layouts.app')

@section('title', 'Dashboard')

@section('description')
    Menampilkan tanggal log pegawai.
@endsection

@section('content')
    @php
        $page = 'Dashboard';
    @endphp

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
            <div id="dashboard"></div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('dashboard');

            if (calendarEl) {
                const logs = @json($logs);

                const calendar = new window.Calendar(calendarEl, {
                    plugins: [window.dayGridPlugin],
                    initialView: 'dayGridMonth',
                    events: logs.map(log => ({
                        title: log.aktivitas,
                        start: log.tanggal,
                        color: log.status === 'disetujui' ? '#10b981' : log.status ===
                            'ditolak' ?
                            '#ef4444' : '#f59e0b',
                        textColor: '#ffffff',
                    })),
                });

                calendar.render();
            }
        });
    </script>
@endpush
