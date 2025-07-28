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
        $this->logRegistration($user->name);

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
        $this->logRegistration($user->name);

        return redirect()->route('dashboard');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
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
        $this->logLogout();
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}