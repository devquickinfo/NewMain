@extends('frontend.layout.applayout')
@section('title', 'Student Details')
@section('content')
<style>
    /*.student-photo-wrapper {
        position: relative;
        width: 200px;
        height: 200px;
        margin: 0 auto;
    }

    .student-photo-wrapper .student-photo {
        width: 200px;
        height: 200px;
        object-fit: cover;
        display: block;
    }

    .photo-hover-options {
        position: absolute;
        top: 0;
        left: 0;
        width: 200px;
        height: 200px;

        background: rgba(0, 0, 0, 0.55);
        border-radius: 50%;

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;

        opacity: 0;
        transition: opacity 0.25s ease;
    }

    .student-photo-wrapper:hover .photo-hover-options {
        opacity: 1;
    }

    .photo-hover-options .btn {
        min-width: 125px;
    }*/
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
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-body box-profile">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                           @if($student->capturephoto || $student->photo)
                            @php
                                $studentPhoto = $student->capturephoto
                                    ? $student->capturephoto
                                    : $student->photo;

                                $studentPhotoUrl = asset('storage/' . $studentPhoto);
                            @endphp
                            <div class="student-photo-wrapper">
                                <img src="{{ $studentPhotoUrl }}"
                                    alt="Student Photo"
                                    class="profile-user-img img-fluid img-circle student-photo"
                                    style="width: 180px; height: 180px; object-fit: cover;">
                                <div class="photo-hover-options mt-2">
                                    <a href="{{ $studentPhotoUrl }}"
                                    class="btn btn-sm btn-light"
                                    data-toggle="modal"
                                    data-target="#viewPhotoModal">
                                        <i class="fas fa-eye mr-1"></i>
                                        View Image
                                    </a>
                                    <a href="javascript:void(0);"
                                    class="btn btn-sm btn-primary capture-student-btn"
                                    data-toggle="modal"
                                    data-target="#photoModal"
                                    data-student-id="{{ $student->id }}">
                                        <i class="fas fa-camera mr-1"></i>
                                        Change Image
                                    </a>
                                </div>
                            </div>
                            @else
                                <a href="javascript:void(0);"
                                    class="capture-student-btn d-inline-flex align-items-center justify-content-center
                                            bg-light border rounded-circle text-decoration-none"
                                    data-toggle="modal"
                                    data-target="#photoModal"
                                    data-student-id="{{ $student->id }}"
                                    style="width:180px;height:180px;">
                                        <i class="fas fa-user fa-4x text-muted"></i>
                                </a>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h2 class="font-weight-bold mb-1">
                                {{ $student->first_name }}
                                {{ $student->last_name }}
                            </h2>
                            <p class="text-muted mb-2">
                                <i class="fas fa-id-card mr-1"></i>
                                Admission No:
                                <strong>
                                    {{ $student->admission_no ?? 'N/A' }}
                                </strong>
                            </p>
                            <p class="mb-2">
                                <span class="badge badge-primary px-3 py-2">
                                    <i class="fas fa-graduation-cap mr-1"></i>
                                    {{ $student->studentClass->name ?? 'N/A' }}
                                </span>

                                <span class="badge badge-info px-3 py-2 ml-1">
                                    Section:
                                    {{ $student->section->name ?? 'N/A' }}
                                </span>
                            </p>
                            @if($student->idcardprinted == 'yes')
                                <span class="badge badge-success px-3 py-2">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    ID Card Printed
                                </span>
                            @else
                                <span class="badge badge-danger px-3 py-2">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    ID Card Not Printed
                                </span>

                            @endif
                        </div>
                        <div class="col-md-3 text-md-right mt-3 mt-md-0">
                            <a href="{{ route('students.edit', $student->id) }}"
                            class="btn btn-warning">
                                <i class="fas fa-edit mr-1"></i>
                            </a>
                            <form action="{{ route('students.destroy', $student->id) }}"
                                method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-danger"
                                        onclick="">
                                    <i class="fas fa-trash mr-1"></i>
                                </button>
                            </form>
                            <a href="{{ url()->previous() }}"
                               class="btn btn-secondary btn-sm px-3">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-user mr-2 text-primary"></i>
                                Personal Information
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover mb-0">
                                <tr>
                                    <th style="width:40%;">
                                        <i class="fas fa-id-card text-muted mr-2"></i>
                                        Admission No
                                    </th>
                                    <td>
                                        {{ $student->admission_no ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <i class="fas fa-user text-muted mr-2"></i>
                                        Full Name
                                    </th>
                                    <td>
                                        {{ $student->first_name }}
                                        {{ $student->last_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <i class="fas fa-male text-muted mr-2"></i>
                                        Father Name
                                    </th>
                                    <td>
                                        {{ $student->father_name ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <i class="fas fa-venus-mars text-muted mr-2"></i>
                                        Gender
                                    </th>
                                    <td>
                                        {{ $student->gender ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <i class="fas fa-birthday-cake text-muted mr-2"></i>
                                        Date of Birth
                                    </th>
                                    <td>
                                        @if($student->date_of_birth)
                                            {{ \Carbon\Carbon::parse($student->date_of_birth)->format('d/m/Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <i class="fas fa-tint text-muted mr-2"></i>
                                        Blood Group
                                    </th>
                                    <td>
                                        {{ $student->blood_group ?? 'N/A' }}
                                    </td>
                                </tr>

                            </table>

                        </div>

                    </div>

                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-graduation-cap mr-2 text-primary"></i>
                                Academic & Contact
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover mb-0">
                                <tr>
                                    <th style="width:40%;">
                                        <i class="fas fa-school text-muted mr-2"></i>
                                        Class
                                    </th>
                                    <td>
                                        {{ $student->studentClass->name ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <i class="fas fa-layer-group text-muted mr-2"></i>
                                        Section
                                    </th>
                                    <td>
                                        {{ $student->section->name ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <i class="fas fa-phone text-muted mr-2"></i>
                                        Phone
                                    </th>
                                    <td>
                                        {{ $student->phone ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <i class="fas fa-id-badge text-muted mr-2"></i>
                                        ID Card
                                    </th>
                                    <td>
                                        @if($student->idcardprinted == 'yes')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check mr-1"></i>
                                                Printed
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times mr-1"></i>
                                                Not Printed
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <i class="fas fa-palette text-muted mr-2"></i>
                                        Photo Background
                                    </th>
                                    <td>
                                        {{ $student->capture_background ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <i class="fas fa-calendar text-muted mr-2"></i>
                                        Added On
                                    </th>
                                    <td>
                                        {{ $student->created_at
                                            ? $student->created_at->format('d/m/Y')
                                            : 'N/A' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="card shadow-sm">
                <div class="card-body text-right">
                   
                </div>
            </div> -->
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
<div class="modal fade" id="viewPhotoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Student Photo
                </h5>

                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body text-center">

                <img id="viewStudentPhoto"
                     src="{{ $studentPhotoUrl ?? '' }}"
                     alt="Student Photo"
                     class="img-fluid"
                     style="max-height: 600px;">

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


