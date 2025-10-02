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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <style>
        .filters-row {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }
        .filter-input {
            width: 100%;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
        .filter-select {
            width: 100%;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
        .table th {
            vertical-align: top;
        }

    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/id.js"></script>

</head>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/68ad13e9fcd547192ddee611/1j3i1bifn';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->
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

                    @endif
                </ul>

                <ul class="navbar-nav">
                    @if(Auth::check())
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
                    <li class="nav-item dropdown">

                        <a style="color:whitesmoke !important" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">

                            {{ Auth::user()->full_name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a style="color:grey !important" class="dropdown-item" href="{{ route('profile.show') }}">Profile</a></li>
                            <li><a style="color:grey !important" class="dropdown-item" href="{{ route('password.change') }}">
                                <i class="fas fa-key me-1"></i>Change Password
                            </a></li>

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button style="color:grey !important" type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>


                    </li>
                    <li class="nav-item">

                    </li>
                    @else
                        <li class="nav-item">
                            <a style="color:whitesmoke !important" class="nav-link" href="{{ route('journals.public') }}">Jurnal</a>
                        </li>
                        <li class="nav-item">
                            <a style="color:whitesmoke !important" class="nav-link" href="{{ route('journals.public.dashboard') }}">Dashboard</a>
                        </li>
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


    <!-- Bootstrap 4 JS Bundle (includes Popper) -->
    <!--Start of Tawk.to Script-->

<!--End of Tawk.to Script-->
    @stack('scripts')

</body>
</html>
