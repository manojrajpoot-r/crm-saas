@extends('saas.layouts.app')
<div class="main-panel">
    <div class="content">
        <h2>Face Login</h2>

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


<script>
let video; // 🔥 GLOBAL variable

document.addEventListener('DOMContentLoaded', function () {

    video = document.getElementById('video');

    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        alert('Camera not supported OR HTTPS required');
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
document.getElementById('captureBtn').addEventListener('click', function () {

    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');

    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    const imageData = canvas.toDataURL('image/png');

    fetch("{{ route('face.store.login') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ image: imageData })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            window.location.href = data.redirect;
        } else {
            alert(data.message || 'Face not matched');
        }
    });
});
</script>



