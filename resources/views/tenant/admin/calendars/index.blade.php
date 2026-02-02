
@extends('tenant.layouts.tenant_master')

@section('content')

<div class="main-panel">
    <div class="content">



<div id="calendar"></div>

{{-- Modal --}}
<div class="modal fade" id="eventModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="eventTitle"></h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="eventBody"></div>
        </div>
    </div>
</div>
@endsection


<script>
document.addEventListener('DOMContentLoaded', function () {

    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 650,

        events: @json($events),

        eventClick: function(info) {
            document.getElementById('eventTitle').innerText = info.event.title;

            document.getElementById('eventBody').innerHTML = `
                <p><strong>Start:</strong> ${info.event.start.toDateString()}</p>
                ${info.event.end ? `<p><strong>End:</strong> ${info.event.end.toDateString()}</p>` : ''}
            `;

            new bootstrap.Modal(document.getElementById('eventModal')).show();
        }
    });

    calendar.render();
});
</script>






