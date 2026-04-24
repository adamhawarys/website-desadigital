<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SnsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function users(){
        
        // $data = array(
        //     'users' => User::orderBy('role','asc'),
        // );
         // Ambil 10 user per halaman
        $users = User::orderByRaw("FIELD(role, 'Admin', 'Petugas', 'Warga')")->paginate(10);


        return view('admin.users.users',compact('users')) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|max:50',
            'email'    => 'required|unique:users,email|max:50',
            'role'     => 'required',
            'password' => 'required|confirmed|min:8',
        ], [
            'name.required'      => 'Nama Tidak Boleh Kosong',
            'email.required'     => 'Email Tidak Boleh Kosong',
            'email.unique'       => 'Email Sudah Digunakan',
            'role.required'      => 'Role Harus Dipilih',
            'password.required'  => 'Password Tidak Boleh Kosong',
            'password.min'       => 'Password Minimal 8 Karakter',
            'password.confirmed' => 'Konfirmasi Password Tidak Sama',
        ]);

        $user           = new User;
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->role     = $request->role;
        $user->password = Hash::make($request->password);
        $user->status   = 'active';
        $user->save();

        // Daftarkan ke topic SNS sesuai role
        $sns = new SnsService();
        if (in_array($request->role, ['Admin', 'Petugas'])) {
            $sns->daftarkanEmailAdmin($user->email);
        } else {
            $sns->daftarkanEmail($user->email);
        }

        return redirect()->route('users.users')->with('success', 'Data Berhasil Ditambahkan');
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
    public function edit($id)
    {
        

        $data = array(
            'users'  => User::findOrFail($id),
        );
         return view('admin.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
         $request->validate([
            'name'     => 'required|max:50',
            'email'    => 'required|unique:users,email,'.$id,
            'role'     => 'required',
            'status'   => 'required',
            'sns_confirmed' => 'required',
            'password' => 'nullable|confirmed|min:8',
            
        ],[
            'name.required'      => 'Nama Tidak Boleh Kosong',
            'email.required'     => 'Email Tidak Boleh Kosong',
            'email.unique'       => 'Email Sudah Di Gigunakan',
            'role.required'      => 'Role Harus Di Isi',
            'status.required'    => 'Status Harus Di Isi',
            'password.min'       => 'Password Minimal 8 Karakter',
            'password.confirmed' => 'Konfirmasi Password Tidak Sama',
            
        ]);

        $user = User::findOrFail($id);
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->role     = $request->role;
        $user->status     = $request->status;
        $user->sns_confirmed = $request->sns_confirmed;
        if($request->filled('password')){
            $user->password = Hash::make($request->password);

        }        
        $user-> save();

        return redirect()->route('users.users')->with('success','Data Berhasil Di Edit ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user -> delete();

         return redirect()->route('users.users')->with('success','Data Berhasil Dihapus ');

    }
}
