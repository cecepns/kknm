<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use App\Helpers\UniversityDataHelper; 
use App\Traits\ActivityLogger;


class AuthController extends Controller
{
    use ActivityLogger;

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
        return view('auth.register-mahasiswa')
            ->with('fakultas', UniversityDataHelper::getFakultas())
            ->with('program_studi', UniversityDataHelper::getProgramStudi())
            ->with('jenis_kkn', UniversityDataHelper::getJenisKKN())
            ->with('angkatan', UniversityDataHelper::getAngkatan())
            ->with('no_kelompok_kkn', UniversityDataHelper::getNoKelompokKKN())
            ->with('tahun_kkn', UniversityDataHelper::getTahunKKN());
    }

    public function showRegisterDosenForm()
    {
        return view('auth.register-dosen')
            ->with('fakultas', UniversityDataHelper::getFakultas())
            ->with('program_studi', UniversityDataHelper::getProgramStudi());
    }

    public function registerMahasiswa(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'student_id' => ['required', 'string', 'size:14', 'unique:users,student_id'],
            'faculty' => ['required', 'string'],
            'study_program' => ['required', 'string'],
            'batch_year' => ['required', 'string'],
            'kkn_type' => ['required', 'string'],
            'kkn_group_number' => ['required', 'string'],
            'kkn_location' => ['required', 'string'],
            'kkn_year' => ['required', 'string'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'student_id.required' => 'NIM wajib diisi.',
            'student_id.string' => 'NIM harus berupa teks.',
            'student_id.size' => 'NIM harus tepat 14 karakter.',
            'student_id.unique' => 'NIM sudah terdaftar.',
            'faculty.required' => 'Fakultas wajib diisi.',
            'faculty.string' => 'Fakultas harus berupa teks.',
            'study_program.required' => 'Program studi wajib diisi.',
            'study_program.string' => 'Program studi harus berupa teks.',
            'batch_year.required' => 'Tahun angkatan wajib diisi.',
            'batch_year.string' => 'Tahun angkatan harus berupa teks.',
            'kkn_type.required' => 'Jenis KKN wajib diisi.',
            'kkn_type.string' => 'Jenis KKN harus berupa teks.',
            'kkn_group_number.required' => 'Nomor kelompok KKN wajib diisi.',
            'kkn_group_number.string' => 'Nomor kelompok KKN harus berupa teks.',
            'kkn_location.required' => 'Lokasi KKN wajib diisi.',
            'kkn_location.string' => 'Lokasi KKN harus berupa teks.',
            'kkn_year.required' => 'Tahun KKN wajib diisi.',
            'kkn_year.string' => 'Tahun KKN harus berupa teks.',
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

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login untuk melanjutkan.');
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
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'employee_id.required' => 'NIDN wajib diisi.',
            'employee_id.string' => 'NIDN harus berupa teks.',
            'employee_id.max' => 'NIDN tidak boleh lebih dari 255 karakter.',
            'employee_id.unique' => 'NIDN sudah terdaftar.',
            'faculty.required' => 'Fakultas wajib diisi.',
            'faculty.string' => 'Fakultas harus berupa teks.',
            'study_program.required' => 'Program studi wajib diisi.',
            'study_program.string' => 'Program studi harus berupa teks.',
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

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login untuk melanjutkan.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // ANCHOR: Check if user exists and is active before attempting authentication
        $user = User::where('email', $credentials['email'])->first();
        
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ]);
        }

        if ($user->status !== 'aktif') {
            throw ValidationException::withMessages([
                'email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
            ]);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $this->logLogin();
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
        try {
            // ANCHOR: Log logout activity before destroying session
            $this->logLogout();
            
            // ANCHOR: Clear all session data first
            $request->session()->flush();
            
            // ANCHOR: Logout user from all guards
            Auth::logout();
            
            // ANCHOR: Invalidate and regenerate session token
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect('/login')->with('success', 'Anda berhasil logout.');
            
        } catch (\Exception $e) {
            // ANCHOR: Handle expired session gracefully
            Auth::logout();
            $request->session()->flush();
            
            return redirect('/login')->with('info', 'Session telah berakhir. Silakan login kembali.');
        }
    }
}