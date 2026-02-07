@extends('tenant.layouts.tenant_master')

@section('content')

                <div class="card" style="padding: 50px;">
                    <h4>{{ $report->title }}</h4>

                    <p>
                        <strong>User:</strong> {{ $report->user->name }}
                    </p>

                    <p>
                        <strong>Project:</strong> {{ $report->project->name ?? 'Other' }}
                    </p>

                    <p>
                        <strong>Date:</strong> {{ \Carbon\Carbon::parse($report->report_date)->format('d M Y') }}
                    </p>

                    <hr>

                    <h6>Description</h6>
                    <p>{!! $report->description !!}</p>

                    <hr>

                    <h6>Documents</h6>
                    @if($report->documents->count())
                        <ul>
                            @foreach($report->documents as $doc)
                                <li>
                                    <a href="{{ asset($doc->path) }}" target="_blank">
                                        {{ $doc->original_name ?? 'View File' }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No documents uploaded</p>
                    @endif
                </div>


@endsection
