<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <!-- Top Header Bar -->
        <header class="header">
            <div class="header-brand">KMS KKN</div>
            <div class="header-user"></div>
        </header>
        
        <!-- Side Menu -->
        @include('layouts.partials.sidemenu')
        
        <!-- Main Content -->
        <main class="main-content">
            <div class="content-wrapper">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>