<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pelamar;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerifikasi;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index', [
            'title' => 'register'
        ]);
    }

    public function store(Request $request)
    {
        $str = Str::random(100);
        $ValidatedData = $request->validate([
            'nama' => ['required', 'max:255',],
            'username' => ['required', 'min:3', 'max:255', 'unique:users'],
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:6|max:12',
            'verify_key' => $str
        ]);
        $id = Employee::create([
            'nama' => $ValidatedData['nama'],
            'username' => $ValidatedData['username'],
            'email' => $ValidatedData['email'],
            'password' => Hash::make($ValidatedData['password']),
            'role' => 'siswa',
            'verify_key' => $str
        ]);
        $user = $id->id;
        $user = User::get('role');
        $details = [
            'username' => $request->username,
            'role' => $user,
            'email' => $request->email,
            'datetime' => date('Y-m-d H:i:s'),
            'url' => request()->getHttpHost() . '/register/verify/' . $str
        ];

        return redirect('/login')
            ->with('success', 'Email Verifikasi telah dikrim. Silahkan Cek Email Anda untuk Mengaktifkan Akun');
    }
}
