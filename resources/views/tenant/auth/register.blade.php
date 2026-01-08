@extends('saas.layouts.app')
<style>
body {
    background: #eef2f7;
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
</head>

<body>

<div class="card col-md-4 col-11">
    <h3 class="text-center mb-4 fw-bold">Create Account ✨</h3>
<form class="ajaxForm" action="{{ route('tenant.register.submit') }}" method="POST">
    @csrf
    <div class="mb-3 position-relative">
        <i class="fa fa-user icon"></i>
        <input type="text" name="name" class="form-control" placeholder="Full Name">
    </div>

    <div class="mb-3 position-relative">
        <i class="fa fa-envelope icon"></i>
        <input type="email" name="email" class="form-control" placeholder="Email Address">
    </div>

    <div class="mb-3 position-relative">
        <i class="fa fa-lock icon"></i>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
           <span class="toggle-password" data-target="password">
                👁️
            </span>

    </div>

    <div class="mb-3 position-relative">
        <i class="fa fa-lock icon"></i>
       <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password">
          <span class="toggle-password" data-target="password_confirmation">
                👁️
            </span>

    </div>

    <button class="btn btn-success btn-custom">Create Account</button>

    <p class="text-center mt-3">Already have an account?
        <a href="{{route("tenant.login")}}" class="fw-bold">Login</a>
    </p>
</form>
</div>

</body>
</html>
