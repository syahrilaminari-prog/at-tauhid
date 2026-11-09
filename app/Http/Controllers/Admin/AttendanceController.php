<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\StoresImageAttachments;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    use StoresImageAttachments;

    public function index(): View
    {
        $students = Student::latest()->get();
        $attendances = Attendance::with(['student', 'imageAttachments'])->latest('tanggal')->get();

        return view('admin.kehadiran.index', compact('students', 'attendances'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(array_merge([
            'student_id' => ['required', 'exists:students,id'],
            'tanggal' => ['required', 'date'],
            'status' => ['required', 'string', 'in:Hadir,Sakit,Izin,Alpha'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ], $this->imageUploadRules()));

        $image = $validated['image'] ?? null;
        unset($validated['image']);

        $attendance = Attendance::create($validated);
        $this->storeImageAttachment($attendance, $image, $request->user());

        return redirect()->route('admin.kehadiran.index')->with('success', 'Data kehadiran berhasil disimpan.');
    }
}
