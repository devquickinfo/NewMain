@extends('frontend.layout.applayout')
@section('title', 'Class Students')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                {{-- <div class="col-sm-6">
                    <h1>{{ $class->name }} - Section {{ $section->name }} Students</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('school.classes') }}">Classes</a></li>
                        <li class="breadcrumb-item active">Students</li>
                    </ol>
                </div> --}}
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Student List</h3>
                </div>
                <div class="card-body">
                    @if($students->isEmpty())
                        <p class="text-muted">No students found for this class and section.</p>
                    @else
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Admission No</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    <tr>
                                        <td>{{ $student->admission_no }}</td>
                                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                        <td>{{ $student->gender }}</td>
                                        <td>{{ $student->phone }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
