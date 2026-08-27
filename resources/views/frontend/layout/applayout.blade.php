<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/dist/img/schoolid1.png') }}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('frontend/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('frontend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('frontend/dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
      <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed text-sm">
  
<div class="wrapper">
    <nav class="main-header navbar navbar-expand-md navbar-dark">
    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="d-md-none w-100 text-right mb-2">
        <button class="btn btn-sm btn-outline-light" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="true" aria-label="Close navigation">
          <i class="fas fa-times"></i>
        </button>
      </div>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item d-flex align-items-center">
          <a class="nav-link p-0 d-flex align-items-center" href="#">
              @if(Auth::user()->profilepicture)
                <a href="{{ asset('storage/' . Auth::user()->profilepicture) }}" target="_blank">
                  <img src="{{ asset('storage/' . Auth::user()->profilepicture) }}"
                      alt="Profile"
                      class="img-circle elevation-2"
                      style="width: 32px; height: 32px; object-fit: cover; display: block;">
                </a>
              @else
                  <i class="fas fa-user-circle fa-lg"></i>
              @endif
          </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"> {{ ucwords(Auth::user()->name) }}</i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          @if(Auth::user()?->role === 'school')
          <a href="{{ route('school.profile') }}" class="dropdown-item">
            <i class="fas fa-school mr-2"></i> School Profile
          </a>
          @else
          <a href="{{ route('admin.profile') }}" class="dropdown-item">
            <i class="fas fa-user mr-2"></i>Profile
          </a>
          @endif
          <div class="dropdown-divider"></div>
          <a href="{{ route('user.logout') }}" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
          <div class="dropdown-divider"></div>
        </div>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
    </ul>
  </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <!-- Brand -->
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ asset('frontend/dist/img/schoolid.jpg') }}"
                alt="School ID Logo"
                class="brand-image img-circle elevation-3"
                style="opacity: .8; width: 33px; height: 33px; object-fit: cover;">

            <span class="brand-text font-weight-light">
                School ID Card
            </span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column"
                    data-widget="treeview"
                    role="menu"
                    data-accordion="false">

                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <!-- Deleted Students -->
                   

                    <!-- School -->
                    @if(session('role') !== 'school')
                    <li class="nav-item">
                        <a href="{{ Auth::user()->role === 'school'
                            ? route('schools.show', Auth::user()->school_id)
                            : route('schools.index') }}"
                        class="nav-link {{ request()->routeIs('schools.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-school"></i>
                            <p>School <i class="right fas {{ session('role') === 'superadmin' && session('viewing_school') ? 'fa-angle-down' : 'fa-angle-left' }}"></i></p>
                            
                        </a>
                    </li>
                    @endif

                    <!-- School Navigation -->
                    @if(session('role') === 'school' || session('viewing_school'))

                        <!-- Students -->
                        <li class="nav-item">
                            <a href="{{ route('student.list') }}"
                            class="nav-link {{ request()->routeIs('student.list') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>Students</p>
                            </a>
                        </li>

                        <!-- Create ID Card -->
                        <li class="nav-item">
                            <a href="{{ route('idcard.create') }}"
                            class="nav-link {{ request()->routeIs('idcard.create') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p>Create ID Card</p>
                            </a>
                        </li>

                        <!-- Import Students -->
                        <li class="nav-item">
                            <a href="{{ route('student.import') }}"
                            class="nav-link {{ request()->routeIs('students.import.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-import"></i>
                                <p>Import Students</p>
                            </a>
                        </li>

                        <!-- Teachers -->
                        <li class="nav-item">
                            <a href="{{ route('teacher.list') }}"
                            class="nav-link {{ request()->routeIs('teacher.list') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                <p>Teachers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                        <a href="{{ route('upload-samples.index') }}"
                        class="nav-link {{ request()->routeIs('upload-samples.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-id-card"></i>

                            <p>
                               Card Sample
                            </p>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="{{ route('idcard.editor') }}"
                        class="nav-link {{ request()->routeIs('idcard.editor.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>ID Card Templates</p>
                        </a>
                        </li>

                    @endif
                    @if(session('role') === 'superadmin')
                    <li class="nav-item">
                        <a href="{{ route('student.deleted') }}"
                        class="nav-link {{ request()->routeIs('student.deleted') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-trash"></i>
                            <p>Deleted Students</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('upload-samples.index') }}"
                        class="nav-link {{ request()->routeIs('upload-samples.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-id-card"></i>

                            <p>
                                Upload Sample
                            </p>
                        </a>
                    </li>
                    @endif
                   
                  {{---- <li class="nav-item">
                        <a href="{{ route('id-card-templates.index') }}"
                        class="nav-link {{ request()->routeIs('id-card-templates.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>ID Card Templates</p>
                        </a>
                    </li>---}} 

                </ul>
            </nav>

        </div>
    </aside>



  


  @yield('content')







 
 
  <footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a href="">IDCard</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
</div>

<script src="{{asset('frontend/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('frontend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('frontend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<script src="{{asset('frontend/dist/js/adminlte.js')}}"></script>
<script src="{{asset('frontend/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('frontend/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('frontend/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('frontend/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<script src="{{asset('frontend/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('frontend/dist/js/demo.js')}}"></script>
<script src="{{asset('frontend/dist/js/pages/dashboard2.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{asset('js/app.js')}}"></script>
<script>
  $(document).ready(function () {
      $('#class_id').on('change', function () {
          let classId = $(this).val();
          $('#section_id').html('<option value="">Select Section</option>');
          if (classId) {
              $.ajax({
                  url: '/sections/' + classId,
                  type: 'GET',
                  success: function (response) {

                      $.each(response, function (index, section) {
                          $('#section_id').append(
                              '<option value="' + section.id + '">' + section.name + '</option>'
                          );
                      });

                  }
              });
          }
      });
  });
</script>
<script>
  let stream = null;
  async function startCamera() {
      if (stream) {
          stream.getTracks().forEach(track => track.stop());
      }
      const facingMode = document.getElementById('camera-facing-mode').value;
      try {
          stream = await navigator.mediaDevices.getUserMedia({
              video: {
                  facingMode: { ideal: facingMode }
              },
              audio: false
          });
          const video = document.createElement('video');
          video.autoplay = true;
          video.playsInline = true;
          video.muted = true;
          video.srcObject = stream;
          video.style.width = "100%";
          video.style.height = "100%";
          video.style.objectFit = "cover";

          document.getElementById('camera-feed').innerHTML = "";
          document.getElementById('camera-feed').appendChild(video);

          await video.play();
          if (video.videoWidth && video.videoHeight) {
              video.style.width = "100%";
              video.style.height = "100%";
          }

      } catch (err) {
          console.error(err);
          console.log(err.name + "\n" + err.message);
      }
  }
  // Start button
  document.getElementById('start-camera').addEventListener('click', startCamera);
  // Change camera (Front/Back)
  document.getElementById('camera-facing-mode').addEventListener('change', startCamera);
  // Capture
  document.getElementById('capture-photo').addEventListener('click', function () {
      const video = document.querySelector('#camera-feed video');
      if (!video) {
          alert("Please start the camera first.");
          return;
      }
      const canvas = document.createElement('canvas');
      canvas.width = video.videoWidth || 640;
      canvas.height = video.videoHeight || 480;
      const ctx = canvas.getContext('2d');
      ctx.drawImage(video, 0, 0);
      const image = canvas.toDataURL("image/png");
      document.getElementById('photo_data').value = image;
      document.getElementById('camera-preview').innerHTML =
          '<img src="' + image + '" style="width:100%;height:100%;object-fit:cover;">';
  });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var searchInput = document.getElementById('studentSearch');
        var tableRows = Array.from(document.querySelectorAll('#studentTable tbody tr'));
        if (!searchInput || tableRows.length === 0) {
            return;
        }
        searchInput.addEventListener('keyup', function () {
            var value = this.value.trim().toLowerCase();
            tableRows.forEach(function (row) {
                var admissionNo = row.cells[0].textContent.toLowerCase();
                var name = row.cells[1].textContent.toLowerCase();
                var phone = row.cells[3].textContent.toLowerCase();
                if (value.length < 3) {
                    row.style.display = '';
                } else {
                    var matches = admissionNo.indexOf(value) > -1 || name.indexOf(value) > -1 || phone.indexOf(value) > -1;
                    row.style.display = matches ? '' : 'none';
                }
            });
        });
    });
</script>
<script>
  $(document).on('change', '#selectAll', function () {
      $('.student-checkbox').prop('checked', this.checked);
  });

  $(document).on('change', '.student-checkbox', function () {
      $('#selectAll').prop(
          'checked',
          $('.student-checkbox').length === $('.student-checkbox:checked').length
      );
  });

  $("#upload-samples-btn").on("click", function () {

      if (sampleDropzone.files.length === 0) {
          alert("Please select at least one image.");
          return;
      }
      sampleDropzone.processQueue();
  });
  Dropzone.autoDiscover = false;
  const sampleDropzone = new Dropzone("#sample-dropzone", {

      url: "{{ route('upload-samples.store') }}",

      paramName: "upload_samples",

      method: "POST",
      autoProcessQueue: false, 

      uploadMultiple: false,
      parallelUploads: 8,

      acceptedFiles: "image/*",
      maxFilesize: 40,

      addRemoveLinks: true,

      headers: {
          "X-CSRF-TOKEN": document
              .querySelector('meta[name="csrf-token"]')
              .getAttribute("content")
      },

      // Add fields to each Dropzone preview
      init: function () {

          this.on("addedfile", function (file) {

              let preview = $(file.previewElement);

              preview.append(`
                  <div class="sample-fields mt-2">

                      <input
                          type="text"
                          class="form-control form-control-sm sample-name mb-2"
                          placeholder="Image Name"
                          value="${file.name}"
                      >

                      <input
                          type="text"
                          class="form-control form-control-sm sample-caption mb-2"
                          placeholder="Caption"
                      >

                      <select
                          class="form-control form-control-sm sample-orientation"
                      >
                          <option value="horizontal">
                              Horizontal
                          </option>

                          <option value="vertical">
                              Vertical
                          </option>
                      </select>

                  </div>
              `);
          });

          this.on("sending", function (file, xhr, formData) {

              let preview = $(file.previewElement);

              let imageName = preview
                  .find(".sample-name")
                  .val() || file.name;

              let caption = preview
                  .find(".sample-caption")
                  .val() || "";

              let orientation = preview
                  .find(".sample-orientation")
                  .val() || "horizontal";

              formData.append("image_name", imageName);
              formData.append("caption", caption);
              formData.append("orientation", orientation);

              console.log("========== FORMDATA ==========");

              for (let pair of formData.entries()) {
                  console.log(
                      pair[0],
                      pair[1],
                      pair[1] instanceof File
                  );
              }
          });

          this.on("queuecomplete", function () {
              console.log("All files uploaded successfully.");
              window.location.href = "{{ route('upload-samples.index') }}";

          });

          this.on("error", function (file, error) {

              console.log("ERROR:", error);
          });
      }
  });
</script>
 <script>
    $(document).on('change', '.sample-radio', function () {
        $('#selected-sample-id').val($(this).val());
    });
</script>
<script>
    @if(session('success'))
        toastr.success("{{ session('success') }}", 'Success');
    @endif
</script>
<script>
    $(document).on('click', '.btn-danger', function (e) {

        e.preventDefault();


        let button = this;
        let form = $(button).closest('form');
        let buttonText = $(button).text().trim();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to undo this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: `Yes, ${buttonText} it!`,
            cancelButtonText: 'Cancel'
        }).then((result) => {

            if (result.isConfirmed) {

                if (form.length) {
                    form.submit();
                } else if (button.tagName === 'A') {
                    window.location.href = button.href;
                }

            }

        });
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const admissionNo  = document.querySelector('[name="admission_no"]');
    const firstName    = document.querySelector('[name="first_name"]');
    const lastName     = document.querySelector('[name="last_name"]');
    const fatherName   = document.querySelector('[name="father_name"]');
    const section      = document.querySelector('[name="section_id"]');
    const dob          = document.querySelector('[name="date_of_birth"]');
    const classSelect  = document.querySelector('[name="class_id"]');
    const bloodGroup   = document.querySelector('[name="blood_group"]');
    const phone        = document.querySelector('[name="phone"]');


    function setText(id, value, defaultText) {

        const element = document.getElementById(id);

        if (element) {
            element.textContent =
                value && value.trim()
                    ? value
                    : defaultText;
        }
    }


    function updateCard() {

        // Student Name
        let first = firstName ? firstName.value.trim() : '';
        let last  = lastName ? lastName.value.trim() : '';

        let fullName = `${first} ${last}`.trim();

        setText(
            'cardStudentName',
            fullName,
            'Student Name'
        );


        // Father Name
        setText(
            'cardFatherName',
            fatherName ? fatherName.value : '',
            'Father Name'
        );


        // Admission Number
        setText(
            'cardAdmissionNo',
            admissionNo ? admissionNo.value : '',
            'Admission No'
        );


        // Section
        if (section) {

            const selectedOption =
                section.options[section.selectedIndex];

            if (selectedOption && selectedOption.value) {

                setText(
                    'cardSection',
                    selectedOption.text,
                    'Section'
                );

            } else {

                setText(
                    'cardSection',
                    '',
                    'Section'
                );
            }
        }


        // Blood Group
        setText(
            'cardBloodGroup',
            bloodGroup ? bloodGroup.value : '',
            'Blood Group'
        );


        // Phone
        setText(
            'cardPhone',
            phone ? phone.value : '',
            'Phone'
        );


        // Class
        if (classSelect) {

            const selectedOption =
                classSelect.options[classSelect.selectedIndex];

            if (selectedOption && selectedOption.value) {

                setText(
                    'cardClass',
                    selectedOption.text,
                    'Class'
                );

            } else {

                setText(
                    'cardClass',
                    '',
                    'Class'
                );
            }
        }


        // Date of Birth
        if (dob && dob.value) {

            const parts = dob.value.split('-');

            if (parts.length === 3) {

                const formattedDob =
                    `${parts[2]}-${parts[1]}-${parts[0]}`;

                setText(
                    'cardDob',
                    formattedDob,
                    'DOB'
                );
            }

        } else {

            setText(
                'cardDob',
                '',
                'DOB'
            );
        }
    }


    // Listen for changes

    if (admissionNo) {
        admissionNo.addEventListener('input', updateCard);
    }

    if (firstName) {
        firstName.addEventListener('input', updateCard);
    }

    if (lastName) {
        lastName.addEventListener('input', updateCard);
    }

    if (fatherName) {
        fatherName.addEventListener('input', updateCard);
    }

    if (section) {
        section.addEventListener('change', updateCard);
    }

    if (dob) {
        dob.addEventListener('change', updateCard);
    }

    if (classSelect) {
        classSelect.addEventListener('change', updateCard);
    }

    if (bloodGroup) {
        bloodGroup.addEventListener('input', updateCard);
    }

    if (phone) {
        phone.addEventListener('input', updateCard);
    }


    // Initial card render
    updateCard();

});
</script>
<script>
 document.getElementById('capture-photo').addEventListener('click', function () {

    // Your existing capture/canvas code here

    const imageData = canvas.toDataURL('image/jpeg');

    // Store captured photo
    document.getElementById('photo_data').value = imageData;

    // Show in captured photo preview
    document.getElementById('camera-preview').innerHTML = `
        <img
            src="${imageData}"
            style="width:100%;height:100%;object-fit:cover;"
        >
    `;

    // Show immediately on ID card
    updateCardPhoto(imageData);
});
</script>

@yield('scripts')

</body>
</html>
