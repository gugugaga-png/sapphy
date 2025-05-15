<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['nullable', 'exists:roles,id'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'] ?? 2, // default role user
        ]);
    }

    // ✅ Method untuk tampilkan form register user
    public function showUserRegisterForm()
    {
        return view('auth.register');
    }

    // ✅ Method untuk tampilkan form register admin
    public function showAdminRegisterForm()
    {
        return view('auth.register_admin');
    }

    // ✅ Tambahan opsional: proses register user
    public function registerUser(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());
        Auth::login($user);

        return redirect($this->redirectTo);
    }

    // ✅ Tambahan opsional: proses register admin
    public function registerAdmin(Request $request)
    {
        $this->validator($request->all())->validate();

        $admin = $this->create(array_merge($request->all(), [
            'role_id' => 1, // role admin
        ]));

        Auth::login($admin);

        return redirect($this->redirectTo);
    }
}
