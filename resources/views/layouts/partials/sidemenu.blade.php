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

        <!-- Menu untuk Admin -->
        @permission('kelola-kategori-pengetahuan')
        <li class="{{ request()->is('kelola-kategori-pengetahuan*') ? 'active' : '' }}">
            <a href="{{ route('kelola.kategori.pengetahuan.index') }}">
                Kelola Kategori Pengetahuan
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
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;" id="logout-form">
                @csrf
                <button type="button" class="btn-logout-link" onclick="showLogoutModal()">
                    Logout
                </button>
            </form>
        </li>
    </ul>
</aside>

<!-- ANCHOR: Logout Confirmation Modal -->
<div id="logout-modal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Konfirmasi Logout</h3>
            <button type="button" class="modal-close" onclick="hideLogoutModal()">×</button>
        </div>
        <div class="modal-body">
            <p class="modal-subtitle">Apakah Anda yakin ingin keluar dari sistem?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="hideLogoutModal()">Batal</button>
            <button type="button" class="btn-confirm" onclick="confirmLogout()">Ya</button>
        </div>
    </div>
</div>

<script>
// ANCHOR: Handle logout confirmation modal
function showLogoutModal() {
    document.getElementById('logout-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

function hideLogoutModal() {
    document.getElementById('logout-modal').style.display = 'none';
    document.body.style.overflow = 'auto'; // Restore scrolling
}

function confirmLogout() {
    // ANCHOR: Add loading state
    const confirmBtn = document.querySelector('.btn-confirm');
    const originalText = confirmBtn.textContent;
    confirmBtn.textContent = 'Logging out...';
    confirmBtn.disabled = true;
    
    // ANCHOR: Submit form with timeout to handle expired session
    setTimeout(() => {
        document.getElementById('logout-form').submit();
    }, 100);
}

// ANCHOR: Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('logout-modal');
    if (event.target === modal) {
        hideLogoutModal();
    }
});

// ANCHOR: Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        hideLogoutModal();
    }
});

// ANCHOR: Handle page unload to detect session expiry
window.addEventListener('beforeunload', function() {
    // ANCHOR: Check if session is still valid
    fetch('{{ route("dashboard") }}', {
        method: 'HEAD',
        credentials: 'same-origin'
    }).catch(() => {
        // ANCHOR: Session might be expired
        console.log('Session might be expired');
    });
});
</script>
