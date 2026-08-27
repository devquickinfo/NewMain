<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Generated ID Cards</title>

    <style>

        * {
            box-sizing: border-box;
        }

        /*
        |--------------------------------------------------------------------------
        | A4 PAGE
        |--------------------------------------------------------------------------
        */

        @page {
            size: A4 portrait;
            margin: 5mm;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            background: #eeeeee;
            font-family: Arial, Helvetica, sans-serif;
        }


        /*
        |--------------------------------------------------------------------------
        | PRINT BUTTON
        |--------------------------------------------------------------------------
        */

        .print-button {
            display: block;

            margin: 15px auto;

            padding: 10px 25px;

            border: 0;
            border-radius: 5px;

            background: #147abb;
            color: #fff;

            cursor: pointer;

            font-size: 14px;
        }


        /*
        |--------------------------------------------------------------------------
        | A4 SHEET
        |--------------------------------------------------------------------------
        | Grid sizing depends on orientation (see .orientation-horizontal /
        | .orientation-vertical below). This element itself only defines the
        | shared page box + gaps; column/row counts + track sizes are set
        | per-orientation so the exact card count (10 horizontal / 9 vertical)
        | fits the 200mm x 287mm usable area with no leftover/overflow.
        |--------------------------------------------------------------------------
        */

        .a4-page {

            width: 200mm;
            height: 287mm;

            margin: 5mm auto;

            display: grid;

            column-gap: 3mm;
            row-gap: 3mm;

            page-break-after: always;

            break-after: page;

            overflow: hidden;
        }

        /* 2 columns x 5 rows = 10 cards, each 98mm x 55mm */
        .a4-page.orientation-horizontal {

            grid-template-columns: repeat(2, 98mm);
            grid-template-rows: repeat(5, 55mm);
        }

        /* 3 columns x 3 rows = 9 cards, each 54mm x 84mm */
        .a4-page.orientation-vertical {

            grid-template-columns: repeat(3, 54mm);
            grid-template-rows: repeat(3, 84mm);
        }


        /*
        |--------------------------------------------------------------------------
        | CARD
        |--------------------------------------------------------------------------
        | Width/height come from the grid track (100%), not fixed mm values,
        | so the same markup automatically resizes for either orientation.
        |--------------------------------------------------------------------------
        */

        .id-card {

            width: 100%;
            height: 100%;

            position: relative;

            overflow: hidden;

            border: 0.3mm solid #d7e0e5;

            background: #eef9fc;

            page-break-inside: avoid;

            font-family: Arial, Helvetica, sans-serif;
        }


        /*
        |--------------------------------------------------------------------------
        | BACKGROUND TEMPLATES
        |--------------------------------------------------------------------------
        */

        .template-sky_blue {

            background:
                linear-gradient(
                    135deg,
                    #ffffff 0%,
                    #eef9fc 45%,
                    #dceff5 100%
                );
        }


        .template-blue {

            background:
                linear-gradient(
                    135deg,
                    #ffffff 0%,
                    #edf3ff 45%,
                    #d5e2ff 100%
                );
        }


        .template-green {

            background:
                linear-gradient(
                    135deg,
                    #ffffff 0%,
                    #eefaf1 45%,
                    #d8f0dd 100%
                );
        }


        .template-red {

            background:
                linear-gradient(
                    135deg,
                    #ffffff 0%,
                    #fff1f1 45%,
                    #fbdada 100%
                );
        }


        .template-custom {

            background:
                linear-gradient(
                    135deg,
                    #ffffff 0%,
                    #f4efff 45%,
                    #e1d6ff 100%
                );
        }


        /*
        |--------------------------------------------------------------------------
        | DECORATIVE BACKGROUND
        |--------------------------------------------------------------------------
        | Sized per orientation so the circles look proportional on a 55mm
        | tall horizontal card vs a taller/narrower 54mm x 84mm vertical card.
        |--------------------------------------------------------------------------
        */

        .orientation-horizontal.id-card::before {

            content: "";

            position: absolute;

            width: 50mm;
            height: 50mm;

            right: -20mm;
            bottom: -22mm;

            background: rgba(80, 170, 210, 0.07);

            transform: rotate(25deg);
        }


        .orientation-horizontal.id-card::after {

            content: "";

            position: absolute;

            width: 42mm;
            height: 42mm;

            left: -24mm;
            bottom: -16mm;

            background: rgba(70, 150, 210, 0.05);

            transform: rotate(25deg);
        }


        .orientation-vertical.id-card::before {

            content: "";

            position: absolute;

            width: 44mm;
            height: 44mm;

            right: -18mm;
            bottom: -20mm;

            background: rgba(80, 170, 210, 0.07);

            transform: rotate(25deg);
        }


        .orientation-vertical.id-card::after {

            content: "";

            position: absolute;

            width: 34mm;
            height: 34mm;

            left: -18mm;
            bottom: -14mm;

            background: rgba(70, 150, 210, 0.05);

            transform: rotate(25deg);
        }


        /*
        |--------------------------------------------------------------------------
        | TOP BLUE STRIPE
        |--------------------------------------------------------------------------
        */

        .blue-stripe {

            position: absolute;

            right: 0;
            top: 2mm;

            width: 18mm;
            height: 5mm;

            background: #36a5e2;

            z-index: 1;
        }

        .orientation-vertical .blue-stripe {

            width: 13mm;
            height: 4mm;
        }


        /*
        |--------------------------------------------------------------------------
        | TEMPLATE STRIPE COLORS
        |--------------------------------------------------------------------------
        */

        .template-sky_blue .blue-stripe {
            background: #36a5e2;
        }

        .template-blue .blue-stripe {
            background: #4778d8;
        }

        .template-green .blue-stripe {
            background: #42a86a;
        }

        .template-red .blue-stripe {
            background: #e16a6a;
        }

        .template-custom .blue-stripe {
            background: #8c68d8;
        }


        /*
        |--------------------------------------------------------------------------
        | HEADER (HORIZONTAL - default)
        |--------------------------------------------------------------------------
        */

        .card-header {

            height: 13mm;

            position: relative;

            display: flex;

            align-items: flex-start;

            z-index: 5;
        }


        /*
        |--------------------------------------------------------------------------
        | LOGO
        |--------------------------------------------------------------------------
        */

        .school-logo {

            width: 12mm;
            height: 12mm;

            margin-left: 2.5mm;
            margin-top: 1mm;

            flex-shrink: 0;

            display: flex;

            align-items: center;
            justify-content: center;

            overflow: hidden;

            border-radius: 50%;
        }


        .school-logo img {

            width: 12mm;
            height: 12mm;

            object-fit: contain;
        }


        /*
        |--------------------------------------------------------------------------
        | SCHOOL INFO
        |--------------------------------------------------------------------------
        */

        .school-info {

            flex: 1;

            min-width: 0;

            text-align: center;

            padding-top: 1mm;

        }


        .school-name {

            font-family: "Times New Roman", serif;

            font-size: 3.6mm;

            line-height: 3.9mm;

            font-weight: bold;

            color: #071b58;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;

            text-transform: uppercase;
        }


        .school-address {

            font-family: "Times New Roman", serif;

            font-size: 2mm;

            line-height: 2.3mm;

            color: #1d2b60;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;

        }


        .school-phone {

            font-family: "Times New Roman", serif;

            font-size: 2mm;

            line-height: 2.3mm;

            color: #1d2b60;
        }


        /*
        |--------------------------------------------------------------------------
        | BADGE
        |--------------------------------------------------------------------------
        */

        .school-badge {

            width: 6mm;
            height: 7.5mm;

            margin-right: 2.5mm;

            background: #147abb;

            color: #fff;

            position: relative;

            z-index: 5;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 3.4mm;

            font-weight: bold;
        }


        .template-blue .school-badge {
            background: #2855b8;
        }

        .template-green .school-badge {
            background: #159447;
        }

        .template-red .school-badge {
            background: #d73535;
        }

        .template-custom .school-badge {
            background: #7148c6;
        }


        /*
        |--------------------------------------------------------------------------
        | SESSION
        |--------------------------------------------------------------------------
        */

        .session {

            position: absolute;

            right: 3mm;
            top: 10.5mm;

            z-index: 10;

            font-size: 1.9mm;

            color: #202759;

        }


        /*
        |--------------------------------------------------------------------------
        | CONTENT (HORIZONTAL - default)
        |--------------------------------------------------------------------------
        */

        .card-content {

            position: relative;

            z-index: 5;

            display: flex;

            padding: 0 4mm;
        }


        /*
        |--------------------------------------------------------------------------
        | PHOTO
        |--------------------------------------------------------------------------
        */

        .student-photo {

            width: 26mm;
            height: 32mm;

            flex-shrink: 0;

            border: 0.7mm solid #242066;

            background: #ddd;

            overflow: hidden;
        }


        .student-photo img {

            width: 100%;
            height: 100%;

            object-fit: cover;

            display: block;
        }


        .no-photo {

            width: 100%;
            height: 100%;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 9mm;

            color: #777;
        }


        /*
        |--------------------------------------------------------------------------
        | DETAILS
        |--------------------------------------------------------------------------
        */

        .student-details {

            flex: 1;

            min-width: 0;

            margin-left: 0.7mm;
        }


        /*
        |--------------------------------------------------------------------------
        | STUDENT NAME
        |--------------------------------------------------------------------------
        */

        .student-name {

            width: 100%;

            height: 5mm;

            line-height: 5mm;

            padding-left: 1.5mm;

            color: #fff;

            font-size: 3mm;

            font-weight: bold;

            text-transform: uppercase;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;

            border-radius: 0 4mm 4mm 0;

        }


        .template-sky_blue .student-name {

            background:
                linear-gradient(
                    to right,
                    #1375b9,
                    #294a9a
                );
        }


        .template-blue .student-name {

            background:
                linear-gradient(
                    to right,
                    #2855b8,
                    #172f79
                );
        }


        .template-green .student-name {

            background:
                linear-gradient(
                    to right,
                    #159447,
                    #176b39
                );
        }


        .template-red .student-name {

            background:
                linear-gradient(
                    to right,
                    #d73535,
                    #8d2020
                );
        }


        .template-custom .student-name {

            background:
                linear-gradient(
                    to right,
                    #7148c6,
                    #49318c
                );
        }


        /*
        |--------------------------------------------------------------------------
        | DETAIL ROW (HORIZONTAL - default)
        |--------------------------------------------------------------------------
        */

        .detail-row {

            display: flex;

            min-height: 4.6mm;

            line-height: 4.6mm;

            font-size: 2.4mm;

            font-weight: bold;

            color: #111;
        }


        .detail-label {

            width: 14mm;

            flex-shrink: 0;
        }


        .detail-colon {

            width: 2.5mm;

            flex-shrink: 0;
        }


        .detail-value {

            flex: 1;

            min-width: 0;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;

            text-transform: uppercase;
        }


        .address-value {

            white-space: normal;

            line-height: 3mm;

            max-height: 6mm;

            overflow: hidden;
        }


        /*
        |--------------------------------------------------------------------------
        | FOOTER
        |--------------------------------------------------------------------------
        */

        .card-footer {

            position: absolute;

            right: 4mm;

            bottom: 1.2mm;

            z-index: 10;

            text-align: center;
        }


        .signature {

            font-family: "Brush Script MT", cursive;

            font-size: 2.2mm;

            color: #536a58;

            transform: rotate(-5deg);
        }


        .principal {

            font-family: "Times New Roman", serif;

            font-size: 2mm;

            color: #202759;

        }


        /*
        |--------------------------------------------------------------------------
        | VERTICAL LAYOUT (portrait card, 54mm x 84mm)
        |--------------------------------------------------------------------------
        */

        .orientation-vertical .card-header {

            height: 15mm;

            display: block;

            text-align: center;
        }


        .orientation-vertical .school-logo {

            width: 10mm;
            height: 10mm;

            margin: 0.8mm auto 0;
        }


        .orientation-vertical .school-logo img {

            width: 10mm;
            height: 10mm;
        }


        .orientation-vertical .school-info {

            padding-top: 0;
        }


        .orientation-vertical .school-name {

            font-size: 2.9mm;

            line-height: 3.1mm;

            padding: 0 3mm;
        }


        .orientation-vertical .school-address,
        .orientation-vertical .school-phone {

            font-size: 1.7mm;

            line-height: 1.9mm;

            padding: 0 3mm;
        }


        .orientation-vertical .school-badge {

            position: absolute;

            right: 2mm;
            top: 1mm;

            width: 5mm;
            height: 6mm;

            font-size: 2.8mm;
        }


        .orientation-vertical .session {

            top: 12mm;

            right: 2.5mm;

            font-size: 1.5mm;
        }


        .orientation-vertical .card-content {

            display: block;

            padding: 0 3.5mm;

            text-align: center;

            margin-top: 2mm;
        }


        .orientation-vertical .student-photo {

            width: 30mm;
            height: 34mm;

            margin: 0 auto 1.5mm;
        }


        .orientation-vertical .no-photo {

            font-size: 8mm;
        }


        .orientation-vertical .student-details {

            width: 100%;

            margin-left: 0;

            text-align: left;
        }


        .orientation-vertical .student-name {

            height: 5mm;

            line-height: 5mm;

            text-align: center;

            padding: 0;

            border-radius: 2.5mm;

            font-size: 2.6mm;
        }


        .orientation-vertical .detail-row {

            min-height: 4mm;

            line-height: 4mm;

            font-size: 2.2mm;
        }


        .orientation-vertical .detail-label {

            width: 13mm;
        }


        .orientation-vertical .detail-colon {

            width: 2mm;
        }


        .orientation-vertical .address-value {

            line-height: 2.6mm;

            max-height: 5.2mm;
        }


        .orientation-vertical .card-footer {

            right: 3.5mm;

            bottom: 1.5mm;
        }


        .orientation-vertical .signature {

            font-size: 2.1mm;
        }


        .orientation-vertical .principal {

            font-size: 1.9mm;
        }


        /*
        |--------------------------------------------------------------------------
        | PRINT
        |--------------------------------------------------------------------------
        */

        @media print {

            html,
            body {

                width: 210mm;
                height: 297mm;

                margin: 0;
                padding: 0;

                background: #fff;
            }


            .print-button {

                display: none !important;
            }


            .a4-page {

                margin: 5mm;

                page-break-after: always;

                break-after: page;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SCREEN
        |--------------------------------------------------------------------------
        */

        @media screen {

            .a4-page {

                background: #fff;

                box-shadow: 0 0 8px rgba(0,0,0,.15);

                padding: 0;
            }

        }

    </style>

</head>


<body>


<button
    class="print-button"
    onclick="window.print()">

    🖨 Print ID Cards

</button>


{{-- =========================================================
     PAGE CHUNK SIZE COMES FROM CONTROLLER ($cardsPerPage):
     10 cards/page for horizontal, 9 cards/page for vertical.
     Falls back to 10 if not passed, so the view never breaks
     if it's rendered from somewhere that forgot to pass it.
     ========================================================= --}}

@php
    $cardsPerPage = $cardsPerPage ?? ($orientation === 'vertical' ? 9 : 10);
@endphp

@foreach($students->chunk($cardsPerPage) as $pageStudents)


    <div class="a4-page orientation-{{ $orientation }}">


        @foreach($pageStudents as $student)


            {{-- =================================================
                 ID CARD
                 ================================================= --}}

            <div class="
                id-card
                template-{{ $template }}
                orientation-{{ $orientation }}
            ">


                {{-- TOP STRIPE --}}

                <div class="blue-stripe"></div>


                {{-- =================================================
                     HEADER
                     ================================================= --}}

                <div class="card-header">


                    {{-- LOGO --}}

                    <div class="school-logo">

                        @if(!empty($school?->logo))

                            <img
                                src="{{ asset('storage/' . $school->logo) }}"
                                alt="School Logo">

                        @else

                            <span style="font-size:2.2mm;">
                                LOGO
                            </span>

                        @endif

                    </div>


                    {{-- SCHOOL INFORMATION --}}

                    <div class="school-info">

                        <div class="school-name">

                            {{ $school->school_name ?? 'LITTLE KIDS PLANET SCHOOL' }}

                        </div>


                        <div class="school-address">

                            {{ $school->address ?? '139/7, Nanda Nagar Indore' }}

                        </div>


                        <div class="school-phone">

                            Ph.
                            {{ $school->phone ?? '9425037963, 8871764062' }}

                        </div>

                    </div>


                    {{-- BADGE --}}

                    <div class="school-badge">

                        ★

                    </div>

                </div>


                {{-- SESSION --}}

                <div class="session">

                    SESSION:
                    {{ $school->session ?? '2026-27' }}

                </div>


                {{-- =================================================
                     STUDENT CONTENT
                     ================================================= --}}

                <div class="card-content">


                    {{-- PHOTO --}}

                    <div class="student-photo">
                        @if($student->capturephoto)
                            <img src="{{ asset('storage/' . $student->capturephoto) }}"
                                alt="{{ $student->first_name }}">

                        @elseif($student->photo)
                            <img src="{{ asset('storage/' . $student->photo) }}"
                                alt="{{ $student->first_name }}">

                        @else
                            <div class="no-photo">
                                👤
                            </div>
                        @endif
                    </div>


                    {{-- DETAILS --}}

                    <div class="student-details">


                        {{-- NAME --}}

                        <div class="student-name">

                            {{ $student->first_name }}
                            {{ $student->last_name }}

                        </div>


                        {{-- FATHER --}}

                        <div class="detail-row">

                            <div class="detail-label">
                                Father
                            </div>

                            <div class="detail-colon">
                                :
                            </div>

                            <div class="detail-value">

                                {{ $student->father_name ?? '-' }}

                            </div>

                        </div>


                        {{-- CLASS --}}

                        <div class="detail-row">

                            <div class="detail-label">
                                Class
                            </div>

                            <div class="detail-colon">
                                :
                            </div>

                            <div class="detail-value">

                                {{ optional($student->studentClass)->name ?? '-' }}

                            </div>

                        </div>


                        {{-- DOB --}}

                        <div class="detail-row">

                            <div class="detail-label">
                                DOB
                            </div>

                            <div class="detail-colon">
                                :
                            </div>

                            <div class="detail-value">

                                {{ $student->date_of_birth
                                    ? \Carbon\Carbon::parse($student->date_of_birth)->format('d-m-Y')
                                    : '-' }}

                            </div>

                        </div>


                        {{-- PHONE --}}

                        <div class="detail-row">

                            <div class="detail-label">
                                Phone No.
                            </div>

                            <div class="detail-colon">
                                :
                            </div>

                            <div class="detail-value">

                                {{ $student->phone ?? '-' }}

                            </div>

                        </div>


                        {{-- ADDRESS --}}

                        <div class="detail-row">

                            <div class="detail-label">
                                Address
                            </div>

                            <div class="detail-colon">
                                :
                            </div>

                            <div class="detail-value address-value">

                                {{ $student->address ?? '-' }}

                            </div>

                        </div>


                    </div>

                </div>


                {{-- =================================================
                     FOOTER
                     ================================================= --}}

                <div class="card-footer">

                    <div class="signature">
                        signature
                    </div>

                    <div class="principal">
                        Principal
                    </div>

                </div>


            </div>


        @endforeach


    </div>


@endforeach


</body>

</html>