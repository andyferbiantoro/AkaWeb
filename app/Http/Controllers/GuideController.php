<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pemesanan;
use App\User;
use File;
use DB;
use Auth;





class GuideController extends Controller
{
	public function index(){


		return view('guide.index');
	}

	public function guide_jadwal(){
		
		$guide_jadwal = Pemesanan::where('status_pemesanan',1)->where('tanggal_berkunjung','>=', date('y-m-d'))->get();
		
		// foreach ($guide_jadwal as $jadwal => $value) {
		// $day = date('D', strtotime($value));
		// $dayList = array(
		//     'Sun' => 'Minggu',
		//     'Mon' => 'Senin',
		//     'Tue' => 'Selasa',
		//     'Wed' => 'Rabu',
		//     'Thu' => 'Kamis',
		//     'Fri' => 'Jumat',
		//     'Sat' => 'Sabtu'
		// );
		// $value->hari_jadwal = $dayList[$day];
		
		// }

		return view('guide.guide-jadwal',compact('guide_jadwal'));
	}



	public function guide_profil()
	{

		$profil_guide = User::where('id',Auth::user()->id)->get();

		return view('guide.profil-guide', compact('profil_guide'));
	}

	public function proses_ganti_foto_profil_guide(Request $request ,$id)
	{
		$foto_guide = User::find($id);

		$input =[
			'name' => $request->name,
			'email' => $request->email,
			'nohp' => $request->nohp,
			'alamat' => $request->alamat
		]; 

		if ($file = $request->file('photo')) {
			if ($foto_guide->photo) {
				File::delete('uploads/foto_pengelola/'.$foto_guide->photo);
			}
			$nama_file = $file->getClientOriginalName();
			$file->move(public_path() . '/uploads/foto_pengelola/', $nama_file);  
			$input['photo'] = $nama_file;
		}

		$foto_guide->update($input);

		return redirect('/guide-profil')->with('success', 'Data Guide berhasil diupdate');

	}

}
