@extends('tenant.layouts.tenant_master')

@section('content')

<div class="card p-5">

    <h4>Daily Report</h4>

    <p><strong class="badge bg-success">User:</strong> {{ $report->user->name }}</p>

    <p>
        <strong>Date:</strong>
        {{ format_date($report->report_date)}}
    </p>
 @php
    $status = strtolower($report->status ?? 'draft');

    $statusMap = [
        'draft'     => 'secondary',
        'submitted' => 'warning',
        'approved'  => 'success',
        'rejected'  => 'danger'
    ];
@endphp
<p>
        <strong>Status:</strong>
        <span class="badge bg-{{ $statusMap[$status] ?? 'secondary' }}">
            {{ ucfirst($status) }}
        </span>
</p>
    <hr>

    <p><strong class="badge bg-success">Approved By:</strong> {{ $report->approvedByUser->name ?? '' }}</p>
    <p><strong class="badge bg-success">Approved At:</strong> {{ format_date_time($report->approved_at) }}</p>



    <hr>

    <h5>Projects</h5>

    @foreach($report->projects as $p)
        <div class="border rounded p-3 mb-3">

            <p>
                <strong>Project:</strong>
                {{ $p->project->name ?? 'Other' }}
            </p>

            <p>
                <strong>Hours:</strong>
                {{ $p->hours }}
            </p>

            <p><strong>Description:</strong></p>
            <div>{!! $p->description !!}</div>

            @if($p->admin_comment)
                <div class="mt-2">
                    <strong>Admin Comment:</strong>
                    <div class="text-danger">{{ $p->admin_comment }}</div>
                </div>
            @endif

        </div>
    @endforeach
     <hr>
 <div class="border rounded p-3 mb-3">
   <p>
        <strong>Remark:</strong>
        <span class="badge bg-primary">{{ ucwords($report->admin_comment ?? '') }}</span>
    </p>

 </div>
    <hr>

    <h6>Documents</h6>

    @if($report->documents->count())
        <ul>
            @foreach($report->documents as $doc)
                <li>
                    <a href="{{ asset('uploads/reports/documents/'.$doc->file_path) }}" target="_blank">
                        {{ $doc->file_path ?? 'View File' }}
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-muted">No documents uploaded</p>
    @endif

</div>

@endsection
