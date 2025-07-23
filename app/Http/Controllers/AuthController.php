<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password; 


class AuthController extends Controller
{
    private $fakultas = [
        ['value' => 'FITK', 'label' => 'Ilmu Tarbiyah dan Keguruan (FITK)'],
        ['value' => 'FAH', 'label' => 'Adab dan Humaniora (FAH)'],
        ['value' => 'USHULUDDIN', 'label' => 'Ushuluddin'],
        ['value' => 'FSH', 'label' => 'Syariah dan Hukum (FSH)'],
        ['value' => 'FDIK', 'label' => 'Ilmu Dakwah dan Ilmu Komunikasi (FDIK)'],
        ['value' => 'FDI', 'label' => 'Dirasat Islamiyah (FDI)'],
        ['value' => 'PSIKOLOGI', 'label' => 'Psikologi'],
        ['value' => 'FEB', 'label' => 'Ekonomi dan Bisnis (FEB)'],
        ['value' => 'FST', 'label' => 'Sains dan Teknologi (FST)'],
        ['value' => 'FIKES', 'label' => 'Ilmu Kesehatan (FIKES)'],
        ['value' => 'FISIP', 'label' => 'Ilmu Sosial dan Ilmu Politik (FISIP)'],
        ['value' => 'FK', 'label' => 'Kedokteran (FK)'],
    ];

    private $program_studi = [
        ['value' => 'pai', 'label' => 'Pendidikan Agama Islam'],
        ['value' => 'pba', 'label' => 'Pendidikan Bahasa Arab'],
        ['value' => 'pbi', 'label' => 'Pendidikan Bahasa Inggris'],
        ['value' => 'pmtk', 'label' => 'Pendidikan Matematika'],
        ['value' => 'pbio', 'label' => 'Pendidikan Biologi'],
        ['value' => 'pfis', 'label' => 'Pendidikan Fisika'],
        ['value' => 'pkim', 'label' => 'Pendidikan Kimia'],
        ['value' => 'mp', 'label' => 'Manajemen Pendidikan'],
        ['value' => 'pgmi', 'label' => 'Pendidikan Guru Madrasah Ibtidaiyah'],
        ['value' => 'pbsi', 'label' => 'Pendidikan Bahasa dan Sastra Indonesia'],
        ['value' => 'pips', 'label' => 'Pendidikan Ilmu Pengetahuan Sosial'],
        ['value' => 'piaud', 'label' => 'Pendidikan Islam Anak Usia Dini'],
        ['value' => 'bsa', 'label' => 'Bahasa dan Sastra Arab'],
        ['value' => 'si', 'label' => 'Sastra Inggris'],
        ['value' => 'ski', 'label' => 'Sejarah dan Kebudayaan Islam'],
        ['value' => 'tarjamah', 'label' => 'Tarjamah (Bahasa Arab)'],
        ['value' => 'perpus', 'label' => 'Ilmu Perpustakaan'],
        ['value' => 'saa', 'label' => 'Studi Agama Agama'],
        ['value' => 'iat', 'label' => 'Ilmu Al-Quran dan Tafsir'],
        ['value' => 'ih', 'label' => 'Ilmu Hadis'],
        ['value' => 'afi', 'label' => 'Aqidah dan Filsafat Islam'],
        ['value' => 'tasawuf', 'label' => 'Ilmu Tasawuf'],
        ['value' => 'pm', 'label' => 'Perbandingan Mazhab'],
        ['value' => 'hki', 'label' => 'Hukum Keluarga Islam (Akhwal Syakhsiyyah)'],
        ['value' => 'htn', 'label' => 'Hukum Tata Negara (Siyasah)'],
        ['value' => 'hpi', 'label' => 'Hukum Pidana Islam (Jinayah)'],
        ['value' => 'hes', 'label' => 'Hukum Ekonomi Syariah (Muamalat)'],
        ['value' => 'ihk', 'label' => 'Ilmu Hukum'],
        ['value' => 'kpi', 'label' => 'Komunikasi dan Penyiaran Islam'],
        ['value' => 'bpi', 'label' => 'Bimbingan Penyuluhan Islam'],
        ['value' => 'md', 'label' => 'Manajemen Dakwah'],
        ['value' => 'pmi', 'label' => 'Pengembangan Masyarakat Islam'],
        ['value' => 'kesos', 'label' => 'Kesejahteraan Sosial'],
        ['value' => 'jurnal', 'label' => 'Jurnalistik'],
        ['value' => 'manajemen', 'label' => 'Manajemen'],
        ['value' => 'akuntansi', 'label' => 'Akuntansi'],
        ['value' => 'ep', 'label' => 'Ekonomi Pembangunan'],
        ['value' => 'ps', 'label' => 'Perbankan Syariah'],
        ['value' => 'es', 'label' => 'Ekonomi Syariah'],
        ['value' => 'ti', 'label' => 'Teknik Informatika'],
        ['value' => 'agb', 'label' => 'Agribisnis'],
        ['value' => 'si_fst', 'label' => 'Sistem Informasi'],
        ['value' => 'mtk_fst', 'label' => 'Matematika'],
        ['value' => 'bio_fst', 'label' => 'Biologi'],
        ['value' => 'kim_fst', 'label' => 'Kimia'],
        ['value' => 'fis_fst', 'label' => 'Fisika'],
        ['value' => 'tambang', 'label' => 'Teknik Pertambangan'],
        ['value' => 'kesmas', 'label' => 'Kesehatan Masyarakat'],
        ['value' => 'farmasi', 'label' => 'Farmasi'],
        ['value' => 'keperawatan', 'label' => 'Ilmu Keperawatan'],
        ['value' => 'sosiologi', 'label' => 'Sosiologi'],
        ['value' => 'ip', 'label' => 'Ilmu Politik'],
        ['value' => 'hi', 'label' => 'Ilmu Hubungan Internasional'],
    ];

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterMahasiswaForm()
    {
        $jenis_kkn = [
            ['value' => 'reguler', 'label' => 'KKN Reguler'],
            ['value' => 'in_campus', 'label' => 'KKN In Campus'],
            ['value' => 'tematik', 'label' => 'KKN Tematik'],
            ['value' => 'kebangsaan', 'label' => 'KKN Kebangsaan'],
            ['value' => 'internasional', 'label' => 'KKN Internasional'],
        ];

        $angkatan = range(2025, 2050);
        $no_kelompok_kkn = range(1, 300);
        $tahun_kkn = range(2022, 2050);

        return view('auth.register-mahasiswa', compact(
            'angkatan', 'jenis_kkn', 
            'no_kelompok_kkn', 'tahun_kkn'
        ))
        ->with('fakultas', $this->fakultas)
        ->with('program_studi', $this->program_studi);
    }

    public function showRegisterDosenForm()
    {

        return view('auth.register-dosen')
            ->with('fakultas', $this->fakultas)
            ->with('program_studi', $this->program_studi);;
    }

    public function registerMahasiswa(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'student_id' => ['required', 'string', 'max:255', 'unique:users,student_id'],
            'faculty' => ['required', 'string'],
            'study_program' => ['required', 'string'],
            'batch_year' => ['required', 'string'],
            'kkn_type' => ['required', 'string'],
            'kkn_group_number' => ['required', 'string'],
            'kkn_location' => ['required', 'string'],
            'kkn_year' => ['required', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => 4,
            'account_type' => 'eksternal',
            'student_id' => $request->student_id,
            'faculty' => $request->faculty,
            'study_program' => $request->study_program,
            'batch_year' => $request->batch_year,
            'kkn_type' => $request->kkn_type,
            'kkn_group_number' => $request->kkn_group_number,
            'kkn_location' => $request->kkn_location,
            'kkn_year' => $request->kkn_year,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function registerDosen(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'employee_id' => ['required', 'string', 'max:255', 'unique:users,employee_id'],
            'faculty' => ['required', 'string'],
            'study_program' => ['required', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => 5,
            'account_type' => 'eksternal',
            'employee_id' => $request->employee_id,
            'faculty' => $request->faculty,
            'study_program' => $request->study_program,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard.dashboard');
        }   
        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}