<?php

namespace App\Http\Controllers\DailyLog;

use App\Http\Controllers\Controller;
use App\Models\LogVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        $bawahanId = User::where('atasan_id', $user->id)->pluck('id');

        if ($user->hasRole('admin')) {
            $verifications = LogVerification::orderBy('created_at', 'desc')->get();
        } else {
            $verifications = LogVerification::whereHas('log', function ($query) use ($bawahanId) {
                $query->whereIn('user_id', $bawahanId);
            })->with(['log.user'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('log-verifications.index', compact('verifications'));
    }

    public function setuju(string $id)
    {
        $verif = LogVerification::with('log')->findOrFail($id);

        return view(
            'log-verifications.verification-action',
            ['verif' => $verif, 'actions' => 'disetujui',]
        );
    }

    public function updateSetuju(Request $request, string $id)
    {
        $verif = LogVerification::findOrFail($id);

        $request->validate([
            'notes' => 'nullable|string|max:255',
        ]);

        $verif->update([
            'status' => 'disetujui',
            'notes' => $request->notes ?? 'Disetujui',
        ]);

        $verif->log->update([
            'status' => 'disetujui',
            'catatan_atasan' => $request->notes ?? 'Disetujui',
        ]);

        // return view('log-verifications.index');
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menyetujui catatan!'
        ]);
    }

    public function tolak(string $id)
    {
        $verif = LogVerification::findOrFail($id);

        return view('log-verifications.verification-action', [
            'verif' => $verif,
            'actions' => 'ditolak',
        ]);
    }

    public function updateTolak(Request $request, string $id)
    {
        $verif = LogVerification::findOrFail($id);

        $request->validate([
            'notes' => 'nullable|string|max:255',
        ]);

        $verif->update([
            'status' => 'ditolak',
            'notes' => $request->notes ?? 'Ditolak',
        ]);

        $verif->log->update([
            'status' => 'ditolak',
            'catatan_atasan' => $request->notes ?? 'Ditolak',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menolak catatan!'
        ]);
    }
}
