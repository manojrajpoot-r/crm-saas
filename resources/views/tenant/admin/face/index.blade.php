{{-- @extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
        <h2>Face Registration</h2>

        <video id="video" width="400" autoplay></video>
        <br><br>
        <button type="button" id="captureBtn">Capture Face</button>

        <canvas id="canvas" width="400" height="300" style="display:none;"></canvas>

        <form id="faceForm">
            @csrf
            <input type="hidden" name="image" id="image">
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
    // Open camera on page load
   document.addEventListener('DOMContentLoaded', function () {

    const video = document.getElementById('video');

    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        alert('Camera not supported OR site not secure (HTTPS required)');
        return;
    }

    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            video.srcObject = stream;
            video.play();
        })
        .catch(err => {
            console.error(err);
            alert('Camera permission denied');
        });

});
    // Capture button
    document.getElementById('captureBtn').addEventListener('click', function() {
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');

        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const imageData = canvas.toDataURL('image/png');
        document.getElementById('image').value = imageData;

        fetch("{{ route('face.store') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ image: imageData })
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success'){
                alert(data.message);
            } else {
                alert(data.error || "Something went wrong");
            }
        })
        .catch(err => {
            console.error(err);
            alert("Error uploading image");
        });
    });
</script>
@endpush --}}
