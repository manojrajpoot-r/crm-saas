<!DOCTYPE html>
<html lang="en">
    <head>

        <style>
            #toast-container > div {
            background: #19e575;
            color: #e4eee3 !important;
            font-size: 15px;
        }
        </style>

        <meta charset="UTF-8">
        <title>Tenant Dashboard</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">


        <!-- SweetAlert2 & Toastr CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->

        <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
 <link rel="stylesheet" href="{{ asset('assets/css/ready.css') }}">
    </head>

<body>
    {{-- @include('tenant.layouts.tenant_sidebar')

    <div class="wrapper">
        <div class="main-header">
            @include('tenant.layouts.tenant_header')

            <main class="mt-3">
                @yield('content')
            </main>
        </div>
    </div>

    @include('tenant.layouts.tenant_footer') --}}

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- SweetAlert2 & Toastr JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- custome js --}}
    <script src="{{asset('front/js/front_common.js')}}"></script>

    <!-- Universal JS includes for modal/form/datatable -->
    @stack('scripts')
</body>
</html>
