
toastr.options = {
  "closeButton": true,
  "progressBar": true,
  "positionClass": "toast-top-right",
  "timeOut": "3000"
}


$(document).on('submit', '.ajaxForm', function (e) {
    e.preventDefault();

    let form = $(this);
    let url = form.attr('action');
    let submitBtn = form.find('button[type="submit"]');
    let originalBtnHtml = submitBtn.html();

    // Button spinner on
    submitBtn.prop('disabled', true);
    submitBtn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`);

    $.ajax({
        url: url,
        method: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        xhrFields: { withCredentials: true },
        success: function(res) {
            toastr.success(res.message);
            if(res.redirect){
                setTimeout(() => {
                    window.location.href = res.redirect;
                }, 800);
            }
        },
        error: function(xhr){
            if(xhr.status === 422){
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value){
                    let input = $('[name="'+key+'"]');
                    input.addClass('is-invalid');
                    $('.'+key+'_error').text(value[0]);
                });
                toastr.error('Please fix the errors');
            }
        },
        complete: function() {
            // Reset button
            submitBtn.prop('disabled', false);
            submitBtn.html(originalBtnHtml);
        }
    });
});


$(document).on('input', '.form-control', function () {
    $(this).removeClass('is-invalid');
    $(this).siblings('.error-text').text('');
});


// send otp
$('#sendOtp').click(function () {
    $.post('/2fa/send', {_token: csrf}, function () {
        Swal.fire('OTP Sent','Check your device','success');
    }).fail(() => {
        Swal.fire('Error','Try again later','error');
    });
});

// verify otp

$('#verifyOtp').click(function () {
    $.post('/2fa/verify',{
        _token: csrf,
        otp: $('#otp').val()
    }, function (res) {
        Swal.fire('Verified','Welcome','success')
        .then(()=> location.href = res.redirect);
    }).fail(res=>{
        Swal.fire('Error',res.responseJSON.error,'error');
    });
});

// verify recovery code
$('#verifyRecovery').click(function () {
    $.post('/2fa/recovery',{
        _token: csrf,
        code: $('#recovery').val()
    }, function () {
        Swal.fire('Success','Logged in','success')
        .then(()=> location.href='/dashboard');
    }).fail(res=>{
        Swal.fire('Error',res.responseJSON.error,'error');
    });
});


// toggle password visibility
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.toggle-password').forEach(function (eye) {

        eye.addEventListener('click', function () {

            let input = document.getElementById(this.dataset.target);

            if (input.type === 'password') {
                input.type = 'text';
                this.textContent = '🙈';
            } else {
                input.type = 'password';
                this.textContent = '👁️';
            }

        });

    });

});
