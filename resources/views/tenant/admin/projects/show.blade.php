@extends('tenant.layouts.tenant_master')

@section('content')

<div class="main-panel">
    <div class="content">


        @include('tenant.admin.projects.tabs',['id'=>$project->id])

            <div class="tab-content mt-4">
                <div class="tab-pane fade show active" id="detail">

                    <div class="row">
                        <!-- LEFT -->
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6>Description</h6>
                                     <p>{{ $project->description ?? '-' }}</p>
                                </div>
                            </div>

                            {{-- Uploaded Files --}}
                            <div class="card">
                                <div class="card-body">
                                    <h6>Uploaded files</h6>

                                    @forelse($project->documents as $doc)
                                        @php
                                           $ext = strtolower(pathinfo($doc->file, PATHINFO_EXTENSION));

                                            $icon = match ($ext) {
                                                'pdf' =>  asset('assets/img/icons/pdf.png'),
                                                'doc', 'docx' =>  asset('assets/img/icons/word.png'),
                                                'xls', 'xlsx' =>  asset('assets/img/icons/excel.png'),
                                                'zip', 'rar' =>  asset('assets/img/icons/zip.png'),
                                                default => asset('assets/img/icons/file.png')
                                            };

                                                $filePath = 'uploads/projects/documents/'.$doc->file;
                                                $viewUrl = asset($filePath);


                                                $users = $project->creators();
                                                      if ($users->isEmpty()) {
                                                            return '-';
                                                        }

                                                $creators = $users->pluck('name')->implode(', ');
                                        @endphp
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <img src="{{$icon }}" width="24">
                                            <a href="{{ $viewUrl }}"
                                            target="_blank">
                                            {{ $doc->file }}
                                            <span style="color:chocolate">{{$creators ?? '-'}}</span>
                                            <span>{{$project->created_at->format('d, M Y') ?? '-'}}</span>
                                            </a>
                                        </div>
                                    @empty
                                        <p class="text-muted">No files uploaded</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                            <!-- RIGHT -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Project details</h6>

                                        <table class="table table-sm">
                                            <tr>
                                                <th>Created by:</th>

                                                <td style="color:chocolate">{{ $creators ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status:</th>
                                                <td>{{ $project->status }}</td>
                                            </tr>
                                            <tr>
                                                <th>Type:</th>
                                                <td>{{ $project->type }}</td>
                                            </tr>
                                            <tr>
                                                <th>Created at:</th>
                                                <td>{{ $project->created_at->format('d, M Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Actual start:</th>
                                                <td>{{ $project->actual_start_date->format('d, M Y') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
    </div>
</div>


@endsection

@push('scripts')

@endpush

