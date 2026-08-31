@extends('frontend.layout.applayout')
@section('title', 'School Details')
@section('content')
<style>
    .id-card-template {
        margin:0px;
        padding:0px;
      
    }
    .id-card-section {
        width: 100%;
    }

    .id-card-preview {
        margin:0px;
        padding:0px;
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }

   

</style>

@if(request()->query('debug'))
    <style>
        /* Debug: visually highlight every rendered field inside the card preview */
        .id-card-template [id^="el"] {
            outline: 2px solid rgba(0,128,255,0.35) !important;
            background: rgba(0,0,0,0.02) !important;
            z-index: 999 !important;
            box-sizing: border-box;
        }
        .id-card-template [id^="el"] img {
            display: block !important;
            max-width: 100% !important;
            height: auto !important;
        }
    </style>
@endif
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <!-- <div class="col-sm-6">
                    <h1>School Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">School</li>
                    </ol>
                </div> -->
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card border-0 shadow-sm school-profile-card">
                <div class="card-header bg-white border-0 px-4 py-3">
                    <div class="d-flex align-items-center">
                        <div>
                            <h4 class="mb-1 font-weight-bold text-dark">
                                <i class="fas fa-school text-primary mr-2"></i>
                                {{ ucwords($school->school_name) }}
                            </h4>

                            <small class="text-muted">
                                <i class="fas fa-id-card mr-1"></i>
                                School Code: {{ $school->school_code }}
                            </small>
                        </div>
                        <div class="ml-auto d-flex align-items-center">
                            @if($school->status)
                                <span class="badge badge-success px-3 py-2 mr-2">
                                    <i class="fas fa-check-circle mr-1"></i> Active
                                </span>
                            @else
                                <span class="badge badge-danger px-3 py-2 mr-2">
                                    <i class="fas fa-times-circle mr-1"></i> Inactive
                                </span>
                            @endif
                            @if(Auth::user()?->role === 'superadmin')
                                <a href="{{ route('schools.edit', $school) }}"
                                class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pt-2 pb-4">
                    <div class="principal-box mb-4">
                        <div class="d-flex align-items-center">
                            <div class="principal-icon flex-shrink-0">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="ml-3">
                                <small class="text-muted d-block">
                                    PRINCIPAL
                                </small>
                                <h5 class="mb-0 font-weight-bold">
                                    {{ $school->principal_name ?: 'Not Available' }}
                                </h5>
                            </div>
                            @if(Auth::user()?->role === 'superadmin')
                                <a href="{{ route('schools.index') }}"
                                class="btn btn-info btn-sm ml-auto flex-shrink-0">
                                    <i class="fas fa-arrow-left"></i>
                                    <span class="d-none d-sm-inline ml-1">Back</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="row align-items-start">
                        <div class="col-lg-3 col-md-4 mb-3 mb-md-0">
                            <div class="school-logo-box">

                                @if($school->logo)
                                    <img src="{{ Storage::disk('public')->url($school->logo) }}"
                                        alt="School Logo"
                                        class="school-logo">
                                @else
                                    <div class="no-logo">
                                        <i class="fas fa-school"></i>
                                        <span>No Logo</span>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 mb-3 mb-md-0">

                            <h6 class="section-title">
                                <i class="fas fa-address-book mr-2"></i>
                                Contact Information
                            </h6>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <small>Email</small>
                                    <strong>{{ $school->email ?: 'Not Available' }}</strong>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <small>Phone</small>
                                    <strong>{{ $school->phone ?: 'Not Available' }}</strong>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <small>Address</small>
                                    <strong>{{ $school->address ?: 'Not Available' }}</strong>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-5 col-md-4">
                            <div class="id-card-section">
                                <div class="d-flex align-items-center mb-2">
                                    <h6 class="section-title mb-0">
                                        <i class="fas fa-id-card mr-2"></i>
                                        Live ID Card Preview
                                    </h6>
                                    <a href="{{ route('idcard.editor') }}"
                                    class="btn btn-sm btn-warning ml-auto"
                                    >
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </div>
                                @if(isset($mainidcard) && $mainidcard && $mainidcard->layout && is_array($mainidcard->layout) && isset($mainidcard->layout['fields']))
                                    <div class="id-card-preview">
                                        @php
                                            $layout = $mainidcard->layout;
                                            $bgUrl = asset('storage/' . $idcardsample->file_path);

                                            $cardW = $mainidcard->card_width ?? ($layout['cardWidth'] ?? 700);
                                            $cardH = $mainidcard->card_height ?? ($layout['cardHeight'] ?? 450);
                                            $previewW = 317;
                                            $previewH = 204;
                                            $scale = min($previewW / max($cardW, 1), $previewH / max($cardH, 1), 1);
                                            $scaleCss = number_format($scale, 3, '.', '');

                                            // Sort fields so shape elements render behind text and image elements
                                            $fields = $layout['fields'];
                                            uksort($fields, function($a, $b) use ($fields) {
                                                $typeA = $fields[$a]['type'] ?? '';
                                                $typeB = $fields[$b]['type'] ?? '';
                                                if ($typeA === 'shape' && $typeB !== 'shape') return -1;
                                                if ($typeA !== 'shape' && $typeB === 'shape') return 1;
                                                return 0;
                                            });
                                        @endphp

                                        <div class="id-card-template img-fluid img-thumbnail" style="position:relative; width:{{$previewW}}px; height:{{$previewH}}px; overflow:hidden; display:flex; align-items:center; justify-content:center;">

                                            <div style="width:{{ $cardW }}px; height:{{ $cardH }}px; transform: scale({{ $scaleCss }}); transform-origin: top left; margin:auto; position:relative; background-image: url('{{ $bgUrl }}'); background-size:100% 100%; background-repeat:no-repeat;">

                                                @foreach($fields as $key => $field)

                                                    @php
                                                        $elId = 'el' . ucfirst($key);
                                                        $type = $field['type'] ?? 'text';

                                                        // Always define $left, $top, $width, $height
                                                        $left = isset($field['x']) ? (int)$field['x'] : 0;
                                                        $top = isset($field['y']) ? (int)$field['y'] : 0;
                                                        $width = isset($field['width']) ? (int)$field['width'] : null;
                                                        $height = isset($field['height']) ? (int)$field['height'] : null;
                                                        $visible = $field['visible'] ?? true;

                                                        // Give shapes low z-index (1) and text/images higher z-index (10)
                                                        $zIndex = ($type === 'shape') ? 1 : 10;
                                                        $style = "position:absolute; left:{$left}px; top:{$top}px; z-index:{$zIndex};";

                                                        if ($width) {
                                                            $style .= " width:{$width}px;";
                                                        }
                                                        if ($height) {
                                                            $style .= " height:{$height}px;";
                                                        }
                                                        if (!$visible) {
                                                            $style .= " display:none;";
                                                        }
                                                    @endphp

                                                    {{-- IMAGE --}}
                                                    @if($type === 'image')

                                                        @php
                                                            $src = '';
                                                            if (!empty($field['src'])) {
                                                                if (preg_match('/^https?:\/\//', $field['src'])) {
                                                                    $src = $field['src'];
                                                                } else {
                                                                    $src = Storage::disk('public')->url($field['src']);
                                                                }
                                                            }
                                                        @endphp

                                                        @if($src)
                                                            <img
                                                                id="{{ $elId }}"
                                                                src="{{ $src }}"
                                                                alt="{{ $key }}"
                                                                style="{{ $style }} object-fit:contain;"
                                                            >
                                                        @endif

                                                    {{-- SHAPE --}}
                                                    @elseif($type === 'shape')

                                                        @php
                                                            $backgroundColor = $field['backgroundColor'] ?? 'transparent';
                                                            $opacity = isset($field['opacity']) ? (float)$field['opacity'] : 1;
                                                            $borderRadius = isset($field['borderRadius']) ? (int)$field['borderRadius'] : 0;

                                                            $style .= " background-color:{$backgroundColor}; opacity:{$opacity}; border-radius:{$borderRadius}px; box-sizing:border-box;";
                                                        @endphp

                                                        <div id="{{ $elId }}" style="{{ $style }}"></div>

                                                    {{-- TEXT --}}
                                                    @else

                                                        @php
                                                            $text = $field['text'] ?? '';
                                                            $fs = isset($field['fontSize']) ? (int)$field['fontSize'] : null;
                                                            $color = $field['color'] ?? null;
                                                            $fw = $field['fontWeight'] ?? null;

                                                            if ($fs) { $style .= " font-size:{$fs}px;"; }
                                                            if ($color) { $style .= " color:{$color};"; }
                                                            if ($fw) { $style .= " font-weight:{$fw};"; }
                                                        @endphp

                                                        <div id="{{ $elId }}" style="{{ $style }}">{!! e($text) !!}</div>

                                                    @endif

                                                    {{-- Custom CSS --}}
                                                    @if(!empty($field['css']))
                                                        <style>
                                                            #{{ $elId }} {
                                                                {!! $field['css'] !!}
                                                            }
                                                        </style>
                                                    @endif

                                                @endforeach

                                                @if(request()->query('debug'))
                                                    @foreach($layout['fields'] as $key => $field)
                                                        @php
                                                            $dbgLeft = isset($field['x']) ? (int)$field['x'] : 0;
                                                            $dbgTop = isset($field['y']) ? (int)$field['y'] : 0;
                                                            $dbgW = isset($field['width']) ? (int)$field['width'] : 80;
                                                            $dbgH = isset($field['height']) ? (int)$field['height'] : 24;
                                                            $dbgId = 'dbg_' . $key;
                                                            $dbgText = (isset($field['type']) && $field['type'] === 'image') 
                                                                ? 'img ' . ($field['src'] ? 'has-src' : 'no-src')
                                                                : 'txt ' . (isset($field['text']) ? e(substr($field['text'], 0, 20)) : 'no-text');
                                                        @endphp

                                                        <div id="{{ $dbgId }}" style="position:absolute; left:{{ $dbgLeft }}px; top:{{ $dbgTop }}px; width:{{ max(20,$dbgW) }}px; height:{{ max(16,$dbgH) }}px; background:rgba(255,0,0,0.12); border:1px dashed rgba(255,0,0,0.6); color:#900; font-size:10px; padding:2px; box-sizing:border-box; z-index:9999;">
                                                            <strong style="font-size:10px">{{ $key }}</strong><br>
                                                            <span style="font-size:10px">{{ $dbgText }}</span>
                                                        </div>
                                                    @endforeach
                                                @endif

                                            </div>

                                        </div>
                                    </div>

                                    @if(request()->query('debug'))
                                        <div style="margin-top:12px; max-height:240px; overflow:auto; background:#f8f9fa; padding:8px; border:1px solid #eee;">
                                            <strong>Saved layout JSON</strong>
                                            <pre style="white-space:pre-wrap; word-break:break-word; font-size:12px;">{{ json_encode($layout, JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                    @endif

                                @elseif($idcardsample)
                                    {{-- Fallback UI --}}

                                    <div class="id-card-preview">
                                        <img src="{{ asset('storage/' . $idcardsample->file_path) }}" class="id-card-template img-fluid img-thumbnail" alt="ID Card Template">
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        No ID card sample selected.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Classes & Sections</h3>
                </div>
                <div class="card-body">
                    @if($classes->isEmpty())
                        <p class="text-muted">No classes or sections found for this school.</p>
                    @else
                        <div class="row">
                            @foreach($classes as $class)
                                <div class="col-md-4 mb-4">
                                    <a href="{{ route('schools.classes.students', ['school' => $school, 'class' => $class]) }}" class="text-decoration-none text-dark">
                                        <div class="card h-100 cursor-pointer">
                                            <div class="card-header bg-primary text-white d-flex align-items-center w-100">
                                                <h3 class="card-title mb-0 flex-grow-1">{{ $class->name }}</h3>
                                                <span class="badge bg-light text-dark ms-3" style="font-size: 0.9rem;">
                                                    {{ App\Models\Student::where('class_id', $class->id)->where('school_id', $school->id)->count() }} Students
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <p class="mb-0 text-muted">Click to view students</p>
                                                <p class="mb-0 mt-2 text-success" style="font-size: 1rem;">
                                                    {{ App\Models\Student::where('class_id', $class->id)->where('school_id', $school->id)->whereNull('photo')->count() }} students without capture photo
                                                </p>
                                                 <p class="mb-0 mt-2 text-danger" style="font-size: 1rem;">
                                                    {{ App\Models\Student::where('class_id', $class->id)->where('school_id', $school->id)->where('idcardprinted', 'no')->count() }} students without printed ID cards
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
