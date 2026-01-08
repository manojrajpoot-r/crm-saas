@extends('saas.layouts.app')


<div class="card col-md-4 col-11">
    <h3 class="text-center mb-4 fw-bold">Welcome Back Tenant👋</h3>

<form method="POST"
      action="{{route('tenant.login.submit')}}"
      class="ajaxForm">
    @csrf

        <div class="mb-3 position-relative">
            <input type="email" name="email" class="form-control" placeholder="Email">
            <span class="error-text email_error"></span>
        </div>

        <div class="mb-3 position-relative">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <span class="error-text password_error"></span>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>

    </form>

</div>

