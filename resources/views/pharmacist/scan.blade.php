@extends('layouts.pharmacist')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Scan Patient Card</h2>
        <video id="camera" autoplay playsinline class="w-full rounded-lg mb-4"></video>

        <button onclick="startCamera()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Start Camera</button>
        <button onclick="stopCamera()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 ml-4">Stop Camera</button>

        <a href="{{ route('dashboard.pharmacist.index') }}" class="block mt-6 text-blue-600 hover:underline">Back to Dashboard</a>
    </div>
</div>

<script>
    let stream;

    async function startCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            const video = document.getElementById('camera');
            video.srcObject = stream;
        } catch (error) {
            alert('Unable to access the camera.');
            console.error(error);
        }
    }

    function stopCamera() {
        if (stream) {
            let tracks = stream.getTracks();
            tracks.forEach(track => track.stop());
        }
    }
</script>
@endsection
