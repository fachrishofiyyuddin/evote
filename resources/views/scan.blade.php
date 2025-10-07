@extends('layouts.app')

@section('title', 'Scan QR Code')

@section('content')
    <div class="w-full max-w-md mx-auto pt-16 sm:pt-12 md:pt-8 px-4">
        <div class="bg-white/90 backdrop-blur-md shadow-xl rounded-2xl p-8 text-center border-t-8"
            style="border-color:#15a34b">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('assets/img/logo-sekolah.png') }}" alt="Logo Sekolah" class="w-20 h-20 object-contain">
            </div>
            <h1 class="text-2xl font-bold" style="color:#15a34b">E-Voting OSIS</h1>
            <p class="text-slate-600 mb-6">Silakan scan QR Code untuk memulai proses pemilihan</p>
            <div id="reader" class="w-full border-2 border-dashed rounded-lg shadow-inner" style="border-color:#15a34b">
            </div>
            <p class="mt-4 text-sm text-slate-500">Arahkan kamera Anda ke QR Code yang diberikan panitia</p>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
    function onScanSuccess(decodedText) {
        let url = decodedText;

        // Jika decodedText bukan URL lengkap (http/https) dan belum ada "vote/" di depan, tambahkan
        if (!/^https?:\/\//i.test(decodedText) && !decodedText.startsWith('vote/')) {
            url = '/vote/' + decodedText;
        }

        window.location.href = url;
    }

    let scanner = new Html5QrcodeScanner("reader", {
        fps: 10,
        qrbox: 250
    });

    scanner.render(onScanSuccess);
</script>

@endpush
