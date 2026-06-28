<!DOCTYPE html>
<html lang="id" x-data="{ dark: localStorage.getItem('dark') === 'true' }" :class="{ 'dark': dark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body { transition: background-color 0.3s, color 0.3s; }
        .dark-mode { background-color: #1a1a2e !important; color: #e0e0e0 !important; }
        .dark-mode .navbar { background-color: #16213e !important; }
        .dark-mode .card { background-color: #16213e !important; color: #e0e0e0 !important; border-color: #0f3460 !important; }
        .dark-mode .form-control, .dark-mode .form-select { background-color: #0f3460 !important; color: #e0e0e0 !important; border-color: #1a1a2e !important; }
        .dark-mode .sidebar { background-color: #16213e !important; }
        .dark-mode .list-group-item { background-color: #16213e !important; color: #e0e0e0 !important; border-color: #0f3460 !important; }
        .dark-mode .table { color: #e0e0e0 !important; }
        .dark-mode .modal-content { background-color: #16213e !important; color: #e0e0e0 !important; }
        .sidebar { min-height: calc(100vh - 56px); width: 220px; }
        @media (max-width: 768px) { .sidebar { width: 100%; min-height: auto; } }
    </style>
</head>
<body id="mainBody" class="{{ Cookie::get('dark_mode') === 'true' ? 'dark-mode' : '' }}">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">📒 Digital Notes</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('notes.index') }}"><i class="bi bi-journal-text"></i> Catatan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('notes.trash') }}"><i class="bi bi-trash"></i> Sampah</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <button class="btn btn-link nav-link" onclick="toggleDark()" title="Toggle Dark Mode">
                        <i class="bi bi-moon-stars" id="darkIcon"></i>
                    </button>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3 mx-3" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleDark() {
        const body = document.getElementById('mainBody');
        const isDark = body.classList.toggle('dark-mode');
        document.cookie = 'dark_mode=' + isDark + '; path=/; max-age=31536000';
        document.getElementById('darkIcon').className = isDark ? 'bi bi-sun' : 'bi bi-moon-stars';
    }

    // Set icon on load
    if (document.getElementById('mainBody').classList.contains('dark-mode')) {
        document.getElementById('darkIcon').className = 'bi bi-sun';
    }
</script>
@stack('scripts')
</body>
</html>
