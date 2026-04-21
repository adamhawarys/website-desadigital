<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Services\SnsService;

class AuthController extends Controller
{
    /*
    
    | VALIDATION RULES (dipakai ulang)
    
    */
    private function loginValidation(Request $request)
    {
        return $request->validate([
            'email'    => 'required|email|max:50',
            'password' => 'required|min:8|max:50',
        ], [
            'email.required'    => 'Email Tidak Boleh Kosong',
            'password.required' => 'Password Tidak Boleh Kosong',
            'password.min'      => 'Password Minimal 8 Karakter',
        ]);
    }

    /*
    
    | LOGIN ADMIN / PETUGAS
    
    */
    public function login_admin(Request $request)
    {
        $this->loginValidation($request);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->with('failed', 'Email atau Password salah');
        }

        $request->session()->regenerate();
        $user = Auth::user();

        if (!in_array($user->role, ['Admin', 'Petugas'])) {
            $this->forceLogout($request);
            return back()->with('failed', 'Akun ini bukan Admin/Petugas');
        }

        $request->session()->put('login_as', 'admin');

        return redirect()->route('dashboard')
            ->with('success', 'Anda Berhasil Masuk');
    }

    /*
    
    | LOGIN WARGA
    
    */
    public function login_user(Request $request)
    {
        $this->loginValidation($request);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->with('failed', 'Email atau Password salah');
        }

        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->role !== 'Warga') {
            $this->forceLogout($request);
            return back()->with('failed', 'Akun ini bukan Warga');
        }

        $request->session()->put('login_as', 'warga');

        return redirect()->route('layanan_mandiri')
            ->with('success', 'Anda Berhasil Masuk');
    }

    /*
    
    | REGISTER WARGA
    
    */
    public function register(Request $request)
    {
        $request->validate([
            'name'             => 'required|max:50',
            'email'            => 'required|email|max:50|unique:users,email',
            'password'         => 'required|min:8|max:50',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'Warga',
            'status'   => 'Verify',
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->put('login_as', 'warga');

        // Kirim OTP dulu, jangan langsung ke layanan mandiri
        return redirect()->route('verifikasi.index')
            ->with('success', 'Registrasi berhasil! Silakan verifikasi email kamu.');
    }

  public function google_redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function google_callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login_user')
                ->with('failed', 'Login Google gagal. Silakan coba lagi.');
        }

        $user = User::whereEmail($googleUser->email)->first();

        if (!$user) {
            $user = User::create([
                'foto'              => $googleUser->getAvatar(),
                'name'              => $googleUser->name,
                'email'             => $googleUser->email,
                'password'          => bcrypt(Str::random(16)),
                'role'              => 'Warga',
                'status'            => 'Active',
                'email_verified_at' => now(),
                
            ]);

            //  daftarkan email ke SNS hanya saat user BARU
                app(SnsService::class)->daftarkanEmail($user->email);
        }

        if ($user->status == 'Banned') {
            return redirect()->route('login_user')
                ->with('failed', 'Akun Anda telah dibekukan');
        }

        Auth::login($user);
        request()->session()->regenerate();
        request()->session()->put('login_as', 'warga');

        if ($user->role == 'Warga') {
            return redirect()->route('layanan_mandiri');
        }

        return redirect()->route('dashboard');
    }


    /*
    
    | SHOW LOGIN PAGES
    
    */
    public function showLoginAdmin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.login_admin');
    }

    public function showLoginUser()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.login_user');
    }

    /*
    
    | LOGOUT
    
    */
    public function logout(Request $request)
    {
        $loginAs = $request->session()->get('login_as');

        $this->forceLogout($request);

        if ($loginAs === 'warga') {
            return redirect()->route('login_user')
                ->with('success', 'Anda Berhasil Logout');
        }

        return redirect()->route('login_admin')
            ->with('success', 'Anda Berhasil Logout');
    }

    /*
    
    | HELPER FUNCTIONS
    
    */

    private function redirectByRole($role)
    {
        return match ($role) {
            'Admin', 'Petugas' => redirect()->route('dashboard'),
            'Warga'            => redirect()->route('layanan_mandiri'),
            default             => redirect()->route('welcome'),
        };
    }

    private function forceLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}