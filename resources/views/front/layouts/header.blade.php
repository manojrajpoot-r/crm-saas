<header>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="#">YourCRM</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
          <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
           <li class="nav-item">
{{-- <a class="btn btn-primary"
   href="{{ request()->getHost() === 'crm.localhost'
        ? route('saas.login')
        : route('tenant.login') }}">
   {{ request()->getHost() === 'crm.localhost'
        ? 'Tenant Login'
        : 'SAAS Login' }}
</a> --}}


            </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
