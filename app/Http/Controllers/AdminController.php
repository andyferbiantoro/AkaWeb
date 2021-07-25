<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Paket;
use App\Galeri;
use App\Pemesanan;
use File;
use DB;
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


		return view('admin.index',compact('laporan_pengunjung_hari','laporan_pengunjung_bulan','laporan_pengunjung_tahun','paket_terlaris','nama_paket','total_orderan','laporan_pendapatan_hari','laporan_pendapatan_bulan','laporan_pendapatan_tahun'));
	}



	public function data_guide(){
		$data_guide = User::where('role_id',3)->orderBy('id','DESC')->get();

		return view('admin.data-guide.index',compact('data_guide'));
	}

	public function data_pengunjung(){
		$data_pengunjung = User::where('role_id',1)->orderBy('id','DESC')->get();

		return view('admin.data-pengunjung.index',compact('data_pengunjung'));
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
		$data_paket=Paket::orderBy('id','DESC')->get();

		return view('admin.data-pemesanan.index',compact('data_pemesanan','data_paket'));
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
		->join('users','pemesanans.user_id','=','users.id')
		->select('pembayarans.*','pakets.nama_paket','users.name','pemesanans.jenis_pembayaran')
		->orderBy('pembayarans.id','DESC')
		->get();
		

		return view('admin.data-pembayaran.index',compact('data_pembayaran'));
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
}