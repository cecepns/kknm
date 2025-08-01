<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password; 
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Role;
use App\Helpers\UniversityDataHelper;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check permission
        if (!auth()->user()->hasPermission('kelola-pengguna-internal')) {
            abort(403, 'Unauthorized action.');
        }

        $users = User::with('role')->where('account_type', 'internal')->latest()->get();
        return view('kelola-pengguna-internal.daftar', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check permission
        if (!auth()->user()->hasPermission('kelola-pengguna-internal')) {
            abort(403, 'Unauthorized action.');
        }

        $roles = Role::all();
        $fakultas = UniversityDataHelper::getFakultas();
        $program_studi = UniversityDataHelper::getProgramStudi();
        
        return view('kelola-pengguna-internal.form', compact('roles', 'fakultas', 'program_studi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check permission
        if (!auth()->user()->hasPermission('kelola-pengguna-internal')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
            'status' => ['required', 'in:aktif,tidak aktif'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => $request->role_id,
            'status' => $request->status,
            'account_type' => 'internal',
        ]);

        return redirect()->route('daftar.pengguna.internal')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $fakultas = UniversityDataHelper::getFakultas();
        $program_studi = UniversityDataHelper::getProgramStudi();
        
        return view('kelola-pengguna-internal.form', compact('user', 'roles', 'fakultas', 'program_studi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
            'status' => ['required', 'in:aktif,tidak aktif'],
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = $request->password;
        }

        $user->update($updateData);

        return redirect()->route('daftar.pengguna.internal')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('daftar.pengguna.internal')->with('success', 'Pengguna berhasil dihapus!');
    }
}
