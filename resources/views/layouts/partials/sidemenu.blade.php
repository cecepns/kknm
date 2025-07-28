<aside class="sidebar">
    <div class="sidebar-header">
        <h3>{{ auth()->user()->role->name ?? 'User Panel' }}</h3>
    </div>
    <ul class="sidebar-menu">
        <!-- Dashboard - Semua role bisa akses -->
        <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}">
                Dashboard
            </a>
        </li>

        <!-- Menu untuk Admin -->
        @permission('kelola-pengguna-internal')
        <li class="{{ request()->is('kelola-pengguna-internal*') ? 'active' : '' }}">
            <a href="{{ route('daftar.pengguna.internal') }}">
                Kelola Pengguna Internal
            </a>
        </li>
        @endpermission

        <!-- Menu untuk Admin dan Koordinator KKN -->
        @permission('kelola-pengumuman')
        <li class="{{ request()->is('kelola-pengumuman*') ? 'active' : '' }}">
            <a href="{{ route('daftar.kelola.pengumuman') }}">
                Kelola Pengumuman
            </a>
        </li>
        @endpermission

        <!-- Menu untuk semua role -->
        @permission('akses-pengumuman')
        <li class="{{ request()->is('akses-pengumuman*') ? 'active' : '' }}">
            <a href="{{ route('akses.pengumuman') }}">
                Akses Pengumuman
            </a>
        </li>
        @endpermission

        <!-- Menu untuk Admin -->
        @permission('kelola-faq')
        <li class="{{ request()->is('kelola-faq*') ? 'active' : '' }}">
            <a href="{{ route('daftar.kelola.faq') }}">
                Kelola FAQ
            </a>
        </li>
        @endpermission

        <!-- Menu untuk semua role -->
        @permission('akses-faq')
        <li class="{{ request()->is('akses-faq') ? 'active' : '' }}">
            <a href="{{ route('akses.faq') }}">
                Akses FAQ
            </a>
        </li>
        @endpermission

        <!-- Menu untuk Koordinator KKN -->
        @permission('kelola-repositori')
        <li class="{{ request()->is('kelola-repositori*') ? 'active' : '' }}">
            <a href="{{ route('kelola.repositori') }}">
                Kelola Repositori
            </a>
        </li>
        @endpermission

        <!-- Menu untuk semua role -->
        @permission('repositori-publik')
        <li class="{{ request()->is('repositori-publik*') ? 'active' : '' }}">
            <a href="{{ route('repositori.publik') }}">
                Repositori Publik
            </a>
        </li>
        @endpermission

        <!-- Menu untuk Admin -->
        @permission('kelola-kategori-forum')
        <li class="{{ request()->is('kelola-kategori-forum*') ? 'active' : '' }}">
            <a href="{{ route('daftar.kelola.kategori.forum') }}">
                Kelola Kategori Forum
            </a>
        </li>
        @endpermission

        <!-- Menu untuk semua role -->
        @permission('forum-diskusi')
        <li class="{{ request()->is('forum-diskusi*') ? 'active' : '' }}">
            <a href="{{ route('forum.diskusi') }}">
                Forum Diskusi
            </a>
        </li>
        @endpermission

        <!-- Menu untuk Kepala PPM dan Koordinator KKN -->
        @permission('monitoring-aktifitas')
        <li class="{{ request()->is('monitoring-aktifitas*') ? 'active' : '' }}">
            <a href="{{ route('monitoring.aktifitas') }}">
                Monitoring Aktifitas
            </a>
        </li>
        @endpermission

        <!-- Menu untuk Kepala PPM -->
        @permission('validasi-pengetahuan')
        <li class="{{ request()->is('validasi-pengetahuan*') ? 'active' : '' }}">
            <a href="{{ route('validasi.pengetahuan') }}">
                Validasi Pengetahuan
            </a>
        </li>
        @endpermission

        <!-- Menu untuk Koordinator KKN -->
        @permission('verifikasi-pengetahuan')
        <li class="{{ request()->is('verifikasi-pengetahuan*') ? 'active' : '' }}">
            <a href="{{ route('verifikasi.pengetahuan') }}">
                Verifikasi Pengetahuan
            </a>
        </li>
        @endpermission

        <!-- Menu untuk Mahasiswa KKN dan Dosen Pembimbing -->
        @permission('unggah-pengetahuan')
        <li class="{{ request()->is('unggah-pengetahuan*') ? 'active' : '' }}">
            <a href="{{ route('unggah.pengetahuan') }}">
                Unggah Pengetahuan
            </a>
        </li>
        @endpermission

        <!-- Logout - Semua role bisa akses -->
        <li>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout-link">
                    Logout
                </button>
            </form>
        </li>
    </ul>
</aside>
