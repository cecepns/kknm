<aside class="sidebar">
    <div class="sidebar-header">
        <h3>Admin Panel</h3>
    </div>
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="icon-home"></i>Home
            </a>
        </li>
        <li>
            <a href="{{ route('daftar.pengguna.internal') }}">
                <i class="icon-users"></i>Kelola Pengguna Internal
            </a>
        </li>
        <li class="{{ request()->is('roles') ? 'active' : '' }}">
            <a href="#">
                <i class="icon-shield"></i>Kelola Role
            </a>
        </li>
        <li class="{{ request()->is('announcements') ? 'active' : '' }}">
            <a href="#">
                <i class="icon-flag"></i>Kelola Pengumuman
            </a>
        </li>
        <li class="{{ request()->is('announcement-access') ? 'active' : '' }}">
            <a href="#">
                <i class="icon-info"></i>Akses Pengumuman
            </a>
        </li>
        <li class="{{ request()->is('faq') ? 'active' : '' }}">
            <a href="{{ route('daftar.kelola.faq') }}">
                <i class="icon-question"></i>Kelola FAQ
            </a>
        </li>
        <li class="{{ request()->is('faq-access') ? 'active' : '' }}">
            <a href="#">
                <i class="icon-faq"></i>Akses FAQ
            </a>
        </li>
        <li class="{{ request()->is('knowledge') ? 'active' : '' }}">
            <a href="#">
                <i class="icon-bookmark"></i>Klasifikasi Pengetahuan
            </a>
        </li>
        <li class="{{ request()->is('repository') ? 'active' : '' }}">
            <a href="#">
                <i class="icon-folder"></i>Kelola Repositori
            </a>
        </li>
        <li class="{{ request()->is('public-repository') ? 'active' : '' }}">
            <a href="#">
                <i class="icon-globe"></i>Repositori Publik
            </a>
        </li>
        <li class="{{ request()->is('forum-category') ? 'active' : '' }}">
            <a href="#">
                <i class="icon-hash"></i>Kelola Kategori Forum
            </a>
        </li>
        <li class="{{ request()->is('forum') ? 'active' : '' }}">
            <a href="#">
                <i class="icon-chat"></i>Forum Diskusi
            </a>
        </li>
        <li class="{{ request()->is('forum-management') ? 'active' : '' }}">
            <a href="#">
                <i class="icon-group"></i>Kelola Forum Diskusi
            </a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout-link">
                    <i class="icon-logout"></i>Logout
                </button>
            </form>
        </li>
    </ul>
</aside>