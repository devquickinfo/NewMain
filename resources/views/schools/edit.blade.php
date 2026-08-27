@extends('frontend.layout.applayout')
@section('title', 'Edit School')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <!-- <div class="col-sm-6">
            <h1>Edit School</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Edit School</li>
            </ol>
          </div> -->
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">EDIT SCHOOL</h3>
            <a href="{{ route('schools.index') }}" class="btn btn-primary float-right"><i class="fas fa-arrow-left"></i> Back</a>
          </div>
          <form action="{{ route('schools.update', $school->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="school_code">School Code</label>
                    <input type="text" name="school_code" class="form-control" id="school_code" value="{{ old('school_code', $school->school_code) }}" required>
                        @error('school_code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="school_name">School Name</label>
                    <input type="text" name="school_name" class="form-control" id="school_name" value="{{ old('school_name', $school->school_name) }}" required>
                        @error('school_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $school->email) }}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone', $school->phone) }}">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="school_logo">School Logo</label>
                    <input type="file" name="school_logo" class="form-control" id="school_logo">
                        @error('school_logo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                      <option value="1" {{ old('status', $school->status) == 1 ? 'selected' : '' }}>Active</option>
                      <option value="0" {{ old('status', $school->status) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" name="city" class="form-control" id="city" value="{{ old('city', $school->city) }}">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" name="state" class="form-control" id="state" value="{{ old('state', $school->state) }}">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="pincode">Pincode</label>
                    <input type="text" name="pincode" class="form-control" id="pincode" value="{{ old('pincode', $school->pincode) }}">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="address">School Address</label>
                    <textarea name="address" class="form-control" id="address" rows="5">{{ old('address', $school->address) }}</textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </form>
        </div>
      </div>
    </section>
</div>

@endsection