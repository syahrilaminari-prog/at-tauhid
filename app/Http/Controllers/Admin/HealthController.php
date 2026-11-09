<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\StoresImageAttachments;
use App\Http\Controllers\Controller;
use App\Models\HealthRecord;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HealthController extends Controller
{
    use StoresImageAttachments;

    public function index(): View
    {
        $students = Student::latest()->get();
        $healthRecords = HealthRecord::with(['student', 'imageAttachments'])->latest('tanggal_pemeriksaan')->get();

        return view('admin.kesehatan.index', compact('students', 'healthRecords'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(array_merge([
            'student_id' => ['required', 'exists:students,id'],
            'jenis_pemeriksaan' => ['required', 'string', 'max:100'],
            'tanggal_pemeriksaan' => ['required', 'date'],
            'status_kesehatan' => ['required', 'string', 'in:Sehat,Sakit,Rawat,Catatan Khusus'],
            'catatan' => ['nullable', 'string', 'max:255'],
        ], $this->imageUploadRules()));

        $image = $validated['image'] ?? null;
        unset($validated['image']);

        $healthRecord = HealthRecord::create($validated);
        $this->storeImageAttachment($healthRecord, $image, $request->user());

        return redirect()->route('admin.kesehatan.index')->with('success', 'Data kesehatan santri berhasil disimpan.');
    }
}
