// =======================
// Logout
// =======================


$(document).on('click', '.logoutBtn', function () {

    let form = $(this).closest('form');

    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to logout!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, logout!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});
