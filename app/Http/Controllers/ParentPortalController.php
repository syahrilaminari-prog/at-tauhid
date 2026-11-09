<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParentPortalController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $links = $user->parentLinks()->with('student')->get();

        $selectedStudent = null;

        if ($request->filled('student_id')) {
            $selectedStudent = $links->first(fn ($link) => (int) $link->student_id === (int) $request->student_id)?->student;
        }

        if (! $selectedStudent && $links->isNotEmpty()) {
            $selectedStudent = $links->first()->student;
        }

        $attendanceSummary = [
            'hadir' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alpha' => 0,
        ];

        if ($selectedStudent) {
            $attendanceSummary = [
                'hadir' => $selectedStudent->attendances()->where('status', 'Hadir')->count(),
                'izin' => $selectedStudent->attendances()->where('status', 'Izin')->count(),
                'sakit' => $selectedStudent->attendances()->where('status', 'Sakit')->count(),
                'alpha' => $selectedStudent->attendances()->where('status', 'Alpha')->count(),
            ];
        }

        $latestGrades = $selectedStudent
            ? $selectedStudent->grades()->orderByDesc('created_at')->limit(5)->get()
            : collect();

        $unpaidBills = $selectedStudent
            ? $selectedStudent->bills()->where('status', '!=', 'Lunas')->sum('nominal')
            : 0;

        $latestHealth = $selectedStudent
            ? $selectedStudent->healthRecords()->latest('tanggal_pemeriksaan')->first()
            : null;

        $healthHistory = $selectedStudent
            ? $selectedStudent->healthRecords()
                ->with('imageAttachments')
                ->orderByDesc('tanggal_pemeriksaan')
                ->orderByDesc('id')
                ->get()
            : collect();

        return view('orangtua.dashboard', compact(
            'user',
            'links',
            'selectedStudent',
            'attendanceSummary',
            'latestGrades',
            'unpaidBills',
            'latestHealth',
            'healthHistory'
        ));
    }
}
