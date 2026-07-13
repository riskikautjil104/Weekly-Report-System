@extends('layouts.app')

@section('content')
    @php
        $selectedDate = old('tanggal', $defaultDate);
        $selectedJamMulai = old('jam_mulai', '');
        $selectedJamSelesai = old('jam_selesai', '');
        $selectedAlasan = old('alasan', '');
    @endphp

    <div class="space-y-6">
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">Overtime</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Input Lembur</h2>
                <p class="mt-2 max-w-2xl text-sm text-on-surface-variant">{{ $pageLead }}</p>
            </div>

            <a href="{{ route('overtime.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-on-surface transition hover:bg-surface-container">
                <span class="material-symbols-outlined text-[20px]">list</span>
                Daftar Lembur
            </a>
        </section>

        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="overtime-form" action="{{ route('overtime.store') }}" method="POST" class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
            @csrf

            <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm space-y-5">
                <h3 class="text-lg font-semibold text-on-surface">Data Lembur</h3>

                <div class="grid gap-5 md:grid-cols-2">
                    <label class="space-y-2">
                        <span class="text-sm font-semibold text-on-surface">Tanggal <span class="text-error">*</span></span>
                        <input type="date" name="tanggal" value="{{ $selectedDate }}" max="{{ now()->toDateString() }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                    </label>

                    <div></div>

                    <label class="space-y-2">
                        <span class="text-sm font-semibold text-on-surface">Jam Mulai <span class="text-error">*</span></span>
                        <input type="time" name="jam_mulai" value="{{ $selectedJamMulai }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                    </label>

                    <label class="space-y-2">
                        <span class="text-sm font-semibold text-on-surface">Jam Selesai <span class="text-error">*</span></span>
                        <input type="time" name="jam_selesai" value="{{ $selectedJamSelesai }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                    </label>
                </div>

                <label class="block space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Alasan Lembur <span class="text-error">*</span></span>
                    <textarea name="alasan" rows="4" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" placeholder="Jelaskan pekerjaan yang dilakukan saat lembur..." required>{{ $selectedAlasan }}</textarea>
                </label>

                <input type="hidden" name="image_hash" id="image_hash" value="{{ old('image_hash') }}">
                <input type="hidden" name="image_width" id="image_width" value="{{ old('image_width') }}">
                <input type="hidden" name="image_height" id="image_height" value="{{ old('image_height') }}">
                <input type="hidden" name="file_size_bytes" id="file_size_bytes" value="{{ old('file_size_bytes') }}">
                <input type="hidden" name="camera_facing" id="camera_facing" value="{{ old('camera_facing', 'unknown') }}">
                <input type="hidden" name="geo_latitude" id="geo_latitude" value="{{ old('geo_latitude') }}">
                <input type="hidden" name="geo_longitude" id="geo_longitude" value="{{ old('geo_longitude') }}">
                <input type="hidden" name="geo_accuracy" id="geo_accuracy" value="{{ old('geo_accuracy') }}">
                <input type="hidden" name="device_user_agent" id="device_user_agent" value="{{ old('device_user_agent', request()->userAgent()) }}">

                <button type="submit" id="submit-btn" disabled class="inline-flex items-center gap-2 rounded-xl bg-primary px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-50">
                    <span class="material-symbols-outlined text-[20px]">send</span>
                    Kirim Laporan Lembur
                </button>
            </section>

            <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-on-surface">Foto Bukti</h3>
                    <span class="text-xs font-semibold text-error">Wajib</span>
                </div>

                <p class="text-sm text-on-surface-variant">
                    Ambil foto langsung dari kamera. Gambar tidak disimpan di server — hanya metadata bukti (termasuk lokasi GPS jika diizinkan) yang dicatat.
                </p>

                <div id="camera-error" class="hidden rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800"></div>

                <div id="camera-section">
                    <div id="camera-preview-wrap" class="relative overflow-hidden rounded-xl border border-outline-variant bg-black aspect-[4/3]">
                        <video id="camera-preview" autoplay playsinline muted class="h-full w-full object-cover"></video>
                        <canvas id="capture-canvas" class="hidden"></canvas>
                    </div>

                    <div id="capture-preview-wrap" class="hidden space-y-3">
                        <img id="capture-preview" alt="Preview bukti" class="w-full rounded-xl border border-outline-variant aspect-[4/3] object-cover">
                        <p id="capture-info" class="text-xs text-on-surface-variant"></p>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-3">
                        <button type="button" id="btn-open-camera" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-on-surface transition hover:bg-surface-container">
                            <span class="material-symbols-outlined text-[20px]">photo_camera</span>
                            Buka Kamera
                        </button>
                        <button type="button" id="btn-capture" disabled class="inline-flex items-center gap-2 rounded-xl bg-secondary px-4 py-3 text-sm font-semibold text-white transition hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-50">
                            <span class="material-symbols-outlined text-[20px]">camera</span>
                            Ambil Foto
                        </button>
                        <button type="button" id="btn-retake" class="hidden inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-on-surface transition hover:bg-surface-container">
                            <span class="material-symbols-outlined text-[20px]">refresh</span>
                            Ulangi Foto
                        </button>
                    </div>
                </div>

                <div id="capture-success" class="hidden rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    <div class="flex items-center gap-2 font-semibold">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        Foto bukti berhasil diambil
                    </div>
                    <p class="mt-1 text-xs">Metadata tersimpan. Gambar tidak di-upload ke server.</p>
                </div>
            </section>
        </form>
    </div>

    <script>
        (function () {
            const video = document.getElementById('camera-preview');
            const canvas = document.getElementById('capture-canvas');
            const previewWrap = document.getElementById('camera-preview-wrap');
            const capturePreviewWrap = document.getElementById('capture-preview-wrap');
            const capturePreview = document.getElementById('capture-preview');
            const captureInfo = document.getElementById('capture-info');
            const cameraError = document.getElementById('camera-error');
            const captureSuccess = document.getElementById('capture-success');
            const submitBtn = document.getElementById('submit-btn');

            const btnOpenCamera = document.getElementById('btn-open-camera');
            const btnCapture = document.getElementById('btn-capture');
            const btnRetake = document.getElementById('btn-retake');

            const fields = {
                image_hash: document.getElementById('image_hash'),
                image_width: document.getElementById('image_width'),
                image_height: document.getElementById('image_height'),
                file_size_bytes: document.getElementById('file_size_bytes'),
                camera_facing: document.getElementById('camera_facing'),
                geo_latitude: document.getElementById('geo_latitude'),
                geo_longitude: document.getElementById('geo_longitude'),
                geo_accuracy: document.getElementById('geo_accuracy'),
                device_user_agent: document.getElementById('device_user_agent'),
            };

            let stream = null;
            let facingMode = 'environment';
            let captured = false;

            fields.device_user_agent.value = navigator.userAgent.substring(0, 500);

            function showError(message) {
                cameraError.textContent = message;
                cameraError.classList.remove('hidden');
            }

            function hideError() {
                cameraError.classList.add('hidden');
            }

            async function stopCamera() {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                }
            }

            async function openCamera() {
                hideError();
                await stopCamera();

                try {
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: facingMode, width: { ideal: 1280 }, height: { ideal: 720 } },
                        audio: false,
                    });

                    video.srcObject = stream;
                    btnCapture.disabled = false;
                    previewWrap.classList.remove('hidden');
                    capturePreviewWrap.classList.add('hidden');
                    btnRetake.classList.add('hidden');
                    btnOpenCamera.textContent = 'Kamera Aktif';
                } catch (err) {
                    if (facingMode === 'environment') {
                        facingMode = 'user';
                        return openCamera();
                    }
                    showError('Tidak bisa mengakses kamera. Pastikan izin kamera diaktifkan di browser.');
                }
            }

            async function getLocation() {
                if (!navigator.geolocation) return null;

                return new Promise((resolve) => {
                    navigator.geolocation.getCurrentPosition(
                        (pos) => resolve({
                            lat: pos.coords.latitude,
                            lng: pos.coords.longitude,
                            accuracy: pos.coords.accuracy,
                        }),
                        () => resolve(null),
                        { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                    );
                });
            }

            async function hashBlob(blob) {
                const buffer = await blob.arrayBuffer();
                const hashBuffer = await crypto.subtle.digest('SHA-256', buffer);
                const hashArray = Array.from(new Uint8Array(hashBuffer));
                return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
            }

            async function capturePhoto() {
                if (!stream) return;

                const width = video.videoWidth;
                const height = video.videoHeight;

                canvas.width = width;
                canvas.height = height;
                canvas.getContext('2d').drawImage(video, 0, 0, width, height);

                const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', 0.85));
                if (!blob) {
                    showError('Gagal mengambil foto. Coba lagi.');
                    return;
                }

                const hash = await hashBlob(blob);
                const location = await getLocation();
                const objectUrl = URL.createObjectURL(blob);

                fields.image_hash.value = hash;
                fields.image_width.value = width;
                fields.image_height.value = height;
                fields.file_size_bytes.value = blob.size;
                fields.camera_facing.value = facingMode;

                if (location) {
                    fields.geo_latitude.value = location.lat;
                    fields.geo_longitude.value = location.lng;
                    fields.geo_accuracy.value = location.accuracy;
                } else {
                    fields.geo_latitude.value = '';
                    fields.geo_longitude.value = '';
                    fields.geo_accuracy.value = '';
                }

                capturePreview.src = objectUrl;
                let infoText = `${width}×${height}px · ${(blob.size / 1024).toFixed(1)} KB · Hash: ${hash.substring(0, 12)}...`;
                if (location) {
                    infoText += ` · Lokasi: ${location.lat.toFixed(5)}, ${location.lng.toFixed(5)}`;
                } else {
                    infoText += ' · Lokasi: tidak tersedia';
                }
                captureInfo.textContent = infoText;

                await stopCamera();

                previewWrap.classList.add('hidden');
                capturePreviewWrap.classList.remove('hidden');
                btnRetake.classList.remove('hidden');
                btnCapture.disabled = true;
                captureSuccess.classList.remove('hidden');
                submitBtn.disabled = false;
                captured = true;

                setTimeout(() => URL.revokeObjectURL(objectUrl), 5000);
            }

            async function retakePhoto() {
                captured = false;
                fields.image_hash.value = '';
                fields.image_width.value = '';
                fields.image_height.value = '';
                fields.file_size_bytes.value = '';
                fields.geo_latitude.value = '';
                fields.geo_longitude.value = '';
                fields.geo_accuracy.value = '';
                captureSuccess.classList.add('hidden');
                submitBtn.disabled = true;
                capturePreview.src = '';
                await openCamera();
            }

            btnOpenCamera.addEventListener('click', openCamera);
            btnCapture.addEventListener('click', capturePhoto);
            btnRetake.addEventListener('click', retakePhoto);

            document.getElementById('overtime-form').addEventListener('submit', function (e) {
                if (!captured || !fields.image_hash.value) {
                    e.preventDefault();
                    showError('Foto bukti wajib diambil dari kamera sebelum submit.');
                }
            });

            if (fields.image_hash.value) {
                captured = true;
                submitBtn.disabled = false;
                captureSuccess.classList.remove('hidden');
            }

            window.addEventListener('beforeunload', stopCamera);
        })();
    </script>
@endsection
