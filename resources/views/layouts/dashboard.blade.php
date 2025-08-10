<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - KMS KKN')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/utilities.css') }}">
    <style>
        /* ANCHOR: Responsive header controls specific to dashboard layout */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #ffffff;
            font-size: 1.5rem;
            cursor: pointer;
            margin-right: 1rem;
        }
        .header-left { display: flex; align-items: center; }
        @media (max-width: 1024px) {
            .menu-toggle { display: inline-flex; align-items: center; justify-content: center; }
        }
        .sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 150;
            display: none;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Top Header Bar -->
        <header class="header">
            <div class="header-left">
                <button class="menu-toggle" type="button" aria-label="Toggle sidebar" onclick="toggleSidebar()">☰</button>
                <div class="header-brand">KMS KKN</div>
            </div>
            <div class="header-user"></div>
        </header>
        
        <!-- Side Menu -->
        @include('layouts.partials.sidemenu')
        <div id="sidebar-backdrop" class="sidebar-backdrop" onclick="toggleSidebar()"></div>
        
        <!-- Main Content -->
        <main class="main-content">
            <div class="content-wrapper">
                @yield('content')
            </div>
        </main>
    </div>
    <script>
        // ANCHOR: Toggle sidebar for responsive layout
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (!sidebar) return;
            const isOpen = sidebar.classList.toggle('open');
            if (backdrop) {
                const shouldShowBackdrop = isOpen && window.innerWidth <= 1024;
                backdrop.style.display = shouldShowBackdrop ? 'block' : 'none';
                document.body.style.overflow = shouldShowBackdrop ? 'hidden' : '';
            }
        }

        // Close sidebar on resize back to desktop
        window.addEventListener('resize', function () {
            const sidebar = document.querySelector('.sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (window.innerWidth > 1024) {
                sidebar?.classList.remove('open');
                if (backdrop) backdrop.style.display = 'none';
                document.body.style.overflow = '';
            }
        });

        // Close sidebar when a menu link is clicked on mobile
        document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('.sidebar a, .btn-logout-link');
            links.forEach(function (el) {
                el.addEventListener('click', function () {
                    if (window.innerWidth <= 1024) {
                        const sidebar = document.querySelector('.sidebar');
                        const backdrop = document.getElementById('sidebar-backdrop');
                        sidebar?.classList.remove('open');
                        if (backdrop) backdrop.style.display = 'none';
                        document.body.style.overflow = '';
                    }
                });
            });
        });
    </script>
</body>
</html>