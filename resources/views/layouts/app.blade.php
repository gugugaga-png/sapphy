<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" rel="stylesheet"/>

    <!-- Styles & Scripts (via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 font-sans antialiased">
    {{-- Alert sukses --}}
    @if(session('success'))
<div class="alert alert-success alert-dismissible fade show position-fixed bottom-0 end-0 m-4 shadow-sm px-3 py-2 small d-flex align-items-center gap-2" role="alert" style="z-index: 1050; min-width: 250px;">
    <i class="bi bi-check-circle-fill fs-5"></i>
    <div>
        <strong>Berhasil!</strong><br>
        {{ session('success') }}
        <div class="progress mt-2" style="height: 3px;">
            <div class="progress-bar bg-white progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%;" id="success-progress"></div>
        </div>
    </div>
    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show position-fixed bottom-0 end-0 m-4 shadow-sm px-3 py-2 small d-flex align-items-center gap-2" role="alert" style="z-index: 1050; min-width: 250px;">
    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
    <div>
        <strong>Gagal!</strong><br>
        {{ session('error') }}
        <div class="progress mt-2" style="height: 3px;">
            <div class="progress-bar bg-white progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%;" id="error-progress"></div>
        </div>
    </div>
    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


    <div id="app">
        <div class="page">
            {{-- Sidebar khusus admin, hanya tampil di layar md ke atas --}}


            {{-- Page wrapper --}}
            <div class="page-wrapper">
                {{-- Header --}}
                @include('layouts.nav')

                {{-- Page content --}}
                <div class="page-body">
                    <div class="container-xl">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quill JS jika digunakan --}}
    <script>
        function toggleAnswerForm() {
            const form = document.getElementById('answerForm');
            form.classList.toggle('d-none');
        }

        function hideAnswerForm() {
            const form = document.getElementById('answerForm');
            form.classList.add('d-none');
        }

        setTimeout(function () {
            const alertEl = document.querySelector('.alert');
            if (alertEl) {
                alertEl.classList.remove('show');
                alertEl.classList.add('fade');
                setTimeout(() => alertEl.remove(), 500);
            }
        }, 5000);

         function animateProgressBar(id) {
        const progressBar = document.getElementById(id);
        let width = 100;
        const interval = setInterval(() => {
            width -= 2;
            if (width <= 0) {
                clearInterval(interval);
                const alertEl = progressBar.closest('.alert');
                if (alertEl) {
                    alertEl.classList.remove('show');
                    alertEl.classList.add('fade');
                    setTimeout(() => alertEl.remove(), 500);
                }
            } else {
                progressBar.style.width = width + "%";
            }
        }, 100); // 2% setiap 100ms → 5 detik
    }

    window.onload = function () {
        if (document.getElementById('success-progress')) {
            animateProgressBar('success-progress');
        }
        if (document.getElementById('error-progress')) {
            animateProgressBar('error-progress');
        }
    };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
</body>
</html>
