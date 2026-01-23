<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">


     <title class="btn btn-primary ms-2">{{ currentTenant() ? 'Tenant Dashboard' : 'SAAS Dashboard' }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

    <!-- SweetAlert2 & Toastr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">




    <!-- Icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome-font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />    <label for="multiSelect">Multi Select:</label>
    {{-- summer note --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ready.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/sass/ready/_layouts.scss') }}">

    <style>
/* Ensure modal is relative for Select2 positioning */


.la {
    font-family: "Line Awesome Free" !important;
    font-weight: 900;
}


.sidebar i.la {
    width: 26px;
    text-align: center;
    display: inline-block;
}

.sidebar a {
    display: flex;
    align-items: center;
    gap: 10px;
}




        body { background: #f4f6f9; }
        .sidebar { width: 240px; height: 100vh; background: #343a40; color: #fff; position: fixed; top: 0; left: 0; padding: 20px; }
        .sidebar a { color: #fff; display: block; margin: 12px 0; text-decoration: none; padding: 8px 12px; border-radius: 6px; }
        .sidebar a:hover { background: #495057; }
        .content-area { margin-left: 260px; padding: 20px; }
        .header { background: #fff; padding: 15px 20px; border-bottom: 1px solid #ddd; }





    </style>
</head>

<body>
    @include('tenant.layouts.tenant_sidebar')

    <div class="wrapper">
        <div class="main-header">
            @include('tenant.layouts.tenant_header')

            <main class="mt-3">
                @yield('content')
            </main>
        </div>
    </div>

    @include('tenant.layouts.tenant_footer')
    @vite(['resources/js/app.js'])
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <!-- Bootstrap 5 JS (ONLY ONE) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- DataTables -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

        <!-- SweetAlert2 & Toastr -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!-- Plugins -->
        <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js') }}"></script>

        <!-- Select2 & Summernote -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

        <!-- Custom -->
        <script src="{{asset('assets/js/admin_common.js')}}"></script>







    <!-- Universal JS includes for modal/form/datatable -->
    @stack('scripts')
</body>
</html>
