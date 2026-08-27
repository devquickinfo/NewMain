@extends('frontend.layout.applayout')

@section('title', 'Edit ID Card Template')

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
                        Edit ID Card Template
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

            @if($errors->any())

                <div class="alert alert-danger">

                    <strong>Please fix the following:</strong>

                    <ul class="mb-0 mt-2">

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif


            <div class="row">

                <div class="col-md-8">

                    <div class="card card-primary">

                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-id-card mr-2"></i>
                                ID Card Template
                            </h3>
                        </div>

                        <form
                            action="{{ route('id-card-templates.update', $template->id) }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >

                            @csrf
                            @method('PUT')

                            <div class="card-body">

                                <div class="form-group">

                                    <label>
                                        Template Name
                                    </label>

                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        value="{{ old('name', $template->name) }}"
                                        required
                                    >

                                </div>


                                <div class="form-group">

                                    <label>
                                        Current Image
                                    </label>

                                    <div>
                                        <img
                                            src="{{ asset('storage/' . $template->image_path) }}"
                                            alt="{{ $template->name }}"
                                            style="max-width:100%;max-height:250px;"
                                        >
                                    </div>

                                </div>


                                <div class="form-group">

                                    <label>
                                        Replace Image (optional)
                                    </label>

                                    <input
                                        type="file"
                                        name="image"
                                        class="form-control-file"
                                        accept="image/jpeg,image/png,image/webp"
                                    >

                                    <small class="form-text text-muted">
                                        JPG, PNG or WEBP · Maximum 5 MB
                                    </small>

                                </div>

                            </div>


                            <div class="card-footer">

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    <i class="fas fa-save mr-1"></i>
                                    Save Changes
                                </button>

                                <a
                                    href="{{ route('id-card-templates.designer', $template->id) }}"
                                    class="btn btn-info"
                                >
                                    <i class="fas fa-edit mr-1"></i>
                                    Open Designer
                                </a>

                                <a
                                    href="{{ route('id-card-templates.index') }}"
                                    class="btn btn-secondary"
                                >
                                    Cancel
                                </a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection
