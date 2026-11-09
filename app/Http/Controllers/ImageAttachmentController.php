<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Bill;
use App\Models\Dormitory;
use App\Models\Grade;
use App\Models\HealthRecord;
use App\Models\ImageAttachment;
use App\Models\InstitutionProfileSection;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImageAttachmentController extends Controller
{
    public function show(Request $request, ImageAttachment $imageAttachment): StreamedResponse
    {
        abort_unless($this->canView($request, $imageAttachment), 403);
        abort_unless(Storage::disk($imageAttachment->disk)->exists($imageAttachment->path), 404);

        return Storage::disk($imageAttachment->disk)->response(
            $imageAttachment->path,
            $imageAttachment->original_name,
            [
                'Content-Type' => $imageAttachment->mime_type,
                'X-Content-Type-Options' => 'nosniff',
            ],
            'inline'
        );
    }

    private function canView(Request $request, ImageAttachment $imageAttachment): bool
    {
        $imageable = $imageAttachment->imageable;

        if ($imageable instanceof InstitutionProfileSection && $imageable->is_published) {
            return true;
        }

        $user = $request->user();

        if (! $user) {
            return false;
        }

        if ($user->isAdmin() || $imageAttachment->uploaded_by === $user->id) {
            return true;
        }

        if (! $user->isParent()) {
            return false;
        }

        $studentId = match (true) {
            $imageable instanceof Student => $imageable->id,
            $imageable instanceof Attendance,
            $imageable instanceof Bill,
            $imageable instanceof Dormitory,
            $imageable instanceof Grade,
            $imageable instanceof HealthRecord => $imageable->student_id,
            default => null,
        };

        return $studentId !== null && $user->parentLinks()
            ->where('student_id', $studentId)
            ->where('status', 'aktif')
            ->exists();
    }
}
