<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\StoresImageAttachments;
use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MasterDataController extends Controller
{
    use StoresImageAttachments;

    public function index(): View
    {
        $majors = Major::with(['classes', 'imageAttachments'])->latest()->get();
        $classes = SchoolClass::with(['major', 'imageAttachments'])->latest()->get();

        return view('admin.master-data.index', compact('majors', 'classes'));
    }

    public function storeMajor(Request $request): RedirectResponse
    {
        $validated = $request->validate(array_merge([
            'nama' => ['required', 'string', 'max:255'],
            'kode' => ['required', 'string', 'max:20', 'unique:majors,kode'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ], $this->imageUploadRules()));

        $image = $validated['image'] ?? null;
        unset($validated['image']);

        $major = Major::create($validated);
        $this->storeImageAttachment($major, $image, $request->user());

        return redirect()->route('admin.master-data.index')->with('success', 'Data jurusan berhasil ditambahkan.');
    }

    public function storeClass(Request $request): RedirectResponse
    {
        $validated = $request->validate(array_merge([
            'nama' => ['required', 'string', 'max:50'],
            'tingkat' => ['required', 'string', 'max:20'],
            'kapasitas' => ['required', 'integer', 'min:1', 'max:500'],
            'jurusan_id' => ['nullable', 'exists:majors,id'],
        ], $this->imageUploadRules()));

        $image = $validated['image'] ?? null;
        unset($validated['image']);

        $schoolClass = SchoolClass::create($validated);
        $this->storeImageAttachment($schoolClass, $image, $request->user());

        return redirect()->route('admin.master-data.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }
}
