<div class="col-md-12">
   <div id="captureForm">
        <input type="hidden" name="student_id" id="student_id" class="form-control" readonly>
        <input type="hidden" name="photo_data" id="photo_data">
        <h3>Capture Photo (Laptop/Mobile)</h3>
        <p>Capture frame is fixed to passport size ratio 3.5cm x 4.5cm. Captured area keeps original crop pixels with no
            downscaling.</p>
        <div class="row mt-3">
            <!-- Live Camera -->
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Live Camera</h3>
                    </div>

                    <div class="card-body">

                        <div id="camera-stage" style="background:#dbeafe;padding:8px;border-radius:8px;">

                            <div id="camera"
                                style="position:relative;aspect-ratio:3/4;background:#fff;border-radius:8px;overflow:hidden;">

                                <div id="camera-feed" style="position:absolute;inset:0;">
                                </div>

                                <div id="capture-frame" style="position:absolute;
                                                            left:50%;
                                                            top:50%;
                                                            width:62%;
                                                            aspect-ratio:35/45;
                                                            transform:translate(-50%,-50%);
                                                            border:3px solid #000;
                                                            border-radius:12px;
                                                            box-shadow:0 0 0 9999px rgba(0,0,0,.25);
                                                            pointer-events:none;">
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!-- Captured Photo -->
            <div class="col-md-4">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Captured Photo</h3>
                    </div>

                    <div class="card-body text-center">

                        <div id="camera-preview" style="width:220px;
                                                    height:280px;
                                                    margin:auto;
                                                    border:1px solid #ccc;
                                                    border-radius:8px;
                                                    display:flex;
                                                    align-items:center;
                                                    justify-content:center;
                                                    overflow:hidden;
                                                    background:#fff;">

                            @if(isset($student) && $student->capturephoto)
                            <img src="{{ asset('storage/' . $student->capturephoto) }}"
                                style="width:100%;height:100%;object-fit:cover;">
                            @else
                            No Capture
                            @endif

                        </div>

                    </div>
                </div>
            </div>
            <!-- Camera Settings -->
            <div class="col-md-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Camera Settings</h3>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label>Capture Background</label>
                            <select id="camera-bg" name="capture_background" class="form-control">
                                <option value="#dbeafe" {{ old('capture_background', $student->capture_background ?? 'Sky
                                    Blue') == '#dbeafe' ? 'selected' : '' }}>Sky Blue</option>
                                <option value="#e2e8f0" {{ old('capture_background', $student->capture_background ?? 'Sky
                                    Blue') == '#e2e8f0' ? 'selected' : '' }}>Light Slate</option>
                                <option value="#dcfce7" {{ old('capture_background', $student->capture_background ?? 'Sky
                                    Blue') == '#dcfce7' ? 'selected' : '' }}>Mint Green</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Camera</label>
                            <select id="camera-facing-mode" class="form-control">
                                <option value="user">Front Camera</option>
                                <option value="environment" selected>Back Camera</option>
                            </select>
                        </div>

                        <div class="form-group mt-4">

                            <button type="button" id="start-camera" class="btn btn-primary btn-block">
                                <i class="fas fa-video"></i>
                                Start Camera
                            </button>

                        </div>

                        <div class="form-group">

                            <button type="button" id="capture-photo" class="btn btn-success btn-block">
                                <i class="fas fa-camera"></i>
                                Capture Photo
                            </button>

                        </div>

                        <input type="hidden" name="photo_data" id="photo_data">

                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
           <button type="button" id="save-capture-photo"  class="btn btn-primary">
                <i class="fas fa-save"></i>
                Capture Photo
            </button>
        </div>
    </div>
</div>