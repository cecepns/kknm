<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password as PasswordRules;
use App\Helpers\UniversityDataHelper; 
use App\Traits\ActivityLogger;
use Illuminate\Support\Facades\DB;


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
            'password' => ['required', 'confirmed', PasswordRules::defaults()],
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
            'password' => ['required', 'confirmed', PasswordRules::defaults()],
            // NIP/NIDN optional, but if provided must be exactly 10 or 18 digits
            'employee_id' => ['required', 'string', 'regex:/^(\\d{10}|\\d{18})$/', 'unique:users,employee_id'],
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
            'employee_id.string' => 'NIP/NIDN harus berupa teks.',
            'employee_id.regex' => 'NIP/NIDN harus berupa 10 atau 18 digit angka.',
            'employee_id.unique' => 'NIP/NIDN sudah terdaftar.',
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

    /**
     * ANCHOR: Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * ANCHOR: Handle forgot password request
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        // ANCHOR: Check if user exists and is active
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan dalam sistem.']);
        }

        if ($user->status !== 'aktif') {
            return back()->withErrors(['email' => 'Akun tidak aktif. Silakan hubungi administrator.']);
        }

        // ANCHOR: Generate password reset token
        $token = Str::random(64);
        
        // ANCHOR: Store token in database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]
        );

        // ANCHOR: Send reset email
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $request->email]);
        
        // ANCHOR: Send email with template
        try {
            Mail::send('emails.reset-password', ['resetUrl' => $resetUrl], function($message) use ($request) {
                $message->to($request->email)
                        ->subject('Reset Password - KMS KKN');
            });
            
            return back()->with('success', 'Link reset password telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            // ANCHOR: If email fails, show the reset URL directly for development
            return back()->with('success', "Link reset password: {$resetUrl}");
        }
    }

    /**
     * ANCHOR: Show password reset form
     */
    public function showResetPasswordForm(Request $request, $token)
    {
        $email = $request->query('email');
        
        // ANCHOR: Verify token exists
        $resetToken = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$resetToken) {
            return redirect()->route('login')->with('error', 'Token reset password tidak valid.');
        }

        // ANCHOR: Check if token is expired (60 minutes)
        if (now()->diffInMinutes($resetToken->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return redirect()->route('login')->with('error', 'Token reset password telah kadaluarsa.');
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    /**
     * ANCHOR: Handle password reset
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ], [
            'token.required' => 'Token wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        // ANCHOR: Verify token
        $resetToken = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetToken) {
            return back()->withErrors(['email' => 'Token reset password tidak valid.']);
        }

        // ANCHOR: Check if token is expired
        if (now()->diffInMinutes($resetToken->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Token reset password telah kadaluarsa.']);
        }

        // ANCHOR: Update user password
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // ANCHOR: Delete used token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login dengan password baru Anda.');
    }
}