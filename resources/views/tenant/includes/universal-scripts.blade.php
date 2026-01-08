<style>

.is-invalid {
    border-color: #dc3545;
}
.dynamic-error {
    font-size: 13px;
    display: block;
}

</style>

<script>

let modal = null;

// CSRF
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});

// =======================
// LOAD FORM FIELDS
// =======================
const fieldLabels = {
    created_by: 'Add Team',
    archived_by: 'Add Client',
    completed_by: 'Add Project Leader'
};

function autoLabel(fieldName) {

    if (fieldName.includes("|")) {
        return fieldName.split("|")[1];
    }

    if (fieldLabels[fieldName]) {
        return fieldLabels[fieldName];
    }

    fieldName = fieldName.replace(/_id$/, "");
    fieldName = fieldName.replace(/_/g, " ");
    return fieldName.replace(/\b\w/g, c => c.toUpperCase());
}


function loadForm(fields, title) {

    $("#modalTitle").text(title);
    $("#modalBody").html("");

    $.each(fields, function (key, type) {

        type = String(type).trim();
        let label = autoLabel(key);
        let html = "";

        //  MULTI SELECT
        if (type.startsWith("select-multiple:")) {

            let options = type.replace("select-multiple:", "").split(",");
            let optHtml = options.map(opt => {
                let [value, text] = opt.split("|");
                return `<option value="${value}">${text}</option>`;
            }).join("");



            html = `
                <div class="mb-3">
                    <label>${label}</label>
                    <select name="${key}[]" class="form-control select2" multiple>
                        ${optHtml}
                    </select>
                </div>
            `;
        }


        else if (type === 'textarea') {
                html = `
                    <div class="form-group mb-3">
                        <label>${label}</label>
                        <textarea name="${key}" class="form-control js-summernote"></textarea>
                    </div>
                `;
            }


        //  NORMAL SELECT
        else if (type.startsWith("select:")) {

            let options = type.replace("select:", "").split(",");
            let optHtml = `<option value="">Select ${label}</option>` +
                options.map(opt => {
                    let [value, text] = opt.split("|");
                    return `<option value="${value}">${text}</option>`;
                }).join("");

            html = `
                <div class="mb-3">
                    <label>${label}</label>
                    <select name="${key}" class="form-control">
                        ${optHtml}
                    </select>
                </div>
            `;
        }

        //  TEXTAREA (ALWAYS AFTER select)
        else if (type === "textarea") {
            html = `
                <div class="mb-3">
                    <label>${label}</label>
                    <textarea name="${key}" class="form-control"></textarea>
                </div>
            `;
        }

        //  INPUT
        else {
            html = `
                <div class="mb-3">
                    <label>${label}</label>
                    <input type="${type}" name="${key}" class="form-control">
                </div>
            `;
        }

        $("#modalBody").append(html);
    });

    //  Select2 init AFTER DOM append
    $("#globalModal").modal('show');
    function initModalSelect2() {
        $('#globalModal .select2').each(function () {
            if ($(this).hasClass("select2-hidden-accessible")) {
                $(this).select2('destroy');
            }
        });

        $('#globalModal .select2').select2({
            placeholder: "Select Users",
            allowClear: true,
           dropdownParent: $('#globalModal .modal-body')

        });
    }

$("#globalModal").modal('show');

    $('#globalModal').on('shown.bs.modal', function () {
        initModalSelect2();
    });
}


// =======================
// UNIVERSAL STATUS CHANGE
// =======================
    // dropdown Status
    const STATUS_OPTIONS = {
        created: 'Created',
        working: 'Working',
        on_hold: 'On Hold',
        finished: 'Finished',
        maintenance: 'Maintenance',
        delay: 'Delay',
        handover: 'Handover',
        discontinued: 'Discontinued',
        inactive: 'Inactive'
    };
    let STATUS_UPDATE_URL = '';

    $(document).on('click', '.openStatusModal', function () {

        STATUS_UPDATE_URL = $(this).data('url');
        let current = $(this).data('current');

        let options = '';
        Object.entries(STATUS_OPTIONS).forEach(([value, label]) => {
            let selected = value === current ? 'selected' : '';
            options += `<option value="${value}" ${selected}>${label}</option>`;
        });

        $('#globalStatusSelect').html(options);
        $('#globalStatusModal').modal('show');
    });

    // functinality Status
    $('#globalStatusSave').on('click', function () {

        let status = $('#globalStatusSelect').val();

        $.post(STATUS_UPDATE_URL, { status: status }, function () {

            $('#globalStatusModal').modal('hide');
            $('.dataTable').DataTable().ajax.reload(null, false);
            toastr.success('Status updated');

        }).fail(function (xhr) {
            toastr.error(xhr.responseJSON?.message ?? 'CSRF Error');
        });

    });


    let dynamicfields = {
        comment: "textarea",
        commentable_type: "hidden",
        commentable_id: "hidden",
        user_id: "hidden",
    };

    let STATUS_GLOBAL_URL = '';

    $(document).on('click', '.dynamicGlobalModal', function () {
        STATUS_GLOBAL_URL = $(this).data('url');

        $("#universalForm").attr("action", STATUS_GLOBAL_URL);

        let post_id = $(this).data('id');
          let user_id = $(this).data('user_id');
        let comment_type = $(this).data('comment_type');
        let title = $(this).data('title');
        loadForm(dynamicfields, title);
          //  auto set hidden id
            $('input[name="commentable_type"]').val(comment_type);
            $('input[name="commentable_id"]').val(post_id);
            $('input[name="user_id"]').val(user_id);
        addDocumentField();

         // summer note
        initSummernote('#globalModal');

    });



$(document).on('click', '.viewComments', function () {

    let url = $(this).data('url');

    $('#commentsModalBody').html(`
        <div class="text-center text-muted">Loading comments...</div>
    `);

    $.get(url, function (comments) {

        let html = '';
        if (comments.length === 0) {
            html = `<div class="text-center text-muted">No comments found</div>`;
        } else {
            comments.forEach(c => {
                html += `
                    <div class="border rounded p-2 mb-2">
                        <div class="d-flex justify-content-between">
                            <strong>${c.user.name}</strong>
                            <small class="text-muted">${c.created_at}</small>
                        </div>
                        <div class="mt-1">${c.comment}</div>
                    </div>
                `;
            });
        }

        $('#commentsModalBody').html(html);
        $('#openModalBody').modal('show');
    });
});





// =======================
// UNIVERSAL Change EDIT
// =======================
$(document).on("click", ".editBtn", function () {
    let url = $(this).data("url");

    $.get(url, function (res) {

        // Step 1: dynamic form fields create
        let fields = {};
        $.each(res, function (key, value) {
            fields[key] = "text";
        });

        // Step 2: show modal
        $("#universalForm").attr("action", url.replace("edit", "update"));
        loadForm(fields, "Edit");

        // Step 3: auto-fill
        $.each(res, function (key, value) {
            $("[name='" + key + "']").val(value);
        });

    });
});

// =======================
// UNIVERSAL Change EDIT Project
// =======================
$(document).on("click", ".editBtnProject", function () {
    let url = $(this).data("url");

    $.get(url, function (res) {

        // Step 1: create full fields like Add modal
        let userlist = "{{ currentGuard() === 'saas'? route('saas.users.list'): route('tenant.users.list', ['tenant' => currentTenant()]) }}";
        $.get(userlist, function(users) {

            let data = users.data;
            let userOptions = data.map(u => `${u.id}|${u.name}`).join(',');

            let statusOptions = "created|Created,working|Working,on_hold|On Hold,finished|Finished,maintenance|Maintenance,delay|Delay,handover|Handover,discontinued|Discontinued,inactive|Inactive";
            let typeOptions = "fixed|Fixed,product|Product";

            let fields = {
                type: "select:" + typeOptions,
                name: "text",
                description: "textarea",

                start_date: "date",
                end_date: "date",
                actual_start_date: "date",

                total_days: "number",
                completion_percent: "number",
                hours_allocated: "number",
                created_by: "select-multiple:" + userOptions,
                archived_by: "select-multiple:" + userOptions,
                completed_by: "select:" + userOptions,
                status: "select:" + statusOptions,
                remarks: "text",
            };

            // Step 2: set form action to update
            $("#universalForm").attr("action", url.replace("edit", "update"));

            // Step 3: load modal
            loadForm(fields, "Edit Project");

            // Step 4: pre-fill values
            setTimeout(() => { // wait for DOM + select2
                $.each(res, function(key, value) {
                    if(key === 'created_by' || key === 'archived_by') {
                        $("[name='" + key + "[]']").val(value).trigger('change');
                    } else {
                        $("[name='" + key + "']").val(value).trigger('change');
                    }
                });
            }, 200);
        });
    });
});




// =======================
// UNIVERSAL CHANGE PASSWORD
// =======================
$(document).on("click", ".changePasswordBtn", function () {
    let url = $(this).data("url");

    let fields = {
        password: "password",
        password_confirmation: "password"
    };

    $("#universalForm").attr("action", url);
    loadForm(fields, "Change Password");

});










// =======================
// Validation
// =======================
function showValidationErrors(errors, form) {
    form.find(".is-invalid").removeClass("is-invalid");
    form.find(".dynamic-error").remove();

    $.each(errors, function (field, messages) {
        let input = form.find('[name="' + field + '"]');

        if (input.length) {
            input.addClass("is-invalid");

            let errorHtml = `<small class="text-danger dynamic-error">${messages[0]}</small>`;
            input.after(errorHtml);
        }
    });
}

function clearFieldError(input) {
    input.removeClass("is-invalid");
    input.next(".dynamic-error").remove();
}

// =======================
// UNIVERSAL SAVE
// =======================
$(document).on("submit", "#universalForm", function (e) {
    e.preventDefault();

    let form = this;
    let url  = $(form).attr("action");
    let btn  = $("#formSubmitBtn");

    let formData = new FormData(form);

    btn.text("Saving...").prop("disabled", true);

    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            toastr.success(res.message);

            if (res.redirect) {
                window.location.href = res.redirect;
                return;
            }

            $("#globalModal").modal("hide");
            table.ajax.reload(null, false);

            btn.text("Save").prop("disabled", false);
        },
        error: function (err) {
            if (err.status === 422) {
                showValidationErrors(err.responseJSON.errors, $(form));
            }
            btn.text("Save").prop("disabled", false);
        }
    });
});



// =======================
// Clear validation on input change

$(document).on("input change", "#universalForm input, #universalForm select, #universalForm textarea", function () {
    clearFieldError($(this));
});

// =======================
// STATUS BUTTON
// =======================
$(document).on("click", ".statusBtn", function () {
    let btn = $(this);
    let url = btn.data("url");

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to change the status?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Change!",
        cancelButtonText: "Cancel"
    }).then((result) => {

        if (result.isConfirmed) {

            $.post(url, {}, function (res) {

                if (res.status == 1) {
                    btn.removeClass("btn-danger")
                        .addClass("btn-success")
                        .text("Active");
                } else {
                    btn.removeClass("btn-success")
                        .addClass("btn-danger")
                        .text("Inactive");
                }

                toastr.success("status update!");
                 table.ajax.reload(null, false);
            });

        }
    });
});


// =======================
// DELETE BUTTON
// =======================
$(document).on("click", ".deleteBtn", function() {
    let url = $(this).data("url");

    Swal.fire({
        title: "Delete?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then(result => {
        if (result.isConfirmed) {
            $.post(url, {}, function() {
                toastr.success("Deleted!");
                table.ajax.reload(null, false);
            });
        }
    });
});

// =======================
// DATATABLE LOADER
// =======================
function loadDataTable(columns, url) {
    $("#tableHead").html("");

    $.each(columns, c => {
        $("#tableHead").append(`<th>${c.title}</th>`);
    });

    table = $("#universalTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: url,
        columns: columns
    });
}


// =======================
// Append Fields LOADER PERMISSION
// =======================

$(document).on("click", ".add-group", function() {
    $("#groupWrapper").append(`
        <div class="input-group mb-2 group-item">
            <input type="text" name="group[]" class="form-control" placeholder="Enter group">
            <div class="input-group-append">
                <button type="button" class="btn btn-danger remove-group"><i class="la la-minus"></i></button>
            </div>
        </div>
    `);
});

$(document).on("click", ".remove-group", function() {
    $(this).closest(".group-item").remove();
});

// =======================
// Append Fields PROJECT
// =======================
$(document).on('click','.addDoc',function(){
    $('#docWrapper').append(`
        <div class="row mb-2">

            <div class="col-md-5">
                <input type="file" name="documents[]" class="form-control">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger removeDoc">×</button>
            </div>
        </div>
    `);
});

$(document).on('click','.removeDoc',function(){
    $(this).closest('.row').remove();
});


// =======================
// ZIPCODE AUTO-FILL
// =======================
$('#present_zipcode').on('blur', function () {
    let zip = $(this).val();

    if (zip.length === 6) {
        $.ajax({
            url: 'https://api.zippopotam.us/in/' + zip,
            type: 'GET',
            success: function (res) {
                $('#present_country').val('India');
                $('#present_state').val(res.places[0].state);
                $('#present_city').val(res.places[0]["place name"]);
            },
            error: function () {
                alert('Invalid or unsupported pincode');
            }
        });
    }
});



// =======================
// NULTIPLE FILES
// =======================
function addDocumentField(delay = 0) {
    setTimeout(() => {
        $("#modalBody").append(`
            <div id="docWrapper">
                <div class="row mb-2">
                    <div class="col-md-5">
                        <input type="file" name="documents[]" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-success addDoc">+</button>
                    </div>
                </div>
            </div>
        `);
    }, delay);
}


// =======================
// SUMMER NOTE
// =======================
function initSummernote(context = document) {
    $(context).find('.js-summernote').each(function () {

        if ($(this).hasClass('summernote-initialized')) {
            return;
        }

        $(this).summernote({
            height: 200,
            placeholder: 'Task description likho...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol']],
                ['insert', ['link']],
                ['view', ['codeview']]
            ]
        });

        $(this).addClass('summernote-initialized');
    });
}


</script>

