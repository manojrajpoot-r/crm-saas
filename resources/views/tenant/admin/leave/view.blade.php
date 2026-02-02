<div class="row">


     <div class="col-md-12 mt-2">
        <strong>Created Date:</strong>
        <p>{{ format_date($leave->created_at) }}</p>
     </div>
    <div class="col-md-6">
        <strong>Employee:</strong> {{ ucwords($leave->user->name) }}
    </div>

    <div class="col-md-6">
        <strong>Leave Type:</strong>
         <span class="badge" style="background:{{ $leave->leaveType->color }}">
            {{ $leave->leaveType->name }}
        </span>
    </div>

    <div class="col-md-6 mt-2">
        <strong>Dates:</strong>
        {{ format_date($leave->start_date) }} to {{ format_date($leave->end_date) }}
    </div>

    <div class="col-md-6 mt-2">
        <strong>Status:</strong>
       <span class="badge bg-{{$leave->status == 'approved' ? 'success' :($leave->status == 'rejected' ? 'danger' : 'warning')}}">
                {{ ucfirst($leave->status) }}
        </span>
    </div>

    <div class="col-md-6 mt-2">
        <strong>Approved By:</strong>
        <span class="badge bg-info"> <img src="{{ $leave->approvedByUser?->profile_url ?? asset('images/default-profile.png') }}"
                class="rounded-circle me-2" width="35" height="35">
            <span>{{ $leave->approvedByUser?->name ?? '-' }}</span></span><span>{{format_date_time($leave->approved_at)}}</span>
    </div>

    <div class="col-md-12 mt-2">
        <strong>Reason:</strong>
        <p>{!!$leave->reason !!}</p>
    </div>


     <div class="col-md-12 mt-2">
        <strong>Remark:</strong>
        <p>{!! $leave->remark !!}</p>
    </div>


</div>
