<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait StoresBase64Images
{
    /**
     * Decode a "data:image/jpeg;base64,...." string from the editor
     * and store it on the public disk. Returns the stored path.
     */
    protected function storeBase64Image(string $dataUrl, string $folder): string
    {
        if (! preg_match('/^data:image\/(\w+);base64,/', $dataUrl, $m)) {
            throw new \InvalidArgumentException('Not a valid base64 image data URL.');
        }

        $ext = $m[1] === 'jpeg' ? 'jpg' : $m[1];
        $raw = base64_decode(substr($dataUrl, strpos($dataUrl, ',') + 1));

        $path = trim($folder, '/') . '/' . Str::uuid() . '.' . $ext;
        Storage::disk('public')->put($path, $raw);

        return $path;
    }
}
