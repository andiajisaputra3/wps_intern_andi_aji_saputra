<?php

namespace App\Http\Controllers\DailyLog;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\LogVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $logs = Log::with('atasan')->orderBy('created_at', 'desc')->get();
        } else {
            $logs = Log::where('user_id', $user->id)->with('atasan')->orderBy('created_at', 'desc')->get();
        }

        return view('logs.index', compact('logs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('logs.log-action', ['log' => new Log()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'aktivitas' => 'required|string',
            'bukti_pekerjaan' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048',
        ]);

        $path = null;

        if ($file = $request->file('bukti_pekerjaan')) {
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('bukti_pekerjaan', $fileName, 'public');
        }

        $log = Log::create([
            'user_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'aktivitas' => $request->aktivitas,
            'bukti_pekerjaan' => $path,
            'status' => 'pending',
            'atasan_id' => Auth::user()->atasan_id,
        ]);

        LogVerification::create([
            'log_id' => $log->id,
            'verified_by' => null,
            'status' => 'pending',
            'notes' => null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Added data successfully!'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $log = Log::findOrFail($id);

        return view('logs.log-action', compact('log'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $log = Log::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'aktivitas' => 'required|string',
            'bukti_pekerjaan' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048',
        ]);

        $path = $log->bukti_pekerjaan;

        if ($request->hasFile('bukti_pekerjaan')) {
            // Hapus file lama jika ada
            if ($path !== null) {
                Storage::disk('public')->delete($path);
            }

            $file = $request->file('bukti_pekerjaan');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('bukti_pekerjaan', $fileName, 'public');
        }

        $log->update([
            'tanggal' => $request->tanggal,
            'aktivitas' => $request->aktivitas,
            'bukti_pekerjaan' => $path,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Updated data successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $log = Log::findOrFail($id);
        $log->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Updated data successfully!'
        ]);
    }
}
