@extends('frontend.layout.applayout')

@section('title', 'ID Card Designer')

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
                        ID Card Designer
                    </h1>

                    <small class="text-muted">
                        {{ $template->name }}
                    </small>

                </div>


                <a
                    href="{{ route('id-card-templates.index') }}"
                    class="btn btn-secondary"
                >

                    <i class="fas fa-arrow-left mr-1"></i>

                    Back

                </a>

            </div>

        </div>

    </section>


    <section class="content">

        <div class="container-fluid">

            <div
                id="saveMessage"
                class="alert"
                style="display:none;"
            ></div>


            <div class="row">

                {{-- =========================================================
                     CARD DESIGNER
                ========================================================== --}}

                <div class="col-lg-9">

                    <div class="card card-primary">

                        <div class="card-header">

                            <h3 class="card-title">

                                <i class="fas fa-edit mr-2"></i>

                                Design Your ID Card

                            </h3>

                        </div>


                        <div class="card-body">

                            <div class="designer-wrapper">

                                <div
                                    id="cardCanvas"
                                    class="card-canvas"
                                >

                                    {{-- Background image --}}

                                    <img
                                        src="{{ asset('storage/' . $template->image_path) }}"
                                        id="cardBackground"
                                        class="card-background"
                                        alt="ID Card"
                                    >


                                    {{-- Existing fields --}}

                                    @foreach($template->fields as $field)

                                        <div
                                            class="design-field"
                                            data-field="{{ $field->field_type }}"

                                            style="
                                                left: {{ $field->x }}%;
                                                top: {{ $field->y }}%;
                                                width: {{ $field->width ?? 20 }}%;
                                                height: {{ $field->height ?? 5 }}%;
                                                font-size: {{ $field->font_size ?? 14 }}px;
                                                color: {{ $field->font_color ?? '#000000' }};
                                                font-weight: {{ $field->font_weight ?? 'normal' }};
                                                text-align: {{ $field->text_align ?? 'left' }};
                                            "
                                        >

                                            <span class="field-label">

                                                {{ ucwords(str_replace('_', ' ', $field->field_type)) }}

                                            </span>

                                            <button
                                                type="button"
                                                class="remove-field"
                                            >
                                                ×
                                            </button>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =========================================================
                     FIELD PANEL
                ========================================================== --}}

                <div class="col-lg-3">

                    <div class="card card-info">

                        <div class="card-header">

                            <h3 class="card-title">

                                <i class="fas fa-layer-group mr-2"></i>

                                Fields

                            </h3>

                        </div>


                        <div class="card-body">

                            <p class="text-muted small">

                                Drag a field onto the card.

                            </p>


                            <div
                                class="available-field"
                                draggable="true"
                                data-field="school_logo"
                            >
                                <i class="fas fa-school"></i>
                                School Logo
                            </div>


                            <div
                                class="available-field"
                                draggable="true"
                                data-field="school_name"
                            >
                                <i class="fas fa-university"></i>
                                School Name
                            </div>


                            <div
                                class="available-field"
                                draggable="true"
                                data-field="student_photo"
                            >
                                <i class="fas fa-user"></i>
                                Student Photo
                            </div>


                            <div
                                class="available-field"
                                draggable="true"
                                data-field="student_name"
                            >
                                <i class="fas fa-user-edit"></i>
                                Student Name
                            </div>


                            <div
                                class="available-field"
                                draggable="true"
                                data-field="father_name"
                            >
                                <i class="fas fa-user-tie"></i>
                                Father Name
                            </div>


                            <div
                                class="available-field"
                                draggable="true"
                                data-field="admission_no"
                            >
                                <i class="fas fa-id-card"></i>
                                Admission No
                            </div>


                            <div
                                class="available-field"
                                draggable="true"
                                data-field="class"
                            >
                                <i class="fas fa-graduation-cap"></i>
                                Class
                            </div>


                            <div
                                class="available-field"
                                draggable="true"
                                data-field="section"
                            >
                                <i class="fas fa-users"></i>
                                Section
                            </div>


                            <div
                                class="available-field"
                                draggable="true"
                                data-field="dob"
                            >
                                <i class="fas fa-calendar"></i>
                                Date of Birth
                            </div>


                            <div
                                class="available-field"
                                draggable="true"
                                data-field="gender"
                            >
                                <i class="fas fa-venus-mars"></i>
                                Gender
                            </div>


                            <div
                                class="available-field"
                                draggable="true"
                                data-field="blood_group"
                            >
                                <i class="fas fa-tint"></i>
                                Blood Group
                            </div>


                            <div
                                class="available-field"
                                draggable="true"
                                data-field="phone"
                            >
                                <i class="fas fa-phone"></i>
                                Phone
                            </div>


                            <div
                                class="available-field"
                                draggable="true"
                                data-field="address"
                            >
                                <i class="fas fa-map-marker-alt"></i>
                                Address
                            </div>


                            <hr>


                            <button
                                type="button"
                                id="saveTemplate"
                                class="btn btn-primary btn-block"
                            >

                                <i class="fas fa-save mr-1"></i>

                                Save Template

                            </button>

                        </div>

                    </div>


                    <div class="card card-warning">

                        <div class="card-header">

                            <h3 class="card-title">

                                <i class="fas fa-info-circle mr-2"></i>

                                How to use

                            </h3>

                        </div>

                        <div class="card-body small">

                            <ol class="pl-3">

                                <li>
                                    Drag a field from the right.
                                </li>

                                <li>
                                    Drop it on the card.
                                </li>

                                <li>
                                    Move the field to the correct position.
                                </li>

                                <li>
                                    Resize if necessary.
                                </li>

                                <li>
                                    Click Save Template.
                                </li>

                            </ol>

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

/*
|--------------------------------------------------------------------------
| Designer
|--------------------------------------------------------------------------
*/

.designer-wrapper {
    width: 100%;
    overflow: auto;
    background: #343a40;
    padding: 20px;
    border-radius: 8px;
}


/*
|--------------------------------------------------------------------------
| Card Canvas
|--------------------------------------------------------------------------
*/

.card-canvas {
    position: relative;

    width: 100%;
    max-width: 1000px;

    margin: auto;

    line-height: normal;

    user-select: none;
}


/*
|--------------------------------------------------------------------------
| Background
|--------------------------------------------------------------------------
*/

.card-background {
    display: block;

    width: 100%;
    height: auto;

    pointer-events: none;

    user-select: none;
}


/*
|--------------------------------------------------------------------------
| Design Field
|--------------------------------------------------------------------------
*/

.design-field {
    position: absolute;

    min-width: 60px;
    min-height: 25px;

    border: 2px dashed #007bff;

    background: rgba(255, 255, 255, .75);

    padding: 5px;

    cursor: move;

    z-index: 20;

    overflow: hidden;

    display: flex;
    align-items: center;
}


/*
|--------------------------------------------------------------------------
| Selected
|--------------------------------------------------------------------------
*/

.design-field.selected {
    border: 2px solid #28a745;

    background: rgba(255, 255, 255, .9);

    box-shadow:
        0 0 0 2px rgba(40, 167, 69, .25);
}


/*
|--------------------------------------------------------------------------
| Label
|--------------------------------------------------------------------------
*/

.field-label {
    display: block;

    width: 100%;

    overflow: hidden;

    white-space: nowrap;

    text-overflow: ellipsis;

    pointer-events: none;

    color: inherit;
}


/*
|--------------------------------------------------------------------------
| Remove button
|--------------------------------------------------------------------------
*/

.remove-field {
    position: absolute;

    top: -1px;
    right: -1px;

    width: 20px;
    height: 20px;

    padding: 0;

    border: none;

    background: #dc3545;

    color: #fff;

    font-size: 14px;

    line-height: 20px;

    cursor: pointer;

    z-index: 30;
}


/*
|--------------------------------------------------------------------------
| Available fields
|--------------------------------------------------------------------------
*/

.available-field {

    padding: 10px 12px;

    margin-bottom: 8px;

    border: 1px solid #dee2e6;

    border-radius: 6px;

    background: #f8f9fa;

    color: #212529;

    cursor: grab;

    font-size: 14px;

    transition: all .2s ease;
}

.available-field:hover {

    background: #e9ecef;

    border-color: #007bff;

    transform: translateX(-2px);
}

.available-field i {

    width: 22px;

    margin-right: 5px;

    color: #007bff;

}


/*
|--------------------------------------------------------------------------
| Drop area
|--------------------------------------------------------------------------
*/

.card-canvas.dragging {

    outline: 3px dashed #28a745;

    outline-offset: -3px;
}


/*
|--------------------------------------------------------------------------
| Mobile
|--------------------------------------------------------------------------
*/

@media(max-width: 767px) {

    .designer-wrapper {
        padding: 10px;
    }

    .available-field {
        font-size: 13px;
        padding: 8px;
    }

}

</style>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const canvas =
        document.getElementById('cardCanvas');

    const saveButton =
        document.getElementById('saveTemplate');

    const saveMessage =
        document.getElementById('saveMessage');


    let draggedField = null;


    /*
    |--------------------------------------------------------------------------
    | Available fields
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.available-field')
        .forEach(function (field) {

            field.addEventListener('dragstart', function (e) {

                draggedField =
                    this.dataset.field;

                canvas.classList.add('dragging');

                e.dataTransfer.effectAllowed =
                    'copy';

                e.dataTransfer.setData(
                    'text/plain',
                    draggedField
                );

            });


            field.addEventListener('dragend', function () {

                canvas.classList.remove('dragging');

                draggedField = null;

            });

        });


    /*
    |--------------------------------------------------------------------------
    | Canvas drag over
    |--------------------------------------------------------------------------
    */

    canvas.addEventListener('dragover', function (e) {

        e.preventDefault();

        e.dataTransfer.dropEffect = 'copy';

    });


    /*
    |--------------------------------------------------------------------------
    | Drop new field
    |--------------------------------------------------------------------------
    */

    canvas.addEventListener('drop', function (e) {

        e.preventDefault();

        const fieldType =
            e.dataTransfer.getData('text/plain');

        if (!fieldType) {
            return;
        }


        const rect =
            canvas.getBoundingClientRect();


        /*
        |--------------------------------------------------------------------------
        | Convert mouse position to percentage
        |--------------------------------------------------------------------------
        */

        const x =
            ((e.clientX - rect.left) / rect.width) * 100;

        const y =
            ((e.clientY - rect.top) / rect.height) * 100;


        createField(
            fieldType,
            x,
            y
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Create field
    |--------------------------------------------------------------------------
    */

    function createField(
        fieldType,
        x,
        y
    ) {

        const field =
            document.createElement('div');


        field.className =
            'design-field selected';


        field.dataset.field =
            fieldType;


        field.style.left =
            Math.max(0, Math.min(90, x)) + '%';


        field.style.top =
            Math.max(0, Math.min(90, y)) + '%';


        field.style.width =
            '25%';


        field.style.height =
            '5%';


        field.style.fontSize =
            '14px';


        field.style.color =
            '#000000';


        field.style.fontWeight =
            'normal';


        field.style.textAlign =
            'left';


        field.innerHTML = `

            <span class="field-label">
                ${formatFieldName(fieldType)}
            </span>

            <button
                type="button"
                class="remove-field"
            >
                ×
            </button>

        `;


        canvas.appendChild(field);


        makeDraggable(field);

        makeSelectable(field);

        makeResizable(field);

    }


    /*
    |--------------------------------------------------------------------------
    | Format field name
    |--------------------------------------------------------------------------
    */

    function formatFieldName(field) {

        return field
            .replaceAll('_', ' ')
            .replace(/\b\w/g, function (letter) {
                return letter.toUpperCase();
            });

    }


    /*
    |--------------------------------------------------------------------------
    | Make existing fields draggable
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.design-field')
        .forEach(function (field) {

            makeDraggable(field);

            makeSelectable(field);

            makeResizable(field);

        });


    /*
    |--------------------------------------------------------------------------
    | Select field
    |--------------------------------------------------------------------------
    */

    function makeSelectable(field) {

        field.addEventListener('mousedown', function () {

            document
                .querySelectorAll('.design-field')
                .forEach(function (item) {

                    item.classList.remove('selected');

                });


            field.classList.add('selected');

        });


        const removeButton =
            field.querySelector('.remove-field');


        if (removeButton) {

            removeButton.addEventListener(
                'click',
                function (e) {

                    e.stopPropagation();

                    field.remove();

                }
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Drag field inside card
    |--------------------------------------------------------------------------
    */

    function makeDraggable(field) {

        let dragging = false;

        let offsetX = 0;
        let offsetY = 0;


        field.addEventListener(
            'mousedown',
            function (e) {

                if (
                    e.target.classList.contains(
                        'remove-field'
                    )
                ) {
                    return;
                }


                dragging = true;


                const fieldRect =
                    field.getBoundingClientRect();


                offsetX =
                    e.clientX -
                    fieldRect.left;


                offsetY =
                    e.clientY -
                    fieldRect.top;


                field.classList.add(
                    'selected'
                );


                document.addEventListener(
                    'mousemove',
                    move
                );


                document.addEventListener(
                    'mouseup',
                    stop
                );

            }
        );


        function move(e) {

            if (!dragging) {
                return;
            }


            const canvasRect =
                canvas.getBoundingClientRect();


            let x =
                ((e.clientX -
                    canvasRect.left -
                    offsetX) /
                    canvasRect.width) *
                100;


            let y =
                ((e.clientY -
                    canvasRect.top -
                    offsetY) /
                    canvasRect.height) *
                100;


            x = Math.max(0, Math.min(95, x));

            y = Math.max(0, Math.min(95, y));


            field.style.left =
                x + '%';

            field.style.top =
                y + '%';

        }


        function stop() {

            dragging = false;

            document.removeEventListener(
                'mousemove',
                move
            );

            document.removeEventListener(
                'mouseup',
                stop
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Resize field
    |--------------------------------------------------------------------------
    */

    function makeResizable(field) {

        /*
        |--------------------------------------------------------------------------
        | Simple resize using browser ResizeObserver
        |--------------------------------------------------------------------------
        */

        field.style.resize = 'both';

        field.style.overflow = 'auto';

    }


    /*
    |--------------------------------------------------------------------------
    | Save template
    |--------------------------------------------------------------------------
    */

    saveButton.addEventListener(
        'click',
        function () {

            const fields = [];

            const canvasRect =
                canvas.getBoundingClientRect();


            document
                .querySelectorAll('.design-field')
                .forEach(function (field, index) {

                    const fieldRect =
                        field.getBoundingClientRect();


                    /*
                    | Recompute position/size as percentages of the
                    | canvas so native resize (which sets px) can't
                    | push values above 100.
                    */

                    const x =
                        Math.max(0, Math.min(100,
                            ((fieldRect.left - canvasRect.left) / canvasRect.width) * 100
                        ));

                    const y =
                        Math.max(0, Math.min(100,
                            ((fieldRect.top - canvasRect.top) / canvasRect.height) * 100
                        ));

                    const width =
                        Math.max(0, Math.min(100,
                            (fieldRect.width / canvasRect.width) * 100
                        ));

                    const height =
                        Math.max(0, Math.min(100,
                            (fieldRect.height / canvasRect.height) * 100
                        ));


                    const fontSize =
                        parseFloat(
                            field.style.fontSize
                        ) || 14;


                    fields.push({

                        field_type:
                            field.dataset.field,

                        x: x,

                        y: y,

                        width: width,

                        height: height,

                        font_size:
                            fontSize,

                        font_family:
                            'Arial',

                        font_color:
                            field.style.color ||
                            '#000000',

                        font_weight:
                            field.style.fontWeight ||
                            'normal',

                        text_align:
                            field.style.textAlign ||
                            'left',

                        visible: true,

                        sort_order:
                            index

                    });

                });


            saveButton.disabled = true;


            saveButton.innerHTML = `
                <i class="fas fa-spinner fa-spin mr-1"></i>
                Saving...
            `;


            fetch(
                "{{ route('id-card-templates.save-fields', $template->id) }}",
                {

                    method: 'POST',

                    headers: {

                        'Content-Type':
                            'application/json',

                        'X-CSRF-TOKEN':
                            '{{ csrf_token() }}',

                        'Accept':
                            'application/json'

                    },

                    body: JSON.stringify({

                        fields: fields

                    })

                }
            )
            .then(function (response) {

                return response.json();

            })
            .then(function (data) {

                saveMessage.className =
                    'alert alert-success';

                saveMessage.innerHTML =
                    (data.message ||
                        'Template saved successfully.') +
                    ' <a href="{{ route('id-card-templates.students', $template->id) }}" class="alert-link">Generate ID Cards &rarr;</a>';

                saveMessage.style.display =
                    'block';

            })
            .catch(function (error) {

                console.error(error);


                saveMessage.className =
                    'alert alert-danger';

                saveMessage.textContent =
                    'Unable to save template.';

                saveMessage.style.display =
                    'block';

            })
            .finally(function () {

                saveButton.disabled = false;

                saveButton.innerHTML = `
                    <i class="fas fa-save mr-1"></i>
                    Save Template
                `;

            });

        }
    );

});

</script>

@endsection