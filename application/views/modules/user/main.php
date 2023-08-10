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
</style>
<div class="app-content">
    <div class="page-header">
        <div class="page-info">
            <h1 class="page-title"><?php echo @$page_title; ?></h1>
        </div>
        <div class="page-action">
            <button class="btn btn--primary" id="add-user"><i class="fa fa-plus" aria-hidden="true"></i> Add User</button>
        </div>
    </div>
    <div class="page-body">
        <div class="user" style="margin-top: 10px;">
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
                    <table id="user" class="table" style="width:100%">
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
<div id="addUserModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Add User</div>
                <div class="modal-close waves-effect" data-dismiss="modal"></div>
            </div>
            <form id="addUserForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="first_name" class="label">First Name</label>
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
                    <button class="btn btn--primary waves-effect" id="btn-add-modal" type="submit">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="deleteUserModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Hapus User</div>
                <div class="modal-close waves-effect" data-dismiss="modal"></div>
            </div>
            <form id="deleteUserForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input id="id" class="form-control" type="hidden" name="id" value="" />
                            <input id="status" class="form-control" type="hidden" name="status" value="'0'" />
                            Apakah kamu yakin akan menghapus user ini?
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
<div id="editUserModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Edit User</div>
                <div class="modal-close waves-effect" data-dismiss="modal"></div>
            </div>
            <form id="editUserForm">
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
                    <button class="btn btn--primary waves-effect" id="btn-add-modal" type="submit">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
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

    var table = $('#user').DataTable({
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
            url: BASE_URL + 'user/list_data',
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
        $('.user .list').hide();
        $('.user .loader').remove();
        $('.user .list').parents('.card').append(dotLoader);
    }).on('xhr.dt', function(e, settings, json, xhr) {
        $('.user .loader').delay(1000).hide();
        $('.user .list').fadeIn(1000);
        setTimeout(function() {
            $('.user .loader').remove();
            $('html, body').animate({
                scrollTop: $('.user .list').offset().top
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

    function loadDataEdit(id) {
        $.ajax({
            data: {
                id: id
            },
            url: BASE_URL + 'user/data',
            method: 'get',
            dataType: 'json',
            beforeSend: function() {},
            success: function(response) {
                let data = response;

                $('#editUserModal').modal('show');
                $('#editUserForm [name="id"]').val(data.id);
                $('#editUserForm [name="first_name"]').val(data.first_name);
                $('#editUserForm [name="last_name"]').val(data.last_name);

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
        $('#deleteUserModal').modal({
            backdrop: 'static',
            keyboard: false
        });

        $('#deleteUserForm [name="id"]').val(id);
    }

    $("#addUserForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            description: {
                required: true,
                minlength: 5
            },
            price: {
                required: true
            },
            category_id: {
                required: true
            },
            image: {
                required: true
            }
        }
    });

    $("#editUserForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            description: {
                required: true,
                minlength: 5
            },
            price: {
                required: true
            },
            category_id: {
                required: true
            }
        }
    });

    $('#add-user').click(function() {
        $('#addUserModal .user_id').val('');
        $('#addUserModal').modal('show');
    });

    $('#addUserForm').on('submit', function(e) {
        let isvalidate = $(this).valid();
        let elBtn = $('#addUserForm [type="submit"]');
        
        e.preventDefault();

        if (isvalidate == false) {
            return false;
        }

        $.ajax({
            type: 'post',
            url: BASE_URL + 'user/insert',
            data: $('#addUserForm').serialize(),
            beforeSend: function() {
                btnLoader(elBtn);
            },
            success: function(response) {
                response = $.parseJSON(response);

                if (response.status == 'error') {
                    notification('error', response.message);
                } else if (response.status == 'success') {
                    notification('info', response.message);

                    $('#addUserModal').modal('hide');

                    table.draw(false);

                    $('#addUserForm').find('select, input').val(null);
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

    $('#editUserForm').on('submit', function(e) {
        let isvalidate = $(this).valid();

        let elBtn = $('#editUserForm [type="submit"]');
        e.preventDefault();

        if (isvalidate == false) {
            return false;
        }

        $.ajax({
            type: 'post',
            url: BASE_URL + 'user/update',
            data: $('#editUserForm').serialize(),
            beforeSend: function() {
                btnLoader(elBtn);
            },
            success: function(response) {
                response = $.parseJSON(response);

                if (response.status == 'error') {
                    notification('error', response.message);
                } else if (response.status == 'success') {
                    notification('info', response.message);

                    $('#editUserModal').modal('hide');

                    table.draw(false);

                    $('#editUserForm').find('select, input').val(null);
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

    $('#deleteUserForm').on('submit', function(e) {
        let elBtn = $('#deleteUserForm [type="submit"]');
        e.preventDefault();

        $.ajax({
            type: 'post',
            url: BASE_URL + 'user/delete',
            data: $('#deleteUserForm').serialize(),
            beforeSend: function() {
                btnLoader(elBtn);
            },
            success: function(response) {
                response = $.parseJSON(response);

                if (response.status == 'error') {
                    notification('error', response.message);
                } else if (response.status == 'success') {
                    notification('info', response.message);

                    $('#deleteUserModal').modal('hide');

                    table.draw(false);

                    $('#deleteUserForm').find('select, input').val(null);
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

    $('#image').change(function() {
        readURL(this, '#imagePreview', '#imageBase64');
    });

    $('#editUserForm #image').change(function() {
        readURL(this, '#editUserForm #imagePreview', '#editUserForm #imageBase64');
    });

    // image preview
    function readURL(input, previewId, valId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(previewId).attr("src", e.target.result);
                $(valId).val(e.target.result);
                // $(previewId).css('background-image', 'url(' + e.target.result + ')');
                $(previewId).hide();
                $(previewId).fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
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