<?php

namespace App\Support;

class ImageUploadRules
{
    public static function rules(): array
    {
        return [
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120', 'dimensions:max_width=4096,max_height=4096'],
        ];
    }
}
