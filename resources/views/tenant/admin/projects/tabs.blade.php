

<h4 class="fw-bold ml-3">
    {{ ucwords($project->name) }}
    <span class="badge bg-success ms-2">{{ $project->status }}</span>
</h4>

<ul class="nav nav-tabs mt-3">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('tenant.projects.show') ? 'active' : '' }}"
           href="{{ route('tenant.projects.show',$project->id) }}">
            Detail
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('tenant.modules.index') ? 'active' : '' }}"
           href="{{ route('tenant.modules.index',['id'=>$project->id]) }}">
            Module
        </a>
    </li>


    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('tenant.tasks.index') ? 'active' : '' }}"
           href="{{ route('tenant.tasks.index',['id'=>$project->id]) }}">
            Task
        </a>
    </li>

     <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('tenant.posts.index') ? 'active' : '' }}"
           href="{{ route('tenant.posts.index',['id'=>$project->id]) }}">

        Discussions
     </a>
    </li>
</ul>
