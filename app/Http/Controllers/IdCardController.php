<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\StoresBase64Images;
use App\Models\IdCard;
use Illuminate\Http\Request;

class IdCardController extends Controller
{
    use StoresBase64Images;

    // GET /students/{student}/id-card -> reload this student's saved card, if any
    public function show($studentId)
    {
        $card = IdCard::with('template')
            ->where('student_id', $studentId)
            ->latest()
            ->first();

        if (! $card) {
            return response()->json(null, 204);
        }

        return [
            'id'         => $card->id,
            'templateId' => $card->id_card_template_id,
            'photo'      => $card->photo_url,
            'data'       => $card->data,
        ];
    }

    // POST /id-cards -> save this student's filled-in card data
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'           => 'required|integer|exists:students,id',
            'id_card_template_id'  => 'required|integer|exists:id_card_templates,id',
            'photo'                => 'nullable|string', // base64 data URL, optional
            'data'                 => 'required|array',  // name, father, mother, dob, class, adm, blood, session, qrData, visibility
        ]);

        $photoPath = null;
        if (! empty($validated['photo'])) {
            $photoPath = $this->storeBase64Image($validated['photo'], 'id-card-photos');
        }

        // one card per student per template — update if it already exists
        $card = IdCard::updateOrCreate(
            [
                'student_id'          => $validated['student_id'],
                'id_card_template_id' => $validated['id_card_template_id'],
            ],
            [
                'photo_path' => $photoPath ?? optional(
                    IdCard::where('student_id', $validated['student_id'])
                          ->where('id_card_template_id', $validated['id_card_template_id'])
                          ->first()
                )->photo_path,
                'data' => $validated['data'],
            ]
        );

        return response()->json($card, 201);
    }
}
