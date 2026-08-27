<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mainidcard;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MainidcardController extends Controller
{
    public function store(Request $request)
    {
        $schoolId = Auth::user()->school_id ?? session('viewing_school');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'orientation' => 'required|in:portrait,landscape',
            'card_width' => 'required|integer',
            'card_height' => 'required|integer',
            'background' => 'nullable|string',
            'layout' => 'required|array',
        ]);

        $isFirst = !Mainidcard::where(
            'school_id',
            $schoolId
        )->exists();
        // Clean up previously stored image files (only files we stored under idcards/)
        $existing = Mainidcard::where('school_id', $schoolId)->first();

        if ($existing) {
            // background
            if (!empty($existing->background) && is_string($existing->background) && strpos($existing->background, 'idcards/') === 0) {
                if (Storage::disk('public')->exists($existing->background)) {
                    Storage::disk('public')->delete($existing->background);
                }
            }

            // layout image fields
            $existingLayout = $existing->layout ?? [];

            if (isset($existingLayout['fields']) && is_array($existingLayout['fields'])) {
                foreach ($existingLayout['fields'] as $fld) {
                    if (isset($fld['type']) && $fld['type'] === 'image' && !empty($fld['src']) && is_string($fld['src']) && strpos($fld['src'], 'idcards/') === 0) {
                        if (Storage::disk('public')->exists($fld['src'])) {
                            Storage::disk('public')->delete($fld['src']);
                        }
                    }
                }
            }
        }

        Mainidcard::where('school_id', $schoolId)->delete();

        // Process background if it's a data URL and save to storage
        if (!empty($validated['background']) && is_string($validated['background']) && strpos($validated['background'], 'data:') === 0) {
            if (preg_match('/^data:(image\/[a-zA-Z]+);base64,/', $validated['background'], $m)) {
                $ext = explode('/', $m[1])[1] ?? 'png';
                $data = preg_replace('/^data:image\/[a-zA-Z]+;base64,/', '', $validated['background']);
                $data = base64_decode($data);
                $filename = 'idcards/' . Str::random(16) . '.' . $ext;
                Storage::disk('public')->put($filename, $data);
                $validated['background'] = $filename;
            }
        }

        // Process layout image fields (logo/photo/sign/qr etc.)
        $layout = $validated['layout'] ?? [];

        if (isset($layout['fields']) && is_array($layout['fields'])) {
            foreach ($layout['fields'] as $key => $field) {
                if (isset($field['type']) && $field['type'] === 'image' && !empty($field['src']) && is_string($field['src']) && strpos($field['src'], 'data:') === 0) {
                    if (preg_match('/^data:(image\/[a-zA-Z]+);base64,/', $field['src'], $m2)) {
                        $ext = explode('/', $m2[1])[1] ?? 'png';
                        $data = preg_replace('/^data:image\/[a-zA-Z]+;base64,/', '', $field['src']);
                        $data = base64_decode($data);
                        $filename = 'idcards/' . Str::random(16) . '.' . $ext;
                        Storage::disk('public')->put($filename, $data);
                        $layout['fields'][$key]['src'] = $filename;
                    }
                }
            }
        }

        $mainidcard = Mainidcard::create([
            'school_id' => $schoolId,
            'name' => $validated['name'],
            'orientation' => $validated['orientation'],
            'card_width' => $validated['card_width'],
            'card_height' => $validated['card_height'],
            'background' => $validated['background'] ?? null,
            'layout' => $layout,
            'is_default' => $isFirst,
        ]);
        

        return response()->json([
            'success' => true,
            'message' => 'ID Card saved successfully.',
            'id' => $mainidcard->id,
        ]);
    }
}
