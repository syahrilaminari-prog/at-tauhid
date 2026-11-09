<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\StoresImageAttachments;
use App\Http\Controllers\Controller;
use App\Models\InstitutionProfileSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class InstitutionProfileSectionController extends Controller
{
    use StoresImageAttachments;

    public function index(): View
    {
        $sections = InstitutionProfileSection::with('imageAttachments')
            ->orderBy('section_type')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('admin.profil.index', [
            'sections' => $sections,
            'sectionTypes' => InstitutionProfileSection::SECTION_TYPES,
        ]);
    }

    public function create(): View
    {
        return view('admin.profil.form', [
            'section' => new InstitutionProfileSection(['is_published' => true]),
            'sectionTypes' => InstitutionProfileSection::SECTION_TYPES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $image = $validated['image'] ?? null;
        unset($validated['image']);
        $validated['is_published'] = $request->boolean('is_published', true);

        $section = InstitutionProfileSection::create($validated);
        $this->storeImageAttachment($section, $image, $request->user());

        return redirect()->route('admin.profil.index')->with('success', 'Bagian profil pesantren berhasil ditambahkan.');
    }

    public function edit(InstitutionProfileSection $profileSection): View
    {
        $profileSection->load('imageAttachments');

        return view('admin.profil.form', [
            'section' => $profileSection,
            'sectionTypes' => InstitutionProfileSection::SECTION_TYPES,
        ]);
    }

    public function update(Request $request, InstitutionProfileSection $profileSection): RedirectResponse
    {
        $validated = $request->validate($this->rules($profileSection));
        $image = $validated['image'] ?? null;
        unset($validated['image']);
        $validated['is_published'] = $request->boolean('is_published');

        $profileSection->update($validated);
        $this->replaceImageAttachment($profileSection, $image, $request->user());

        return redirect()->route('admin.profil.index')->with('success', 'Bagian profil pesantren berhasil diperbarui.');
    }

    public function destroy(InstitutionProfileSection $profileSection): RedirectResponse
    {
        foreach ($profileSection->imageAttachments as $image) {
            Storage::disk($image->disk)->delete($image->path);
            $image->delete();
        }

        $profileSection->delete();

        return redirect()->route('admin.profil.index')->with('success', 'Bagian profil pesantren berhasil dihapus.');
    }

    private function rules(?InstitutionProfileSection $section = null): array
    {
        $slug = Rule::unique('institution_profile_sections', 'slug');

        if ($section) {
            $slug->ignore($section->id);
        }

        return array_merge([
            'section_type' => ['required', Rule::in(array_keys(InstitutionProfileSection::SECTION_TYPES))],
            'slug' => ['required', 'string', 'max:100', 'alpha_dash', $slug],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:20000'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:65535'],
            'is_published' => ['sometimes', 'boolean'],
        ], $this->imageUploadRules());
    }
}