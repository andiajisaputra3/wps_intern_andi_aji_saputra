<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $logs = Log::all();

        return view('dashboard.index', compact('logs'));
    }
}
