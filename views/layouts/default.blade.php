<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Maets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root{
            --g1: #0f1724;
            --g2: #284b63;
            --g3: #1f6b3a;
        }
        html, body { height: 100%; }
        body {
            margin: 0;
            min-height: 100vh;
            color: #000000;
            background: linear-gradient(270deg, var(--g1), var(--g2), var(--g3));
            background-size: 600% 600%;
            animation: bgShift 12s ease infinite;
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:grayscale;
        }
        @keyframes bgShift {
            0%   { background-position: 0 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0 50%; }
        }
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: linear-gradient(rgba(0,0,0,0.22), rgba(0,0,0,0.16));
            pointer-events: none;
            z-index: 0;
        }

        .app-container { position: relative; z-index: 1; padding-top: 20px; padding-bottom: 40px; }

        .panel {
            background: rgba(255,255,255,0.03);
            border-radius: 10px;
            padding: 18px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.25);
            backdrop-filter: blur(6px);
        }

        .navbar { background: rgba(0,0,0,0.20) !important; z-index: 2; }
        .navbar .navbar-brand { color: #fff !important; font-weight:600; letter-spacing:0.5px; }

        .cards-glass .card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.10);
            backdrop-filter: blur(6px);
            color: #ffffff;
            box-shadow: 0 8px 32px rgba(12,20,30,0.35);
            border-radius: 10px;
            overflow: hidden;
        }
        .cards-glass .card .card-title { color: #fff; font-weight:600; }
        .cards-glass .card .card-text { color: rgba(255,255,255,0.9); }

        .cards-glass .btn-outline-primary { color:#fff; border-color: rgba(255,255,255,0.16); }
        .cards-glass .btn-outline-primary:hover { background: rgba(255,255,255,0.04); color:#fff; }
        .cards-glass .btn-outline-warning { color:#fff; border-color: rgba(255,255,255,0.12); }
        .cards-glass .btn-outline-danger { color:#fff; border-color: rgba(255,255,255,0.10); }

        .cards-glass .form-control {
            background: rgba(255,255,255,0.03);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.06);
        }
        .cards-glass .form-control::placeholder { color: rgba(255,255,255,0.6); }

        .game-card { height: 100%; display: flex; flex-direction: column; }
        .game-card .card-body { display: flex; flex-direction: column; flex: 1 1 auto; }

        .game-cover {
            width: 100%;
            height: 200px;
            max-height: 250px;
            object-fit: cover;
            display: block;
        }

        .game-card .card-body .flex-grow-1 { margin-bottom: 0.8rem; }

        .constrain-large-icon,
        img.constrain-large-icon,
        svg.constrain-large-icon {
            max-width: 64px !important;
            max-height: 64px !important;
            width: auto !important;
            height: auto !important;
            display: inline-block !important;
        }

        svg:not(.game-cover) {
            max-width: 100% !important;
            height: auto !important;
        }

        img:not(.game-cover) {
            max-width: 100%;
            height: auto;
        }

        .pagination { display:flex; gap:6px; justify-content:center; align-items:center; margin-top: 1rem; }
        .pagination .page-link {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.95);
            min-width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            padding: 0 .6rem;
        }
        .pagination .page-item.active .page-link {
            background: rgba(255,255,255,0.18);
            border-color: rgba(255,255,255,0.18);
            color: #0f1724 !important;
            font-weight: 700;
        }
        .pagination .page-link svg { width:16px; height:16px; }

        .btn-outline-secondary { color: #fff; border-color: rgba(255,255,255,0.08); }
        .btn-outline-secondary:hover { color:#fff; background: rgba(255,255,255,0.03); }
        .form-control { background: rgba(255,255,255,0.02); color: #fff; border: 1px solid rgba(255,255,255,0.06); }
        .form-control::placeholder { color: rgba(255,255,255,0.6); }

        @media (max-width: 575px) {
            .game-cover { height: 160px; }
            .pagination .page-link { min-width: 34px; height: 34px; }
        }

        .cards-glass .card .text-muted {
            color: rgba(255,255,255,0.78) !important;
        }

        .cards-glass .card .text-muted.small {
            color: rgba(255,255,255,0.78) !important;
            font-weight: 500;
            letter-spacing: 0.2px;
        }

        .cards-glass .card .card-text {
            color: rgba(255,255,255,0.92) !important;
        }

        .cards-glass .pagination .page-link {
            color: #ffffff !important;
            background: rgba(255,255,255,0.03) !important;
            border: 1px solid rgba(255,255,255,0.06) !important;
            box-shadow: none;
        }

        .cards-glass .pagination .page-link:hover,
        .cards-glass .pagination .page-link:focus {
            background: rgba(255,255,255,0.08) !important;
            color: #ffffff !important;
        }

        .cards-glass .pagination .page-item.active .page-link {
            background: #1f6b3a !important;
            border-color: #1f6b3a !important;
            color: #ffffff !important;
            font-weight: 700;
        }

        .cards-glass .pagination .page-link svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
            color: inherit;
        }

        @media (max-width: 575px) {
            .cards-glass .pagination .page-link {
                min-width: 36px !important;
                height: 36px !important;
                padding: 0 .45rem !important;
            }
            .cards-glass .card .text-muted.small { font-size: 0.82rem; }
        }

        .panel { position: relative;
            padding-bottom: 76px;
        }

        .pagination-wrapper {
            position: absolute;
            right: 18px;
            bottom: 18px;
            z-index: 2;
            display: flex;
            gap: 8px;
            align-items: center;
            justify-content: flex-end;
        }

        .pagination-wrapper .pagination { margin: 0; }

        @media (max-width: 767.98px) {
            .panel { padding-bottom: 18px; }
            .pagination-wrapper {
                position: static;
                width: 100%;
                justify-content: center;
                margin-top: 12px;
            }
        }
        #createModal .modal-content {
            background: rgba(255,255,255,0.96);
            color: #000;
        }

        #createModal .form-control {
            background: #ffffff;
            color: #000000;
            border: 1px solid rgba(0,0,0,0.14);
            box-shadow: none;
        }

        #createModal input[type="file"].form-control {
            color: #000;
        }

        #createModal .form-control::placeholder {
            color: rgba(0,0,0,0.6) !important;
            opacity: 1;
        }

        #createModal .form-control:focus {
            background: #fff;
            color: #000;
            border-color: #000;
            box-shadow: 0 0 0 .12rem rgba(0,0,0,0.08);
            outline: none;
        }

        #createModal .btn-secondary { color: #000; background: #e9ecef; border-color: rgba(0,0,0,0.08); }
        #createModal .btn-success { color: #fff; background: #1f6b3a; border-color: #1f6b3a; }
    </style>
</head>

<body class="cards-glass">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('inicio') }}">Maets</a>
        </div>
    </nav>

    <div class="app-container">
        <div class="container my-4 panel">
            @yield('conteudo')
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
