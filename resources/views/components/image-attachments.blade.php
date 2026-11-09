@props(['images'])

@if ($images->isNotEmpty())
    <div class="mt-2 flex flex-wrap gap-2">
        @foreach ($images as $image)
            <a href="{{ route('image-attachments.show', $image) }}" target="_blank" rel="noopener" class="text-xs font-semibold text-emerald-800 underline underline-offset-2 hover:text-emerald-950">
                Lihat {{ $image->original_name }}
            </a>
        @endforeach
    </div>
@endif
