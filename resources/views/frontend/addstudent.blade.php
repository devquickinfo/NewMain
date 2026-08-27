@extends('frontend.layout.applayout')
@section('title', 'Add Student')
@section('content')
<style>

  .id-card-preview {
      position: relative;
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
      overflow: hidden;
      border-radius: 8px;
      background: #fff;
      box-shadow: 0 4px 15px rgba(0,0,0,.25);
  }

  /* Background template */
  .id-card-template {
      display: block;
      width: 100%;
      height: auto;
  }

  /* =========================
     SCHOOL LOGO
  ========================= */

  .card-school-logo {
      position: absolute;
      top: 4%;
      left: 5%;
      width: 12%;
      aspect-ratio: 1 / 1;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 100%;
      overflow: hidden;
      z-index: 5;

  }

  .card-school-logo img {
      width: 100%;
      height: 100%;
      object-fit: contain;
  }

  .logo-placeholder {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 8px;
      font-weight: bold;
      color: #333;
  }

  /* =========================
     SCHOOL NAME & ADDRESS
  ========================= */

  .card-school-name {
      position: absolute;
      top: 3%;
      left: 20%;
      width: 75%;
      text-align: left;
      font-size: clamp(12px, 2vw, 22px);
      font-weight: 800;
      color: #173f7a;
      text-transform: uppercase;
      z-index: 5;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
  }

  .card-school-address {
      position: absolute;
      top: 13%;
      left: 20%;
      width: 75%;
      text-align: left;
      font-size: clamp(6px, 1vw, 11px);
      font-weight: 500;
      color: #555;
      z-index: 5;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
  }

  /* =========================
     STUDENT PHOTO
  ========================= */

  .card-student-photo {
      position: absolute;
      top: 50%;
      left: 5%;
      width: 22%;
      aspect-ratio: 3 / 4;
      background: #eee;
      border: 3px solid #fff;
      border-radius: 8px;
      overflow: hidden;
      z-index: 5;
      box-shadow: 0 3px 10px rgba(0,0,0,.25);
  }

  .card-student-photo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
  }

  .student-photo-placeholder {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      font-weight: bold;
      color: #777;
  }

  /* =========================
     STUDENT DETAILS
  ========================= */

  .card-student-details {
      position: absolute;
      top: 25%;
      left: 32%;
      width: 63%;
      z-index: 5;
      color: #173f7a;
      font-size: clamp(7px, 1.15vw, 14px);
      font-weight: 600;
  }

  .card-detail-row {
      display: flex;
      width: 100%;
      margin-bottom: 1.2%;
      line-height: 1.25;
  }

  .detail-label {
      width: 32%;
      font-weight: 800;
      flex-shrink: 0;
  }

  .detail-value {
      width: 68%;
      font-weight: 600;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
  }

  /* Mobile Responsive */
  @media (max-width: 767px) {
      .card-school-name {
          font-size: 14px;
      }
      .card-school-address {
          font-size: 7px;
      }
      .card-student-details {
          font-size: 8px;
      }
  }
  /*ID card Edit Styles*/
   .preview-field {
    position: absolute;
    font-size: 12px;
    font-weight: 600;
    color: #111;
    }

    #preview-name {
        top: 80px;
        left: 80px;
    }

    #preview-admission {
        top: 100px;
        left: 80px;
        font-size: 10px;
    }

    #preview-class {
        top: 115px;
        left: 80px;
        font-size: 10px;
    }

    #preview-address {
        bottom: 15px;
        left: 20px;
        font-size: 10px;
    }
    /* Make modal body scrollable */
    #editSampleModal .modal-body {
        max-height: 80vh;
        overflow-y: auto;
    }

    /* Make the preview column stick while the right column scrolls */
    #editSampleModal .col-md-6:first-child {
        position: sticky;
        top: 0;
        align-self: flex-start;
    }

    /* Bootstrap's .row is display:flex by default, but just in case */
    #editSampleModal .row {
        display: flex;
        flex-wrap: wrap;
    }
    #id-card-preview {
    transition: width 0.2s ease, height 0.2s ease;
    padding: 0;
    box-sizing: border-box;
    }
    .preview-field {
        position: absolute;
        font-size: 12px;
        font-weight: 600;
        color: #111;
        white-space: nowrap;
    }
    #preview-name     { top: 80px;  left: 80px; }
    #preview-admission{ top: 100px; left: 80px; font-size: 10px; }
    #preview-class    { top: 115px; left: 80px; font-size: 10px; }
    #preview-address  { bottom: 15px; left: 20px; font-size: 10px; }
    #preview-photo    { top: 60px; left: 15px; width: 80px; height: 80px; }
    #preview-logo     { top: 10px; left: 10px; width: 40px; height: 40px; }
    #preview-signature{ bottom: 10px; right: 15px; width: 60px; height: 30px; }

</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
     
      </div>
    </div>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title">{{ isset($student) ? 'EDIT STUDENT' : 'ADD STUDENT' }}</h3>
                 <a href="{{ route('student.list') }}"
                      class="btn btn-secondary btn-sm ml-auto flex-shrink-0">
                          <i class="fas fa-arrow-left"></i>
                          <span class="d-none d-sm-inline ml-1">Back</span>
                  </a>
            </div>
            @if(session('success'))
            <div class="alert alert-success m-3 mb-0">
              {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger m-3 mb-0">
              {{ session('error') }}
            </div>
            @endif
            <!-- /.card-header -->
            <!-- form start -->
            <form id="quickForm"
              action="{{ isset($student) ? route('students.update', $student->id) : route('students.store') }}"
              method="POST" enctype="multipart/form-data">
              @csrf
              @if(isset($student))
              @method('PUT')
              @endif
              <div class="card-body">
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Admission No</label>
                      <input type="text" name="admission_no" class="form-control" id="exampleInputEmail1"
                        placeholder="Enter Admission No"
                        value="{{ old('admission_no', $student->admission_no ?? '') }}">
                      @error('admission_no')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">First Name</label>
                      <input type="text" name="first_name" class="form-control" id="exampleInputPassword1"
                        placeholder="Enter First Name" value="{{ old('first_name', $student->first_name ?? '') }}">
                      @error('first_name')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword2">Last Name</label>
                      <input type="text" name="last_name" class="form-control" id="exampleInputPassword2"
                        placeholder="Enter Last Name" value="{{ old('last_name', $student->last_name ?? '') }}">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword2">Father Name</label>
                      <input type="text" name="father_name" class="form-control" id="exampleInputPassword2"
                        placeholder="Enter Father Name" value="{{ old('father_name', $student->father_name ?? '') }}">
                      @error('father_name')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Gender</label>
                      <select name="gender" id="gender" class="form-control">
                        <option value="">-- Select Gender --</option>
                        <option value="Male" {{ old('gender', $student->gender ?? '') == 'Male' ? 'selected' : ''
                          }}>Male</option>
                        <option value="Female" {{ old('gender', $student->gender ?? '') == 'Female' ? 'selected' : ''
                          }}>Female</option>
                        <option value="Other" {{ old('gender', $student->gender ?? '') == 'Other' ? 'selected' : ''
                          }}>Other</option>
                      </select>
                      @error('gender')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">Date of Birth</label>
                      <input type="date" name="date_of_birth" class="form-control" id="exampleInputPassword1"
                        placeholder="Enter Date of Birth"
                        value="{{ old('date_of_birth', optional($student->date_of_birth ?? null)->format('Y-m-d') ?? '') }}">
                      @error('date_of_birth')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword2">Class</label>
                      <select name="class_id" id="class_id" class="form-control" required>
                        <option value="">Select Class</option>

                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id', $student->class_id ?? '') == $class->id ?
                          'selected' : '' }}>
                          {{ $class->name }}
                        </option>
                        @endforeach
                      </select>
                      @error('class_id')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword2">Section</label>
                      <select name="section_id" id="section_id" class="form-control" required>
                        <option value="">Select Section</option>
                        @foreach($sections as $section)
                        <option value="{{ $section->id }}" data-class-id="{{ $section->class_id }}" {{ old('section_id',
                          $student->section_id ?? '') == $section->id ? 'selected' : '' }}>
                          {{ $section->name }}
                        </option>
                        @endforeach
                      </select>
                      @error('section_id')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword2">Blood Group</label>
                      <input type="text" name="blood_group" class="form-control" id="exampleInputPassword2"
                        placeholder="Enter Blood Group" value="{{ old('blood_group', $student->blood_group ?? '') }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword2">Phone</label>
                      <input type="text" name="phone" class="form-control" id="exampleInputPassword2"
                        placeholder="Enter Phone" value="{{ old('phone', $student->phone ?? '') }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword2">Photo Upload</label>
                      <input type="file" name="photo" class="form-control" id="exampleInputPassword2"
                        placeholder="Upload Photo">
                    </div>
                    @if(isset($student) && $student->photo)
                    <div class="form-group">
                      <label>Current Upload Photo:</label><br>
                      <img src="{{ asset('storage/' . $student->photo) }}" alt="Student Photo"
                        style="max-width: 150px; max-height: 150px;">
                    </div>
                    @endif
                    @if(isset($student) && $student->capturephoto)
                    <div class="form-group">
                      <label>Current Capture Photo:</label><br>
                      <img src="{{ asset('storage/' . $student->capturephoto) }}" alt="Captured Student Photo"
                        style="max-width: 150px; max-height: 150px;">
                    </div>
                    @endif
                    @error('photo')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="form-group">
                      <label for="exampleInputPassword2">Address</label>
                      <textarea name="address" class="form-control" rows="5" id="exampleInputPassword2"
                        placeholder="Enter Address">{{ old('address', $student->address ?? '') }}</textarea>
                    </div>
                  </div>
                  <div class="col-md-10">
                    <h3>Capture Photo (Laptop/Mobile)</h3>
                    <p>Capture frame is fixed to passport size ratio 3.5cm x 4.5cm. Captured area keeps original crop
                      pixels with no downscaling.</p>
                    <div class="row mt-3">
                      <!-- Live Camera -->
                      <div class="col-md-3">
                        <div class="card card-primary">
                          <div class="card-header">
                            <h3 class="card-title">Live Camera</h3>
                          </div>
                          <div class="card-body">
                            <div id="camera-stage" style="background:#dbeafe;padding:8px;border-radius:8px;">
                              <div id="camera"
                                style="position:relative;aspect-ratio:3/4;background:#fff;border-radius:8px;overflow:hidden;">
                                <div id="camera-feed" style="position:absolute;inset:0;">
                                </div>
                                <div id="capture-frame" style="position:absolute;
                                                        left:50%;
                                                        top:50%;
                                                        width:62%;
                                                        aspect-ratio:35/45;
                                                        transform:translate(-50%,-50%);
                                                        border:3px solid #000;
                                                        border-radius:12px;
                                                        box-shadow:0 0 0 9999px rgba(0,0,0,.25);
                                                        pointer-events:none;">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Captured Photo -->
                      <div class="col-md-3">
                        <div class="card card-success">
                          <div class="card-header">
                            <h3 class="card-title">Captured Photo</h3>
                          </div>
                          <div class="card-body text-center">
                            <div id="camera-preview" style="width:200px;
                                                height:258px;
                                                margin:auto;
                                                width:100%;
                                                border:1px solid #ccc;
                                                border-radius:8px;
                                                display:flex;
                                                align-items:center;
                                                justify-content:center;
                                                overflow:hidden;
                                                background:#fff;">

                              @if(isset($student) && ($student->capturephoto || $student->photo))
                              <img src="{{ asset('storage/' . ($student->capturephoto ?? $student->photo)) }}"
                                style="width:100%;height:100%;object-fit:cover;">
                              @else
                              No Capture
                              @endif
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Camera Settings -->
                     <!-- <div class="col-md-2">
                        <div class="card card-info">
                          <div class="card-header">
                            <h3 class="card-title">Camera Settings</h3>
                          </div>
                          <div class="card-body">
                            <div class="form-group">
                              <label>Capture Background</label>
                              <select id="camera-bg" name="capture_background" class="form-control">
                                <option value="#dbeafe" {{ old('capture_background', $student->capture_background ??
                                  'Sky Blue') == '#dbeafe' ? 'selected' : '' }}>Sky Blue</option>
                                <option value="#e2e8f0" {{ old('capture_background', $student->capture_background ??
                                  'Sky Blue') == '#e2e8f0' ? 'selected' : '' }}>Light Slate</option>
                                <option value="#dcfce7" {{ old('capture_background', $student->capture_background ??
                                  'Sky Blue') == '#dcfce7' ? 'selected' : '' }}>Mint Green</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Camera</label>
                              <select id="camera-facing-mode" class="form-control">
                                <option value="user">Front Camera</option>
                                <option value="environment" selected>Back Camera</option>
                              </select>
                            </div>
                            <div class="form-group mt-4">
                              <button type="button" id="start-camera" class="btn btn-primary btn-sm">
                                <i class="fas fa-video"></i>
                                Start Camera
                              </button>
                            </div>
                            <div class="form-group">
                              <button type="button" id="capture-photo" class="btn btn-sm btn-success">
                                <i class="fas fa-camera"></i>
                                Capture Photo
                              </button>
                            </div>
                            <input type="hidden" name="photo_data" id="photo_data">
                          </div>
                        </div>
                      </div>-->
                      <div class="col-md-2">
                        <div class="card card-info mb-2">

                            <!-- Header -->
                            <div class="card-header py-1 px-2">
                                <h3 class="card-title mb-0" style="font-size: 15px;">
                                    <i class="fas fa-camera mr-1"></i>
                                    Camera Settings
                                </h3>
                            </div>

                            <!-- Body -->
                            <div class="card-body p-2">

                                <!-- Background + Camera -->
                                <div class="row">

                                    <!-- Capture Background -->
                                    <div class="col-6 pr-1">
                                        <div class="form-group mb-2">
                                            <label class="mb-1" style="font-size: 11px;">
                                                Background
                                            </label>

                                            <select id="camera-bg"
                                                    name="capture_background"
                                                    class="form-control form-control-sm"
                                                    style="font-size: 11px;">

                                                <option value="#dbeafe"
                                                    {{ old(
                                                        'capture_background',
                                                        $student->capture_background ?? '#dbeafe'
                                                    ) == '#dbeafe' ? 'selected' : '' }}>
                                                    Sky Blue
                                                </option>

                                                <option value="#e2e8f0"
                                                    {{ old(
                                                        'capture_background',
                                                        $student->capture_background ?? '#dbeafe'
                                                    ) == '#e2e8f0' ? 'selected' : '' }}>
                                                    Light Slate
                                                </option>

                                                <option value="#dcfce7"
                                                    {{ old(
                                                        'capture_background',
                                                        $student->capture_background ?? '#dbeafe'
                                                    ) == '#dcfce7' ? 'selected' : '' }}>
                                                    Mint Green
                                                </option>

                                            </select>
                                        </div>
                                    </div>

                                    <!-- Camera -->
                                    <div class="col-6 pl-1">
                                        <div class="form-group mb-2">
                                            <label class="mb-1" style="font-size: 11px;">
                                                Camera
                                            </label>

                                            <select id="camera-facing-mode"
                                                    class="form-control form-control-sm"
                                                    style="font-size: 11px;">

                                                <option value="user">
                                                    Front
                                                </option>

                                                <option value="environment" selected>
                                                    Back
                                                </option>

                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <!-- Camera Buttons -->
                                <div class="row">

                                    <div class="col-6 pr-1">
                                        <button type="button"
                                                id="start-camera"
                                                class="btn btn-primary btn-sm"
                                                style="font-size: 10px;">

                                            <i class="fas fa-video mr-1"></i>
                                            Start
                                        </button>
                                    </div>

                                    <div class="col-6 pl-1">
                                        <button type="button"
                                                id="capture-photo"
                                                class="btn btn-success btn-sm btn-block"
                                                style="font-size: 11px;">

                                            <i class="fas fa-camera mr-1"></i>
                                            Capture
                                        </button>
                                    </div>

                                </div>

                                <!-- Hidden Photo Data -->
                                <input type="hidden"
                                    name="photo_data"
                                    id="photo_data">

                            </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                          <div class="card card-info">
                              <div class="card-header d-flex align-items-center">
                                  <h3 class="card-title mb-0">Live ID Card Preview</h3>
                                  <!-- <button type="button"
                                          class="btn btn-sm btn-warning ml-auto"
                                          data-toggle="modal"
                                          data-target="#editSampleModal">
                                      <i class="fas fa-edit"></i> Edit
                                  </button> -->
                                  <!-- <a href="{{ route('idcard.editor') }}"
                                     class="btn btn-sm btn-warning ml-auto" target="_blank">
                                      <i class="fas fa-edit"></i> Edit
                                  </a> -->
                              </div>
                              <div class="card-body p-2" style="overflow-x:auto;">
                                  @if(isset($mainidcard) && $mainidcard && is_array($mainidcard->layout) && isset($mainidcard->layout['fields']))
                                      @php
                                          $layout = $mainidcard->layout;
                                          $cardWidth = (int) ($layout['cardWidth'] ?? $mainidcard->card_width ?? 317);
                                          $cardHeight = (int) ($layout['cardHeight'] ?? $mainidcard->card_height ?? 204);
                                          $background = $mainidcard->background ?: ($idcardsample->file_path ?? null);
                                          $backgroundUrl = $background ? asset('storage/' . $background) : null;
                                          $previewWidth = 317;
                                          $previewHeight = 204;
                                          $scale = min($previewWidth / max($cardWidth, 1), $previewHeight / max($cardHeight, 1));
                                          $fields = $layout['fields'];
                                          uksort($fields, function ($first, $second) use ($fields) {
                                              return (($fields[$first]['type'] ?? '') === 'shape') <=> (($fields[$second]['type'] ?? '') === 'shape');
                                          });
                                      @endphp
                                      <div class="id-card-preview" style="width:{{ $previewWidth }}px;height:{{ $previewHeight }}px;">
                                          <div style="position:absolute;left:50%;top:50%;width:{{ $cardWidth }}px;height:{{ $cardHeight }}px;transform:translate(-50%,-50%) scale({{ $scale }});transform-origin:center;background:{{ $backgroundUrl ? "url('{$backgroundUrl}')" : '#fff' }} center/100% 100% no-repeat;">
                                              @foreach($fields as $key => $field)
                                                  @php
                                                      $type = $field['type'] ?? 'text';
                                                      $fieldType = strtolower(str_replace([' ', '-'], '_', $field['fieldType'] ?? $field['field_type'] ?? $key));
                                                      $fieldLabel = strtolower($field['label'] ?? $field['text'] ?? '');
                                                      if (str_contains($fieldType, 'father') || str_contains($fieldLabel, 'father')) {
                                                          $fieldType = 'father_name';
                                                      }
                                                      if ($fieldType === 'adm' || str_contains($fieldType, 'admission') || str_contains($fieldLabel, 'admission') || str_contains($fieldLabel, 'adm no') || str_contains($fieldLabel, 'roll no')) {
                                                          $fieldType = 'admission_no';
                                                      }
                                                      $value = match ($fieldType) {
                                                          'student_name', 'name' => trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? '')),
                                                          'first_name' => $student->first_name ?? '',
                                                          'last_name' => $student->last_name ?? '',
                                                          'father_name' => $student->father_name ?? '',
                                                          'admission_no' => $student->admission_no ?? '',
                                                          'class' => $student->studentClass->name ?? '',
                                                          'section' => $student->section->name ?? '',
                                                          'dob', 'date_of_birth' => $student->date_of_birth ? $student->date_of_birth->format('d-M-Y') : '',
                                                          'gender' => $student->gender ?? '',
                                                          'blood_group' => $student->blood_group ?? '',
                                                          'phone' => $student->phone ?? '',
                                                          //'address' => $student->address ?? '',
                                                          'school_name' => $school->school_name ?? '',
                                                          'principal_name' => $school->principal_name ?? '',
                                                          default => $field['text'] ?? '',
                                                      };
                                                      $left = (int) ($field['x'] ?? 0);
                                                      $top = (int) ($field['y'] ?? 0);
                                                      $width = isset($field['width']) ? 'width:' . (int) $field['width'] . 'px;' : '';
                                                      $height = isset($field['height']) ? 'height:' . (int) $field['height'] . 'px;' : '';
                                                      $style = "position:absolute;left:{$left}px;top:{$top}px;z-index:" . ($type === 'shape' ? 1 : 10) . ";{$width}{$height}";
                                                      if (!($field['visible'] ?? true)) $style .= 'display:none;';
                                                  @endphp
                                                  @if($type === 'image')
                                                      @php
                                                          $photoPath = collect([$student->photo, $student->capturephoto])->first(function ($path) {
                                                              return $path && \Illuminate\Support\Facades\Storage::disk('public')->exists($path);
                                                          });
                                                          $isStudentPhoto = in_array($fieldType, ['photo', 'student_photo']) || str_contains($fieldType, 'photo') || str_contains($fieldLabel, 'photo');
                                                          $imagePath = $isStudentPhoto ? $photoPath : ($field['src'] ?? null);
                                                          $imageUrl = $imagePath ? (preg_match('/^https?:\/\//', $imagePath) ? $imagePath : asset('storage/' . $imagePath)) : null;
                                                      @endphp
                                                      @if($imageUrl)
                                                          <img src="{{ $imageUrl }}" alt="{{ $fieldType }}" style="{{ $style }}object-fit:contain;">
                                                      @endif
                                                  @elseif($type === 'shape')
                                                      <div style="{{ $style }}background-color:{{ $field['backgroundColor'] ?? 'transparent' }};opacity:{{ $field['opacity'] ?? 1 }};border-radius:{{ (int) ($field['borderRadius'] ?? 0) }}px;"></div>
                                                  @else
                                                      <div style="{{ $style }}font-size:{{ (int) ($field['fontSize'] ?? 14) }}px;color:{{ $field['color'] ?? '#111' }};font-weight:{{ $field['fontWeight'] ?? 'normal' }};">{{ $value }}</div>
                                                  @endif
                                              @endforeach
                                          </div>
                                      </div>
                                  @elseif($idcardsample)
                                      <div class="id-card-preview">
                                          <img
                                              src="{{ asset('storage/' . $idcardsample->file_path) }}"
                                              class="id-card-template"
                                              alt="ID Card Template"
                                          >
                                       
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
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ isset($student) ? 'Update' : 'Submit' }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="modal fade" id="idCardImageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ID Card Sample</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                @if($idcardsample)
                    <img src="{{ asset('storage/' . $idcardsample->file_path) }}"
                         alt="ID Card Sample"
                         class="img-fluid"
                         style="max-height: 80vh;">
                @endif
            </div>
        </div>
    </div>
  </div>
</div>
@if($idcardsample)
<div class="modal fade" id="editSampleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 1200px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Edit ID Card
                </h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Preview ID Card
                                </h3>
                            </div>
                            <div class="card-body text-center">
                                <div id="id-card-preview" style="position: relative; display: inline-block; width: 380px; overflow: hidden; background: #fff;">
                                    <img src="{{ asset('storage/' . $idcardsample->file_path) }}"
                                        id="preview-background"
                                        class="img-fluid"
                                        style="width: 100%; height: auto; display: block;"
                                        alt="ID Card">
                                    <div class="preview-field" id="preview-name">Student Name</div>
                                    <div class="preview-field" id="preview-admission">Admission No: 83838</div>
                                    <div class="preview-field" id="preview-class">Class: Class 1 (A)</div>
                                    <div class="preview-field" id="preview-address">Address</div>
                                    <img id="preview-photo" src="{{ asset('images/default-photo.png') }}" style="display:none; position:absolute; object-fit:cover;">
                                    <img id="preview-logo" src="" style="display:none; position:absolute; object-fit:contain;">
                                    <img id="preview-signature" src="" style="display:none; position:absolute; object-fit:contain;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    ID Card Settings
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>ID CARD TITLE <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="title"
                                           class="form-control"
                                           value="{{ $idcardsample->title ?? '' }}"
                                           id="card-title">
                                </div>
                                <div class="form-group">
                                    <label>LAYOUT</label>
                                    <select name="layout"
                                            id="card-layout"
                                            class="form-control">

                                        <option value="horizontal">
                                            Horizontal
                                        </option>

                                        <option value="vertical">
                                            Vertical
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>BACKGROUND IMAGE</label>
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control"
                                               id="background-image-name"
                                               placeholder="Background Image"
                                               readonly>
                                        <div class="input-group-append">
                                            <label class="btn btn-primary mb-0">
                                                BROWSE
                                                <input type="file"
                                                       id="background-image"
                                                       accept="image/*"
                                                       hidden>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>APPLICABLE USER</label>
                                    <select name="applicable_user"
                                            class="form-control">
                                        <option value="student">
                                            Student
                                        </option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                PAGE LAYOUT WIDTH
                                                <small>(DEFAULT 57 MM)</small>
                                            </label>
                                            <input type="number"
                                                   name="page_width"
                                                   class="form-control"
                                                   value="57"
                                                   step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                PAGE LAYOUT HEIGHT
                                                <small>(DEFAULT 89 MM)</small>
                                            </label>

                                            <input type="number"
                                                   name="page_height"
                                                   class="form-control"
                                                   value="89"
                                                   step="0.1">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>PROFILE IMAGE</label>
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control"
                                               id="profile-image-name"
                                               placeholder="Profile Image"
                                               readonly>
                                        <div class="input-group-append">
                                            <label class="btn btn-primary mb-0">
                                                BROWSE
                                                <input type="file"
                                                       id="profile-image"
                                                       accept="image/*"
                                                       hidden>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>USER PHOTO STYLE</label>
                                    <select name="photo_style"
                                            class="form-control"
                                            id="photo-style">
                                        <option value="square">
                                            Square
                                        </option>
                                        <option value="circle">
                                            Circle
                                        </option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                USER PHOTO SIZE WIDTH
                                                <small>(DEFAULT 21 MM)</small>
                                            </label>
                                            <input type="number"
                                                   name="photo_width"
                                                   class="form-control"
                                                   value="21"
                                                   step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                USER PHOTO SIZE HEIGHT
                                                <small>(DEFAULT 21 MM)</small>
                                            </label>

                                            <input type="number"
                                                   name="photo_height"
                                                   class="form-control"
                                                   value="21"
                                                   step="0.1">
                                        </div>
                                    </div>
                                </div>
                                <label class="mt-2">
                                    Layout Spacing
                                </label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                TOP SPACE
                                                <small>(DEFAULT 2.5 MM)</small>
                                            </label>

                                            <input type="number"
                                                   name="top_space"
                                                   class="form-control"
                                                   value="2.5"
                                                   step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                BOTTOM SPACE
                                                <small>(DEFAULT 2.5 MM)</small>
                                            </label>

                                            <input type="number"
                                                   name="bottom_space"
                                                   class="form-control"
                                                   value="2.5"
                                                   step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                LEFT SPACE
                                                <small>(DEFAULT 3 MM)</small>
                                            </label>

                                            <input type="number"
                                                   name="left_space"
                                                   class="form-control"
                                                   value="3"
                                                   step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                RIGHT SPACE
                                                <small>(DEFAULT 3 MM)</small>
                                            </label>

                                            <input type="number"
                                                   name="right_space"
                                                   class="form-control"
                                                   value="3"
                                                   step="0.1">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>LOGO</label>
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control"
                                               id="logo-name"
                                               placeholder="Logo"
                                               readonly>
                                        <div class="input-group-append">
                                            <label class="btn btn-primary mb-0">
                                                BROWSE
                                                <input type="file"
                                                       id="logo-image"
                                                       accept="image/*"
                                                       hidden>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>
                                        SIGNATURE
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control"
                                               id="signature-name"
                                               placeholder="Signature"
                                               readonly>
                                        <div class="input-group-append">
                                            <label class="btn btn-primary mb-0">
                                                BROWSE

                                                <input type="file"
                                                       id="signature-image"
                                                       accept="image/*"
                                                       hidden>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="id-card-fields">
                                    @php
                                        $fields = [
                                            'admission_no' => 'ADMISSION NO',
                                            'name'         => 'NAME',
                                            'class'        => 'CLASS',
                                            'address'      => 'ADDRESS',
                                            'photo'        => 'PHOTO',
                                            'signature'    => 'SIGNATURE',
                                        ];
                                    @endphp
                                    @foreach($fields as $key => $label)
                                        <div class="row align-items-center mb-3">
                                            <div class="col-6">
                                                <label class="mb-0">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                            <div class="col-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"
                                                           class="custom-control-input"
                                                           id="{{ $key }}_yes"
                                                           name="{{ $key }}"
                                                           value="1"
                                                           checked>

                                                    <label class="custom-control-label"
                                                           for="{{ $key }}_yes">
                                                        Yes
                                                    </label>
                                                </div>

                                            </div>
                                            <div class="col-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"
                                                           class="custom-control-input"
                                                           id="{{ $key }}_no"
                                                           name="{{ $key }}"
                                                           value="0">
                                                    <label class="custom-control-label"
                                                           for="{{ $key }}_no">
                                                        No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">
                    Close
                </button>
                <button type="button"
                        class="btn btn-primary"
                        id="save-id-card">
                    <i class="fas fa-save"></i>
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const classSelect = document.getElementById('class_id');
    const sectionSelect = document.getElementById('section_id');
    function filterSections() {
      const selectedClassId = classSelect.value;
      Array.from(sectionSelect.querySelectorAll('option[data-class-id]')).forEach(function (option) {
                const sectionClassId = option.getAttribute('data-class-id');
                const belongsToAnotherClass = selectedClassId && sectionClassId && sectionClassId !== selectedClassId;
                option.style.display = belongsToAnotherClass ? 'none' : '';
                if (belongsToAnotherClass) {
          option.disabled = true;
        } else {
          option.disabled = false;
        }
      });
      if (!selectedClassId) {
        sectionSelect.value = '';
      }
    }
    if (classSelect && sectionSelect) {
      filterSections();
      classSelect.addEventListener('change', filterSections);
    }
  });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const preview = document.getElementById('id-card-preview');
    const bg = document.getElementById('preview-background');

    // ---- px-per-mm scale, recalculated whenever page width changes ----
    const DISPLAY_WIDTH = 380; // fixed preview width in px
    function getScale() {
        const widthMm = parseFloat(document.querySelector('[name="page_width"]').value) || 57;
        return DISPLAY_WIDTH / widthMm;
    }

    function applyPageSize() {
        const widthMm  = parseFloat(document.querySelector('[name="page_width"]').value) || 57;
        const heightMm = parseFloat(document.querySelector('[name="page_height"]').value) || 89;
        const scale = getScale();
        preview.style.width  = DISPLAY_WIDTH + 'px';
        preview.style.height = (heightMm * scale) + 'px';
        applySpacing();
        applyPhotoSize();
    }

    function applySpacing() {
        const scale = getScale();
        const top    = parseFloat(document.querySelector('[name="top_space"]').value) || 0;
        const bottom = parseFloat(document.querySelector('[name="bottom_space"]').value) || 0;
        const left   = parseFloat(document.querySelector('[name="left_space"]').value) || 0;
        const right  = parseFloat(document.querySelector('[name="right_space"]').value) || 0;

        preview.style.padding =
            (top * scale) + 'px ' +
            (right * scale) + 'px ' +
            (bottom * scale) + 'px ' +
            (left * scale) + 'px';
    }

    function applyPhotoSize() {
        const scale = getScale();
        const w = parseFloat(document.querySelector('[name="photo_width"]').value) || 21;
        const h = parseFloat(document.querySelector('[name="photo_height"]').value) || 21;
        const photo = document.getElementById('preview-photo');
        photo.style.width  = (w * scale) + 'px';
        photo.style.height = (h * scale) + 'px';
    }

    // ---- LAYOUT (horizontal / vertical) ----
    document.getElementById('card-layout').addEventListener('change', function () {
        const widthInput  = document.querySelector('[name="page_width"]');
        const heightInput = document.querySelector('[name="page_height"]');

        // swap width/height values when orientation changes
        const w = widthInput.value;
        const h = heightInput.value;
        widthInput.value  = h;
        heightInput.value = w;

        applyPageSize();
    });

    // ---- PAGE SIZE / SPACING / PHOTO SIZE live inputs ----
    ['page_width', 'page_height'].forEach(name => {
        document.querySelector(`[name="${name}"]`).addEventListener('input', applyPageSize);
    });

    ['top_space', 'bottom_space', 'left_space', 'right_space'].forEach(name => {
        document.querySelector(`[name="${name}"]`).addEventListener('input', applySpacing);
    });

    ['photo_width', 'photo_height'].forEach(name => {
        document.querySelector(`[name="${name}"]`).addEventListener('input', applyPhotoSize);
    });

    // ---- PHOTO STYLE (square / circle) ----
    document.getElementById('photo-style').addEventListener('change', function () {
        const photo = document.getElementById('preview-photo');
        photo.style.borderRadius = this.value === 'circle' ? '50%' : '0';
    });

    // ---- IMAGE UPLOADS (background, profile, logo, signature) ----
    function bindImageUpload(inputId, nameFieldId, targetImgId, showOnUpload = true) {
        document.getElementById(inputId).addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            document.getElementById(nameFieldId).value = file.name;

            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.getElementById(targetImgId);
                img.src = e.target.result;
                if (showOnUpload) img.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }

    bindImageUpload('background-image', 'background-image-name', 'preview-background');
    bindImageUpload('profile-image',    'profile-image-name',    'preview-photo');
    bindImageUpload('logo-image',       'logo-name',              'preview-logo');
    bindImageUpload('signature-image',  'signature-name',         'preview-signature');

    // ---- YES / NO FIELD TOGGLES ----
    const fieldMap = {
        admission_no: 'preview-admission',
        name:         'preview-name',
        class:        'preview-class',
        address:      'preview-address',
        photo:        'preview-photo',
        signature:    'preview-signature',
    };

    Object.keys(fieldMap).forEach(function (key) {
        document.querySelectorAll(`input[name="${key}"]`).forEach(function (radio) {
            radio.addEventListener('change', function () {
                const targetEl = document.getElementById(fieldMap[key]);
                const isYes = this.value === '1' && this.checked;

                if (!targetEl) return;

                if (key === 'photo' || key === 'signature') {
                    // only show if it's set to yes AND actually has an image loaded
                    targetEl.style.display = (isYes && targetEl.src) ? 'block' : 'none';
                } else {
                    targetEl.style.display = isYes ? 'block' : 'none';
                }
            });
        });
    });

    // ---- INIT on modal open ----
    applyPageSize();
});
</script>
@endsection