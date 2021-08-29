<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function proses_login(Request $request){
        //remember
        $ingat = $request->remember ? true : false; //jika di ceklik true jika tidak gfalse
        //akan ingat selama 5 tahun jika tidak logout

    	//auth()->attempt buat proses login  request input username dan password,  request input  sama kayak $request->password dan usernamenya, ditambah $ingat jika pengen ingat
        if(auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $ingat)){
    		//auth->user() untuk memanggil data user yang sudah login
         if(auth()->user()->role_id == "1"){
            return redirect()->route('pengunjung-data_pemesanan')->with('success', 'Anda Berhasil Login');
        }else if(auth()->user()->role_id == "2"){
            return redirect()->route('admin-beranda')->with('success', 'Anda Berhasil Login');
        }else if(auth()->user()->role_id == "3"){
            return redirect()->route('guide-beranda')->with('success', 'Anda Berhasil Login');
        }else if(auth()->user()->role_id == "4"){
            return redirect()->route('kepala_desa-beranda')->with('success', 'Anda Berhasil Login');
        }
    }else{
        return $role;
            return redirect()->route('login')->with('error', 'Username / Password anda salah'); //route itu isinya name dari route di web.php

        }
    }

//register
    public function proses_register(Request $request){
        $messages = [
            'required' => ':attribute wajib diisi',
            'min' => ':attribute harus diisi minimal :min karakter',
            'max' => ':attribute harus diisi maksimal :max karakter',
            'same' => ':attribute harus sama dengan konfirmasi password',
        ];

            //validasi
        $this->validate($request, [
            //pasword validasinya repassword
            'password' => 'min:8|required_with:repassword|same:repassword',
            'repassword' => 'min:8'
        ], $messages);

        $cekemail = User::where('email', $request->email)->where('role_id',1)->first();

        if ($cekemail) {

            return redirect()->back()->with('error', 'Email Sudah Digunakan');
        }else{

           User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'alamat' => $request['alamat'],
            'nohp' => $request['nohp'],
            'role_id' => $request['role_id']="1",
            'password' => Hash::make($request['password']),
            
        ]);


           return redirect('/login')->with('success', 'Anda Berhasil Register, Silakan Login');
       }       
   }

     //proses logout
   public function logout(){

        auth()->logout(); //logout
        
        return redirect()->route('login')->with('success', 'Anda Berhasil Logout');
        

    }

}
