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
    <div class="alert alert-success bg-dark alert-dismissible fade show position-fixed bottom-0 end-0 m-4 shadow-lg" role="alert" style="z-index: 1050;">
        <div class="alert-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
              viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon icon-2">
              <path d="M5 12l5 5l10 -10" />
            </svg>
        </div>
        <div>
            <h4 class="alert-heading">Berhasil!</h4>
            <div class="alert-description">
                {{ session('success') }}
            </div>
        </div>
    </div>
    @endif

    {{-- Alert error --}}
    @if(session('error'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3 z-50">
        <div class="toast show align-items-center text-white bg-danger border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
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
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
</body>
</html>
