@extends('frontend.layout.applayout')

@section('title', 'Generated ID Cards')

@section('content')

@php
    if (!function_exists('resolveIdCardFieldValue')) {
        function resolveIdCardFieldValue($fieldType, $student, $school)
        {
            return match ($fieldType) {
                'school_name'    => $school->school_name ?? '',
                'principal_name' => $school->principal_name ?? '',
                'student_name'   => trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? '')),
                'first_name'     => $student->first_name ?? '',
                'last_name'      => $student->last_name ?? '',
                'father_name'    => $student->father_name ?? '',
                'mother_name'    => '',
                'admission_no'   => $student->admission_no ?? '',
                'class'          => $student->studentClass->name ?? '',
                'section'        => $student->section->name ?? '',
                'dob'            => $student->date_of_birth ? $student->date_of_birth->format('d-M-Y') : '',
                'gender'         => $student->gender ?? '',
                'blood_group'    => $student->blood_group ?? '',
                'phone'          => $student->phone ?? '',
                'address'        => $student->address ?? '',
                'academic_year'  => '',
                'signature'      => '',
                default          => '',
            };
        }
    }
@endphp
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
     
      </div>
    </div>
</section>
<div class="content-wrapper">

    <section class="content-header no-print">
        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center">

                <h1 class="m-0">
                    Generated ID Cards
                </h1>

                <div>
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print mr-1"></i>
                        Print
                    </button>

                    <a href="{{ route('id-card-templates.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back
                    </a>
                </div>

            </div>

        </div>
    </section>


    <section class="content">

        <div class="container-fluid">

            <div class="cards-grid">

                @foreach($students as $student)

                    <div class="id-card">

                        <img
                            src="{{ asset('storage/' . $template->image_path) }}"
                            class="id-card-background"
                            alt="ID Card"
                        >

                        @foreach($template->fields as $field)

                            @if($field->visible)

                                @if($field->field_type === 'student_photo')

                                    @php
                                        $photoPath = $student->photo ?: $student->capturephoto;
                                        $photoExists = $photoPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($photoPath);
                                    @endphp

                                    <div
                                        class="id-card-field id-card-photo{{ $photoExists ? '' : ' id-card-photo-empty' }}"
                                        style="
                                            left: {{ $field->x }}%;
                                            top: {{ $field->y }}%;
                                            width: {{ $field->width ?? 20 }}%;
                                            height: {{ $field->height ?? 20 }}%;
                                        "
                                    >
                                        @if($photoExists)
                                            <img src="{{ asset('storage/' . $photoPath) }}" alt="Photo">
                                        @else
                                            <i class="fas fa-user"></i>
                                        @endif
                                    </div>

                                @elseif($field->field_type === 'school_logo')

                                    <div
                                        class="id-card-field id-card-photo"
                                        style="
                                            left: {{ $field->x }}%;
                                            top: {{ $field->y }}%;
                                            width: {{ $field->width ?? 15 }}%;
                                            height: {{ $field->height ?? 15 }}%;
                                        "
                                    >
                                        @if($school && $school->logo)
                                            <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo">
                                        @endif
                                    </div>

                                @elseif($field->field_type === 'qr_code')

                                    <div
                                        class="id-card-field id-card-photo"
                                        style="
                                            left: {{ $field->x }}%;
                                            top: {{ $field->y }}%;
                                            width: {{ $field->width ?? 15 }}%;
                                            height: {{ $field->height ?? 15 }}%;
                                        "
                                    >
                                        <img
                                            src="data:image/png;base64,{{ \Milon\Barcode\Facades\DNS2DFacade::getBarcodePNG($student->admission_no ?? (string) $student->id, 'QRCODE') }}"
                                            alt="QR Code"
                                        >
                                    </div>

                                @elseif($field->field_type === 'barcode')

                                    <div
                                        class="id-card-field id-card-photo"
                                        style="
                                            left: {{ $field->x }}%;
                                            top: {{ $field->y }}%;
                                            width: {{ $field->width ?? 30 }}%;
                                            height: {{ $field->height ?? 10 }}%;
                                        "
                                    >
                                        <img
                                            src="data:image/png;base64,{{ \Milon\Barcode\Facades\DNS1DFacade::getBarcodePNG($student->admission_no ?? (string) $student->id, 'C128') }}"
                                            alt="Barcode"
                                        >
                                    </div>

                                @else

                                    <div
                                        class="id-card-field"
                                        style="
                                            left: {{ $field->x }}%;
                                            top: {{ $field->y }}%;
                                            width: {{ $field->width ?? 20 }}%;
                                            height: {{ $field->height ?? 5 }}%;
                                            font-size: {{ $field->font_size ?? 14 }}px;
                                            color: {{ $field->font_color ?? '#000000' }};
                                            font-weight: {{ $field->font_weight ?? 'normal' }};
                                            text-align: {{ $field->text_align ?? 'left' }};
                                        "
                                    >
                                        {{ resolveIdCardFieldValue($field->field_type, $student, $school) }}
                                    </div>

                                @endif

                            @endif

                        @endforeach

                    </div>

                @endforeach

            </div>

        </div>

    </section>

</div>

@endsection


@section('scripts')

<style>

.cards-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.id-card {
    position: relative;
    width: 350px;
    line-height: normal;
}

.id-card-background {
    display: block;
    width: 100%;
    height: auto;
}

.id-card-field {
    position: absolute;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    white-space: nowrap;
}

.id-card-photo {
    overflow: hidden;
}

.id-card-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.id-card-photo-empty {
    border: 1px dashed #adb5bd;
    background: #f1f3f5;
    color: #adb5bd;
    font-size: 20px;
}

@media print {

    .no-print,
    .main-header,
    .main-footer {
        display: none !important;
    }

    .content-wrapper {
        margin: 0 !important;
    }

    .id-card {
        page-break-inside: avoid;
    }

}

</style>

@endsection
