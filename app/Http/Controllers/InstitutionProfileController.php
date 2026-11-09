<?php

namespace App\Http\Controllers;

use App\Models\InstitutionProfileSection;
use Illuminate\View\View;

class InstitutionProfileController extends Controller
{
    public function show(): View
    {
        $profileSections = InstitutionProfileSection::query()
            ->where('is_published', true)
            ->with('imageAttachments')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get()
            ->groupBy('section_type');

        return view('profil-pesantren', compact('profileSections'));
    }
}