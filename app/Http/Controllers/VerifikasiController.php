<?php

namespace App\Http\Controllers;

use App\Mail\OtpEmail;
use App\Models\User;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class VerifikasiController extends Controller
{
    public function index(){
        return view('verifikasi.index');
    }

    public function show($unique_id){
        $verify = Verifikasi::whereUserId(Auth::user()->id)->whereUniqueId($unique_id)
                ->whereStatus('active')->count();
                
                if(!$verify) abort(404);
                return view('verifikasi.show', compact('unique_id'));
    }

    public function update(Request $request, $unique_id){
       $verify = Verifikasi::whereUserId(Auth::user()->id)
                ->whereUniqueId($unique_id)
                ->whereStatus('active')
                ->first();

                if(!$verify) abort(404);
                if(md5($request->otp) != $verify->otp){
                    $verify->update(['status' => 'invalid']);
                    return redirect()->route('verifikasi.index');
                }

                $verify->update(['status' => 'valid']);
                User::find($verify->user_id)->update([
                    'status' => 'Active',
                    'email_verified_at' => now(),
                    ]);
                 return redirect()->route('layanan_mandiri');

    }
    
    public function store(Request $request){
        if($request->type == 'register'){
            $user = User::find($request->user()->id);
            
        }else{
            // $user = Reset pw
        }

        if (!$user) 
            return back()->with('failed','User Tidak Ditemukan');
        

        $otp = rand(100000, 999999);
        
        $verify = Verifikasi::create([
            'user_id' => $user->id, 
            'unique_id' => uniqid(), 
            'otp' => md5($otp),
            'type' => $request->type, 
            'send_via' => 'email'        
        ]);
        // Ganti queue() -> send() dulu
        Mail::to($user->email)->send(new OtpEmail($otp));
        if($request->type == 'register'){
            return redirect('/verify/'. $verify->unique_id);
        }
        // return redirect ('/reset-password')
    }

        /*
    |--------------------------------------------------------------------------
    | LUPA PASSWORD
    |--------------------------------------------------------------------------
    */
 
    // Step 1: Tampilkan form input email
    public function lupaPassword()
    {
        return view('auth.lupa_password');
    }
 
    // Step 2: Kirim OTP ke email
    public function kirimOtpLupaPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email tidak boleh kosong',
            'email.email'    => 'Format email tidak valid',
            'email.exists'   => 'Email tidak terdaftar',
        ]);
 
        $user = User::where('email', $request->email)->first();
 
        // Invalidate OTP lama
        Verifikasi::where('user_id', $user->id)
            ->where('type', 'reset_password')
            ->where('status', 'active')
            ->update(['status' => 'invalid']);
 
        $otp = rand(100000, 999999);
 
        $verify = Verifikasi::create([
            'user_id'   => $user->id,
            'unique_id' => uniqid(),
            'otp'       => md5($otp),
            'type'      => 'reset_password',
            'send_via'  => 'email',
        ]);
 
        Mail::to($user->email)->send(new OtpEmail($otp, 'OTP - Reset Password'));
 
        return redirect()->route('lupa_password.otp', $verify->unique_id)
            ->with('success', 'Kode OTP telah dikirim ke email kamu.');
    }
 
    // Step 3: Tampilkan form input OTP
    public function showOtpLupaPassword($unique_id)
    {
        $verify = Verifikasi::whereUniqueId($unique_id)
                ->whereStatus('active')
                ->whereType('reset_password')
                ->first();
 
        if (!$verify) abort(404);
 
        return view('auth.lupa_password_otp', compact('unique_id'));
    }
 
    // Step 4: Verifikasi OTP
    public function verifyOtpLupaPassword(Request $request, $unique_id)
    {
        $verify = Verifikasi::whereUniqueId($unique_id)
                ->whereStatus('active')
                ->whereType('reset_password')
                ->first();
 
        if (!$verify) abort(404);
 
        if (md5($request->otp) != $verify->otp) {
            $verify->update(['status' => 'invalid']);
            return redirect()->route('lupa_password')
                ->with('failed', 'Kode OTP salah atau sudah tidak valid. Silakan coba lagi.');
        }
 
        $verify->update(['status' => 'valid']);
 
        return redirect()->route('lupa_password.reset', $unique_id);
    }
 
    // Step 5: Tampilkan form password baru
    public function showResetPassword($unique_id)
    {
        $verify = Verifikasi::whereUniqueId($unique_id)
                ->whereStatus('valid')
                ->whereType('reset_password')
                ->first();
 
        if (!$verify) abort(404);
 
        return view('auth.lupa_password_reset', compact('unique_id'));
    }
 
    // Step 6: Simpan password baru
    public function resetPassword(Request $request, $unique_id)
    {
        $request->validate([
            'password'         => 'required|min:8|max:50',
            'confirm_password' => 'required|same:password',
        ], [
            'password.required'         => 'Password tidak boleh kosong',
            'password.min'              => 'Password minimal 8 karakter',
            'confirm_password.required' => 'Konfirmasi password tidak boleh kosong',
            'confirm_password.same'     => 'Konfirmasi password tidak sama',
        ]);
 
        $verify = Verifikasi::whereUniqueId($unique_id)
                ->whereStatus('valid')
                ->whereType('reset_password')
                ->first();
 
        if (!$verify) abort(404);
 
        User::find($verify->user_id)->update([
            'password' => Hash::make($request->password),
        ]);
 
        $verify->update(['status' => 'invalid']);
 
        return redirect()->route('login_user')
            ->with('success', 'Password berhasil diubah. Silakan login.');
    }

 
}


