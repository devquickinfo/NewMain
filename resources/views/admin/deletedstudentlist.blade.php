@extends('frontend.layout.applayout')
@section('title', 'Deleted Student List')
@section('content')
<style>
@media (max-width: 767.98px) {

    .pagination {
        flex-wrap: wrap;
        justify-content: flex-start !important;
        margin-bottom: 0;
    }

    .pagination .page-item {
        margin-bottom: 4px;
    }

    .pagination .page-link {
        padding: 5px 9px;
        font-size: 13px;
    }
}
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
               
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">Deleted Student List</h3>
                </div>
                <div class="card-body">
                    <form method="get" action="" class="row g-2 align-items-end mb-3">
                        @csrf
                        <div class="col-md-3">
                            <label class="form-label">School</label>
                            <select name="school" class="form-control" onchange="this.form.submit()">
                                <option value="">All Schools</option>
                                @foreach($school as $s)
                                <option value="{{ $s->id }}" {{ request('school')==$s->id ? 'selected' : '' }}>
                                    {{ $s->school_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Class</label>
                            <select name="class" class="form-control" onchange="this.form.submit()">
                                <option value="">All Classes</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class')==$class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Section</label>
                            <select name="section" class="form-control" onchange="this.form.submit()">
                                <option value="">All Sections</option>

                                @foreach($sections as $section)
                                <option value="{{ $section->id }}" {{ request('section')==$section->id ? 'selected' : ''
                                    }}>
                                    {{ $section->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" id="studentSearch" class="form-control"
                                placeholder="Search by Admission No, Name or Phone">
                        </div>
                        <div class="col-md-1">
                            <a href="{{ route('student.deleted') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="studentTable">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Father Name</th>
                                    <th>Section</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                <tr>
                                    <td>
                                        @if($student->photo)
                                        <a href="{{ asset('storage/' . $student->photo) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $student->photo) }}" alt="Student Photo"
                                                style="width: 50px; height: 50px; object-fit: cover;"
                                                class="img-thumbnail rounded-circle">
                                        </a>
                                        @elseif($student->capturephoto)
                                        <a href="{{ asset('storage/' . $student->capturephoto) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $student->capturephoto) }}" alt="Student Photo"
                                                style="width: 50px; height: 50px; object-fit: cover;" class="img-thumbnail">
                                        </a>
                                        @else
                                        <button type="button" class="btn btn-sm btn-link text-white capture-student-btn"
                                            data-toggle="modal" data-target="#photoModal"
                                            data-student-id="{{ $student->id }}">
                                            Add Photo
                                        </button>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $student->first_name }}
                                        {{ $student->last_name }}
                                    </td>
                                    <td>
                                        {{ $student->father_name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $student->section->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $student->phone ?? '-' }}
                                    </td>
                                    <td style="white-space: nowrap;">
                                        <form action="{{ route('student.restore', $student->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="">Restore</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        No students found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="row align-items-center mt-3">
                                <div class="col-12 col-md-5 mb-2 mb-md-0">
                                    <small class="text-muted">
                                        Showing
                                        <strong>{{ $students->firstItem() }}</strong>
                                        to
                                        <strong>{{ $students->lastItem() }}</strong>
                                        of
                                        <strong>{{ $students->total() }}</strong>
                                        students
                                    </small>
                                </div>
                                <div class="col-12 col-md-7">
                                    <div class="d-flex justify-content-md-end justify-content-start">
                                        {{ $students->onEachSide(1)->links() }}
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection