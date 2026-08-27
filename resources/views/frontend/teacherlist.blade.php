@extends('frontend.layout.applayout')
@section('title', 'Teacher List')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <!-- <div class="col-sm-6">
                    <h1>Teachers</h1>
                </div> -->
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">Teacher List</h3>
                    <a href="#" class="btn btn-sm btn-primary ml-auto">
                        Add Teacher
                    </a>
                </div>
                
                <div class="card-body">
                    <form method="GET" action="" class="row g-2 align-items-end mb-3">
                        <div class="col-md-3">
                            <label class="form-label">ID Card Created</label>
                            <select name="idcardprinted" class="form-control" onchange="this.form.submit()">
                                <option value="">All Teachers</option>

                                <option value="yes" {{ request('idcardprinted') == 'yes' ? 'selected' : '' }}>
                                    Yes
                                </option>

                                <option value="no" {{ request('idcardprinted') == 'no' ? 'selected' : '' }}>
                                    No
                                </option>
                          </select>
                        </div>
                        <div class="col-md-3">
                        <label class="form-label">Teacher Photo</label>
                        <select name="teacher_photo" class="form-control" onchange="this.form.submit()">
                            <option value="">All Teachers</option>
                            <option value="with_photo" {{ request('teacher_photo') == 'with_photo' ? 'selected' : '' }}>With Photo</option>
                            <option value="without_photo" {{ request('teacher_photo') == 'without_photo' ? 'selected' : '' }}>Without Photo</option>
                        </select>
                        </div>
                    </form>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" id="teacherSearch" class="form-control" placeholder="Search by Name or Phone">
                        </div>
                    </div>
                    <table class="table table-bordered table-striped" id="teacherTable">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teachers as $teacher)
                                <tr>
                                    <td>
                                        @if(!empty($teacher->photo))
                                            <img src="{{ asset('storage/' . $teacher->photo) }}" width="50" height="50" style="object-fit: cover;">
                                        @elseif(!empty($teacher->capturephoto))
                                            <img src="{{ asset('storage/' . $teacher->capturephoto) }}" width="50" height="50" style="object-fit: cover;">
                                        @else
                                            <span class="text-muted">No Photo</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                                    </td>

                                    <td>
                                        {{ $teacher->phone ?? '-' }}
                                    </td>

                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="#" class="btn btn-sm btn-info">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No teachers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="mt-3">
                            {{ $teachers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection
