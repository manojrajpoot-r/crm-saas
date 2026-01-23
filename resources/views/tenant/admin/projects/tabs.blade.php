

<h4 class="fw-bold ml-3">
    {{ ucwords($project->name) }}
    <span class="badge bg-success ms-2">{{ $project->status }}</span>
</h4>
@php
    $encode_id =base64_encode($project->id);
@endphp
<ul class="nav nav-tabs mt-3">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('projects.show') ? 'active' : '' }}"
           href="{{ tenantRoute('projects.show', $encode_id) }}">
            Detail
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('modules.index') ? 'active' : '' }}"
           href="{{ tenantRoute('modules.index',['id'=> $encode_id]) }}">
            Module
        </a>
    </li>


    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}"
           href="{{ tenantRoute('tasks.index',['id'=> $encode_id]) }}">
            Task
        </a>
    </li>

     <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('posts.index') ? 'active' : '' }}"
           href="{{ tenantRoute('posts.index',['id'=> $encode_id]) }}">
        Discussions
     </a>
    </li>

     <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('teams.index') ? 'active' : '' }}"
           href="{{ tenantRoute('teams.index',['id'=> $encode_id]) }}">
        Team Member
     </a>
    </li>
</ul>
