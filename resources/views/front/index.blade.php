@extends('front.layouts.app')

@section('content')

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Powerful CRM Features</h2>
            <p class="text-muted">Everything you need to manage customers</p>
        </div>

        <div class="row g-4">
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5>CRM</h5>
                        <p>Customer Management</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5>Analytics</h5>
                        <p>Reports & Insights</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
