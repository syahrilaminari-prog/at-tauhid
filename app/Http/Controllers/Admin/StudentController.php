<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\StoresImageAttachments;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentController extends Controller
{
    use StoresImageAttachments;

    public function index(): View
    {
        $students = Student::with('imageAttachments')->latest()->get();

        return view('admin.santri.index', compact('students'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(array_merge($this->studentRules(), [
            'nama_ayah' => ['nullable', 'string', 'max:255', 'required_without:nama_ibu'],
            'nama_ibu' => ['nullable', 'string', 'max:255', 'required_without:nama_ayah'],
            'email_orang_tua' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password_orang_tua' => ['required', 'string', 'min:8', 'confirmed'],
        ]));

        $image = $validated['image'] ?? null;
        $guardianEmail = $validated['email_orang_tua'];
        $guardianPassword = $validated['password_orang_tua'];
        $guardianName = $validated['nama_ayah'] ?: $validated['nama_ibu'];
        $relationship = filled($validated['nama_ayah']) ? 'Ayah' : 'Ibu';
        unset($validated['image']);
        unset($validated['email_orang_tua'], $validated['password_orang_tua']);

        $parentRole = Role::firstOrCreate(
            ['slug' => 'orang_tua'],
            [
                'name' => 'Orang Tua',
                'description' => 'Orang tua / wali santri',
            ]
        );

        [$student, $parent] = DB::transaction(function () use ($validated, $guardianEmail, $guardianPassword, $guardianName, $relationship, $parentRole) {
            $student = Student::create($validated);
            $parent = User::create([
                'name' => $guardianName,
                'email' => $guardianEmail,
                'password' => Hash::make($guardianPassword),
                'role_id' => $parentRole->id,
            ]);

            $student->parents()->attach($parent->id, [
                'hubungan' => $relationship,
                'status' => 'aktif',
            ]);

            return [$student, $parent];
        });

        $this->storeImageAttachment($student, $image, $request->user());

        return redirect()->route('admin.santri.index')->with('success', 'Data santri dan akun orang tua berhasil ditambahkan.');
    }

    public function edit(Student $student): View
    {
        $student->load(['imageAttachments', 'parents']);
        $parents = User::whereHas('role', fn ($query) => $query->where('slug', 'orang_tua'))
            ->orderBy('name')
            ->get();

        return view('admin.santri.edit', compact('student', 'parents'));
    }

    public function linkParent(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'hubungan' => ['required', 'string', 'in:Ayah,Ibu,Wali'],
        ]);

        $parent = User::whereKey($validated['user_id'])
            ->whereHas('role', fn ($query) => $query->where('slug', 'orang_tua'))
            ->first();

        if (! $parent) {
            return back()
                ->withErrors(['user_id' => 'Akun yang dipilih bukan akun orang tua atau wali.'])
                ->withInput();
        }

        $student->parents()->syncWithoutDetaching([
            $parent->id => [
                'hubungan' => $validated['hubungan'],
                'status' => 'aktif',
            ],
        ]);

        return redirect()->route('admin.santri.edit', $student)
            ->with('success', 'Akun orang tua berhasil dihubungkan dengan santri.');
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate($this->studentRules($student));

        $image = $validated['image'] ?? null;
        unset($validated['image']);

        $student->update($validated);
        $this->replaceImageAttachment($student, $image, $request->user());

        return redirect()->route('admin.santri.index')->with('success', 'Data santri berhasil diperbarui.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $relatedRecords = collect([$student]);

        foreach (['attendances', 'grades', 'bills', 'dormitories', 'healthRecords'] as $relation) {
            $relatedRecords = $relatedRecords->concat($student->{$relation}()->get());
        }

        foreach ($relatedRecords as $record) {
            $this->deleteImageAttachments($record);
        }

        $student->delete();

        return redirect()->route('admin.santri.index')->with('success', 'Data santri beserta data terkait berhasil dihapus.');
    }

    private function studentRules(?Student $student = null): array
    {
        $nisRule = Rule::unique('students', 'nis');

        if ($student) {
            $nisRule->ignore($student->id);
        }

        return [
            'nama' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'max:50', $nisRule],
            'jenis_kelamin' => ['required', 'string', 'max:20'],
            'tanggal_lahir' => ['required', 'date'],
            'kelas' => ['required', 'string', 'max:50'],
            'tahun_masuk' => ['required', 'integer', 'min:2000', 'max:2100'],
            'status' => ['required', 'string', 'max:50'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'nama_ayah' => ['nullable', 'string', 'max:255'],
            'nama_ibu' => ['nullable', 'string', 'max:255'],
            ...$this->imageUploadRules(),
        ];
    }
}
