<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>ID Card Editor — {{ ucwords($school->school_name ?? " ") }}</title>
<style>
  :root{
    --maroon:#9e1b32;
    --maroon-dark:#7a1526;
    --gold:#e8b84b;
    --ink:#1f2430;
    --muted:#6b7280;
    --line:#e5e7eb;
    --panel-bg:#ffffff;
    --bg:#f2f3f5;
    --accent:#2f6fed;
  }
  *{box-sizing:border-box;}
  body{
    margin:0;
    font-family:'Segoe UI',Arial,sans-serif;
    background:var(--bg);
    color:var(--ink);
  }
  .topbar{
    background:var(--maroon);
    color:#fff;
    padding:14px 24px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    box-shadow:0 2px 8px rgba(0,0,0,.15);
  }
  .topbar h1{
    font-size:17px;
    margin:0;
    font-weight:700;
    letter-spacing:.2px;
  }
  .topbar .sub{
    font-size:12px;
    opacity:.85;
    margin-top:2px;
    font-weight:400;
  }
  .topbar button{
    background:var(--gold);
    color:#3a2a00;
    border:none;
    padding:9px 16px;
    border-radius:6px;
    font-weight:700;
    font-size:13px;
    cursor:pointer;
  }
  .topbar button:hover{filter:brightness(1.05);}

  .editor{
    display:flex;
    gap:24px;
    padding:24px;
    align-items:flex-start;
    flex-wrap:wrap;
  }

  /* =========== LEFT CONTROLS =========== */
  .controls{
    width:340px;
    max-height:calc(100vh - 100px);
    overflow-y:auto;
    background:var(--panel-bg);
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
    padding:6px 0 16px;
    flex-shrink:0;
  }
  .group{
    border-bottom:1px solid var(--line);
    padding:14px 18px;
  }
  .group:last-child{border-bottom:none;}
  .group-title{
    display:flex;
    align-items:center;
    justify-content:space-between;
    cursor:pointer;
    user-select:none;
  }
  .group-title h3{
    margin:0;
    font-size:13.5px;
    font-weight:700;
    color:var(--maroon-dark);
  }
  .group-title .chev{
    font-size:12px;
    color:var(--muted);
    transition:transform .15s;
  }
  .group.collapsed .chev{transform:rotate(-90deg);}
  .group-body{
    margin-top:12px;
    display:flex;
    flex-direction:column;
    gap:10px;
  }
  .group.collapsed .group-body{display:none;}

  .field label{
    display:block;
    font-size:11px;
    font-weight:600;
    color:var(--muted);
    margin-bottom:4px;
    text-transform:uppercase;
    letter-spacing:.3px;
  }
  .field input[type="text"],
  .field input[type="number"],
  .field select{
    width:100%;
    padding:7px 8px;
    border:1px solid #d5d8dd;
    border-radius:5px;
    font-size:13px;
    font-family:inherit;
  }
  .field input[type="color"]{
    width:44px;
    height:30px;
    padding:2px;
    border:1px solid #d5d8dd;
    border-radius:5px;
    cursor:pointer;
  }
  .row2{display:flex;gap:8px;}
  .row2 .field{flex:1;}
  .row4{display:flex;gap:8px;flex-wrap:wrap;}
  .row4 .field{flex:1;min-width:70px;}

  .filebtn{
    display:inline-block;
    width:100%;
    text-align:center;
    padding:8px;
    border:1px dashed #b9bec7;
    border-radius:6px;
    font-size:12.5px;
    color:var(--muted);
    cursor:pointer;
    background:#fafbfc;
  }
  .filebtn:hover{border-color:var(--accent);color:var(--accent);}
  .filebtn input{display:none;}

  .reset-link{
    font-size:11px;
    color:var(--accent);
    cursor:pointer;
    text-decoration:underline;
    background:none;
    border:none;
    padding:0;
  }

  /* ---- visibility toggle switch ---- */
  .switch{
    position:relative;
    display:inline-block;
    width:34px;
    height:19px;
    flex-shrink:0;
  }
  .switch input{
    opacity:0;
    width:0;
    height:0;
  }
  .switch .slider{
    position:absolute;
    cursor:pointer;
    top:0;left:0;right:0;bottom:0;
    background:#ccced3;
    border-radius:19px;
    transition:.15s;
  }
  .switch .slider:before{
    position:absolute;
    content:"";
    height:14px;
    width:14px;
    left:2.5px;
    bottom:2.5px;
    background:#fff;
    border-radius:50%;
    transition:.15s;
    box-shadow:0 1px 2px rgba(0,0,0,.3);
  }
  .switch input:checked + .slider{background:var(--maroon);}
  .switch input:checked + .slider:before{transform:translateX(15px);}

  .group-title-left{
    display:flex;
    align-items:center;
    gap:9px;
  }
  .group-title-right{
    display:flex;
    align-items:center;
    gap:10px;
  }
  .group.field-off .group-title h3{color:var(--muted);}
  .group.field-off .el-preview-note{color:var(--muted);}

  .toggle-all-row{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:12px 18px;
    border-bottom:1px solid var(--line);
    background:#fafbfc;
  }
  .toggle-all-row span{
    font-size:12.5px;
    font-weight:700;
    color:var(--maroon-dark);
  }
  .toggle-all-row .links{
    display:flex;
    gap:10px;
  }
  .toggle-all-row .links button{
    font-size:11px;
    color:var(--accent);
    background:none;
    border:none;
    cursor:pointer;
    text-decoration:underline;
    padding:0;
  }

  /* =========== RIGHT PREVIEW =========== */
  .preview-wrap{
    flex:1;
    min-width:340px;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:16px;
  }
  .zoom-controls{
    display:flex;
    align-items:center;
    gap:10px;
    font-size:12px;
    color:var(--muted);
  }
  .zoom-controls input{vertical-align:middle;}

  .card-stage{
    background:repeating-conic-gradient(#e9eaed 0% 25%, #f6f7f8 0% 50%) 50% / 20px 20px;
    padding:40px;
    border-radius:12px;
  }

  .id-card{
    position:relative;
    background-image: url('{{ asset('storage/' . $selectedSample->file_path) }}');
    background-size:100% 100%;
    background-repeat:no-repeat;
    background-position:center;
    overflow:hidden;
    box-shadow:0 8px 24px rgba(0,0,0,.25);
    border-radius:6px;
    transform-origin:top center;
  }

  .el{
    position:absolute;
    cursor:move;
    outline:1px dashed transparent;
  }
  .el:hover{outline-color:rgba(47,111,237,.6);}
  .el.dragging{outline-color:var(--accent);z-index:50;}

  .el-photo{
    object-fit:cover;
    border:3px solid var(--maroon);
    background:#eee;
  }
  .el-text{
    white-space:nowrap;
    line-height:1.25;
  }
  .el-qr{
    object-fit:contain;
  }
  .el-logo{
    object-fit:contain;
    background:transparent;
  }
  .el-sign{
    object-fit:contain;
    background:transparent;
  }

  .hint{
    font-size:12px;
    color:var(--muted);
    text-align:center;
    max-width:700px;
  }

  ::-webkit-scrollbar{width:8px;}
  ::-webkit-scrollbar-thumb{background:#c9ccd1;border-radius:4px;}
</style>
</head>
<body>


  

<div class="editor">

  <!-- ===================== LEFT CONTROLS ===================== -->
  <div class="controls" id="controlsPanel">

    

    <!-- CARD BACKGROUND -->
    
    <!-- SCHOOL LOGO -->
    <div class="group">
      <div class="group-title"><h3>School Logo</h3><div class="group-title-right"><label class="switch" onclick="event.stopPropagation()"><input type="checkbox" id="logoToggle"  @if(isset($designcard->layout['fields']['logo'])) checked @endif><span class="slider"></span></label><span class="chev">▾</span></div></div>
      <div class="group-body">
        <label class="filebtn">Click to upload logo
          <input type="file" id="logoUpload" accept="image/*">
        </label>
        <div class="row4">
          <div class="field"><label>X</label><input type="number" id="logoX" value="{{ $designcard->layout['fields']['logo']['x'] ?? 30 }}"></div>
          <div class="field"><label>Y</label><input type="number" id="logoY" value="{{ $designcard->layout['fields']['logo']['y'] ?? 20 }}"></div>
          <div class="field"><label>W</label><input type="number" id="logoW" value="{{ $designcard->layout['fields']['logo']['width'] ?? 80 }}"></div>
          <div class="field"><label>H</label><input type="number" id="logoH" value="{{ $designcard->layout['fields']['logo']['height'] ?? 80 }}"></div>
        </div>
      </div>
    </div>

    <!-- SCHOOL NAME -->
    <div class="group">
      <div class="group-title"><h3>School Name</h3><div class="group-title-right"><label class="switch" onclick="event.stopPropagation()"><input type="checkbox" id="schoolNameToggle"  @if(isset($designcard->layout['fields']['schoolName'])) checked @endif><span class="slider"></span></label><span class="chev">▾</span></div></div>
      <div class="group-body">
        <div class="field"><label>Text</label><input type="text" id="schoolNameText" value="{{ $designcard->layout['fields']['schoolName']['text'] ?? (ucwords($school->school_name) ?? '') }}"></div>
        <div class="row4">
          <div class="field"><label>X</label><input type="number" id="schoolNameX" value="{{ $designcard->layout['fields']['schoolName']['x'] ?? 130 }}"></div>
          <div class="field"><label>Y</label><input type="number" id="schoolNameY" value="{{ $designcard->layout['fields']['schoolName']['y'] ?? 25 }}"></div>
          <div class="field"><label>Size</label><input type="number" id="schoolNameSize" value="{{ $designcard->layout['fields']['schoolName']['size'] ?? 28 }}"></div>
        </div>
        <div class="row2">
          <div class="field"><label>Color</label><input type="color" id="schoolNameColor" value="{{ $designcard->layout['fields']['schoolName']['color'] ?? '#9e1b32' }}"></div>
          <div class="field"><label>Weight</label>
            <select id="schoolNameWeight">
              <option value="700" @if(isset($designcard->layout['fields']['schoolName']['weight']) && $designcard->layout['fields']['schoolName']['weight'] == 700) selected @endif>Bold</option>
              <option value="400" @if(isset($designcard->layout['fields']['schoolName']['weight']) && $designcard->layout['fields']['schoolName']['weight'] == 400) selected @endif>Normal</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- ADDRESS -->
    <div class="group">
      <div class="group-title"><h3>Address</h3><div class="group-title-right"><label class="switch" onclick="event.stopPropagation()"><input type="checkbox" id="addressToggle" @if(isset($designcard->layout['fields']['address'])) checked @endif><span class="slider"></span></label><span class="chev">▾</span></div></div>
      <div class="group-body">
        <div class="field"><label>Text</label><input type="text" id="addressText" value="123 Education Lane, Varanasi, UP - 221001"></div>
        <div class="row4">
          <div class="field"><label>X</label><input type="number" id="addressX" value="{{ $designcard->layout['fields']['address']['x'] ?? 130 }}"></div>
          <div class="field"><label>Y</label><input type="number" id="addressY" value="{{ $designcard->layout['fields']['address']['y'] ?? 62 }}"></div>
          <div class="field"><label>Size</label><input type="number" id="addressSize" value="{{ $designcard->layout['fields']['address']['size'] ?? 13 }}"></div>
        </div>
        <div class="row2">
         <div class="field"><label>Color</label><input type="color" id="addressColor" value="@php echo $designcard->layout['fields']['address']['color'] ?? '#1f2430'; @endphp"></div>
          <div class="field"><label>Weight</label>
            <select id="addressWeight">
              <option value="700" @php echo (isset($designcard->layout['fields']['address']['weight']) && $designcard->layout['fields']['address']['weight'] == 700) ? 'selected' : ''; @endphp>Bold</option>
              <option value="400" @php echo (isset($designcard->layout['fields']['address']['weight']) && $designcard->layout['fields']['address']['weight'] == 400) ? 'selected' : ''; @endphp>Normal</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- SESSION -->
    <div class="group">
      <div class="group-title"><h3>Session</h3><div class="group-title-right"><label class="switch" onclick="event.stopPropagation()"><input type="checkbox" id="sessionToggle" @if(isset($designcard->layout['fields']['session'])) checked @endif><span class="slider"></span></label><span class="chev">▾</span></div></div>
      <div class="group-body">
        <div class="field"><label>Text</label><input type="text" id="sessionText" value="Session: 2026-2027"></div>
        <div class="row4">
          <div class="field"><label>X</label><input type="number" id="sessionX" value="@php echo $designcard->layout['fields']['session']['x'] ?? 130; @endphp"></div>
          <div class="field"><label>Y</label><input type="number" id="sessionY" value="@php echo $designcard->layout['fields']['session']['y'] ?? 86; @endphp"></div>
          <div class="field"><label>Size</label><input type="number" id="sessionSize" value="@php echo $designcard->layout['fields']['session']['size'] ?? 13; @endphp"></div>
        </div>
        <div class="row2">
         <div class="field"><label>Color</label><input type="color" id="sessionColor" value="@php echo $designcard->layout['fields']['session']['color'] ?? '#1f2430'; @endphp"></div>
          <div class="field"><label>Weight</label>
            <select id="sessionWeight">
              <option value="700" @php echo (isset($designcard->layout['fields']['session']['weight']) && $designcard->layout['fields']['session']['weight'] == 700) ? 'selected' : ''; @endphp>Bold</option>
              <option value="400" @php echo (isset($designcard->layout['fields']['session']['weight']) && $designcard->layout['fields']['session']['weight'] == 400) ? 'selected' : ''; @endphp>Normal</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- STUDENT PHOTO -->
    <div class="group">
      <div class="group-title"><h3>Student Photo</h3><div class="group-title-right"><label class="switch" onclick="event.stopPropagation()"><input type="checkbox" id="photoToggle" @if(isset($designcard->layout['fields']['photo'])) checked @endif><span class="slider"></span></label><span class="chev">▾</span></div></div>
      <div class="group-body">
        <label class="filebtn">Click to upload photo
          <input type="file" id="photoUpload" accept="image/*">
        </label>
        <div class="row4">
          <div class="field"><label>X</label><input type="number" id="photoX" value="@php echo $designcard->layout['fields']['photo']['x'] ?? 55; @endphp"></div>
          <div class="field"><label>Y</label><input type="number" id="photoY" value="@php echo $designcard->layout['fields']['photo']['y'] ?? 325; @endphp"></div>
          <div class="field"><label>W</label><input type="number" id="photoW" value="@php echo $designcard->layout['fields']['photo']['width'] ?? 150; @endphp"></div>
          <div class="field"><label>H</label><input type="number" id="photoH" value="@php echo $designcard->layout['fields']['photo']['height'] ?? 150; @endphp"></div>
        </div>
      </div>
    </div>

    <!-- STUDENT NAME -->
    <div class="group">
      <div class="group-title"><h3>Student Name</h3><div class="group-title-right"><label class="switch" onclick="event.stopPropagation()"><input type="checkbox" id="nameToggle" @if(isset($designcard->layout['fields']['name'])) checked @endif><span class="slider"></span></label><span class="chev">▾</span></div></div>
      <div class="group-body">
        <div class="field"><label>Text</label><input type="text" id="nameText" value="AARAV SHARMA"></div>
        <div class="row4">
          <div class="field"><label>X</label><input type="number" id="nameX" value="@php echo $designcard->layout['fields']['name']['x'] ?? 230; @endphp"></div>
          <div class="field"><label>Y</label><input type="number" id="nameY" value="@php echo $designcard->layout['fields']['name']['y'] ?? 340; @endphp"></div>
          <div class="field"><label>Size</label><input type="number" id="nameSize" value="@php echo $designcard->layout['fields']['name']['size'] ?? 24; @endphp"></div>
        </div>
        <div class="row2">
          <div class="field"><label>Color</label><input type="color" id="nameColor" value="@php echo $designcard->layout['fields']['name']['color'] ?? '#16009f'; @endphp"></div>
          <div class="field"><label>Weight</label>
            <select id="nameWeight">
              <option value="700" @php echo (isset($designcard->layout['fields']['name']['weight']) && $designcard->layout['fields']['name']['weight'] == 700) ? 'selected' : ''; @endphp>Bold</option>
              <option value="400" @php echo (isset($designcard->layout['fields']['name']['weight']) && $designcard->layout['fields']['name']['weight'] == 400) ? 'selected' : ''; @endphp>Normal</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- FATHER'S NAME -->
    <div class="group">
      <div class="group-title"><h3>Father's Name</h3><div class="group-title-right"><label class="switch" onclick="event.stopPropagation()"><input type="checkbox" id="fatherToggle" @if(isset($designcard->layout['fields']['father'])) checked @endif><span class="slider"></span></label><span class="chev">▾</span></div></div>
      <div class="group-body">
        <div class="field"><label>Text</label><input type="text" id="fatherText" value="Father: Rakesh Sharma"></div>
        <div class="row4">
          <div class="field"><label>X</label><input type="number" id="fatherX" value="@php echo $designcard->layout['fields']['father']['x'] ?? 230; @endphp"></div>
          <div class="field"><label>Y</label><input type="number" id="fatherY" value="@php echo $designcard->layout['fields']['father']['y'] ?? 378; @endphp"></div>
          <div class="field"><label>Size</label><input type="number" id="fatherSize" value="@php echo $designcard->layout['fields']['father']['size'] ?? 15; @endphp"></div>
        </div>
        <div class="row2">
           <div class="field"><label>Color</label><input type="color" id="fatherColor" value="@php echo $designcard->layout['fields']['father']['color'] ?? '#1f2430'; @endphp"></div>
            <div class="field"><label>Weight</label>
              <select id="fatherWeight">
                <option value="700" @php echo (isset($designcard->layout['fields']['father']['weight']) && $designcard->layout['fields']['father']['weight'] == 700) ? 'selected' : ''; @endphp>Bold</option>
                <option value="400" @php echo (isset($designcard->layout['fields']['father']['weight']) && $designcard->layout['fields']['father']['weight'] == 400) ? 'selected' : ''; @endphp>Normal</option>
              </select>
            </div>
        </div>
      </div>
    </div>

    <!-- MOTHER'S NAME -->
    <div class="group">
      <div class="group-title"><h3>Mother's Name</h3><div class="group-title-right"><label class="switch" onclick="event.stopPropagation()"><input type="checkbox" id="motherToggle" @if(isset($designcard->layout['fields']['mother'])) checked @endif><span class="slider"></span></label><span class="chev">▾</span></div></div>
      <div class="group-body">
        <div class="field"><label>Text</label><input type="text" id="motherText" value="Mother: Anita Sharma"></div>
        <div class="row4">
          <div class="field"><label>X</label><input type="number" id="motherX" value="@php echo $designcard->layout['fields']['mother']['x'] ?? 230; @endphp"></div>
          <div class="field"><label>Y</label><input type="number" id="motherY" value="@php echo $designcard->layout['fields']['mother']['y'] ?? 403; @endphp"></div>
          <div class="field"><label>Size</label><input type="number" id="motherSize" value="@php echo $designcard->layout['fields']['mother']['size'] ?? 15; @endphp"></div>
        </div>
        <div class="row2">
           <div class="field"><label>Color</label><input type="color" id="motherColor" value="@php echo $designcard->layout['fields']['mother']['color'] ?? '#1f2430'; @endphp"></div>
            <div class="field"><label>Weight</label>
              <select id="motherWeight">
                <option value="700" @php echo (isset($designcard->layout['fields']['mother']['weight']) && $designcard->layout['fields']['mother']['weight'] == 700) ? 'selected' : ''; @endphp>Bold</option>
                <option value="400" @php echo (isset($designcard->layout['fields']['mother']['weight']) && $designcard->layout['fields']['mother']['weight'] == 400) ? 'selected' : ''; @endphp>Normal</option>
              </select>
            </div>
        </div>
      </div>
    </div>

    <!-- CLASS -->
    <div class="group">
      <div class="group-title"><h3>Class &amp; Section</h3><div class="group-title-right"><label class="switch" onclick="event.stopPropagation()"><input type="checkbox" id="classToggle" @if(isset($designcard->layout['fields']['class'])) checked @endif><span class="slider"></span></label><span class="chev">▾</span></div></div>
      <div class="group-body">
        <div class="field"><label>Text</label><input type="text" id="classText" value="Class: V - B"></div>
        <div class="row4">
          <div class="field"><label>X</label><input type="number" id="classX" value="@php echo $designcard->layout['fields']['class']['x'] ?? 230; @endphp"></div>
          <div class="field"><label>Y</label><input type="number" id="classY" value="@php echo $designcard->layout['fields']['class']['y'] ?? 428; @endphp"></div>
          <div class="field"><label>Size</label><input type="number" id="classSize" value="@php echo $designcard->layout['fields']['class']['size'] ?? 15; @endphp"></div>
        </div>
        <div class="row2">
          <div class="field"><label>Color</label><input type="color" id="classColor" value="@php echo $designcard->layout['fields']['class']['color'] ?? '#1f2430'; @endphp"></div>
          <div class="field"><label>Weight</label>
            <select id="classWeight">
              <option value="700" @php echo (isset($designcard->layout['fields']['class']['weight']) && $designcard->layout['fields']['class']['weight'] == 700) ? 'selected' : ''; @endphp>Bold</option>
              <option value="400" @php echo (isset($designcard->layout['fields']['class']['weight']) && $designcard->layout['fields']['class']['weight'] == 400) ? 'selected' : ''; @endphp>Normal</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- DOB -->
    <div class="group">
      <div class="group-title"><h3>Date of Birth</h3><div class="group-title-right"><label class="switch" onclick="event.stopPropagation()"><input type="checkbox" id="dobToggle" @if(isset($designcard->layout['fields']['dob'])) checked @endif><span class="slider"></span></label><span class="chev">▾</span></div></div>
      <div class="group-body">
        <div class="field"><label>Text</label><input type="text" id="dobText" value="DOB: 12-05-2015"></div>
        <div class="row4">
          <div class="field"><label>X</label><input type="number" id="dobX" value="@php echo $designcard->layout['fields']['dob']['x'] ?? 230; @endphp"></div>
          <div class="field"><label>Y</label><input type="number" id="dobY" value="@php echo $designcard->layout['fields']['dob']['y'] ?? 453; @endphp"></div>
          <div class="field"><label>Size</label><input type="number" id="dobSize" value="@php echo $designcard->layout['fields']['dob']['size'] ?? 15; @endphp"></div>
        </div>
        <div class="row2">
          <div class="field"><label>Color</label><input type="color" id="dobColor" value="@php echo $designcard->layout['fields']['dob']['color'] ?? '#1f2430'; @endphp"></div>
          <div class="field"><label>Weight</label>
            <select id="dobWeight">
              <option value="700" @php echo (isset($designcard->layout['fields']['dob']['weight']) && $designcard->layout['fields']['dob']['weight'] == 700) ? 'selected' : ''; @endphp>Bold</option>
              <option value="400" @php echo (isset($designcard->layout['fields']['dob']['weight']) && $designcard->layout['fields']['dob']['weight'] == 400) ? 'selected' : ''; @endphp>Normal</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- ADMISSION / ROLL NO -->
    <div class="group">
      <div class="group-title"><h3>Admission / Roll No</h3><div class="group-title-right"><label class="switch" onclick="event.stopPropagation()"><input type="checkbox" id="admToggle" @if(isset($designcard->layout['fields']['adm'])) checked @endif><span class="slider"></span></label><span class="chev">▾</span></div></div>
      <div class="group-body">
        <div class="field"><label>Text</label><input type="text" id="admText" value="Adm No: MP-2026-0143"></div>
        <div class="row4">
          <div class="field"><label>X</label><input type="number" id="admX" value="@php echo $designcard->layout['fields']['adm']['x'] ?? 230; @endphp"></div>
          <div class="field"><label>Y</label><input type="number" id="admY" value="@php echo $designcard->layout['fields']['adm']['y'] ?? 478; @endphp"></div>
          <div class="field"><label>Size</label><input type="number" id="admSize" value="@php echo $designcard->layout['fields']['adm']['size'] ?? 15; @endphp"></div>
        </div>
        <div class="row2">
          <div class="field"><label>Color</label><input type="color" id="admColor" value="@php echo $designcard->layout['fields']['adm']['color'] ?? '#1f2430'; @endphp"></div>
          <div class="field"><label>Weight</label>
            <select id="admWeight">
              <option value="700" @php echo (isset($designcard->layout['fields']['adm']['weight']) && $designcard->layout['fields']['adm']['weight'] == 700) ? 'selected' : ''; @endphp>Bold</option>
              <option value="400" @php echo (isset($designcard->layout['fields']['adm']['weight']) && $designcard->layout['fields']['adm']['weight'] == 400) ? 'selected' : ''; @endphp>Normal</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- BLOOD GROUP / CONTACT -->
    <div class="group">
      <div class="group-title"><h3>Blood Group / Contact</h3><div class="group-title-right"><label class="switch" onclick="event.stopPropagation()"><input type="checkbox" id="bloodToggle" @if(isset($designcard->layout['fields']['blood'])) checked @endif><span class="slider"></span></label><span class="chev">▾</span></div></div>
      <div class="group-body">
        <div class="field"><label>Text</label><input type="text" id="bloodText" value="Blood Group: O+  |  Ph: 98765 43210"></div>
        <div class="row4">
          <div class="field"><label>X</label><input type="number" id="bloodX" value="@php echo $designcard->layout['fields']['blood']['x'] ?? 55; @endphp"></div>
          <div class="field"><label>Y</label><input type="number" id="bloodY" value="@php echo $designcard->layout['fields']['blood']['y'] ?? 817; @endphp"></div>
          <div class="field"><label>Size</label><input type="number" id="bloodSize" value="@php echo $designcard->layout['fields']['blood']['size'] ?? 13; @endphp"></div>
        </div>
        <div class="row2">
          <div class="field"><label>Color</label><input type="color" id="bloodColor" value="@php echo $designcard->layout['fields']['blood']['color'] ?? '#ffffff'; @endphp"></div>
          <div class="field"><label>Weight</label>
            <select id="bloodWeight">
              <option value="700" @php echo (isset($designcard->layout['fields']['blood']['weight']) && $designcard->layout['fields']['blood']['weight'] == 700) ? 'selected' : ''; @endphp>Bold</option>
              <option value="400" @php echo (isset($designcard->layout['fields']['blood']['weight']) && $designcard->layout['fields']['blood']['weight'] == 400) ? 'selected' : ''; @endphp>Normal</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- PRINCIPAL SIGNATURE -->
    <div class="group">
      <div class="group-title"><h3>Principal Signature</h3><div class="group-title-right"><label class="switch" onclick="event.stopPropagation()"><input type="checkbox" id="signToggle" @if(isset($designcard->layout['fields']['sign'])) checked @endif><span class="slider"></span></label><span class="chev">▾</span></div></div>
      <div class="group-body">
        <label class="filebtn">Click to upload signature
          <input type="file" id="signUpload" accept="image/*">
        </label>
        <div class="row4">
          <div class="field"><label>X</label><input type="number" id="signX" value="@php echo $designcard->layout['fields']['sign']['x'] ?? 1150; @endphp"></div>
          <div class="field"><label>Y</label><input type="number" id="signY" value="@php echo $designcard->layout['fields']['sign']['y'] ?? 790; @endphp"></div>
          <div class="field"><label>W</label><input type="number" id="signW" value="@php echo $designcard->layout['fields']['sign']['width'] ?? 180; @endphp"></div>
          <div class="field"><label>H</label><input type="number" id="signH" value="@php echo $designcard->layout['fields']['sign']['height'] ?? 60; @endphp"></div>
        </div>
        <div style="font-size:11px;color:var(--muted);">Tip: use a signature saved with a transparent background for best results.</div>
        <div class="row2">
          <div class="field"><label>Color</label><input type="color" id="signColor" value="#ffffff"></div>
          <div class="field"><label>Weight</label>
            <select id="signWeight">
              <option value="700" selected>Bold</option>
              <option value="400">Normal</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- QR CODE -->
    <div class="group">
      <div class="group-title"><h3>QR Code</h3><div class="group-title-right"><label class="switch" onclick="event.stopPropagation()"><input type="checkbox" id="qrToggle" @if(isset($designcard->layout['fields']['qr'])) checked @endif><span class="slider"></span></label><span class="chev">▾</span></div></div>
      <div class="group-body">
        <div class="field"><label>Data (usually admission no.)</label><input type="text" id="qrData" value="MP-2026-0143"></div>
        <div class="row4">
          <div class="field"><label>X</label><input type="number" id="qrX" value="@php echo $designcard->layout['fields']['qr']['x'] ?? 600; @endphp"></div>
          <div class="field"><label>Y</label><input type="number" id="qrY" value="@php echo $designcard->layout['fields']['qr']['y'] ?? 800; @endphp"></div>
          <div class="field"><label>Size</label><input type="number" id="qrSize" value="@php echo $designcard->layout['fields']['qr']['width'] ?? 80; @endphp"></div>
        </div>
      </div>
    </div>

   

  </div>


  

</div>
</body>
</html>
