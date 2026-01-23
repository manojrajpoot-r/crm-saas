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

.top-50 {
    top: 70% !important;
}

.modal-body {
    max-height: 70vh;
    overflow-y: auto;
}
.select2-container--open .select2-dropdown {
    top: 100% !important;
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
    // FIELD LABELS
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

        return fieldName
            .replace(/_id$/, '')
            .replace(/_/g, ' ')
            .replace(/\b\w/g, c => c.toUpperCase());
    }


    // =======================
    // LOAD FORM
    // =======================


        function loadForm(fields, title,hasTenantUser = false) {

            $("#modalTitle").text(title);
            $("#modalBody").empty();

            $.each(fields, function (key, config) {

                let type = '';
                let value = '';
                let options = [];
                let readonly = false;

                // ---------- EDIT MODE (object) ----------
                if (typeof config === 'object') {
                    type     = config.type;
                    value    = config.value ?? '';
                    options  = config.options ?? [];
                    readonly = config.readonly ?? false;
                }

                // ---------- ADD MODE (string) ----------
                else {
                    let raw = String(config).trim();

                    if (raw.startsWith('select:')) {
                        type = 'select';
                        options = raw.replace('select:', '')
                            .split(',')
                            .map(o => {
                                let [id, name] = o.split('|');
                                return { id, name };
                            });
                    }
                    else if (raw.startsWith('multiselect:')) {
                        type = 'multiselect';
                        options = raw.replace('multiselect:', '')
                            .split(',')
                            .map(o => {
                                let [id, name] = o.split('|');
                                return { id, name };
                            });
                    }
                    else {
                        type = raw;
                    }
                }

                let label = autoLabel(key);
                let html = '';

                // ---------- Skip fields ----------
                if (hasTenantUser && (key === 'email' || key === 'password')) {
                    return;
                }
                // ---------- MULTI SELECT ----------
                if (type === 'multiselect') {
                    html = `
                        <div class="mb-3">
                            <label>${label}</label>
                            <select name="${key}[]" multiple class="form-control select2">
                                ${options.map(opt => `
                                    <option value="${opt.id}"
                                        ${Array.isArray(value) && value.includes(opt.id) ? 'selected' : ''}>
                                        ${opt.name} ${opt.name}
                                    </option>
                                `).join('')}
                            </select>
                        </div>
                    `;
                }

                // ---------- SINGLE SELECT ----------
                else if (type === 'select') {
                    html = `
                        <div class="mb-3">
                            <label>${label}</label>
                            <select name="${key}" class="form-control select2">
                                <option value="">Select ${label}</option>
                                ${options.map(opt => `
                                    <option value="${opt.id}" ${opt.id == value ? 'selected' : ''}>
                                        ${opt.name}
                                    </option>
                                `).join('')}
                            </select>
                        </div>
                    `;
                }

                // ---------- TEXTAREA ----------
                else if (type === 'textarea') {
                    html = `
                        <div class="mb-3">
                            <label>${label}</label>
                            <textarea name="${key}" class="form-control js-summernote">${value}</textarea>
                        </div>
                    `;
                }



                // =======================
                // PASSWORD
                // =======================
                else if (type === 'password') {

                    html = `
                        <div class="mb-3 position-relative">
                            <label>${label}</label>
                            <input type="password" name="${key}" id="${key}" class="form-control pe-5">
                            <span class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3"
                                data-target="${key}" style="cursor:pointer">👁️</span>
                        </div>
                    `;
                }




            // =======================
                // HIDDEN
            // =======================
                else if (type === 'hidden') {
                    html = `<input type="hidden" name="${key}" value="${value}">`;
                }



             // =======================
                // checkbox
            // =======================
                else if (type === 'checkbox') {
                    html = `
                        <div class="mb-3">
                            <label>${label}</label>
                            <input type="checkbox" name="${key}" class="form-check-input"
                                ${value ? 'checked' : ''}>
                        </div>
                    `;
                }


                // ---------- INPUT ----------
                else {
                    html = `
                        <div class="mb-3">
                            <label>${label}</label>
                            <input type="${type}" name="${key}" class="form-control"
                                value="${value}" ${readonly ? 'readonly' : ''}>
                        </div>
                    `;
                }

                $("#modalBody").append(html);
            });

            $("#globalModal").modal('show');
        }





    // =======================
    // UNIVERSAL Change EDIT
    // =======================
    // $(document).on("click", ".editBtn", function () {

    //     let url = $(this).data("url");

    //     $.get(url, function (res) {

    //         $("#universalForm").attr(
    //             "action",
    //             url.replace("/edit", "")
    //         );

    //         loadForm(res.fields, "Edit");

    //         $('#globalModal')
    //             .off('shown.bs.modal')
    //             .on('shown.bs.modal', function () {

    //                 //  MUST ORDER
    //                 initModalSelect2(this);
    //                 initSummernote(this);

    //                 // ---------- SET VALUES ----------
    //                 $.each(res.fields, function (key, field) {

    //                     let el = $(`[name="${key}"]`);

    //                     if (!el.length) return;

    //                     // MULTI SELECT
    //                     if (Array.isArray(field.value)) {
    //                         el.val(field.value).trigger('change');
    //                     }

    //                     // SINGLE SELECT
    //                     else if (el.is('select')) {
    //                         el.val(field.value).trigger('change');
    //                     }

    //                     // SUMMERNOTE
    //                     else if (el.hasClass('js-summernote')) {
    //                         el.summernote('code', field.value ?? '');
    //                     }

    //                     // NORMAL INPUT
    //                     else if (el.attr("type") !== "file") {
    //                         el.val(field.value);
    //                     }
    //                 });

    //                 // ---------- PROFILE PREVIEW ----------
    //                 if (res.fields.profile?.value) {

    //                     let fileInput = $("[name='profile']");

    //                     fileInput.closest(".mb-3")
    //                         .find(".profile-preview")
    //                         .remove();

    //                     fileInput.closest(".mb-3").append(`
    //                         <div class="profile-preview mt-2 text-center">
    //                             <img src="${res.fields.profile.value}"
    //                                 style="max-width:120px;border-radius:8px;border:1px solid #ddd">
    //                         </div>
    //                     `);
    //                 }
    //             });
    //     });
    // });


         $(document).on("click", ".editBtn", function () {
            let editUrl = $(this).data("url");
            $("#modalBody").empty();

            $.get(editUrl, function (res) {
                let updateUrl = editUrl.replace('/edit/', '/update/');
                $("#universalForm").attr("action", updateUrl);


                loadForm(res.fields, "Edit Project");

                // documents fields
             if (res.fields.documents !== undefined) {
                addDocumentField('#modalBody', res.fields.documents);
            }


                $("#globalModal").modal('show');

                $('#globalModal').off('shown.bs.modal').on('shown.bs.modal', function () {
                    initModalPlugins();

                   $.each(res.fields, function (key, field) {
                    let el = $(`[name="${key}"], [name="${key}[]"]`);
                    if (!el.length) return;

                    if (field.type === 'checkbox') {
                        el.prop('checked', field.checked === true);
                    }
                    else if (Array.isArray(field.value)) {
                        el.val(field.value).trigger('change');
                    }
                    else if (el.is('select')) {
                        el.val(field.value).trigger('change');
                    }
                    else if (el.hasClass('js-summernote')) {
                        el.summernote('code', field.value ?? '');
                    }
                    else {
                        el.val(field.value);
                    }


                    });
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
            project_id: "hidden",
            user_id: "hidden",
        };

        let STATUS_GLOBAL_URL = '';

        $(document).on('click', '.dynamicGlobalModal', function () {
            STATUS_GLOBAL_URL = $(this).data('url');

            $("#universalForm").attr("action", STATUS_GLOBAL_URL);

            let project_id = $(this).data('id');
            let user_id = $(this).data('user_id');
            let title = $(this).data('title');
            loadForm(dynamicfields, title);
            //  auto set hidden id
                $('input[name="project_id"]').val(project_id);
                $('input[name="uploaded_by"]').val(user_id);

                // files
                addDocumentField();
                // summer note
                initModalPlugins('#globalModal');
        });

        //view Comment /////////////////////
        // $(document).on('click', '.viewComments', function () {

        //     let url = $(this).data('url');

        //     $('#commentsModalBody').html(`
        //         <div class="text-center text-muted">Loading comments...</div>
        //     `);

        //     $.get(url, function (comments) {

        //         let html = '';
        //         if (comments.length === 0) {
        //             html = `<div class="text-center text-muted">No comments found</div>`;
        //         } else {
        //             comments.forEach(c => {
        //             html += `
        //                 <div class="border rounded p-2 mb-2">
        //                     <div class="d-flex justify-content-between">
        //                         <strong>${c.user.name}</strong>
        //                         <small class="text-muted">${c.created_at}</small>
        //                     </div>

        //                     <div class="mt-1">${c.comment}</div>

        //                     ${
        //                         c.documents && c.documents.length
        //                         ? `<div class="mt-2 d-flex flex-wrap gap-2">
        //                             ${c.documents.map(d => `
        //                                 <a href="${d.url}" download
        //                                 class="border rounded p-2 text-center"
        //                                 style="width:90px">
        //                                     <img src="${d.icon}" width="28">
        //                                     <div class="small text-truncate">${d.name}</div>
        //                                 </a>
        //                             `).join('')}
        //                         </div>`
        //                         : ''
        //                     }
        //                 </div>
        //             `;

        //             });
        //         }

        //         $('#commentsModalBody').html(html);
        //         $('#openModalBody').modal('show');
        //     });
        // });



        //view post //////////////////////////////////////////
       $(document).on('click', '.universalViewDetails', function () {
            let url = $(this).data('url');

            $('#commonModalTitle').text('Loading...');
            $('#commonModalBody').html('<div class="text-muted">Loading...</div>');

            $.get(url, function (res) {

                let docsHtml = '';

                if (res.documents && res.documents.length) {
                    docsHtml = `<div class="mt-3 d-flex flex-wrap gap-2">`;
                    res.documents.forEach(d => {
                        docsHtml += `
                            <a href="${d.url}" download
                            class="border rounded p-2 text-center"
                            style="width:90px">
                                <img src="${d.icon}" width="28">
                                <div class="small text-truncate">${d.name}</div>
                            </a>
                        `;
                    });
                    docsHtml += `</div>`;
                }

                $('#commonModalTitle').text(res.title ?? 'Details');

                $('#commonModalBody').html(`
                    <div class="fw-semibold mb-1">${res.description ?? '-'}</div>
                    <small class="text-muted">Created At: ${res.created_at}</small>
                    ${docsHtml}
                `);

                $('#commonDetailsModal').modal('show');
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
        function toggleBtn(btn, loading) {
            btn.prop("disabled", loading);
            btn.find(".btn-text").toggleClass("d-none", loading);
            btn.find(".spinner-border").toggleClass("d-none", !loading);
        }

        $(document).on("submit", "#universalForm", function (e) {
            e.preventDefault();

            let form = this;
            let url  = $(form).attr("action");
            let btn  = $("#formSubmitBtn");
            let formData = new FormData(form);

            // spinner ON
            toggleBtn(btn, true);

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,

                success: function (res) {
                    toastr.success(res.message);

                     $('#tableBody').load(window.location.href + ' #tableBody > *');
                    // spinner OFF
                    toggleBtn(btn, false);

                    if (res.redirect) {
                        window.location.href = res.redirect;
                        return;
                    }

                    $("#globalModal").modal("hide");
                    if (typeof table !== "undefined") {
                        table.ajax.reload(null, false);
                    }
                },

                error: function (err) {

                    // spinner OFF
                    toggleBtn(btn, false);

                    if (err.status === 422) {
                        showValidationErrors(err.responseJSON.errors, $(form));
                    }
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
        // function loadDataTable(columns, url) {
        //     $("#tableHead").html("");

        //     $.each(columns, c => {
        //         $("#tableHead").append(`<th>${c.title}</th>`);
        //     });

        //     table = $("#universalTable").DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: url,
        //         columns: columns
        //     });
        // }



        function loadDataTable(columns, url, extraData = {}) {
            $("#tableHead").html("");
            $('#universalTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: url,
                    data: function (d) {
                        Object.assign(d, extraData);
                    }
                },
                columns: columns
            });
        }


        // =======================
        // Universal  Append Fields
        // =======================
         function field(name, placeholder, first = false) {
                return `
                    <div class="input-group mb-2 item">
                        <input type="text" name="${name}[]" class="form-control" placeholder="${placeholder}">
                        <button type="button" class="btn ${first ? 'btn-success add' : 'btn-danger remove'}">
                            <i class="la ${first ? 'la-plus' : 'la-minus'}"></i>
                        </button>
                    </div>
                `;
            }

            $(document).on("click", ".add", function () {
                $("#wrap").append(field('name', 'Enter Permission Name'));
            });
            $(document).on("click", ".remove", function () {
                $(this).closest(".item").remove();
            });




                // =======================
                // Append Fields PROJECT
                // =======================

                   function documentFieldRow(doc = null, isFirst = false) {
                        // Agar document object hai, show file link aur remove button
                        let fileHtml = doc ? `<a href="${doc.file}" target="_blank">${doc.file.split('/').pop()}</a>` : '';

                        return `
                            <div class="row mb-2 doc-row">
                                <div class="col-md-5">
                                    <input type="file" name="documents[]" class="form-control" ${doc ? '' : ''}>
                                    ${fileHtml ? `<div class="existing-file mt-1">${fileHtml}</div>` : ''}
                                </div>
                                <div class="col-md-2">
                                    ${
                                        doc
                                            ? `<button type="button" class="btn btn-danger removeDoc">×</button>` // existing doc
                                            : `<button type="button" class="btn btn-${isFirst ? 'success addDoc' : 'danger removeDoc'}">${isFirst ? '+' : '×'}</button>`
                                    }
                                </div>
                            </div>
                        `;
                    }

                    function addDocumentField(target = '#modalBody', documents = []) {
                        // Remove previous wrapper if any
                        $(target).find('#docWrapper').remove();

                        let wrapper = $('<div id="docWrapper"></div>');

                        if (documents.length > 0) {
                            // Existing documents
                            documents.forEach(doc => {
                                wrapper.append(documentFieldRow(doc, false));
                            });
                            // Add one empty input at the end with + button
                            wrapper.append(documentFieldRow(null, true));
                        } else {
                            // No documents, just one empty input with + button
                            wrapper.append(documentFieldRow(null, true));
                        }

                        $(target).append(wrapper);
                    }

                    // Click handlers
                    $(document).on('click', '.addDoc', function() {
                        let wrapper = $(this).closest('#docWrapper');
                        wrapper.append(documentFieldRow(null, false));
                    });

                    $(document).on('click', '.removeDoc', function() {
                        $(this).closest('.doc-row').remove();
                    });



        // =======================
        // selected 2 && Summernote in Modal
        // =======================
        function initModalPlugins() {

            $('#globalModal select.select2').each(function () {
                if ($(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2('destroy');
                }

                $(this).select2({
                    width: '100%',
                    dropdownParent: $('#globalModal'),
                    placeholder: 'Select',
                    allowClear: true
                });
            });

            $('#globalModal .js-summernote').each(function () {

                if ($(this).hasClass('summernote-initialized')) return;

                $(this).summernote({
                    height: 200,
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
        // MULTIPLE SELECT 2 Users
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
                            ? `/uploads/employees/profile/${u.profile}`
                            : `https://ui-avatars.com/api/?name=${u.first_name}&background=random&size=128`;

                        html += `
                            <a href="#" class="list-group-item list-group-item-action selectUser"
                            data-id="${u.id}" data-name="${u.first_name} ${u.last_name}">
                                <img src="${img}" width="30" class="rounded-circle me-2">
                                ${u.first_name} ${u.last_name}

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
                    <input type="hidden" name="employee_id[]" value="${id}" id="employee_${id}">
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


        // =======================
        //  toggle password visibility
        // =======================

        document.addEventListener('click', function (e) {

            if (e.target.classList.contains('toggle-password')) {

                let input = document.getElementById(e.target.dataset.target);

                if (input.type === 'password') {
                    input.type = 'text';
                    e.target.textContent = '🙈';
                } else {
                    input.type = 'password';
                    e.target.textContent = '👁️';
                }
            }
        });



        // =======================
        //  Date caculation
        // =======================

        $(document).on('change', '[name="start_date"], [name="end_date"]', function () {

            let start = $('[name="start_date"]').val();
            let end   = $('[name="end_date"]').val();

            if (start && end) {
                let d1 = new Date(start);
                let d2 = new Date(end);
                let days = Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24)) + 1;

                if (days > 0) {
                    $('[name="total_days"]').val(days);
                }
            }
        });




       // =======================
        // Field Validation Employee
        // =======================
        function validateField(el) {
            const type = el.dataset.validate;
            let value = el.value.trim();

            let regex = null;
            let message = '';

            switch (type) {

                case 'aadhaar':
                    regex = /^[2-9]{1}[0-9]{11}$/;
                    message = 'Invalid Aadhaar number';
                    break;

                case 'pan':
                    el.value = value.toUpperCase();
                    regex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
                    message = 'Invalid PAN number';
                    break;

                case 'account':
                    regex = /^[0-9]{9,18}$/;
                    message = 'Invalid Account number';
                    break;

                case 'ifsc':
                    el.value = value.toUpperCase();
                    regex = /^[A-Z]{4}0[A-Z0-9]{6}$/;
                    message = 'Invalid IFSC code';
                    break;

                case 'upi':
                    regex = /^[\w.-]{2,256}@[a-zA-Z]{2,64}$/;
                    message = 'Invalid UPI ID';
                    break;
            }

            if (!regex) return;

            if (!regex.test(el.value)) {
                el.classList.add('is-invalid');
                showError(el, message);
            } else {
                el.classList.remove('is-invalid');
                removeError(el);
            }
        }

        function showError(el, message) {
            removeError(el);
            const div = document.createElement('div');
            div.className = 'invalid-feedback';
            div.innerText = message;
            el.parentNode.appendChild(div);
        }

        function removeError(el) {
            const error = el.parentNode.querySelector('.invalid-feedback');
            if (error) error.remove();
        }

        document.addEventListener('input', function (e) {
            if (e.target.dataset.validate) {
                validateField(e.target);
            }
        });




</script>

