<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\StoresImageAttachments;
use App\Http\Controllers\Controller;
use App\Models\Dormitory;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DormitoryController extends Controller
{
    use StoresImageAttachments;

    public function index(): View
    {
        $students = Student::latest()->get();
        $dormitories = Dormitory::with(['student', 'imageAttachments'])->latest()->get();

        return view('admin.asrama.index', compact('students', 'dormitories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(array_merge([
            'student_id' => ['required', 'exists:students,id'],
            'nama_kamar' => ['required', 'string', 'max:100'],
            'kapasitas' => ['required', 'integer', 'min:1', 'max:200'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ], $this->imageUploadRules()));

        $image = $validated['image'] ?? null;
        unset($validated['image']);

        $dormitory = Dormitory::create($validated);
        $this->storeImageAttachment($dormitory, $image, $request->user());

        return redirect()->route('admin.asrama.index')->with('success', 'Data asrama berhasil disimpan.');
    }
}
