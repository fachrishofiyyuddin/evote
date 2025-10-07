<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') — E-Voting OSIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>

    <style>
        html,
        body {
            height: 100%;
        }

        .candidate-card {
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .candidate-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.12);
        }

        input[type="radio"] {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #15a34b;
            border-radius: 50%;
            position: relative;
            cursor: pointer;
        }

        input[type="radio"]:checked::before {
            content: "";
            position: absolute;
            top: 3px;
            left: 3px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #15a34b;
        }

        .tab-active {
            background-color: #15a34b;
            color: white;
        }

        .tab-inactive {
            background-color: #f3f4f6;
            /* gray-100 */
            color: #374151;
            /* gray-700 */
        }
    </style>
</head>

<body class="min-h-screen p-6 bg-cover bg-center"
    style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('assets/img/bg-sekolah.jpeg') }}');">
    <div class="w-full max-w-7xl mx-auto pt-16 sm:pt-12 md:pt-8 pb-8">
        @yield('content')
    </div>

    @stack('scripts')
</body>

</html>
