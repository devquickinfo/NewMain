@extends('frontend.layout.applayout')

@section('title', 'Create ID Card Template')

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
                        Create ID Card Template
                    </h1>

                    <small class="text-muted">
                        Upload your ID card design
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

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif


            @if($errors->any())

                <div class="alert alert-danger">

                    <strong>Please fix the following:</strong>

                    <ul class="mb-0 mt-2">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

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
                            action="{{ route('id-card-templates.store') }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >

                            @csrf


                            <div class="card-body">

                                <div class="form-group">

                                    <label>
                                        Template Name
                                    </label>

                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        placeholder="Example: Student ID Card"
                                        value="{{ old('name') }}"
                                        required
                                    >

                                    <small class="form-text text-muted">
                                        Give this template a name so you can identify it later.
                                    </small>

                                </div>


                                <div class="form-group">

                                    <label>
                                        ID Card Image
                                    </label>

                                    <div
                                        class="upload-box"
                                        id="uploadBox"
                                    >

                                        <input
                                            type="file"
                                            name="image"
                                            id="templateImage"
                                            accept="image/jpeg,image/png,image/webp"
                                            hidden
                                            required
                                        >


                                        <div
                                            class="upload-content"
                                            id="uploadContent"
                                        >

                                            <i class="fas fa-cloud-upload-alt"></i>

                                            <h5>
                                                Upload ID Card Image
                                            </h5>

                                            <p>
                                                Click here or drag and drop
                                            </p>

                                            <small>
                                                JPG, PNG or WEBP · Maximum 5 MB
                                            </small>

                                        </div>


                                        <img
                                            id="imagePreview"
                                            class="image-preview"
                                            style="display:none;"
                                        >

                                    </div>

                                </div>


                                <div
                                    id="imageInformation"
                                    class="alert alert-info"
                                    style="display:none;"
                                >

                                    <div class="row">

                                        <div class="col-md-4">

                                            <strong>
                                                Width
                                            </strong>

                                            <br>

                                            <span id="imageWidth">
                                                -
                                            </span>
                                            px

                                        </div>


                                        <div class="col-md-4">

                                            <strong>
                                                Height
                                            </strong>

                                            <br>

                                            <span id="imageHeight">
                                                -
                                            </span>
                                            px

                                        </div>


                                        <div class="col-md-4">

                                            <strong>
                                                Ratio
                                            </strong>

                                            <br>

                                            <span id="imageRatio">
                                                -
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="card-footer">

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >

                                    <i class="fas fa-arrow-right mr-1"></i>

                                    Upload & Design

                                </button>

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


                <div class="col-md-4">

                    <div class="card card-info">

                        <div class="card-header">

                            <h3 class="card-title">
                                <i class="fas fa-info-circle mr-2"></i>
                                How It Works
                            </h3>

                        </div>


                        <div class="card-body">

                            <div class="template-step">

                                <div class="step-number">
                                    1
                                </div>

                                <div>
                                    <strong>
                                        Upload your card
                                    </strong>

                                    <p>
                                        Upload any JPG, PNG or WEBP ID card design.
                                    </p>
                                </div>

                            </div>


                            <div class="template-step">

                                <div class="step-number">
                                    2
                                </div>

                                <div>
                                    <strong>
                                        Place fields
                                    </strong>

                                    <p>
                                        Drag Photo, Name, Class, DOB and other fields onto the card.
                                    </p>
                                </div>

                            </div>


                            <div class="template-step">

                                <div class="step-number">
                                    3
                                </div>

                                <div>
                                    <strong>
                                        Save template
                                    </strong>

                                    <p>
                                        The positions are saved automatically as percentages.
                                    </p>

                                </div>

                            </div>


                            <div class="template-step">

                                <div class="step-number">
                                    4
                                </div>

                                <div>
                                    <strong>
                                        Use for students
                                    </strong>

                                    <p>
                                        Every student will use the same template automatically.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="card card-success">

                        <div class="card-header">

                            <h3 class="card-title">
                                Supported Fields
                            </h3>

                        </div>

                        <div class="card-body">

                            <span class="badge badge-primary m-1">
                                Photo
                            </span>

                            <span class="badge badge-primary m-1">
                                Name
                            </span>

                            <span class="badge badge-primary m-1">
                                Father Name
                            </span>

                            <span class="badge badge-primary m-1">
                                Class
                            </span>

                            <span class="badge badge-primary m-1">
                                Section
                            </span>

                            <span class="badge badge-primary m-1">
                                DOB
                            </span>

                            <span class="badge badge-primary m-1">
                                Gender
                            </span>

                            <span class="badge badge-primary m-1">
                                Blood Group
                            </span>

                            <span class="badge badge-primary m-1">
                                Phone
                            </span>

                            <span class="badge badge-primary m-1">
                                Admission No
                            </span>

                            <span class="badge badge-primary m-1">
                                School Logo
                            </span>

                            <span class="badge badge-primary m-1">
                                School Name
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection


@section('scripts')

<style>

.upload-box {
    border: 2px dashed #adb5bd;
    border-radius: 12px;
    min-height: 280px;

    display: flex;
    align-items: center;
    justify-content: center;

    cursor: pointer;

    background: #f8f9fa;

    transition: all .2s ease;

    overflow: hidden;

    position: relative;
}

.upload-box:hover {
    border-color: #007bff;
    background: #f0f7ff;
}

.upload-box.drag-over {
    border-color: #28a745;
    background: #f0fff4;
}

.upload-content {
    text-align: center;
    color: #6c757d;
}

.upload-content i {
    font-size: 55px;
    color: #007bff;
    margin-bottom: 15px;
}

.upload-content h5 {
    font-weight: 700;
}

.upload-content p {
    margin-bottom: 5px;
}

.image-preview {
    max-width: 100%;
    max-height: 400px;
    object-fit: contain;
}

.template-step {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
}

.step-number {
    min-width: 35px;
    height: 35px;

    border-radius: 50%;

    background: #007bff;
    color: #fff;

    display: flex;
    align-items: center;
    justify-content: center;

    font-weight: bold;
}

.template-step p {
    margin: 3px 0 0;
    color: #6c757d;
    font-size: 13px;
}

</style>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const uploadBox =
        document.getElementById('uploadBox');

    const imageInput =
        document.getElementById('templateImage');

    const uploadContent =
        document.getElementById('uploadContent');

    const imagePreview =
        document.getElementById('imagePreview');

    const imageInformation =
        document.getElementById('imageInformation');

    const imageWidth =
        document.getElementById('imageWidth');

    const imageHeight =
        document.getElementById('imageHeight');

    const imageRatio =
        document.getElementById('imageRatio');


    /*
    |--------------------------------------------------------------------------
    | Click upload box
    |--------------------------------------------------------------------------
    */

    uploadBox.addEventListener('click', function () {

        imageInput.click();

    });


    /*
    |--------------------------------------------------------------------------
    | File selected
    |--------------------------------------------------------------------------
    */

    imageInput.addEventListener('change', function () {

        if (this.files && this.files[0]) {

            showImage(this.files[0]);

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Drag over
    |--------------------------------------------------------------------------
    */

    uploadBox.addEventListener('dragover', function (e) {

        e.preventDefault();

        uploadBox.classList.add('drag-over');

    });


    /*
    |--------------------------------------------------------------------------
    | Drag leave
    |--------------------------------------------------------------------------
    */

    uploadBox.addEventListener('dragleave', function () {

        uploadBox.classList.remove('drag-over');

    });


    /*
    |--------------------------------------------------------------------------
    | Drop
    |--------------------------------------------------------------------------
    */

    uploadBox.addEventListener('drop', function (e) {

        e.preventDefault();

        uploadBox.classList.remove('drag-over');

        const files = e.dataTransfer.files;

        if (files.length > 0) {

            imageInput.files = files;

            showImage(files[0]);

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Show image
    |--------------------------------------------------------------------------
    */

    function showImage(file) {

        if (!file.type.startsWith('image/')) {

            alert('Please select an image file.');

            return;

        }


        const reader = new FileReader();


        reader.onload = function (e) {

            imagePreview.src = e.target.result;

            imagePreview.style.display = 'block';

            uploadContent.style.display = 'none';


            /*
            |--------------------------------------------------------------------------
            | Get image dimensions
            |--------------------------------------------------------------------------
            */

            const img = new Image();

            img.onload = function () {

                const width = img.naturalWidth;
                const height = img.naturalHeight;

                const ratio =
                    (width / height).toFixed(2);


                imageWidth.textContent = width;

                imageHeight.textContent = height;

                imageRatio.textContent = ratio;

                imageInformation.style.display = 'block';

            };

            img.src = e.target.result;

        };


        reader.readAsDataURL(file);

    }

});

</script>

@endsection