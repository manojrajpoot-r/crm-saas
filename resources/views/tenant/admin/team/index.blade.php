@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">

         @include('tenant.admin.projects.tabs',['id'=>$project->id])

         <div class="container-fluid">
    <div class="row">

        <!-- LEFT: TEAM -->
        <div class="col-md-8 border-end">
            <h5 class="fw-bold mb-3">Add your team</h5>




    <form id="teamForm">
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->id }}">

        <div class="position-relative">

            <div class="input-group team-input">

                <span class="input-group-text">
                    <i class="fa fa-user"></i>
                </span>

                <div class="form-control d-flex flex-wrap align-items-center gap-1 team-box">

                    <div id="selectedUsers" class="d-flex flex-wrap gap-1"></div>

                    <input type="text" id="userSearch" class="border-0 flex-grow-1 user-input"
                        placeholder="Search user..." autocomplete="off">

                </div>

            </div>

            <div id="userList" class="list-group shadow"></div>

        </div>

        <button type="submit" class="btn btn-primary mt-3 w-100" style="margin-bottom:15px;">
            Add To Project
        </button>
    </form>




            <div class="row" id="teamGrid">
                <!-- User Card -->
            <div class="row">
            @foreach($project->teamMembers as $user)

                @php
                    $employee = $user->employee;
                    $department = $employee?->department?->name ?? 'N/A';
                    $designation = $employee?->designation?->name ?? 'N/A';
                @endphp

                <div class="col-md-4 mb-4">
                    <div class="user-card text-center p-3 shadow-sm rounded">

                        <img
                            src="{{ $user->profile
                                    ? asset('uploads/tenantusers/profile/'.$user->profile)
                                    : asset('images/default-profile.png')
                                }}"
                            width="80"
                            height="80"
                            style="border-radius:50%;object-fit:cover"
                        >

                        <h6 class="mt-2">{{ $user->name }}</h6>
                        <small>{{ $designation }}</small><br>
                        <small class="text-muted">{{ $department }}</small>

                    </div>
                </div>

            @endforeach
            </div>




            </div>
        </div>


        <!-- RIGHT: CLIENT -->
      <div class="col-md-4">
    <h5 class="fw-bold mb-3">Add your client</h5>

    {{-- <div class="input-group mb-2">
        <span class="input-group-text"><i class="fa fa-user"></i></span>
        <input type="text" class="form-control" placeholder="Search Client...">
    </div>

    <small class="text-muted">
        To add a Client who’s not on Techsaga, you need to
        <a href="#">Invite Them First</a>
    </small> --}}

    <div class="mt-4">

        @forelse($project->clients as $client)

            <div class="client-card mb-3">
                <div class="dots">⋮</div>

                <img
                    src="{{ $client->profile
                        ? asset('uploads/tenantusers/profile/'.$client->profile)
                        : 'https://ui-avatars.com/api/?name='.urlencode($client->name).'&background=0D8ABC&color=fff'
                    }}"
                >

                <h6>{{ $client->name }}</h6>
                <small>{{ $client->email }}</small>

                <div class="status">
                    {{ $client->is_active ? 'Active' : 'Inactive' }}
                </div>
            </div>

        @empty
            <p class="text-muted">No clients added to this project</p>
        @endforelse

    </div>
</div>


    </div>
</div>



    </div>
</div>


@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')

<script>




</script>

@endpush
