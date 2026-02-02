<h4 class="fw-bold ml-3">
    {{ ucwords($project->name) }}
    <span class="badge bg-success ms-2">{{ $project->status }}</span>
</h4>

@php
    $encode_id = base64_encode($project->id);
@endphp

<ul class="nav nav-tabs mt-3">

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('tenant.projects.show') ? 'active' : '' }}"
           href="{{ tenantRoute('projects.show', null, $encode_id) }}">
            Detail
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('tenant.modules.index') ? 'active' : '' }}"
           href="{{ tenantRoute('modules.index', null, $encode_id) }}">
            Module
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('tenant.tasks.index') ? 'active' : '' }}"
           href="{{ tenantRoute('tasks.index', null, $encode_id) }}">
            Task
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('tenant.posts.index') ? 'active' : '' }}"
           href="{{ tenantRoute('posts.index', null, $encode_id) }}">
            Discussions
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('tenant.teams.index') ? 'active' : '' }}"
           href="{{ tenantRoute('teams.index', null, $encode_id) }}">
            Team Member
        </a>
    </li>

</ul>
