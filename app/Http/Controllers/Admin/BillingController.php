<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\StoresImageAttachments;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillingController extends Controller
{
    use StoresImageAttachments;

    public function index(): View
    {
        $students = Student::latest()->get();
        $bills = Bill::with(['student', 'imageAttachments'])->latest('tanggal_jatuh_tempo')->get();

        return view('admin.tagihan.index', compact('students', 'bills'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(array_merge([
            'student_id' => ['required', 'exists:students,id'],
            'jenis' => ['required', 'string', 'max:100'],
            'nominal' => ['required', 'numeric', 'min:0'],
            'tanggal_jatuh_tempo' => ['required', 'date'],
            'status' => ['required', 'string', 'in:Belum Bayar,Sudah Bayar,Pending'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ], $this->imageUploadRules()));

        $image = $validated['image'] ?? null;
        unset($validated['image']);

        $bill = Bill::create($validated);
        $this->storeImageAttachment($bill, $image, $request->user());

        return redirect()->route('admin.tagihan.index')->with('success', 'Data tagihan berhasil disimpan.');
    }
}
