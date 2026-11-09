<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\StoresImageAttachments;
use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AcademicController extends Controller
{
    use StoresImageAttachments;

    public function index(): View
    {
        $students = Student::latest()->get();
        $grades = Grade::with(['student', 'imageAttachments'])->latest()->get();

        return view('admin.akademik.index', compact('students', 'grades'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(array_merge([
            'student_id' => ['required', 'exists:students,id'],
            'mata_pelajaran' => ['required', 'string', 'max:100'],
            'semester' => ['required', 'string', 'max:20'],
            'nilai' => ['required', 'integer', 'min:0', 'max:100'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ], $this->imageUploadRules()));

        $image = $validated['image'] ?? null;
        unset($validated['image']);

        $grade = Grade::create($validated);
        $this->storeImageAttachment($grade, $image, $request->user());

        return redirect()->route('admin.akademik.index')->with('success', 'Nilai akademik berhasil disimpan.');
    }
}
