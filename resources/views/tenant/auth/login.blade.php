@extends('saas.layouts.app')
<style>

body {
    background: #f1f5f9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.card {
    border-radius: 20px;
    padding: 35px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
input {
    border-radius: 10px !important;
    padding-left: 40px !important;
}
.icon {
    position: absolute;
    left: 12px;
    top: 12px;
    color: #777;
}
.btn-custom {
    border-radius: 10px;
    width: 100%;
    padding: 10px;
}

</style>
<div class="card col-md-4 col-11">
    <h3 class="text-center mb-4 fw-bold">Welcome Back Tenant 👋</h3>

<form method="POST" id="" action="{{  route('tenant.login.submit', currentTenant()) }}" class="ajaxForm">
    @csrf
        <div class="mb-3 position-relative">
            <input type="email" name="email" class="form-control" placeholder="Email">
            <span class="error-text email_error"></span>
        </div>

        <div class="mb-3 position-relative">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password">

            <span class="toggle-password" data-target="password">
                👁️
            </span>

            <span class="error-text password_error"></span>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>

        {{-- <p class="text-center mt-3">Create an account?
                <a href="{{route("tenant.register")}}" class="fw-bold">Register</a>
            </p> --}}
    </form>
</div>

