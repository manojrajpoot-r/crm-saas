<style>

.is-invalid {
    border-color: #dc3545;
}
.dynamic-error {
    font-size: 13px;
    display: block;
}


.hover-danger:hover {
    background-color: #dc3545 !important;
    color: #fff !important;
    border-color: #dc3545 !important;
}

.hover-success:hover {
    background-color: #198754 !important;
    color: #fff !important;
    border-color: #198754 !important;
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
    user_id: 'Add Team',
    client_id: 'Add Client'
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
          if (type.startsWith("multiselect:")) {

                let options = type.replace("multiselect:", "").split(",");
                console.log(options);
                let select = `<select name="${name}[]" multiple class="form-control select2">`;

                options.forEach(opt => {
                    let [id, label] = opt.split("|");
                    select += `<option value="${id}">${label}</option>`;
                });

                select += `</select>`;
                html += select;
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
        // hidden

        else if (type === 'hidden') {
                html += `<input type="hidden" name="${key}">`;

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

    if ($("#profilePreview").length === 0) {
        $("#modalBody").append(`<div id="profilePreview" class="mt-2 text-center"></div>`);
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
// UNIVERSAL Change EDIT
// =======================
$(document).on("click", ".editBtn", function () {

    let url = $(this).data("url");

    $.get(url, function (res) {

        let fields = {};
        let values = {};

        $.each(res.fields, function (key, obj) {

            if (obj.type === "select") {
                let opts = obj.options.map(r => `${r.id}|${r.name}`).join(",");
                fields[key] = "select:" + opts;
            } else {
                fields[key] = obj.type;
            }

            values[key] = obj.value;
        });

        $("#universalForm").attr("action", url.replace("edit","update"));
        loadForm(fields, "Edit");

        $('#globalModal').off('shown.bs.modal').on('shown.bs.modal', function () {

            $.each(values, function (key, val) {

                let el = $("[name='"+key+"']");

                if (el.prop("tagName") === "SELECT") {
                    el.val(val).trigger("change.select2");
                }
                else if(el.attr("type") !== "file"){
                    el.val(val);
                }
            });

            $("#profilePreview").html(`<img ...>`);

           let fileInput = $("[name='profile']");

            fileInput.closest(".mb-3").find(".profile-preview").remove();

            fileInput.closest(".mb-3").append(`
                <div class="profile-preview mt-2 text-center">
                    <img src="${values.profile}"
                        style="max-width:120px;border-radius:8px;border:1px solid #ddd">
                </div>
            `);

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

                created_by: "select:" + userOptions,
                 user_id: "multiselect:" + userOptions,
                client_id: "multiselect:" + userOptions,
                status: "select:" + statusOptions,
                remarks: "text",
            };

            // Step 2: set form action to update
            $("#universalForm").attr("action", url.replace("edit", "update"));

            // Step 3: load modal
            loadForm(fields, "Edit Project");

            // Step 4: pre-fill values
            // console.log((res));

       setTimeout(() => {

    // Step 1 — init select2 AFTER HTML is created
    $('.select2').select2({
        width: '100%'
    });

    // Step 2 — fill values
    $.each(res, function (key, value) {

        if (Array.isArray(value)) {
            let el = $("[name='" + key + "[]']");

            let stringValues = value.map(v => v.toString());

            el.val(stringValues).trigger('change');   // 🔥 no select2 in trigger
        }
        else {
            let el = $("[name='" + key + "']");
            el.val(value).trigger('change');
        }

    });

}, 300);


        });
    });
});

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



    //comment model

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

//view post /////////////////////
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

                    ${
                        c.documents && c.documents.length
                        ? `<div class="mt-2 d-flex flex-wrap gap-2">
                            ${c.documents.map(d => `
                                <a href="${d.url}" download
                                class="border rounded p-2 text-center"
                                style="width:90px">
                                    <img src="${d.icon}" width="28">
                                    <div class="small text-truncate">${d.name}</div>
                                </a>
                            `).join('')}
                        </div>`
                        : ''
                    }
                </div>
            `;

            });
        }

        $('#commentsModalBody').html(html);
        $('#openModalBody').modal('show');
    });
});



//view post //////////////////////////////////////////
$(document).on('click', '.viewPostDetails', function() {
    let url = $(this).data('url');

    $('#postModalTitle').text('Loading...');
    $('#postModalBody').html('Loading...');

    $.get(url, function(res) {
        $('#postModalTitle').text(res.title);

        let docsHtml = '';
        if (res.documents.length) {
            docsHtml = `<div class="mt-2 d-flex flex-wrap gap-2">`;
            res.documents.forEach(d => {
                docsHtml += `
                    <a href="${d.url}" download class="border rounded p-2 text-center" style="width:90px">
                        <img src="${d.icon}" width="28">
                        <div class="small text-truncate">${d.name}</div>
                    </a>
                `;
            });
            docsHtml += `</div>`;
        }

        $('#postModalBody').html(`
            <div class="fw-semibold">${res.description}</div>
            <small class="text-muted">Created: ${res.created_at}</small>
            ${docsHtml}
        `);

        $('#postDetailsModal').modal('show');
    });
});





// ===========================================================
// UNIVERSAL CHANGE PASSWORD  multiple model open
// =========================================================
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
// MULTIPLE FILES
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


// =======================
// MULTIPLE SELECT 2
// =======================

$("#userSearch").on("keyup", function () {
    let q = $(this).val().trim();

    if (q.length < 2) {
        $("#userList").hide().html('');
        return;
    }

    $.get("/search-users?q=" + q, function (res) {

        let html = '';

        if (res.length === 0) {
            html = `<div class="list-group-item text-muted">No users found</div>`;
        } else {
            res.forEach(u => {
                let img = u.profile
                    ? `/uploads/tenantusers/profile/${u.profile}`
                    : `https://ui-avatars.com/api/?name=${u.name}`;

                html += `
                    <a href="#" class="list-group-item list-group-item-action selectUser"
                       data-id="${u.id}" data-name="${u.name}">
                        <img src="${img}" width="30" class="rounded-circle me-2">
                        ${u.name}

                    </a>
                `;
            });
        }

        $("#userList").html(html).show();
    });
});


$(document).on("click", ".selectUser", function (e) {
    e.preventDefault();

    let id = $(this).data("id");
    let name = $(this).data("name");

    if ($("#user_" + id).length) return;

    $("#selectedUsers").append(`
        <div class="badge bg-primary px-2 py-1 d-flex align-items-center">
            ${name}
            <input type="hidden" name="user_id[]" value="${id}" id="user_${id}">
            <span class="ms-2 removeUser" style="cursor:pointer">&times;</span>
        </div>
    `);

    $("#userSearch").val('');
    $("#userList").hide();
});

//click outside hide
$(document).click(function (e) {
    if (!$(e.target).closest("#userSearch, #userList").length) {
        $("#userList").hide();
    }
});

// remove
$(document).on("click", ".removeUser", function () {
    $(this).parent().remove();
});

// submit

$("#teamForm").submit(function (e) {
    e.preventDefault();

    $.post("/assign-team", $(this).serialize(), function (res) {
        if(res.success){
            Swal.fire("Saved!", "Team members added successfully", "success")
            .then(()=> location.reload());
        }
    });
});



//////////////////Tooltip////////////////////////////
document.addEventListener("DOMContentLoaded", function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});


</script>

