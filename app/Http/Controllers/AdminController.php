<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Paket;
use App\Galeri;
use App\Pemesanan;
use App\Pembayaran;
use File;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
	public function index(){

		//pengunjung
		$laporan_pengunjung_hari = Pemesanan::whereDate('created_at','=', date('y-m-d'))
		->where('status_pemesanan',1)
		->count();

		$month = Carbon::now()->format('m');
		$laporan_pengunjung_bulan = Pemesanan::whereMonth('created_at','=', $month)
		->where('status_pemesanan',1)
		->count();

		$year = Carbon::now()->format('Y');
		$laporan_pengunjung_tahun = Pemesanan::whereYear('created_at','=', $year)
		->where('status_pemesanan',1)
		->count();


		//pendapatan
		$laporan_pendapatan_hari = Pemesanan::whereDate('created_at','=', date('y-m-d'))
		->where('status_pemesanan',1)
		->sum('jumlah_pembayaran');

		$month = Carbon::now()->format('m');
		$laporan_pendapatan_bulan = Pemesanan::whereMonth('created_at','=', $month)
		->where('status_pemesanan',1)
		->sum('jumlah_pembayaran');

		$year = Carbon::now()->format('Y');
		$laporan_pendapatan_tahun = Pemesanan::whereYear('created_at','=', $year)
		->where('status_pemesanan',1)
		->sum('jumlah_pembayaran');


		//paket wisata
		$paket_terlaris = DB::table('pemesanans')
		->join('pakets', 'pemesanans.paket_id', '=', 'pakets.id')
		->select(DB::raw('paket_id, count(pemesanans.id) as total_orderan'))
		->groupBy('paket_id')
		->where('pemesanans.status_pemesanan', 1)
		->orderBy('total_orderan', 'DESC')
		->get();

		$nama_paket = [];
		
		foreach ($paket_terlaris as $terlaris => $value) {
			
			$paket = Paket::where('id',$value->paket_id)->first();
			$nama_paket[] = $paket->nama_paket;
		}

		$total_orderan = [];
		
		foreach ($paket_terlaris as $orderan => $value) {
			
			$orderan = DB::table('pemesanans')
			->join('pakets', 'pemesanans.paket_id', '=', 'pakets.id')
			->select(DB::raw('paket_id, count(pemesanans.id) as total_orderan'))
			->groupBy('paket_id')
			->first();
			$total_orderan[] = $orderan->total_orderan;
		}

		$foto_admin = User::where('id',Auth::user()->id)->get();

		return view('admin.index',compact('laporan_pengunjung_hari','laporan_pengunjung_bulan','laporan_pengunjung_tahun','paket_terlaris','nama_paket','total_orderan','laporan_pendapatan_hari','laporan_pendapatan_bulan','laporan_pendapatan_tahun','foto_admin'));
	}



	public function data_guide(){
		$data_guide = User::where('role_id',3)->orderBy('id','DESC')->get();

		return view('admin.data-guide.index',compact('data_guide'));
	}


	public function data_pengunjung(){
		$data_pengunjung = User::where('role_id',1)->orderBy('id','DESC')->get();

		return view('admin.data-pengunjung.index',compact('data_pengunjung'));
	}


	public function tambah_pengunjung(Request $request){

		
		$data_guide = new User();

		$data_guide->name = $request->input('name');
		$data_guide->email = $request->input('email');
		$data_guide->alamat = $request->input('alamat');
		$data_guide->role_id = 1;
		$data_guide->password = Hash::make($request->input('password'));

		if($request->hasFile('photo')){
			$file = $request->file('photo');
			$filename = $file->getClientOriginalName();
			$path = $file->store('public/uploads/foto_pengunjung');
			$file->move('uploads/foto_pengunjung/', $filename);
			$data_guide->photo = $filename;

		}else{
			echo "Gagal upload gambar";
		}

		$data_guide->save();

		// User::create([
		// 	'name' => $request['name'],
		// 	'email' => $request['email'],
		// 	'alamat' => $request['alamat'],
		// 	'role_id' => $request['role_id']="3",
		// 	'password' => Hash::make($request['password']),

		// ]);

		return redirect('/admin-data_pengunjung')->with('success', 'Pengunjung Baru Berhasil Ditambahkan');
	}



	public function tambah_guide(Request $request){

		
		$data_guide = new User();

		$data_guide->name = $request->input('name');
		$data_guide->email = $request->input('email');
		$data_guide->alamat = $request->input('alamat');
		$data_guide->role_id = 3;
		$data_guide->password = Hash::make($request->input('password'));

		if($request->hasFile('photo')){
			$file = $request->file('photo');
			$filename = $file->getClientOriginalName();
			$path = $file->store('public/uploads/foto_guide');
			$file->move('uploads/foto_guide/', $filename);
			$data_guide->photo = $filename;

		}else{
			echo "Gagal upload gambar";
		}

		$data_guide->save();

		// User::create([
		// 	'name' => $request['name'],
		// 	'email' => $request['email'],
		// 	'alamat' => $request['alamat'],
		// 	'role_id' => $request['role_id']="3",
		// 	'password' => Hash::make($request['password']),

		// ]);

		return redirect('/admin-data_guide')->with('success', 'Guide Baru Berhasil Ditambahkan');
	}


	public function hapus_data_guide($id){

		$data_guide = User::findOrFail($id);
		File::delete('uploads/foto_guide/'.$data_guide->photo);
		$data_guide->delete();

		return redirect()->back()->with('success', 'Data Guide Berhasil Dihapus');
	}


	public function data_paket_wisata(){
		$data_paket_wisata = Paket::orderBy('id','DESC')->where('status_paket',1)->get();

		return view('admin.data-paket-wisata.index',compact('data_paket_wisata'));
	}


	public function data_paket_wisata_nonaktif(){
		$data_paket_wisata = Paket::orderBy('id','DESC')->where('status_paket',0)->get();

		return view('admin.data-paket-wisata.paket-nonaktif',compact('data_paket_wisata'));
	}


	public function tambah_paket_wisata(Request $request){

		
		$data_paket_wisata = new Paket();

		$data_paket_wisata->nama_paket = $request->input('nama_paket');
		$data_paket_wisata->deskripsi_paket = $request->input('deskripsi_paket');
		$data_paket_wisata->harga_paket = $request->input('harga_paket');
		$data_paket_wisata->status_paket = 1;


		if($request->hasFile('photo')){
			$file = $request->file('photo');
			$filename = $file->getClientOriginalName();
			$path = $file->store('public/uploads/foto_paket_wisata');
			$file->move('uploads/foto_paket_wisata/', $filename);
			$data_paket_wisata->photo = $filename;

		}else{
			echo "Gagal upload gambar";
		}

		$data_paket_wisata->save();

		// User::create([
		// 	'name' => $request['name'],
		// 	'email' => $request['email'],
		// 	'alamat' => $request['alamat'],
		// 	'role_id' => $request['role_id']="3",
		// 	'password' => Hash::make($request['password']),

		// ]);

		return redirect('/admin-data_paket_wisata')->with('success', 'Paket Wisata Baru Berhasil Ditambahkan');
	}


	public function nonaktif_data_paket_wisata($id){

		// $data_paket_wisata = Paket::findOrFail($id);
		// File::delete('uploads/foto_paket_wisata/'.$data_paket_wisata->photo);
		// $data_paket_wisata->delete();

		$edit_status_paket = Paket::where('id', $id);

		$input =([
			'status_paket' => 0,
		]);  
		$edit_status_paket->update($input);

		return redirect()->back()->with('success', 'Data Guide Berhasil Dihapus');
	}


	public function proses_update_paket_wisata(Request $request, $id){

		$update_data_paket = Paket::where('id', $id)->first();

		$input =[
			'nama_paket' => $request->nama_paket,
			'deskripsi_paket' => $request->deskripsi_paket,
			'harga_paket' => $request->harga_paket
		]; 

		if ($file = $request->file('photo')) {
			if ($update_data_paket->photo) {
				File::delete('uploads/foto_paket_wisata/'.$update_data_paket->photo);
			}
			$nama_file = $file->getClientOriginalName();
			$file->move(public_path() . '/uploads/foto_paket_wisata/', $nama_file);  
			$input['photo'] = $nama_file;
		}

		$update_data_paket->update($input);

		return redirect()->back()->with('success', 'Data Paket Berhasil diupdate');
	}


	public function aktif_data_paket_wisata($id){

		$edit_status_paket = Paket::where('id', $id);

		$input =([
			'status_paket' => 1,
		]);  
		$edit_status_paket->update($input);

		return redirect()->back()->with('success', 'Data Guide Berhasil Dihapus');
	}




	public function data_pemesanan_pengunjung(){
		
		$data_pemesanan = DB::table('pemesanans')
		->join('pakets', 'pemesanans.paket_id', '=', 'pakets.id')
		->join('users', 'pemesanans.user_id', '=', 'users.id')
		->select('pemesanans.*','pakets.nama_paket','users.name')
		->orderBy('pemesanans.id','DESC')
		->get();
		$data_paket=Paket::orderBy('id','DESC')->where('id', '>', '1')->where('status_paket',1)->get();
		$data_pengunjung = User::where('role_id',1)->get();

		return view('admin.data-pemesanan.index',compact('data_pemesanan','data_paket','data_pengunjung'));
	}


	public function proses_tambah_pesanan(Request $request){

		
		$data_pesananan = new Pemesanan();
		

		$data_pesananan->user_id = $request->input('user_id');
		$data_pesananan->paket_id  = $request->input('paket_id');
		$data_pesananan->kategori_pemesanan = $request->input('kategori_pemesanan');
		$data_pesananan->tanggal_pemesanan = $request->input('tanggal_pemesanan');
		$data_pesananan->tanggal_berkunjung = $request->input('tanggal_berkunjung');
		$data_pesananan->pukul_kunjungan = $request->input('pukul_kunjungan');
		$data_pesananan->jumlah_pengunjung = $request->input('jumlah_pengunjung');
		$data_pesananan->jumlah_pembayaran = $request->input('jumlah_pembayaran');
		$data_pesananan->status_pemesanan = 0;
		$data_pesananan->nomor_pemesanan =  rand(100, 999);
		$data_pesananan->jenis_pembayaran = $request->input('jenis_pembayaran');


		$data_pesananan->save();

		return redirect('/admin-data_pemesanan_pengunjung')->with('success', 'Pemesanan Baru Berhasil Ditambahkan');
	}


	public function batalkan_pesanan($id){

		$data_pemesanan = Pemesanan::findOrFail($id);
		$data_pemesanan->delete();

		return redirect()->back()->with('success', 'Data Pemesanan Berhasil Dibatalkan');
	}


	public function data_pembayaran_pengunjung(){
		
		$data_pembayaran = DB::table('pembayarans')
		->join('pemesanans', 'pembayarans.pemesanan_id', '=', 'pemesanans.id')
		->join('pakets', 'pemesanans.paket_id', '=', 'pakets.id')
		->join('users', 'pemesanans.user_id', '=', 'users.id')
		->select('pembayarans.*','pakets.nama_paket','pemesanans.jenis_pembayaran','pemesanans.jumlah_pembayaran','users.name','pemesanans.bukti_pelunasan')
		
		->orderBy('pembayarans.id','DESC')
		->where('pemesanans.status_pemesanan', 1)
		->get();

		//dd($data_pembayaran);
		

		$data_pamesanan = DB::table('pemesanans')
		->join('pakets', 'pemesanans.paket_id', '=', 'pakets.id')
		->join('users', 'pemesanans.user_id', '=', 'users.id')
		->select('pemesanans.*','pakets.nama_paket','users.name')
		->where('status_pemesanan',0)
		->orderBy('pemesanans.id','DESC')
		->get();

		

		return view('admin.data-pembayaran.index',compact('data_pembayaran','data_pamesanan'));
	}


	public function proses_tambah_pembayaran(Request $request){

		
		$data_pembayaran = new Pembayaran();
		

		$data_pembayaran->pemesanan_id = $request->input('pemesanan_id');
		$data_pembayaran->tanggal_pembayaran  = $request->input('tanggal_pembayaran');
		$data_pembayaran->metode_pembayaran = $request->input('metode_pembayaran');
		$data_pembayaran->status_pembayaran = 2; //langsung status 2 karena dari admin, tidak perlu verifikasi
		
		if($request->hasFile('bukti_pembayaran')){
			$file = $request->file('bukti_pembayaran');
			$filename = $file->getClientOriginalName();
			$file->move('uploads/bukti_pembayaran/', $filename);
			$data_pembayaran->bukti_pembayaran = $filename;

		}else{
			echo "Gagal upload gambar";
		}

		$data_pembayaran->save();

		//Ubah Status pemesanan
		$edit_status_pemesanan = Pemesanan::where('id', $data_pembayaran->pemesanan_id);

		$input =([
			'status_pemesanan' => 1,
		]);  
		$edit_status_pemesanan->update($input);

		$pem = Pemesanan::where('id', $data_pembayaran->pemesanan_id)->pluck('id');
		$guide_id = User::where('role_id',3)->pluck('id');

       	// dd($guide);
		$this->received($pem);
		//$this->received_guide($pem);


		return redirect('/admin-data_pembayaran_pengunjung')->with('success', 'Pembayaran  Berhasil Dilakukan, Email verifikasi telah terkirim ke pemesan');
	}



	public function verifikasi_pembayaran($id){

		$verifikasi_pembayaran = Pembayaran::find($id);

		
		$input =([
			'status_pembayaran' => 2,
		]);  
		$verifikasi_pembayaran->update($input);


		$pem = Pemesanan::where('id', $verifikasi_pembayaran->pemesanan_id)->pluck('id');
		$guide_id = User::where('role_id',3)->pluck('id');

       	// dd($guide);
		$this->received($pem);
		//$this->received_guide($pem);

		return redirect()->back()->with('success', 'Data pembayaran berhasill diverifikasi, Email konfirmasi sudah dikirimkan ke pemesan');
	}


	public function received($pem)
	{
		
		$pemesanan= DB::table('pemesanans')
		->join('pakets', 'pemesanans.paket_id', '=', 'pakets.id')
		->join('users', 'pemesanans.user_id', '=', 'users.id')
		->select('pemesanans.*','pakets.nama_paket','users.email')
		->where('pemesanans.id', $pem)
		->orderBy('pemesanans.id','DESC')
		->first();

		$this->_sendEmail($pemesanan);

	}


	public function received_guide($pem)
	{
		

		$pemesanan_pengunjung= DB::table('pemesanans')
		->join('pakets', 'pemesanans.paket_id', '=', 'pakets.id')
		->join('users', 'pemesanans.user_id', '=', 'users.id')
		->select('pemesanans.*','pakets.nama_paket','users.name')
		->where('pemesanans.id', $pem)
		->orderBy('pemesanans.id','DESC')
		->first();

		$this->_sendEmailGuide($pemesanan_pengunjung);

	}


	public function _sendEmail($pemesanan)
	{
		$message = new \App\Mail\OrderShipped($pemesanan);
		\Mail::to($pemesanan->email)->send($message);
	}


	public function _sendEmailGuide($pemesanan_pengunjung)
	{

		$guide = User::where('role_id',3)->get();

		foreach ($guide as $key => $value) {

			$message = new \App\Mail\OrderShippedGuide($pemesanan_pengunjung);
			\Mail::to($value->email)->send($message);
		}
		
	}




	public function laporan_pengunjung(){
		$laporan_pengunjung_hari = Pemesanan::whereDate('created_at','=', date('y-m-d'))
		->where('status_pemesanan',1)
		->count();

		$month = Carbon::now()->format('m');
		$laporan_pengunjung_bulan = Pemesanan::whereMonth('created_at','=', $month)
		->where('status_pemesanan',1)
		->count();

		$year = Carbon::now()->format('Y');
		$laporan_pengunjung_tahun = Pemesanan::whereYear('created_at','=', $year)
		->where('status_pemesanan',1)
		->count();


		return view('admin.data-laporan.laporan-pengunjung',compact('laporan_pengunjung_hari','laporan_pengunjung_bulan','laporan_pengunjung_tahun'));
	}


	public function laporan_pemesanan_paket(){
		$paket_terlaris = DB::table('pemesanans')
		->join('pakets', 'pemesanans.paket_id', '=', 'pakets.id')
		->select(DB::raw('paket_id, count(pemesanans.id) as total_orderan'))
		->groupBy('paket_id')
		->where('pemesanans.status_pemesanan', 1)
		->orderBy('total_orderan', 'DESC')
		->get();
		
		foreach ($paket_terlaris as $terlaris => $value) {
			
			$paket = Paket::where('id',$value->paket_id)->first();
			$value->nama_paket = $paket->nama_paket;
		}
		
		 // return $paket_terlaris;
		return view('admin.data-laporan.laporan-pemesanan-paket',compact('paket_terlaris'));
	}


	public function laporan_pendapatan(){

		$laporan_pendapatan_hari = Pemesanan::whereDate('created_at','=', date('y-m-d'))
		->where('status_pemesanan',1)
		->sum('jumlah_pembayaran');

		$month = Carbon::now()->format('m');
		$laporan_pendapatan_bulan = Pemesanan::whereMonth('created_at','=', $month)
		->where('status_pemesanan',1)
		->sum('jumlah_pembayaran');

		$year = Carbon::now()->format('Y');
		$laporan_pendapatan_tahun = Pemesanan::whereYear('created_at','=', $year)
		->where('status_pemesanan',1)
		->sum('jumlah_pembayaran');

		// return $laporan_pendapatan;
		return view('admin.data-laporan.laporan-pendapatan',compact('laporan_pendapatan_hari','laporan_pendapatan_bulan','laporan_pendapatan_tahun'));
	}


	public function galeri(){
		$data_galeri = Galeri::orderBy('id','DESC')->get();

		return view('admin.data-galeri.index',compact('data_galeri'));
	}


	public function tambah_galeri(Request $request){

		
		$data_galeri = new Galeri();

		if($request->hasFile('photo')){
			$file = $request->file('photo');
			$filename = $file->getClientOriginalName();
			$file->move('uploads/foto_galeri/', $filename);
			$data_galeri->photo = $filename;

		}else{
			echo "Gagal upload gambar";
		}

		$data_galeri->save();


		return redirect('/admin-galeri')->with('success', 'Galeri Baru Berhasil Ditambahkan');
	}


	public function hapus_data_galeri($id){

		$data_galeri = Galeri::findOrFail($id);
		File::delete('uploads/foto_galeri/'.$data_galeri->photo);
		$data_galeri->delete();

		return redirect()->back()->with('success', 'Data Galeri Berhasil Dihapus');
	}


	public function get_paket_belum_bayar($id_user){

		//$pemesanan = Pemesanan::where('status_pemesanan',0)->get();
		$pemesanan = DB::table('pemesanans')
		->join('pakets', 'pemesanans.paket_id', '=', 'pakets.id')
		->select('pemesanans.*','pakets.nama_paket')
		->where('pemesanans.status_pemesanan', 0)
		->where('user_id', $id_user)
		->get();

		return response()->json([

			'pemesanan' => $pemesanan
		]);
	}


	public function admin_profil()
	{

		$profil_admin = User::where('id',Auth::user()->id)->get();

		return view('admin.profil-admin', compact('profil_admin'));
	}

	public function proses_ganti_foto_profil_admin(Request $request ,$id)
	{
		$foto_admin = User::find($id);
		//dd($foto_admin);

		File::delete('uploads/foto_pengelola/'.$foto_admin->photo);
		$foto_admin->delete();  

		if($request->hasFile('photo')){
			$file = $request->file('photo');
			$filename = $file->getClientOriginalName();
			$file->move('uploads/foto_pengelola/', $filename);
			$foto_admin->photo = $filename;

		}else{
			echo "Gagal upload gambar";
		}

		$foto_admin->save();

		return redirect('/admin-profil')->with('success', 'Foto profil berhasil diupdate');

	}


	public function pelunasan_pembayaran(Request $request ,$id)
	{

		$pemesanan = Pemesanan::find($id);
		
		$data = [
			'jumlah_pembayaran' => $pemesanan->jumlah_pembayaran + $pemesanan->jumlah_pembayaran,
			'jenis_pembayaran' => 'lunas'

		];

        $pemesanan->update($data);
        if($request->hasFile('bukti_pelunasan')){
			$file = $request->file('bukti_pelunasan');
			$filename = $file->getClientOriginalName();
			$file->move('uploads/bukti_pelunasan/', $filename);
			$pemesanan->bukti_pelunasan = $filename;

		}else{
			echo "Gagal upload gambar";
		}

		$pemesanan->save();
    

		return redirect('/admin-data_pembayaran_pengunjung')->with('success', 'Pembayaran berhasil dilunasi');

	}
}
	