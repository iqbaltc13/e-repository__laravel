<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'E-Repository UIN Syekh Wasil Kediri') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-info">
        <div class="container">
            @if (Auth::check())
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <img height="80" src="https://iainkediri.ac.id/assets/uploads/setting/bd169c485f8ab3b7a4e723d8fbe8365e.png" srcset="https://iainkediri.ac.id/assets/uploads/setting/bd169c485f8ab3b7a4e723d8fbe8365e.png 2x" class="img-responsive" alt=""> E-Repository UIN Syekh Wasil Kediri
                </a>
            @else
                <a class="navbar-brand" href="{{ route('journals.public') }}">
                    <img height="80" src="https://iainkediri.ac.id/assets/uploads/setting/bd169c485f8ab3b7a4e723d8fbe8365e.png" srcset="https://iainkediri.ac.id/assets/uploads/setting/bd169c485f8ab3b7a4e723d8fbe8365e.png 2x" class="img-responsive" alt=""> E-Repository UIN Syekh Wasil Kediri
                </a>

            @endif



            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav" style="padding-left: 100px;">
                <ul class="navbar-nav me-auto">
                    @if (Auth::check())
                    <li class="nav-item" >
                        <a style="color:whitesmoke !important" class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a style="color:whitesmoke !important" class="nav-link" href="{{ route('journals.index') }}">Jurnal</a>
                    </li>
                    @can('manage-categories')
                    <li class="nav-item">
                        <a style="color:whitesmoke !important" class="nav-link" href="{{ route('journal-categories.index') }}">Kategori</a>
                    </li>
                    @endcan
                    @can('manage-users')
                    <li class="nav-item">
                        <a style="color:whitesmoke !important" class="nav-link" href="{{ route('users.index') }}">Users</a>
                    </li>
                    @endcan
                    @endif
                </ul>

                <ul class="navbar-nav">
                    @if(Auth::check())
                    <li class="nav-item dropdown">

                        <a style="color:whitesmoke !important" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">

                            {{ Auth::user()->full_name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a style="color:whitesmoke !important" class="dropdown-item" href="{{ route('profile.show') }}">Profile</a></li>
                            <li><a style="color:whitesmoke !important" class="dropdown-item" href="{{ route('password.change') }}">
                                <i class="fas fa-key me-1"></i>Change Password
                            </a></li>

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button style="color:whitesmoke !important" type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>


                    </li>
                    @else
                        <li class="nav-item">
                            <a style="color:whitesmoke !important" class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a style="color:whitesmoke !important" class="nav-link" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mt-4">
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
