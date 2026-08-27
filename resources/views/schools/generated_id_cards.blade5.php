@if($orientation=='vertical')

<style>
    /* =========================================================
       GLOBAL
    ========================================================= */

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;

        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    @page {
        size: A4 landscape;
        margin: 8mm;
    }

    html,
    body {
        margin: 0;
        padding: 0;

        background: #eeeeee;

        font-family: Arial, Helvetica, sans-serif;
    }


    /* =========================================================
       ID CARD
       SIZE: 54mm × 84mm
    ========================================================= */

    .id-card {
        position: relative;

        display: inline-block;

        width: 54mm;
        height: 84mm;

        margin: 1.5mm;

        overflow: hidden;

        background-color: #ffffff;

        background-image: url('{{ asset("sample/ganesh_school.jpg") }}');

        background-size: 100% 100%;
        background-position: center;
        background-repeat: no-repeat;

        vertical-align: top;

        page-break-inside: avoid;
        break-inside: avoid;
    }


    /* =========================================================
       MAIN CONTENT
    ========================================================= */

    .vertical-bulk-content {
        position: relative;

        width: 100%;
        height: 100%;

        padding: 3mm;
    }


    /* =========================================================
       SCHOOL LOGO
    ========================================================= */

    .vertical-bulk-logo {
        position: absolute;

        top: 3mm;
        left: 50%;

        transform: translateX(-50%);

        width: 12mm;
        height: 10mm;

        object-fit: contain;
        object-position: center;
    }


    /* =========================================================
       SCHOOL NAME
    ========================================================= */

    .vertical-bulk-school {
        position: absolute;

        top: 13.5mm;

        left: 2.5mm;
        right: 2.5mm;

        text-align: center;

        font-size: 3.1mm;

        line-height: 1.15;

        font-weight: 800;

        color: #a82738;

        text-transform: uppercase;

        overflow: hidden;
    }


    /* =========================================================
       SCHOOL ADDRESS
    ========================================================= */

    .vertical-bulk-meta {
        position: absolute;

        top: 18mm;

        left: 3mm;
        right: 3mm;

        text-align: center;

        font-size: 2.15mm;

        line-height: 1.2;

        font-weight: 500;

        color: #26364a;

        overflow: hidden;
    }


    /* =========================================================
       SCHOOL PHONE
    ========================================================= */

    .vertical-bulk-meta + .vertical-bulk-meta {
        top: 20.7mm;

        font-size: 2.15mm;

        font-weight: 600;
    }


    /* =========================================================
       SESSION
    ========================================================= */

    .vertical-bulk-session {
        position: absolute;

        top: 23.2mm;

        left: 3mm;
        right: 3mm;

        text-align: center;

        font-size: 2.5mm;

        line-height: 1.2;

        font-weight: 800;

        color: #c4000b;

        text-transform: uppercase;
    }


    /* =========================================================
       STUDENT PHOTO
    ========================================================= */

    .vertical-bulk-photo {
        position: absolute;

        top: 27mm;

        left: 50%;

        transform: translateX(-50%);

        width: 24mm;
        height: 27mm;

        object-fit: cover;

        object-position: center;

        border: 0.6mm solid #555555;

        border-radius: 1mm;

        background: #ffffff;
    }


    /* =========================================================
       STUDENT NAME
    ========================================================= */

    .vertical-bulk-name {
        position: absolute;

        top: 55mm;

        left: 2.5mm;
        right: 2.5mm;

        text-align: center;

        font-size: 3.2mm;

        line-height: 1.15;

        font-weight: 800;

        color: #034094;

        text-transform: uppercase;

        white-space: nowrap;

        overflow: hidden;

        text-overflow: ellipsis;
    }


    /* =========================================================
       FATHER NAME
    ========================================================= */

    .vertical-bulk-father {
        position: absolute;

        top: 59mm;

        left: 3mm;
        right: 3mm;

        text-align: center;

        font-size: 2.3mm;

        line-height: 1.2;

        font-weight: 700;

        color: #034094;

        text-transform: uppercase;

        white-space: nowrap;

        overflow: hidden;

        text-overflow: ellipsis;
    }


    /* =========================================================
       STUDENT INFORMATION AREA
    ========================================================= */

    .vertical-bulk-info-row {
        position: absolute;

        top: 63mm;

        left: 3.5mm;
        right: 3.5mm;
    }


    /* =========================================================
       INFORMATION TABLE
    ========================================================= */

    .arrangedata {
        width: 100%;

        border-collapse: collapse;

        border-spacing: 0;

        table-layout: fixed;
    }


    /* =========================================================
       TABLE ROW
    ========================================================= */

    .arrangedata tr {
        height: 5mm;
    }


    /* =========================================================
       TABLE CELLS
    ========================================================= */

    .arrangedata td {
        padding: 0.5mm 0;

        font-size: 2.25mm;

        line-height: 1.2;

        vertical-align: top;

        color: #202020;
    }


    /* =========================================================
       LABEL COLUMN
    ========================================================= */

    .first_td {
        width: 25%;

        font-weight: 800;

        white-space: nowrap;
    }


    /* =========================================================
       VALUE COLUMN
    ========================================================= */

    .second_td {
        width: 75%;

        padding-left: 1mm !important;

        font-weight: 600;

        word-break: break-word;

        overflow-wrap: anywhere;
    }


    /* =========================================================
       PRINCIPAL SIGNATURE
    ========================================================= */

    .principal-signature {
        position: absolute;

        width: 14mm;

        height: auto;

        max-height: 7mm;

        object-fit: contain;

        object-position: center;

        bottom: 3.5mm;

        right: 4mm;
    }


    /* =========================================================
       PRINT
    ========================================================= */

    @media print {

        html,
        body {
            margin: 0;
            padding: 0;

            background: #ffffff;
        }

        .id-card {
            margin: 1.5mm;

            page-break-inside: avoid;

            break-inside: avoid;
        }
    }


    /* =========================================================
       SCREEN PREVIEW
    ========================================================= */

    @media screen {

        .id-card {
            box-shadow: 0 1mm 4mm rgba(0, 0, 0, 0.20);
        }
    }

</style>




@foreach($students as $student)

<div class="id-card id-card-vertical-bulk">

    <div class="vertical-bulk-content">

        {{-- SCHOOL LOGO --}}
        @if(!empty($school->logo))
            <img
                class="vertical-bulk-logo"
                src="{{ asset('storage/' . $school->logo) }}"
                alt="School Logo"
            >
        @endif

        {{-- SCHOOL NAME --}}
        <div class="vertical-bulk-school">
            {{ strtoupper($school->school_name ?? '') }}
        </div>

        {{-- SCHOOL ADDRESS --}}
        <div class="vertical-bulk-meta">
            {{ $school->address ?? '' }}
        </div>

        {{-- SCHOOL PHONE --}}
        @if(!empty($school->phone))
            <div class="vertical-bulk-meta">
                P: {{ $school->phone }}
            </div>
        @endif

        {{-- SESSION --}}
        <div class="vertical-bulk-session">
            Session: {{ $school->session ?? '2026-27' }}
        </div>

        {{-- STUDENT PHOTO --}}
        @if(!empty($student->capturephoto))

            <img
                class="vertical-bulk-photo"
                src="{{ asset('storage/' . $student->capturephoto) }}"
                alt="Student Photo"
            >

        @elseif(!empty($student->photo))

            <img
                class="vertical-bulk-photo"
                src="{{ asset('storage/' . $student->photo) }}"
                alt="Student Photo"
            >

        @else

            <img
                class="vertical-bulk-photo"
                src="{{ asset('images/default-student.png') }}"
                alt="Student Photo"
            >

        @endif

        {{-- PRINCIPAL SIGNATURE --}}
        @if(!empty($school->signature))

            <img
                src="{{ asset('storage/' . $school->signature) }}"
                alt="Principal Signature"
                class="principal-signature"
            >

        @endif

        {{-- STUDENT NAME --}}
        <div class="vertical-bulk-name">
            {{ strtoupper(
                trim(
                    $student->first_name . ' ' .
                    ($student->last_name ?? '')
                )
            ) }}
        </div>

        {{-- FATHER NAME --}}
        <div class="vertical-bulk-father">
            {{ strtoupper($student->father_name ?? '') }}
        </div>

        {{-- STUDENT INFORMATION --}}
        <div class="vertical-bulk-info-row">

            <table class="arrangedata">

                <tbody>

                    {{-- CLASS --}}
                    <tr>
                        <td class="first_td">
                            Class
                        </td>

                        <td class="second_td">
                            {{ $student->studentClass->name ?? '-' }}
                        </td>
                    </tr>

                    {{-- PHONE --}}
                    <tr>
                        <td class="first_td">
                            Phone
                        </td>

                        <td class="second_td">
                            {{ $student->phone ?? '-' }}
                        </td>
                    </tr>

                    {{-- ADDRESS --}}
                    <tr>
                        <td class="first_td">
                            Address
                        </td>

                        <td class="second_td">
                            {{ $student->address ?? '-' }}
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

@endforeach


@else
<html lang="en"><head><style>
     .print-page {
        width: 180mm;
        margin: 0mm auto;
        display: grid;
        grid-template-columns: repeat(2, 86mm);
        grid-template-rows: repeat(5, 54mm);
        gap: 2.7mm 13mm;
        page-break-after: always;
        break-after: page;
    }

    /* ── Print rules ── */
        @page {
        size: A4 portrait;
        margin: 8mm;
    }
    </style>


    <meta charset="utf-8">
    <title>ID Cards</title>
    <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    html, body {
        background: #f0f0f0;
        font-family: Arial, Helvetica, sans-serif;
    }

    /* ── Page wrapper: one page = 10 cards (2 col × 5 row) ── */
    
    .print-page:last-child {
        page-break-after: auto;
        break-after: auto;
    }

    /* ── One card shell ── */
    .id-card {
        position: relative;
        width: 86mm;
        height: 54mm;
        overflow: hidden;
        background: #fff;
        /*border: 0.3mm solid #ccc;
         background-image: url('sample/background.jpg'); */
        background-image: url('sample/little_kids_planet3.jpg');
        background-size: cover;
        background-repeat: no-repeat;
    }

    /* If using the template image as background */
    .id-card.has-bg {
        background-size: 100% 100%;
        background-repeat: no-repeat;
    }

    /* ── Red top bar ── */
    .card-bar-top {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2.8mm;
        background: #c8010a;
        background: linear-gradient(90deg,rgba(81, 112, 255, 1) 0%, rgba(255, 102, 196, 1) 50%, rgba(237, 221, 83, 1) 100%);
    }

    /* ── Red bottom bar ── */
    .card-bar-bottom {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2.8mm;
        background: #c8010a;
        background: linear-gradient(90deg,rgba(81, 112, 255, 1) 0%, rgba(255, 102, 196, 1) 50%, rgba(237, 221, 83, 1) 100%);
    }

    /* ── School header (below top bar) ── */
    .card-header {
        position: absolute;
        top: 2.8mm;
        left: 0;
        right: 0;
        height: 13mm;
        display: flex;
        align-items: center;
        padding: 0 2mm;
        gap: 1.5mm;
        border-bottom: 0.2mm solid #e0e0e0;
    }

    /* School logo */
    .card-school-logo {
        width: 10mm;
        height: 10mm;
        object-fit: contain;
        flex-shrink: 0;
        border-radius: 50%;
    }
    .card-school-logo-placeholder {
        width: 10mm;
        height: 10mm;
        flex-shrink: 0;
        background: #f0f0f0;
        border-radius: 50%;
        border: 0.3mm solid #ccc;
    }

    /* School text block */
    .card-school-text {
        flex: 1;
        text-align: center;
    }
    .card-school-name {
        font-size: 2.4mm;
        font-weight: 900;
        color: #c8010a;
        text-transform: uppercase;
        line-height: 1.1;
    }
    .card-school-address {
        font-size: 2.5mm;
        color: #222;
        margin-top: 0.5mm;
        line-height: 1.2;
        font-weight: 600;
    }
    .card-school-session {
        font-size: 2.4mm;
        font-weight: 600;
        color: #c8010a;
        margin-top: 0.8mm;
        text-transform: uppercase;
    }

    /* ── Divider between header and body ── */
    /* (already handled by border-bottom on card-header) */

    /* ── Student name + Scholar/Mobile row ── */
    .card-meta-row {
        position: absolute;
        top: 15.8mm;
        left: 0;
        right: 0;
        height: 5mm;
        display: flex;
        align-items: center;
        padding: 0 1.5mm;
        gap: 8mm;
        border-bottom: 0.2mm solid #e0e0e0;
    }
    .card-student-name {
        font-size: 2.5mm;
        font-weight: 600;
        color: #1811f5;
        text-transform: uppercase;
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .card-meta-item {
        font-size: 2.5mm;
        color: #111;
        white-space: nowrap;
        font-weight: bold;
    }
    .card-meta-item strong {
        color: #c8010a;
        font-size: 1.8mm;
    }

    /* ── Body: photo left + data grid right ── */
    .card-body {
        position: absolute;
        top: 20.8mm;
        left: 0;
        right: 0;
        bottom: 2.8mm;
        display: flex;
        gap: 0;
    }

    /* Student photo column */
    .card-photo-col {
        width: 24.36mm;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        gap: 0.5mm;
        height: 28.77mm;
        position: relative;
        top: 4px;
        left: 11px;
    }
    .card-student-photo {
        width: 100%;
        flex: 1;
        object-fit: fill;
        border: 0.8mm solid #262262;
        border-radius: 0.5mm;
        height: 23mm;
    }
    .card-student-photo-placeholder {
        width: 100%;
        flex: 1;
        background: #f5f5f5;
        border: 0.8mm solid #c8010a;
        border-radius: 0.5mm;
    }
    .card-student-address {
        position: absolute;
        left: 1.5mm;
        right: 1.5mm;
        bottom: 1.2mm;
        font-size: 2.6mm;
        color: #000;
        font-weight: 600;
        line-height: 1.2;
        white-space: normal;
        word-break: break-word;
        text-align: left;
    }

    /* Data grid: right side */
    .card-data-col {
        flex: 1;
        padding: 1mm 1.5mm 1mm 1mm;
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        grid-template-rows: auto auto auto auto;
        gap: 3.3mm 1mm;
        align-content: start;
    }
    .card-field {
        display: flex;
        flex-direction: column;
        gap: 0;
    }
    .card-field-label {
        font-size: 2.2mm;
        font-weight: 700;
        color: #c8010a;
        text-transform: uppercase;
        line-height: 1.3;
    }
    .card-field-value {
        font-size: 2mm;
        color: #111;
        font-weight: 500;
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-sign-row {
        grid-column: 1 / -1;
        margin-top: 1.2mm;
        /* display: flex; */
        align-items: flex-end;
        justify-content: space-between;
        gap: 1.2mm;
    }

    .card-sign-label {
        color: #000;
        font-size: 2.7mm;
        font-weight: 700;
        line-height: 1;
        white-space: nowrap;
        padding-left: 22px;
        z-index: 999;
    }

    .card-sign-qr {
        width: 17mm;
        object-fit: contain;
        border: 0.3mm solid #999;
        background: #fff;
        padding: 0.4mm;
        flex-shrink: 0;
        float: right;
        top: -45px;
        position: relative;
    }

    /* placeholder for odd cards */
    .id-card.placeholder {
        visibility: hidden;
    }

    /* ── Print rules ── */
   
    @media print {
        html, body {
            background: #fff;
        }
        .print-page {
            margin: 0 auto;
        }
    }
    .card-sign-image{
        width: 67px;
        position: absolute;
        top: 65px;
        left: 10px;
    }

    .id-card-vertical-bulk {
        background: #fff;
        background-image: none;
        /* border-radius: 3.2mm;
        border: 0.3mm solid #cfd8e6;
        padding: 0; */
        display: flex;
        flex-direction: column;
        overflow: hidden;
        position: relative;
        background-image: url('sample/ganesh_school.jpg');
        background-size: contain;
    }

    .vertical-card-bar-top {
        height: 2.8mm;
        /* background: linear-gradient(90deg, rgba(81, 112, 255, 1) 0%, rgba(255, 102, 196, 1) 50%, rgba(237, 221, 83, 1) 100%); */
        flex-shrink: 0;
        background: #16009f;
    }

    .vertical-card-bar-bottom {
        height: 2.8mm;
        background: linear-gradient(90deg, rgba(81, 112, 255, 1) 0%, rgba(255, 102, 196, 1) 50%, rgba(237, 221, 83, 1) 100%);
        flex-shrink: 0;
        margin-top: auto;
    }

    .vertical-bulk-content {
        flex: 1;
        padding: 2.4mm 2.4mm;
        display: flex;
        flex-direction: column;
    }

    .vertical-bulk-logo {
        /* width: 7.8mm; */
        height: 7.8mm;
        /* border-radius: 50%; */
        object-fit: cover;
        margin: 0 auto 0.8mm;
    }

    .vertical-bulk-school {
        text-align: center;
        font-size: 2.5mm;
        font-weight: 800;
        color: #b33442;
        line-height: 1.08;
        text-transform: uppercase;
        min-height: 3.5mm;
    }

    .vertical-bulk-meta {
        text-align: center;
        font-size: 1.9mm;
        color: #253246;
        line-height: 1.15;
        margin-top: 1.5px;
    }

    .vertical-bulk-session {
        /* margin: 0.8mm auto 1.2mm;
        background: #f2d53c;
        color: #2f2f2f;
        border-radius: 99mm;
        padding: 0.4mm 1.6mm;
        font-size: 1.8mm;
        font-weight: 800;
        line-height: 1; */
        font-size: 2.4mm;
  font-weight: 600;
  color: #c8010a;
  margin-top: 0.8mm;
  text-transform: uppercase;
  text-align: center;
  margin-bottom: 3px;
    }

    .vertical-bulk-photo {
        width: 22mm;
        height: 25mm;
        object-fit: cover;
        border: 0.8mm solid #666667;
        margin: 0 auto 0.8mm;
        margin-top: 84px;;
    }

    .vertical-bulk-name {
        text-align: center;
        font-size: 2.6mm;
        color: #034094;
        font-weight: 800;
        /* line-height: 1.08; */
        text-transform: uppercase;
        /* min-height: 5.6mm; */
    }

    .vertical-bulk-father {
        text-align: center;
        font-size: 2mm;
        color: #034094;
        min-height: 4.2mm;
        font-weight: 600;
    }

    .vertical-bulk-info-row {
        margin-top: -5px;
        display: grid;
        /* grid-template-columns: 1fr auto 1fr; */
        gap: 1.1mm;
        align-items: center;
    }

    .vertical-bulk-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.9mm;
        padding: 0.9mm 1mm;
        align-content: start;
    }

    .vertical-bulk-field-label {
        display: block;
        color: #c8010a;
        font-size: 2.2mm;
        line-height: 1;
        font-weight: 700;
    }

    .vertical-bulk-field-value {
        display: block;
        color: #1f2937;
        font-size: 2.2mm;
        line-height: 1.12;
        max-height: 4.5mm;
        overflow: hidden;
        font-weight: 600;
        margin-top: 3px;
    }

    .vertical-bulk-qr-wrap {
        margin-top: 0;
        text-align: center;
        display: grid;
        place-items: center;
    }

    .vertical-bulk-qr {
        width: 15.2mm;
        height: 15.2mm;
        border: 0.25mm solid #cfd7e3;
        padding: 0.3mm;
        background: #fff;
    }

    .vertical-bulk-address {
        font-size: 2mm;
        color: #1f2937;
        text-align: center;
        line-height: 1.15;
        min-height: 5.6mm;
        max-height: 5.6mm;
        overflow: hidden;
    }

    .vertical-bulk-note {
        margin-top: 0.6mm;
        text-align: center;
        font-size: 1.35mm;
        color: #39485a;
        line-height: 1.1;
        display: none;
    }
    .vertical-bulk-field-right-left{
        margin-bottom: 10px;
    }

    .arrangedata tr td{
        
        padding: 2px 0px 0px 5px;
        font-size: 2.6mm;
    }
    .first_td{
        width: 25%;
        font-weight: 600;
    }
    .second_td{
        width: 75%;
        font-weight: 600;
    }
    .header_text, .subheader_text{
        color: #fff; text-align: center;
    }
    .header_text{
        font-size: 15px;
        font-weight: 600;
        position: relative;
        top: 13px;
        left: 23px;
    }
    .subheader_text{
        font-size: 11px;
        font-weight: 600;
        position: relative;
        top: 12px;
        left: 30px;
    }
    .fnt_color{
        color:#fff;
    }
    .h_card_phone{
       position: relative;
        top: 155px;
        left: 215px;
        font-size: 13px;
        font-weight: 600
    }
    </style>
</head>
<body>


<div class="print-page">
                            <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">AADARSH PAL</span>
                <span class="card-meta-item">MOBILE: 8827390218</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a3a5db7807ab7.32928147.jpg" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>34, BARFANI NAGAR</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">AADARSH PAL</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. BALRAM PAL</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 21-11-2018</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 8827390218</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 34, BARFANI NAGAR</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">AARUVEE CHAUHAN</span>
                <span class="card-meta-item">MOBILE: 9630594226</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a3a61fb786ac8.60075146.jpg" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>GANESH NAGAR</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">AARUVEE CHAUHAN</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. DEVRAJ CHAUHAN</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 21-08-2020</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 9630594226</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: GANESH NAGAR</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">AKSHARA JITENDRA AABUJ</span>
                <span class="card-meta-item">MOBILE: 9340170140</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a3ba407967bd7.17444368.jpg" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>300, KRISHNA BAG COLONY, INDORE</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">AKSHARA JITENDRA AABUJ</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. JITENDRA ANKUSH AABUJ</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 29-01-2020</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 9340170140</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 300, KRISHNA BAG COLONY, INDORE</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">AMAR BALMIK</span>
                <span class="card-meta-item">MOBILE: 9343390704</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a636dd6cd9060.89834937.png" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>22, BARFANI NAGAR</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">AMAR BALMIK</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. BABLU BALMIK</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 29-09-2018</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 9343390704</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 22, BARFANI NAGAR</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">ARUSHI AHIRWAR</span>
                <span class="card-meta-item">MOBILE: 8889745261</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a702931f17202.99559000.png" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>SHRADDHA SHRE COLONY</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">ARUSHI AHIRWAR</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. SIYARAM AHIRWAR</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 02-07-2020</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 8889745261</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: SHRADDHA SHRE COLONY</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">BEHANSH JATAV</span>
                <span class="card-meta-item">MOBILE: 7489115043</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a3cdecf16e697.08934231.jpg" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>205, SETHI SAMBHAND NAGAR</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">BEHANSH JATAV</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. ARVIND JATAV</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 27-12-2019</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 7489115043</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 205, SETHI SAMBHAND NAGAR</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">BHAGWANSINGH BANSAL</span>
                <span class="card-meta-item">MOBILE: 9111318473</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a3e1b87a87335.77596806.jpg" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>01, SUNDAR NAGAR</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">BHAGWANSINGH BANSAL</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. KAMAL BANSAL</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 21-10-2020</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 9111318473</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 01, SUNDAR NAGAR</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">DEVANSH BILLORE</span>
                <span class="card-meta-item">MOBILE: 9300748022</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a3f86cb57b299.90363343.jpg" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>122, BARFANI NAGAR, INDORE</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">DEVANSH BILLORE</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. ROHIT BILLORE</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 12-07-2019</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 9300748022</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 122, BARFANI NAGAR, INDORE</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">DEVIKA PRADHAN</span>
                <span class="card-meta-item">MOBILE: 6265252368</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a4db5c42219c6.33733659.png" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>248/2, MALVIYA NAGAR, INDORE</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">DEVIKA PRADHAN</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. NIKLESH PRADHAN</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 27-02-2020</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 6265252368</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 248/2, MALVIYA NAGAR, INDORE</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">DHIRAJ SHAH</span>
                <span class="card-meta-item">MOBILE: 7999600208</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a40f4eb6c4f04.28958695.jpg" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>10, MALVIYA NAGAR, INDORE</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">DHIRAJ SHAH</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. DINESH SHAH</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 20-02-2020</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 7999600208</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 10, MALVIYA NAGAR, INDORE</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
            </div>
<div class="print-page">
                            <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">DIPESH PATEL</span>
                <span class="card-meta-item">MOBILE: 6268357810</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a42284f2577f8.49090148.jpg" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>KRISHNA BAG COLONY</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">DIPESH PATEL</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. LAKHAN LAL PATEL</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 15-09-2019</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 6268357810</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: KRISHNA BAG COLONY</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">DRASHYA SAHU</span>
                <span class="card-meta-item">MOBILE: 9691047260</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a4357da174976.86125850.jpg" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>253, KRISHNA BAG COLONY, INDORE</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">DRASHYA SAHU</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. MAHENDRA SAHU</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 04-09-2020</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 9691047260</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 253, KRISHNA BAG COLONY, INDORE</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">DRUP KANCHOLE</span>
                <span class="card-meta-item">MOBILE: 7770942492</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a437149c6c9b0.16372223.jpg" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>24, KRISHNA BAG COLONY, INDORE</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">DRUP KANCHOLE</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. DHARMENDRA KANCHOLE</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 27-08-2019</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 7770942492</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 24, KRISHNA BAG COLONY, INDORE</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">KAVYA DATODIYA</span>
                <span class="card-meta-item">MOBILE: 7777880875</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a437674d974f4.67441710.jpg" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>MALVIYA NAGAR</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">KAVYA DATODIYA</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. NITIN DATODIYA</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 09-12-2019</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 7777880875</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: MALVIYA NAGAR</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">KAYRAV RAJAWAT</span>
                <span class="card-meta-item">MOBILE: 7879767618</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a437c696ecad3.63077780.jpg" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>157, KRISHNA BAG COLONY, INDORE</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">KAYRAV RAJAWAT</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. ANAND RAJAWAT</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 22-02-2021</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 7879767618</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 157, KRISHNA BAG COLONY, INDORE</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">KOMAL RAJPUT</span>
                <span class="card-meta-item">MOBILE: </span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a4381accc6e29.27402073.jpg" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>BARFANI NAGAR, INDORE</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">KOMAL RAJPUT</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. RAHUL SINGH RAJPUT</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 29-06-2020</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: </td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: BARFANI NAGAR, INDORE</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">KUNAL RANJEETRAO AABUJ</span>
                <span class="card-meta-item">MOBILE: 7067988052</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a438448e854f3.53400801.jpg" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>300, KRISHNA BAG COLONY, INDORE</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">KUNAL RANJEETRAO AABUJ</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. RANJEETRAO ANKUSH AABUJ</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 02-01-2020</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 7067988052</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 300, KRISHNA BAG COLONY, INDORE</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">LAVANSH CHOUHAN</span>
                <span class="card-meta-item">MOBILE: 7697722107</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a4399084f74a0.20974637.jpg" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>301, KRISHNA BAG COLONY, INDORE</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">LAVANSH CHOUHAN</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. SANDEEP CHOUHAN</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 07-09-2020</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 7697722107</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 301, KRISHNA BAG COLONY, INDORE</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">LAVYANSH AHIRWAR</span>
                <span class="card-meta-item">MOBILE: 7722806664</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a460e1e3ca095.14196622.jpg" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>BARFANI NAGAR, INDORE</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">LAVYANSH AHIRWAR</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. SURENDRA AHIRWAR</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 01-10-2020</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 7722806664</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: BARFANI NAGAR, INDORE</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">MAHAK PARMAR</span>
                <span class="card-meta-item">MOBILE: 9770192296</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a57253fa683f0.07685173.png" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>186, BARFANI NAGAR, INDORE</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">MAHAK PARMAR</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. VISHAL PARMAR</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 16-04-2019</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 9770192296</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 186, BARFANI NAGAR, INDORE</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
            </div>
<div class="print-page">
                            <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">MAHIR SAHU</span>
                <span class="card-meta-item">MOBILE: 9893603774</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a5db54d1d3cd2.77505516.png" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>76, KRISHNA BAG COLONY, INDORE</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">MAHIR SAHU</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. RAKESH SAHU</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 20-07-2020</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 9893603774</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 76, KRISHNA BAG COLONY, INDORE</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">NAMOKAR JAIN</span>
                <span class="card-meta-item">MOBILE: 6265252368</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a44f08d7112a3.28231793.jpg" alt="photo">
                                        <!--  -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">NAMOKAR JAIN</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: VIVEK JAIN</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: VI</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 16-07-2026</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 6265252368</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: </td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">NARENDRA KUSHWAH</span>
                <span class="card-meta-item">MOBILE: 9009038716</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a53c46ad4b730.23769019.png" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>64, SHRADDHA SHREE COLONY, INDORE</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">NARENDRA KUSHWAH</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. GHANSHYAM KUSHWAH</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 07-09-2019</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 9009038716</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 64, SHRADDHA SHREE COLONY, INDORE</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">NISHTI BAGHEL</span>
                <span class="card-meta-item">MOBILE: 9926088459</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a5efa55ccc297.24721806.png" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>72, KRISHNA BAG COLONY, INDORE</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">NISHTI BAGHEL</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. ANAND BAGHEL</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 15-12-2019</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 9926088459</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 72, KRISHNA BAG COLONY, INDORE</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">PARIDHI SAHU</span>
                <span class="card-meta-item">MOBILE: 9630408553</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a60555a632286.33696158.png" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>79, KRISHNA BAG COLONY</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">PARIDHI SAHU</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. SITARAM SAHU</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 06-08-2019</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 9630408553</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 79, KRISHNA BAG COLONY</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">PRIYANK BAMNIYA</span>
                <span class="card-meta-item">MOBILE: 9131199088</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a605e923307b8.96547341.png" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>142, BARFANI NAGAR</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">PRIYANK BAMNIYA</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. PANKAJ KUMAR BAMNIYA</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 23-10-2020</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 9131199088</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: 142, BARFANI NAGAR</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">SAMARTH SITHOLIYA</span>
                <span class="card-meta-item">MOBILE: 9691748755</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a6608e559a8f9.27200780.png" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>BARFANI NAGAR</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">SAMARTH SITHOLIYA</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. SANDIP SITHOLIYA</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 17-09-2019</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 9691748755</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: BARFANI NAGAR</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">SHREYANSH AHIRWAR</span>
                <span class="card-meta-item">MOBILE: 7722806664</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <img class="card-student-photo" style="position: relative;bottom: 11px;left: 3px;" src="uploads/students/default-school/cam_6a6dad82bf6b41.92136093.png" alt="photo">
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>BARFANI NAGAR</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">SHREYANSH AHIRWAR</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. SURENDRA AHIRWAR</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 25-03-2018</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 7722806664</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: BARFANI NAGAR</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">SOMYA GOYAL</span>
                <span class="card-meta-item">MOBILE: 7999039301</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <div class="card-student-photo-placeholder" style="position: relative;bottom: 11px;left: 3px;"></div>
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>KRISHNA BAG COLONY</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">SOMYA GOYAL</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. SATISH GOYAL</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 13-06-2020</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 7999039301</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: KRISHNA BAG COLONY</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
                                    <div class="id-card" style="">

                        <!-- Rendered design (unfill / blank template) -->
            
            
            
            <!-- Name + Scholar + Mobile row -->
            <!-- <div class="card-meta-row">
                <span class="card-student-name">SUHANA UIKEY</span>
                <span class="card-meta-item">MOBILE: 9244517328</span>
            </div> -->

            <!-- Body: photo | data -->
            <div class="card-body">
                <div class="card-photo-col">
                                            <div class="card-student-photo-placeholder" style="position: relative;bottom: 11px;left: 3px;"></div>
                                        <!--                         <div class="card-student-address"><span style="font-weight: normal;">Add. </span>KRISHNA BAG COLONY</div>
                     -->
                    
                </div>
                <div style="width: 100%;position: relative;top: -6px; left: 10px;">
                    <div style="color: #fff;font-size: 3mm;margin: 5px;font-weight: 600;">SUHANA UIKEY</div>
                    <table style="width: 100%;margin-top: 5px;" class="arrangedata">
                        
                        <tbody><tr>
                            <td class="first_td">Father</td>
                            <td class="second_td">: MR. SUNIL UIKEY</td>
                        </tr>
                        <tr>
                            <td class="first_td">Class</td>
                            <td class="second_td">: I</td>
                        </tr>
                        <tr>
                            <td class="first_td">DOB</td>
                            <td class="second_td">: 06-02-2020</td>
                        </tr>
                        <tr>
                            <td class="first_td">Phone No.</td>
                            <td class="second_td">: 9244517328</td>
                        </tr>
                        <tr>
                            <td class="first_td">Address</td>
                            <td class="second_td">: KRISHNA BAG COLONY</td>
                        </tr>
                    </tbody></table>
                    
                </div>
            </div>

            
        </div>
                
            </div>
<a href="/create_id_cards_little_kids.php?print=1&amp;class_id=0&amp;section_id=0&amp;template=unfill&amp;orientation=horizontal&amp;photo_only=&amp;id_card_printed=0&amp;is_print=1" class="print-button no-print">Print This Page</a>


</body></html>

@endif