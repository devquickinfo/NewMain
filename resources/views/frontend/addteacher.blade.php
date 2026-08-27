@extends('frontend.layout.applayout')
@section('title', 'Add Teacher')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <!-- <div class="col-sm-6">
            <h1>Add Teacher</h1>
          </div> -->
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">{{ isset($teacher) ? 'EDIT TEACHER' : 'ADD TEACHER' }}</h3>
              </div>
              @if(session('success'))
                <div class="alert alert-success m-3 mb-0">{{ session('success') }}</div>
              @endif
              <form action="{{ isset($teacher) ? route('teachers.update', $teacher->id) : route('teachers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($teacher)) @method('PUT') @endif
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $teacher->first_name ?? '') }}">
                        @error('first_name')<span class="text-danger">{{ $message }}</span>@enderror
                      </div>
                      <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $teacher->last_name ?? '') }}">
                      </div>
                      <div class="form-group">
                        <label>Gender</label>
                        <select name="gender" class="form-control">
                          <option value="">-- Select --</option>
                          <option value="Male" {{ old('gender', $teacher->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                          <option value="Female" {{ old('gender', $teacher->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                          <option value="Other" {{ old('gender', $teacher->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', optional($teacher->date_of_birth ?? null)->format('Y-m-d') ?? '') }}">
                      </div>
                      <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $teacher->phone ?? '') }}">
                      </div>
                      <div class="form-group">
                        <label>Photo Upload</label>
                        <input type="file" name="photo" class="form-control">
                      </div>
                      @if(isset($teacher) && $teacher->photo)
                        <div class="form-group">
                          <label>Current Uploaded Photo</label><br>
                          <img src="{{ asset('storage/' . $teacher->photo) }}" style="max-width:150px;max-height:150px;">
                        </div>
                      @endif
                      @if(isset($teacher) && $teacher->capturephoto)
                        <div class="form-group">
                          <label>Captured Photo</label><br>
                          <img src="{{ asset('storage/' . $teacher->capturephoto) }}" style="max-width:150px;max-height:150px;">
                        </div>
                      @endif
                    </div>
                    <div class="col-md-8">
                      <h3>Capture Photo</h3>
                      <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="5">{{ old('address', $teacher->address ?? '') }}</textarea>
                      </div>
                      <input type="hidden" name="photo_data" id="photo_data">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">{{ isset($teacher) ? 'Update' : 'Submit' }}</button>
                </div>
              </form>
            </div>

            <div class="card card-secondary mt-4">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Teacher List</h3>
                <a href="{{ route('teachers.create') }}" class="btn btn-sm btn-primary">Add Teacher</a>
              </div>
              <div class="card-body">
                @if($teachers->isEmpty())
                  <p class="text-muted">No teachers found.</p>
                @else
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Phone</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($teachers as $teacherItem)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $teacherItem->first_name }} {{ $teacherItem->last_name }}</td>
                            <td>{{ $teacherItem->phone ?? '-' }}</td>
                            <td>
                              <a href="{{ route('teachers.edit', $teacherItem->id) }}" class="btn btn-sm btn-warning">Edit</a>
                              <form action="{{ route('teachers.destroy', $teacherItem->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this teacher?')">Delete</button>
                              </form>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <div class="mt-3">{{ $teachers->links() }}</div>
                @endif
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </div>

@endsection
