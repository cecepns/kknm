@extends('layouts.dashboard')

@section('title', 'Pantauan Aktivitas Pengguna - KMS KKN')

@section('content')
@php
    function getActivityTypeLabel($activityType) {
        $labels = [
            'login' => 'Login',
            'logout' => 'Logout',
            'register' => 'Registrasi',
            'membuat_diskusi_forum' => 'Membuat Diskusi Forum',
            'mengupdate_diskusi_forum' => 'Mengupdate Diskusi Forum',
            'menghapus_diskusi_forum' => 'Menghapus Diskusi Forum',
            'menambah_komentar_forum' => 'Menambah Komentar Forum',
            'mengupdate_komentar_forum' => 'Mengupdate Komentar Forum',
            'menghapus_komentar_forum' => 'Menghapus Komentar Forum',
        ];
        
        return $labels[$activityType] ?? ucfirst(str_replace('_', ' ', $activityType));
    }
@endphp

<div class="monitoring-container">
    <h1 class="page-title">Pantauan Aktivitas Pengguna</h1>
    
    <!-- Activity Summary Section -->
    <div class="summary-section">
        <h2 class="section-title">Ringkasan Aktivitas</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-label">Total Pengguna Terdaftar</div>
                    <div class="stat-number">{{ number_format($totalUsers) }}</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-label">Jumlah Login Hari Ini</div>
                    <div class="stat-number">{{ number_format($todayLogins) }}</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-label">Total Registrasi</div>
                    <div class="stat-number">{{ number_format($totalRegistrations) }}</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-label">Total Aktivitas Forum</div>
                    <div class="stat-number">{{ number_format($totalForumActivities) }}</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Activity Type Filter Section -->
    <div class="filter-section">
        <h2 class="section-title">Jenis Aktivitas</h2>
        <form method="GET" action="{{ route('monitoring.aktifitas') }}" class="filter-form">
            <div class="filter-group">
                <label for="activity_type" class="filter-label">Jenis Aktivitas</label>
                <select name="activity_type" id="activity_type" class="filter-select" onchange="this.form.submit()">
                    <option value="all" {{ $activityType === 'all' ? 'selected' : '' }}>Semua Aktivitas</option>
                    @foreach($activityTypes as $type)
                        <option value="{{ $type }}" {{ $activityType === $type ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    
    <!-- Activity Data Section -->
    <div class="data-section">
        <h2 class="section-title">Data Aktivitas</h2>
        <div class="table-container">
            <table class="activity-table">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Jenis Aktivitas</th>
                        <th>Deskripsi</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
                        <tr>
                            <td>{{ $activity->user->name ?? 'User tidak ditemukan' }}</td>
                            <td>{{ getActivityTypeLabel($activity->activity_type) }}</td>
                            <td>{{ $activity->description }}</td>
                            <td>{{ $activity->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="no-data">Tidak ada data aktivitas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.monitoring-container {
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.page-title {
    font-size: 2rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 1rem;
}

.summary-section {
    margin-bottom: 3rem;
}

.filter-section {
    margin-bottom: 3rem;
}

.filter-form {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    padding: 1.5rem;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
}

.filter-select {
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    background: white;
    font-size: 0.875rem;
    color: #374151;
    cursor: pointer;
    transition: border-color 0.2s ease;
}

.filter-select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.data-section {
    margin-bottom: 2rem;
}

.table-container {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    overflow: hidden;
}

.activity-table {
    width: 100%;
    border-collapse: collapse;
}

.activity-table th {
    background: #f9fafb;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
}

.activity-table td {
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
    color: #374151;
}

.activity-table tr:hover {
    background: #f9fafb;
}

.no-data {
    text-align: center;
    color: #6b7280;
    font-style: italic;
}

@media (max-width: 768px) {
    .monitoring-container {
        padding: 1rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .activity-table {
        font-size: 0.875rem;
    }
    
    .activity-table th,
    .activity-table td {
        padding: 0.75rem 0.5rem;
    }
}
</style>
@endsection 