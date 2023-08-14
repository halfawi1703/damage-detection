<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<style>
    .error {
        color: red;
    }

    .field-error {
        color: red;
    }

    .btn {
        color: white !important;
    }

    .btn-icon {
        color: white !important;
        margin-right: 6px;
        margin-bottom: 5px;
        padding: 0px 0px !important;
        height: 23px !important;
    }

    .required {
        color: red;
        font-weight: bold;
    }

    .card-file {
        border: none;
        box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .card-file-header {
        background-color: #007bff;
        color: white;
        text-align: center;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .btn-upload {
        background-color: #007bff;
        color: white;
    }

    #preview_front_image {
        max-width: 100%;
        max-height: 170px;
        display: none;
        margin-top: 10px;
    }

    #preview_right_image {
        max-width: 100%;
        max-height: 170px;
        display: none;
        margin-top: 10px;
    }

    #sampleImage {
        max-width: 100%;
        max-height: 170px;
        margin-top: 10px;
    }

    #cameraFeedFront {
        max-width: 100%;
        max-height: 170px;
        /* margin-top: 10px; */
        margin-bottom: 10px;
    }

    #capturedImageFront {
        margin-bottom: 10px;
        margin-top: 10px;
    }

    #cameraFeedRight {
        max-width: 100%;
        max-height: 170px;
        /* margin-top: 10px; */
        margin-bottom: 10px;
    }

    #capturedImageRight {
        margin-bottom: 10px;
        margin-top: 10px;
    }

    .div-search-police-number {
        margin-bottom: 20px;
    }

    .title-section {
        margin-bottom: 10px;
    }
</style>
<div class="app-content">
    <div class="page-header">
        <div class="page-info">
            <h1 class="page-title"><?php echo @$page_title; ?></h1>
        </div>
        <div class="page-action">
            <button class="btn btn--primary" id="add-report"><i class="fa fa-plus" aria-hidden="true"></i> Add Report</button>
        </div>
    </div>
    <div class="page-body">
        <div class="report" style="margin-top: 10px;">
            <div class="filter">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-6">
                        <div class="form-group">
                            <!-- <label for="search">Search</label> -->
                            <input id="keyword" class="form-control" type="text" name="keyword" placeholder="Keyword..." />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="list" style="display: none;">
                    <table id="report" class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Updated At</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="loader">
                    <div class="dot-loader"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="addReportModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Add Report</div>
                <div class="modal-close waves-effect" data-dismiss="modal"></div>
            </div>
            <form id="addReportForm">
                <div class="modal-body">
                    <div class="row div-search-police-number">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" name="search_police_number" class="form-control" placeholder="Masukan Nomor Polisi / Nomor Rangka / Nomor Mesin">
                                <div class="input-group-append">
                                    <a class="btn btn--primary" id="search_police_number">Search</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="title-section"><?php echo $this->lang->line('vehicle_unit_information'); ?></h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="police_number" class="label"><?php echo $this->lang->line('police_number'); ?> <span class="required">*</span></label>
                                <input id="police_number" class="form-control" type="text" name="police_number" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="machine_number" class="label"><?php echo $this->lang->line('machine_number'); ?> <span class="required">*</span></label>
                                <input id="machine_number" class="form-control" type="text" name="machine_number" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="chassis_number" class="label"><?php echo $this->lang->line('chassis_number'); ?> <span class="required">*</span></label>
                                <input id="chassis_number" class="form-control" type="text" name="chassis_number" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="vehicle_brand" class="label"><?php echo $this->lang->line('vehicle_brand'); ?> <span class="required">*</span></label>
                                <select class="form-control" id="vehicle_brand" name="vehicle_brand">
                                    <option value="">--- Please Select ---</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="vehicle_variant" class="label"><?php echo $this->lang->line('vehicle_variant'); ?> <span class="required">*</span></label>
                                <select class="form-control" id="vehicle_variant" name="vehicle_variant">
                                    <option value="">--- Please Select ---</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="vehicle_year" class="label"><?php echo $this->lang->line('vehicle_year'); ?> <span class="required">*</span></label>
                                <select class="form-control" id="vehicle_year" name="vehicle_year">
                                    <option value="">--- Please Select ---</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <h6 class="title-section"><?php echo $this->lang->line('insured_information'); ?></h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="police_number" class="label"><?php echo $this->lang->line('police_number'); ?></label>
                                <input id="police_number" class="form-control" type="text" name="police_number" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="insured_name" class="label"><?php echo $this->lang->line('insured_name'); ?></label>
                                <input id="insured_name" class="form-control" type="text" name="insured_name" value="" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <h6 class="title-section"><?php echo $this->lang->line('reporting_information'); ?></h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reporting_name" class="label"><?php echo $this->lang->line('reporting_name'); ?> <span class="required">*</span></label>
                                <input id="reporting_name" class="form-control" type="text" name="reporting_name" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reporting_phone_number" class="label"><?php echo $this->lang->line('reporting_phone_number'); ?></label>
                                <input id="reporting_phone_number" class="form-control" type="text" name="reporting_phone_number" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reporting_email" class="label"><?php echo $this->lang->line('reporting_email'); ?></label>
                                <input id="reporting_email" class="form-control" type="text" name="reporting_email" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rider_name" class="label"><?php echo $this->lang->line('rider_name'); ?> <span class="required">*</span></label>
                                <input id="rider_name" class="form-control" type="text" name="rider_name" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rider_phone_number" class="label"><?php echo $this->lang->line('rider_phone_number'); ?></label>
                                <input id="rider_phone_number" class="form-control" type="text" name="rider_phone_number" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sim_expired_date" class="label"><?php echo $this->lang->line('sim_expired_date'); ?> <span class="required">*</span></label>
                                <input id="sim_expired_date" class="form-control" type="date" name="sim_expired_date" value="" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <h6 class="title-section"><?php echo $this->lang->line('event_information'); ?></h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_date" class="label"><?php echo $this->lang->line('event_date'); ?> <span class="required">*</span></label>
                                <input id="event_date" class="form-control" type="date" name="event_date" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_type" class="label"><?php echo $this->lang->line('event_type'); ?></label>
                                <select class="form-control" id="event_type" name="event_type">
                                    <option value="">--- Please Select ---</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_location" class="label"><?php echo $this->lang->line('event_location'); ?> <span class="required">*</span></label>
                                <select class="form-control" id="event_location" name="event_location">
                                    <option value="">--- Please Select ---</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_chronology" class="label"><?php echo $this->lang->line('event_chronology'); ?> <span class="required">*</span></label>
                                <textarea class="form-control" name="event_chronology" id="event_chronology" cols="40" rows="5"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <h6 class="title-section">Foto Kendaraan</h6>
                        </div><br><br>
                        <div class="col-md-6">
                            <div class="card-file">
                                <div class="card-file-header">
                                    <p>Ambil Foto Bagian Depan <span class="required">*</span></p>
                                </div>
                                <div class="card-body">
                                    <video id="cameraFeedFront" autoplay style="display: none;"></video>
                                    <a class="btn btn--primary" id="startButtonFront"> <i class="fa fa-camera"></i></a>
                                    <button class="btn btn--secondary" id="captureButtonFront" disabled> <i class="fa fa-image"></i></button>
                                    <button class="btn btn-danger" id="cancelButtonFront" disabled> <i class="fa fa-trash"></i></button>
                                    <canvas id="capturedCanvasFront" style="display: none;"></canvas>
                                    <img id="capturedImageFront" style="display: none;">
                                    <input type="hidden" name="front_image" id="front_image" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-file">
                                <div class="card-file-header">
                                    <p>Contoh Gambar Bagian Depan</p>
                                </div>
                                <div class="card-body">
                                    <img src="<?php echo base_url('assets/no-image.png'); ?>" id="sampleImage" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-file">
                                <div class="card-file-header">
                                    <p>Unggah Gambar Bagian Kanan <span class="required">*</span></p>
                                </div>
                                <div class="card-body">
                                    <video id="cameraFeedRight" autoplay style="display: none;"></video>
                                    <a class="btn btn--primary" id="startButtonRight"> <i class="fa fa-camera"></i></a>
                                    <button class="btn btn--secondary" id="captureButtonRight" disabled> <i class="fa fa-image"></i></button>
                                    <button class="btn btn-danger" id="cancelButtonRight" disabled> <i class="fa fa-trash"></i></button>
                                    <canvas id="capturedCanvasRight" style="display: none;"></canvas>
                                    <img id="capturedImageRight" style="display: none;">
                                    <input type="hidden" name="right_image" id="right_image" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-file">
                                <div class="card-file-header">
                                    <p>Contoh Gambar Bagian Kanan</p>
                                </div>
                                <div class="card-body">
                                    <img src="<?php echo base_url('assets/no-image.png'); ?>" id="sampleImage" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn--secondary waves-effect" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn--primary waves-effect" id="btn-add-report" type="submit">Add Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="deleteReportModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Hapus Report</div>
                <div class="modal-close waves-effect" data-dismiss="modal"></div>
            </div>
            <form id="deleteReportForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input id="id" class="form-control" type="hidden" name="id" value="" />
                            <input id="status" class="form-control" type="hidden" name="status" value="'0'" />
                            Apakah kamu yakin akan menghapus Report ini?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary waves-effect" data-dismiss="modal">No</button>
                    <button class="btn btn--primary waves-effect" type="submit">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="editReportModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Edit Report</div>
                <div class="modal-close waves-effect" data-dismiss="modal"></div>
            </div>
            <form id="editReportForm">
                <input id="id" class="form-control" type="hidden" name="id" value="" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="first_name" class="label-email">Name</label>
                                <input id="first_name" class="form-control" type="text" name="first_name" value="" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="last_name" class="label">First Name</label>
                                <input id="last_name" class="form-control" type="text" name="last_name" value="" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn--secondary waves-effect" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn--primary waves-effect" id="btn-add-modal" type="submit">Update Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/js/select2.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/exif.js'); ?>"></script>
<script>
    // take picture in front
    const cameraFeedFront = document.getElementById('cameraFeedFront');
    const startButtonFront = document.getElementById('startButtonFront');
    const captureButtonFront = document.getElementById('captureButtonFront');
    const cancelButtonFront = document.getElementById('cancelButtonFront');
    const capturedCanvasFront = document.getElementById('capturedCanvasFront');
    const capturedImageFront = document.getElementById('capturedImageFront');

    // set focus
    startButtonFront.focus();

    let streamFront = null;

    startButtonFront.addEventListener('click', async () => {
        try {
            streamFront = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: "environment"
                }
            });
            cameraFeedFront.srcObject = streamFront;
            cameraFeedFront.style.display = 'block';
            startButtonFront.disabled = true;
            captureButtonFront.disabled = false;
            cancelButtonFront.disabled = false;
        } catch (error) {
            console.error('Gagal mengakses kamera:', error);
        }
    });

    captureButtonFront.addEventListener('click', () => {
        capturedCanvasFront.width = cameraFeedFront.videoWidth;
        capturedCanvasFront.height = cameraFeedFront.videoHeight;
        const context = capturedCanvasFront.getContext('2d');
        context.drawImage(cameraFeedFront, 0, 0, capturedCanvasFront.width, capturedCanvasFront.height);
        capturedImageFront.src = capturedCanvasFront.toDataURL('image/png');
        capturedImageFront.style.display = 'block';
        capturedCanvasFront.style.display = 'none';
        cameraFeedFront.style.display = 'none';
        captureButtonFront.disabled = true;
        cancelButtonFront.disabled = true;
        startButtonFront.disabled = false;
    });

    cancelButtonFront.addEventListener('click', () => {
        if (streamFront) {
            const tracks = streamFront.getTracks();
            tracks.forEach(track => track.stop());
            cameraFeedFront.style.display = 'none';
            capturedCanvasFront.style.display = 'none';
            capturedImageFront.style.display = 'none';
            startButtonFront.disabled = false;
            captureButtonFront.disabled = true;
            cancelButtonFront.disabled = true;
        }
    });

    // take picture from right
    const cameraFeedRight = document.getElementById('cameraFeedRight');
    const startButtonRight = document.getElementById('startButtonRight');
    const captureButtonRight = document.getElementById('captureButtonRight');
    const cancelButtonRight = document.getElementById('cancelButtonRight');
    const capturedCanvasRight = document.getElementById('capturedCanvasRight');
    const capturedImageRight = document.getElementById('capturedImageRight');

    // set focus
    startButtonRight.focus();

    let streamRight = null;

    startButtonRight.addEventListener('click', async () => {
        try {
            streamRight = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: "environment"
                }
            });
            cameraFeedRight.srcObject = streamRight;
            cameraFeedRight.style.display = 'block';
            startButtonRight.disabled = true;
            captureButtonRight.disabled = false;
            cancelButtonRight.disabled = false;
        } catch (error) {
            console.error('Gagal mengakses kamera:', error);
        }
    });

    captureButtonRight.addEventListener('click', () => {
        capturedCanvasRight.width = cameraFeedRight.videoWidth;
        capturedCanvasRight.height = cameraFeedRight.videoHeight;
        const context = capturedCanvasRight.getContext('2d');
        context.drawImage(cameraFeedRight, 0, 0, capturedCanvasRight.width, capturedCanvasRight.height);
        capturedImageRight.src = capturedCanvasRight.toDataURL('image/png');
        capturedImageRight.style.display = 'block';
        capturedCanvasRight.style.display = 'none';
        cameraFeedRight.style.display = 'none';
        captureButtonRight.disabled = true;
        cancelButtonRight.disabled = true;
        startButtonRight.disabled = false;
    });

    cancelButtonRight.addEventListener('click', () => {
        if (streamRight) {
            const tracks = streamRight.getTracks();
            tracks.forEach(track => track.stop());
            cameraFeedRight.style.display = 'none';
            capturedCanvasRight.style.display = 'none';
            capturedImageRight.style.display = 'none';
            startButtonRight.disabled = false;
            captureButtonRight.disabled = true;
            cancelButtonRight.disabled = true;
        }
    });
    // take picture from left
    // take picture from behind
</script>
<script>
    let tabSelected = '<?php echo @$tab_selected ?: ''; ?>';
    let menuActive = '<?php echo @$menu_active ?: ''; ?>';

    let option = '';
    option += '<div class="action">';
    option += '<a class="btn btn--primary action-item action-edit btn-icon" role="button" data-action="edit">';
    option += '&nbsp;&nbsp;<i class="fa fa-edit"></i>';
    option += '<a class="btn btn-danger action-item action-delete btn-icon" role="button" data-action="delete">';
    option += '&nbsp;&nbsp;<i class="fa fa-trash"></i>';
    option += '</a>';
    option += '</div>';

    var table = $('#report').DataTable({
        searching: false,
        processing: true,
        ordering: false,
        lengthChange: false,
        info: false,
        pagingType: 'full_numbers',
        pagingType: 'full_numbers',
        serverSide: true,
        pageLength: 10,
        scrollX: true,
        ajax: {
            url: BASE_URL + 'report/list_data',
            data: function(d) {
                return $.extend({}, d, {
                    tab: tabSelected,
                    menu_active: menuActive,
                    keyword: $('#keyword').val()
                });
            }
        },
        columnDefs: [{
                targets: 0,
                visible: false
            },
            {
                targets: -1,
                defaultContent: option // expand as needed
            }
        ],
        rowCallback: function(row, data) {
            let el = $(row).find('.action-item');
            el.on('click', function() {
                let id = data[0];
                let action = $(this).data('action');

                orderAction(action, id);
            });
        }
    }).on('preXhr.dt', function(e, settings, data) {
        $('.report .list').hide();
        $('.report .loader').remove();
        $('.report .list').parents('.card').append(dotLoader);
    }).on('xhr.dt', function(e, settings, json, xhr) {
        $('.report .loader').delay(1000).hide();
        $('.report .list').fadeIn(1000);
        setTimeout(function() {
            $('.report .loader').remove();
            $('html, body').animate({
                scrollTop: $('.report .list').offset().top
            }, 500);
        }, 500);
    });

    $('#keyword').bind('change', function() {
        table.draw();
    });

    $(function() {
        if (tabSelected) {
            console.log('S');
            scrollToTabSelected();
        }
    })

    function scrollToTabSelected() {
        var out = $('.tabs');
        var tar = $('.tabs .tabs-item.selected');
        var x = out.width();
        var y = tar.outerWidth(true);
        var z = tar.index();
        var q = 0;
        var m = out.find('.tabs-item');

        for (var i = 0; i < z; i++) {
            q += $(m[i]).outerWidth(true);
        }

        out.animate({
            scrollLeft: Math.max(0, q - (x - y) / 2)
        }, 500);

        return true;
    }

    function orderAction(action, id) {

        if (action == 'edit') {
            // notification('error', 'Under Maintenance');
            loadDataEdit(id);
        } else if (action == 'delete') {
            // notification('error', 'Under Maintenance');
            loadDataDelete(id);
        }
    }

    $("#addReportForm").validate({
        rules: {
            police_number: {
                required: true,
                minlength: 6,
                maxlength: 10
            },
            machine_number: {
                required: true,
                minlength: 10,
                maxlength: 12
            },
            chassis_number: {
                required: true,
                minlength: 10,
                maxlength: 20
            },
            vehicle_brand: {
                required: true
            },
            vehicle_variant: {
                required: true
            },
            vehicle_year: {
                required: true
            },
            reporting_name: {
                required: true
            },
            rider_name: {
                required: true
            },
            sim_expired_date: {
                required: true
            },
            event_date: {
                required: true
            },
            event_type: {
                required: true
            },
            event_location: {
                required: true
            },
            event_chronology: {
                required: true,
                minlength: 5,
                maxlength: 225
            },
            // front_image: {
            //     required: true
            // },
            // right_image: {
            //     required: true
            // }
        },
        submitHandler: function(form) {
            $('#addReportForm').on('submit', function(e) {
                let isvalidate = $(this).valid();
                let elBtn = $('#addReportForm [type="submit"]');

                e.preventDefault();

                if (isvalidate == false) {
                    return false;
                }

                $.ajax({
                    type: 'post',
                    url: BASE_URL + 'report/insert',
                    data: $('#addReportForm').serialize(),
                    beforeSend: function() {
                        btnLoader(elBtn);
                    },
                    success: function(response) {
                        response = $.parseJSON(response);

                        if (response.status == 'error') {
                            notification('error', response.message);
                        } else if (response.status == 'success') {
                            notification('info', response.message);

                            $('#addReportModal').modal('hide');

                            table.draw(false);

                            $('#addReportForm').find('select, input').val(null);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status == 401) {
                            window.location.replace(BASE_URL + 'login');
                        }

                        notification('error', xhr.status + ' ' + xhr.statusText, 3000, true);
                    },
                    complete: function() {
                        setTimeout(function() {
                            btnLoader(elBtn);
                        }, 1000);
                    }
                });

            });
        }
    });

    $('#add-report').click(function() {
        $('#addReportModal .report_id').val('');
        $('#addReportModal').modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    function loadDataEdit(id) {
        $.ajax({
            data: {
                id: id
            },
            url: BASE_URL + 'report/data',
            method: 'get',
            dataType: 'json',
            beforeSend: function() {},
            success: function(response) {
                let data = response;

                $('#editReportModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#editReportForm [name="id"]').val(data.id);
                $('#editReportForm [name="first_name"]').val(data.first_name);
                $('#editReportForm [name="last_name"]').val(data.last_name);

            },
            error: function(xhr) {
                if (xhr.status == 401) {
                    window.location.replace(BASE_URL + 'login');
                }
                let response = '<div class="empty">';
                response += '<div class="image">';
                response += '<img src="https://cdn.skynet.alternatecreative.id/production/assets/images/icon/no-data.svg" alt="Empty Icon">';
                response += '</div>';
                response += '<div class="caption">Order not Found</div>';
                response += '</div>';

                $('.order-detail .result').hide().html(response).fadeIn(300);

                notification('error', xhr.status + ' ' + xhr.statusText, 3000, true);
            },
            complete: function() {
                setTimeout(function() {
                    $('.order-detail .loader').hide();
                    $('.order-detail .loader').remove();
                }, 500);
            }
        });
    }

    function loadDataDelete(id) {
        $('#deleteReportModal').modal({
            backdrop: 'static',
            keyboard: false
        });

        $('#deleteReportForm [name="id"]').val(id);
    }

    $('#editReportForm').on('submit', function(e) {
        let isvalidate = $(this).valid();

        let elBtn = $('#editReportForm [type="submit"]');
        e.preventDefault();

        if (isvalidate == false) {
            return false;
        }

        $.ajax({
            type: 'post',
            url: BASE_URL + 'report/update',
            data: $('#editReportForm').serialize(),
            beforeSend: function() {
                btnLoader(elBtn);
            },
            success: function(response) {
                response = $.parseJSON(response);

                if (response.status == 'error') {
                    notification('error', response.message);
                } else if (response.status == 'success') {
                    notification('info', response.message);

                    $('#editReportModal').modal('hide');

                    table.draw(false);

                    $('#editReportForm').find('select, input').val(null);
                }
            },
            error: function(xhr) {
                if (xhr.status == 401) {
                    window.location.replace(BASE_URL + 'login');
                }

                notification('error', xhr.status + ' ' + xhr.statusText, 3000, true);
            },
            complete: function() {
                setTimeout(function() {
                    btnLoader(elBtn);
                }, 1000);
            }
        });

    });

    $('#deleteReportForm').on('submit', function(e) {
        let elBtn = $('#deleteReportForm [type="submit"]');
        e.preventDefault();

        $.ajax({
            type: 'post',
            url: BASE_URL + 'report/delete',
            data: $('#deleteReportForm').serialize(),
            beforeSend: function() {
                btnLoader(elBtn);
            },
            success: function(response) {
                response = $.parseJSON(response);

                if (response.status == 'error') {
                    notification('error', response.message);
                } else if (response.status == 'success') {
                    notification('info', response.message);

                    $('#deleteReportModal').modal('hide');

                    table.draw(false);

                    $('#deleteReportForm').find('select, input').val(null);
                }
            },
            error: function(xhr) {
                if (xhr.status == 401) {
                    window.location.replace(BASE_URL + 'login');
                }

                notification('error', xhr.status + ' ' + xhr.statusText, 3000, true);
            },
            complete: function() {
                setTimeout(function() {
                    btnLoader(elBtn);
                }, 1000);
            }
        });

    });

    $("input[data-type='currency']").on({
        keyup: function() {
            formatCurrency($(this));
        },
        blur: function() {
            formatCurrency($(this), "blur");
        },
        change: function() {
            formatCurrency($(this), "blur");
        }
    });


    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }


    function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.

        // get input value
        var input_val = input.val();

        // don't validate empty input
        if (input_val === "") {
            return;
        }

        // original length
        var original_len = input_val.length;

        // initial caret position 
        var caret_pos = input.prop("selectionStart");

        // check for decimal
        if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);

            // validate right side
            right_side = formatNumber(right_side);

            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
                right_side += "00";
            }

            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);

            // join number by .
            input_val = left_side + "." + right_side;

        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val = input_val;

            // final formatting
            if (blur === "blur") {
                input_val += ".00";
            }
        }

        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }

    // only number input field
    function onlyNumberKey(evt) {
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
</script>