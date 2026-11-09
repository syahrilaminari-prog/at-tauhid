@props(['label' => 'Foto atau gambar', 'fieldId' => 'image'])

<div>
    <label for="{{ $fieldId }}" class="mb-1 block text-sm font-medium text-slate-700">{{ $label }}</label>
    <input id="{{ $fieldId }}" name="image" type="file" accept="image/jpeg,image/png,image/webp" class="block w-full rounded-md border border-slate-300 bg-white text-sm text-slate-700 file:mr-4 file:border-0 file:bg-emerald-50 file:px-4 file:py-2.5 file:font-semibold file:text-emerald-800 hover:file:bg-emerald-100 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
    <p class="mt-1 text-xs text-slate-500">JPG, PNG, atau WEBP; maksimal 5 MB.</p>
    <x-input-error :messages="$errors->get('image')" class="mt-2" />
</div>
