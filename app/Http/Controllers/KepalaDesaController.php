<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pemesanan;
use App\Paket;
use Carbon\Carbon;
use App\User;
use File;
use DB;
use Auth;

class KepalaDesaController extends Controller
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


		return view('kepala-desa.index',compact('laporan_pengunjung_hari','laporan_pengunjung_bulan','laporan_pengunjung_tahun','paket_terlaris','nama_paket','total_orderan','laporan_pendapatan_hari','laporan_pendapatan_bulan','laporan_pendapatan_tahun'));
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


		return view('kepala-desa.data-laporan.laporan-pengunjung',compact('laporan_pengunjung_hari','laporan_pengunjung_bulan','laporan_pengunjung_tahun'));
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
		return view('kepala-desa.data-laporan.laporan-pemesanan-paket',compact('paket_terlaris'));
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
		return view('kepala-desa.data-laporan.laporan-pendapatan',compact('laporan_pendapatan_hari','laporan_pendapatan_bulan','laporan_pendapatan_tahun'));
	}



	public function kepala_desa_profil()
	{

		$profil_kepala_desa = User::where('id',Auth::user()->id)->get();

		return view('kepala-desa.profil-kepala_desa', compact('profil_kepala_desa'));
	}

	public function proses_ganti_foto_profil_kades(Request $request ,$id)
	{
		$foto_kepala_desa = User::find($id);
		//dd($foto_kepala_desa);

		File::delete('uploads/foto_pengelola/'.$foto_kepala_desa->photo);
		$foto_kepala_desa->delete();  

		if($request->hasFile('photo')){
			$file = $request->file('photo');
			$filename = $file->getClientOriginalName();
			$file->move('uploads/foto_pengelola/', $filename);
			$foto_kepala_desa->photo = $filename;

		}else{
			echo "Gagal upload gambar";
		}

		$foto_kepala_desa->save();

		return redirect('/kepala_desa-profil')->with('success', 'Foto profil berhasil diupdate');

	}
}
