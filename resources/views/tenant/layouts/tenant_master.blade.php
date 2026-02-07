<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ currentTenant() ? 'Tenant Dashboard' : 'SAAS Dashboard' }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <!-- Ready Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ready.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ready.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/sass/ready/ready.scss') }}">
    <link rel="stylesheet" href="{{ asset('assets/sass/ready/_layouts.scss') }}">



     <link rel="stylesheet" href="{{ asset('assets/sass/ready/components/_inputs.scss') }}">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">



    <!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Plugins -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
   {{-- FullCalendar CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">


    <style>
        /* .la {
            font-family: "Line Awesome Free" !important;
            font-weight: 900;
        }

        .sidebar i.la {
            width: 26px;
            text-align: center;
            display: inline-block;
        } */


        .form-check-inline .form-check-input {
            position: static !important;
            margin-top: 0;
            margin-right: .3125rem;
            margin-left: 0;
        }
        .form-check-input {
            position: static !important;
            margin-top: .3rem;
            margin-left: 0.75rem;
        }


    </style>
</head>





<body>

<div class="wrapper">

    {{-- HEADER --}}
   @include('tenant.layouts.tenant_header')

    {{-- SIDEBAR --}}
  @include('tenant.layouts.tenant_sidebar')

    {{-- MAIN PANEL --}}
    <div class="main-panel">
        <div class="content">
            @yield('content')
        </div>
    </div>
 {{-- FOOTER --}}
        @include('tenant.layouts.tenant_footer')

</div>
<!-- Core JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

<!-- Plugins -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
{{-- FullCalendar JS --}}
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<!-- Bootstrap 5 JS (Bundle = collapse + dropdown included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('assets/js/ready.min.js') }}"></script>
<script src="{{ asset('assets/js/admin_common.js') }}"></script>

@stack('scripts')
</body>
</html>
