@extends('frontend.layout.applayout')
@section('title', 'Class & Section Overview')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Class & Section Overview</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Classes</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @foreach($classes as $class)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title mb-0">{{ $class->name }}</h3>
                            </div>
                            <div class="card-body">
                                @if($class->sections->isEmpty())
                                    <p class="text-muted">No sections found.</p>
                                @else
                                    <div class="row">
                                        @foreach($class->sections as $section)
                                            <div class="col-12 mb-3">
                                                <div class="border rounded p-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <strong>Section {{ $section->name }}</strong>
                                                        <a href="{{ route('school.class.section.students', [$class->id, $section->id]) }}" class="btn btn-sm btn-success">View Students</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection
