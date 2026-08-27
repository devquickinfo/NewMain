@extends('frontend.layout.applayout')
@section('title', 'School Details')
@section('content')
<style>
    .id-card-template {
        width: 350px;
        height: 220px;
        object-fit: contain;
        display: block;
    }
    .id-card-section {
        width: 100%;
    }

    .id-card-preview {
        width: 100%;
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }

    .id-card-template {
        width: auto;
        max-width: 100%;
        /* height: auto; */
        display: block;
        max-height: 300px;

    }

</style>
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
                                    target="_blank">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </div>
                                @if($idcardsample)
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
