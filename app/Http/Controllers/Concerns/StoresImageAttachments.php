<?php

namespace App\Http\Controllers\Concerns;

use App\Models\ImageAttachment;
use App\Models\User;
use App\Support\ImageUploadRules;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Throwable;

trait StoresImageAttachments
{
    protected function imageUploadRules(): array
    {
        return ImageUploadRules::rules();
    }

    protected function storeImageAttachment(Model $record, ?UploadedFile $image, ?User $uploader): ?ImageAttachment
    {
        if (! $image) {
            return null;
        }

        $path = $image->store('images', 'local');

        try {
            return $record->imageAttachments()->create([
                'uploaded_by' => $uploader?->id,
                'disk' => 'local',
                'path' => $path,
                'original_name' => substr(basename($image->getClientOriginalName()), 0, 255),
                'mime_type' => $image->getMimeType() ?? 'application/octet-stream',
                'size' => $image->getSize(),
            ]);
        } catch (Throwable $exception) {
            Storage::disk('local')->delete($path);

            throw $exception;
        }
    }

    protected function replaceImageAttachment(Model $record, ?UploadedFile $image, ?User $uploader): void
    {
        $newAttachment = $this->storeImageAttachment($record, $image, $uploader);

        if (! $newAttachment) {
            return;
        }

        $oldAttachments = $record->imageAttachments()->where('id', '!=', $newAttachment->id)->get();

        foreach ($oldAttachments as $attachment) {
            Storage::disk($attachment->disk)->delete($attachment->path);
            $attachment->delete();
        }
    }

    protected function deleteImageAttachments(Model $record): void
    {
        foreach ($record->imageAttachments()->get() as $attachment) {
            Storage::disk($attachment->disk)->delete($attachment->path);
            $attachment->delete();
        }
    }
}
