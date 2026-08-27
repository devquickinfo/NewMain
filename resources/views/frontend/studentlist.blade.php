@extends('frontend.layout.applayout')
@section('title', 'Student List')
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
                    <h3 class="card-title">Student List</h3>
                    <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary ml-auto">
                        Add Student
                    </a>
                </div>

                <div class="card-body">
                    <form method="GET" action="" class="row g-2 align-items-end mb-3">
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
                            <label class="form-label">ID Card Created</label>
                            <select name="idcardprinted" class="form-control" onchange="this.form.submit()">
                                <option value="">All Students</option>

                                <option value="yes" {{ request('idcardprinted')=='yes' ? 'selected' : '' }}>
                                    Yes
                                </option>

                                <option value="no" {{ request('idcardprinted')=='no' ? 'selected' : '' }}>
                                    No
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Student Photo</label>
                            <select name="student_photo" class="form-control" onchange="this.form.submit()">
                                <option value="">All Students</option>
                                <option value="with_photo" {{ request('student_photo')=='with_photo' ? 'selected' : ''
                                    }}>With Photo</option>
                                <option value="without_photo" {{ request('student_photo')=='without_photo' ? 'selected'
                                    : '' }}>Without Photo</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Records Per Page</label>
                            <select name="per_page" class="form-control" onchange="this.form.submit()">
                                <option value="10" {{ request('per_page')==10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('per_page')==20 ? 'selected' : '' }}>20</option>
                                <option value="30" {{ request('per_page')==30 ? 'selected' : '' }}>30</option>
                                <option value="40" {{ request('per_page')==40 ? 'selected' : '' }}>40</option>
                                <option value="50" {{ request('per_page')==50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page')==100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                    </form>


                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" id="studentSearch" class="form-control"
                                placeholder="Search by Admission No, Name or Phone">
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('student.list') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
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
                                    <th>Card Printed</th>
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
                                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-info">
                                            View
                                        </a>
                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="">Delete</button>
                                        </form>
                                    </td>
                                    <td style="white-space: nowrap;">
                                        @if($student->idcardprinted == 'no')
                                        <a href="{{ route('student.cardstatus', $student->id) }}" class="btn btn-sm btn-warning">
                                            Not Printed
                                        </a>
                                        @else
                                        <a href="{{ route('student.cardstatus', $student->id) }}" class="btn btn-sm btn-success">
                                            Printed
                                        </a>
                                        @endif 
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
<div class="modal fade" id="photoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Capture Student Photo
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div id="modalPhotoContent">
                    @include('frontend.studentpartials.commoncapture')
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    let selectedStudentId = null;
    $(document).on('click', '.capture-student-btn', function () {
        selectedStudentId = $(this).attr('data-student-id');
        console.log('Selected Student ID:', selectedStudentId);
    });

    $('#save-capture-photo').on('click', function () {
        console.log('Student ID:', selectedStudentId);
        if (!selectedStudentId) {
            alert('Student ID missing');
            return;
        }
        let photoData = $('#photo_data').val();
        let background = $('#camera-bg').val();
        if (!photoData) {
            alert('Please capture a photo first');
            return;
        }
        let url = "{{ route('student.capture-photo', ':student') }}";
        url = url.replace(':student', selectedStudentId);
        console.log('POST URL:', url);
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                photo_data: photoData,
                capture_background: background
            })
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    $('#photoModal').modal('hide');
                    toastr.success(data.message, 'Success');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    alert(data.message || 'Photo could not be saved');
                }

            })
            .catch(error => {
                console.error(error);
                alert('Error while saving photo.');
            });
    });
</script>
@endsection