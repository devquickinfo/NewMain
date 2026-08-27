@extends('frontend.layout.applayout')

@section('title', 'Generate ID Cards')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
     
      </div>
    </div>
</section>
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h1 class="m-0">
                        Generate ID Cards
                    </h1>

                    <small class="text-muted">
                        {{ $template->name }}
                    </small>
                </div>

                <a href="{{ route('id-card-templates.index') }}"
                   class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Back
                </a>

            </div>

        </div>
    </section>


    <section class="content">

        <div class="container-fluid">

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter mr-2"></i>
                        Filters
                    </h3>
                </div>

                <div class="card-body">

                    <form method="GET" action="{{ route('id-card-templates.students', $template->id) }}">

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Class</label>
                                    <select name="class_id" class="form-control" onchange="this.form.submit()">
                                        <option value="">All Classes</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}"
                                                {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Section</label>
                                    <select name="section_id" class="form-control" onchange="this.form.submit()">
                                        <option value="">All Sections</option>
                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}"
                                                {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                                {{ $section->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Search</label>
                                    <input
                                        type="text"
                                        name="search"
                                        class="form-control"
                                        placeholder="Name or Admission No"
                                        value="{{ request('search') }}"
                                    >
                                </div>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search mr-1"></i>
                            Search
                        </button>

                        <a href="{{ route('id-card-templates.students', $template->id) }}" class="btn btn-secondary">
                            <i class="fas fa-sync-alt mr-1"></i>
                            Reset
                        </a>

                    </form>

                </div>

            </div>


            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users mr-2"></i>
                        <span class="badge badge-info">
                            {{ $students->total() }} Students
                        </span>
                    </h3>
                </div>

                <form action="{{ route('id-card-templates.generate', $template->id) }}"
                      method="POST"
                      target="_blank">

                    @csrf

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-bordered table-hover mb-0">

                                <thead>
                                    <tr>
                                        <th width="40">
                                            <input type="checkbox" id="selectAll">
                                        </th>
                                        <th>Photo</th>
                                        <th>Student Name</th>
                                        <th>Father Name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($students as $student)

                                        <tr>
                                            <td>
                                                <input
                                                    type="checkbox"
                                                    name="student_ids[]"
                                                    value="{{ $student->id }}"
                                                    class="student-checkbox"
                                                >
                                            </td>
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
                                            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                            <td>{{ $student->father_name }}</td>
                                            <td>{{ $student->studentClass->name ?? '-' }}</td>
                                            <td>{{ $student->section->name ?? '-' }}</td>
                                        </tr>

                                    @empty

                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                No students found.
                                            </td>
                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                        <div class="p-3">
                            {{ $students->withQueryString()->links() }}
                        </div>

                    </div>

                    @if($students->count() > 0)

                        <div class="card-footer d-flex justify-content-between align-items-center">

                            <span id="selectedCount">
                                0 students selected
                            </span>

                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-id-card mr-1"></i>
                                Generate ID Cards
                            </button>

                        </div>

                    @endif

                </form>

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


@section('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.student-checkbox');
    const selectedCount = document.getElementById('selectedCount');

    function updateCount() {
        const checked = document.querySelectorAll('.student-checkbox:checked').length;

        if (selectedCount) {
            selectedCount.textContent = checked + ' students selected';
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = selectAll.checked;
            });

            updateCount();
        });
    }

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', updateCount);
    });

});
</script>

@endsection
