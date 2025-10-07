<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>QR Token - {{ $kelas }}</title>
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin: 10px 0 5px 0;
        }

        .kelas {
            text-align: center;
            font-size: 13px;
            color: #555;
            margin-bottom: 10px;
        }

        .container {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 15px;
            padding: 0 5mm;
            box-sizing: border-box;
        }

        .card {
            border: 1px dashed #bbb;
            border-radius: 8px;
            width: 22%;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-sizing: border-box;
            page-break-inside: avoid;
            background: #fff;
            padding: 8px;
        }

        .token-text {
            font-size: 11px;
            margin-top: 8px;
            word-break: break-all;
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }

        @media print {
            .card {
                break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <h2>QR TOKEN {{ $kelas }}</h2>
    <div class="kelas">Total: {{ count($tokens) }} Token</div>

    @php $count = 0; @endphp
    <div class="container">
        @foreach ($tokens as $t)
            <div class="card">
                <div id="qr-{{ $loop->index }}" class="qr"></div>
                <div class="token-text">{{ $t->token }}</div>
            </div>

            @php $count++; @endphp
            {{-- 24 QR per halaman (6 baris × 4 kolom) --}}
            @if ($count % 24 == 0)
                </div>
                <div class="page-break"></div>
                <div class="container">
            @endif
        @endforeach
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tokens = @json($tokens->pluck('token'));
            tokens.forEach((token, i) => {
                new QRCode(document.getElementById("qr-" + i), {
                    text: token,
                    width: 130,  // ukuran QR lebih besar
                    height: 130
                });
            });
        });
    </script>
</body>
</html>
