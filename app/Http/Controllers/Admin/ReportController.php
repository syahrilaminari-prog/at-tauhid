<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Bill;
use App\Models\Grade;
use App\Models\HealthRecord;
use App\Models\Student;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $totalSantri = Student::count();
        $totalKehadiranHariIni = Attendance::whereDate('tanggal', today())->count();
        $totalTagihanBelumBayar = Bill::where('status', 'Belum Bayar')->count();
        $totalTagihanNominalBelumBayar = Bill::where('status', 'Belum Bayar')->sum('nominal');
        $totalKesehatanCatatan = HealthRecord::count();
        $kondisiKesehatan = HealthRecord::selectRaw('status_kesehatan, COUNT(*) as total')
            ->groupBy('status_kesehatan')
            ->get();

        $persentaseKehadiran = $totalSantri > 0
            ? round(($totalKehadiranHariIni / $totalSantri) * 100)
            : 0;

        $recentAttendance = Attendance::with('student')->latest('tanggal')->take(5)->get();
        $recentBills = Bill::with('student')->latest()->take(5)->get();
        $recentGrades = Grade::with('student')->latest()->take(5)->get();
        $recentHealth = HealthRecord::with('student')->latest('tanggal_pemeriksaan')->take(5)->get();

        return view('admin.laporan.index', compact(
            'totalSantri',
            'totalKehadiranHariIni',
            'totalTagihanBelumBayar',
            'totalTagihanNominalBelumBayar',
            'totalKesehatanCatatan',
            'kondisiKesehatan',
            'persentaseKehadiran',
            'recentAttendance',
            'recentBills',
            'recentGrades',
            'recentHealth'
        ));
    }
}
