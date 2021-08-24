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
				->where('paket_id', $value->paket_id)
				->where('pemesanans.status_pemesanan', 1)
				->whereMonth('pemesanans.created_at','=',$month)
				->count();

				$total_orderan[] = $orderan;
			}


		return view('kepala-desa.index',compact('laporan_pengunjung_hari','laporan_pengunjung_bulan','laporan_pengunjung_tahun','paket_terlaris','nama_paket','total_orderan','laporan_pendapatan_hari','laporan_pendapatan_bulan','laporan_pendapatan_tahun'));
	}


	public function laporan_pengunjung(Request $request){

		// $laporan_pengunjung_hari = Pemesanan::whereDate('created_at','=', date('y-m-d'))
		// ->where('status_pemesanan',1)
		// ->count();

		// $month = Carbon::now()->format('m');
		// $laporan_pengunjung_bulan = Pemesanan::whereMonth('created_at','=', $month)
		// ->where('status_pemesanan',1)
		// ->count();

		// $year = Carbon::now()->format('Y');
		// $laporan_pengunjung_tahun = Pemesanan::whereYear('created_at','=', $year)
		// ->where('status_pemesanan',1)
		// ->count();

		$from = $request->from;
		$to = $request->to;

		if ($from == null && $to == null) {
			$count_pengunjung = DB::table('pemesanans')
			->join('users','pemesanans.user_id','=','users.id')
			->select(DB::raw('pemesanans.created_at, count(pemesanans.created_at) as total_pengunjung'))
		//->select('users.nama')
			->groupby('created_at')
			->get();
		}else{
			$count_pengunjung = DB::table('pemesanans')
			->join('users','pemesanans.user_id','=','users.id')
			->select(DB::raw('pemesanans.created_at, count(pemesanans.created_at) as total_pengunjung'))
		//->select('users.nama')
			->groupby('created_at')
			->whereBetween('pemesanans.created_at', [$from, $to])
			->get();

		}
		
		return view('kepala-desa.data-laporan.laporan-pengunjung',compact('count_pengunjung','from','to'));
	}


	public function laporan_pemesanan_paket(Request $request){

		$from = $request->from;
		$to = $request->to;


		if ($from == null && $to == null) {
			$paket_terlaris = DB::table('pemesanans')
			->join('pakets', 'pemesanans.paket_id', '=', 'pakets.id')
			->select(DB::raw('paket_id,pemesanans.created_at, count(pemesanans.id) as total_orderan'))
			->groupBy('paket_id','pemesanans.created_at')
			->where('pemesanans.status_pemesanan', 1)
			->orderBy('total_orderan', 'DESC')
			->get();

			foreach ($paket_terlaris as $terlaris => $value) {

				$paket = Paket::where('id',$value->paket_id)->first();
				$value->nama_paket = $paket->nama_paket;
			}
		}else{
			$paket_terlaris = DB::table('pemesanans')
			->join('pakets', 'pemesanans.paket_id', '=', 'pakets.id')
			->select(DB::raw('paket_id,pemesanans.created_at, count(pemesanans.id) as total_orderan'))
			->groupBy('paket_id','pemesanans.created_at')
			->where('pemesanans.status_pemesanan', 1)
			->whereBetween('pemesanans.created_at', [$from, $to])
			->orderBy('total_orderan', 'DESC')
			->get();

			foreach ($paket_terlaris as $terlaris => $value) {

				$paket = Paket::where('id',$value->paket_id)->first();
				$value->nama_paket = $paket->nama_paket;
			}
		}
		
		 //return $paket_terlaris;
		return view('kepala-desa.data-laporan.laporan-pemesanan-paket',compact('paket_terlaris','from','to'));
	}



	public function laporan_pendapatan(Request $request){

		// $laporan_pendapatan_hari = Pemesanan::whereDate('created_at','=', date('y-m-d'))
		// ->where('status_pemesanan',1)
		// ->sum('jumlah_pembayaran');

		// $month = Carbon::now()->format('m');
		// $laporan_pendapatan_bulan = Pemesanan::whereMonth('created_at','=', $month)
		// ->where('status_pemesanan',1)
		// ->sum('jumlah_pembayaran');

		// $year = Carbon::now()->format('Y');
		// $laporan_pendapatan_tahun = Pemesanan::whereYear('created_at','=', $year)
		// ->where('status_pemesanan',1)
		// ->sum('jumlah_pembayaran');

		$from = $request->from;
		$to = $request->to;

		if ($from == null && $to == null) {
			$data_pendapatan = DB::table('pemesanans')
			->select(DB::raw('pemesanans.created_at, sum(jumlah_pembayaran) as total_pendapatan'))
		//->select('users.nama')
			->where('status_pemesanan',1)
			->groupby('created_at')
			->get();
		}else{
			$data_pendapatan = DB::table('pemesanans')
			->select(DB::raw('pemesanans.created_at, sum(jumlah_pembayaran) as total_pendapatan'))
		//->select('users.nama')
			->where('status_pemesanan',1)
			->groupby('created_at')
			->whereBetween('pemesanans.created_at', [$from, $to])
			->get();
		}

		 //return $data_pendapatan;
		return view('kepala-desa.data-laporan.laporan-pendapatan',compact('data_pendapatan','from','to'));
	}



	public function kepala_desa_profil()
	{

		$profil_kepala_desa = User::where('id',Auth::user()->id)->get();

		return view('kepala-desa.profil-kepala_desa', compact('profil_kepala_desa'));
	}

	public function proses_ganti_profil_kades(Request $request ,$id)
	{
		$foto_kades = User::find($id);

		$input =[
			'name' => $request->name,
			'email' => $request->email,
			'nohp' => $request->nohp,
			'alamat' => $request->alamat
		]; 

		if ($file = $request->file('photo')) {
			if ($foto_kades->photo) {
				File::delete('uploads/foto_pengelola/'.$foto_kades->photo);
			}
			$nama_file = $file->getClientOriginalName();
			$file->move(public_path() . '/uploads/foto_pengelola/', $nama_file);  
			$input['photo'] = $nama_file;
		}

		$foto_kades->update($input);

		return redirect('/kepala_desa-profil')->with('success', 'Profil Kepala Desa berhasil diupdate');

	}


	public function laporan_berkala_pengunjung(Request $request){
		
		$cari_tahun = $request->cari_tahun;

		$januari = '01';
		$februari = '02';
		$maret = '03';
		$april = '04';
		$mei = '05';
		$juni = '06';
		$juli = '07';
		$agustus = '08';
		$september = '09';
		$oktober = '10';
		$november = '11';
		$desember = '12';


		$year = Carbon::now()->format('Y');
		


		if ($cari_tahun == null) {
			$laporan_januari = Pemesanan::whereMonth('created_at','=',$januari)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->count();

			$laporan_februari = Pemesanan::whereMonth('created_at','=',$februari)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->count();

			$laporan_maret = Pemesanan::whereMonth('created_at','=',$maret)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->count();

			$laporan_april = Pemesanan::whereMonth('created_at','=',$april)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->count();

			$laporan_mei = Pemesanan::whereMonth('created_at','=',$mei)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->count();

			$laporan_juni = Pemesanan::whereMonth('created_at','=',$juni)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->count();

			$laporan_juli = Pemesanan::whereMonth('created_at','=',$juli)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->count();

			$laporan_agustus = Pemesanan::whereMonth('created_at','=',$agustus)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->count();

			$laporan_september = Pemesanan::whereMonth('created_at','=',$september)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->count();

			$laporan_oktober = Pemesanan::whereMonth('created_at','=',$oktober)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->count();

			$laporan_november = Pemesanan::whereMonth('created_at','=',$november)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->count();

			$laporan_desember = Pemesanan::whereMonth('created_at','=',$desember)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->count();
		}else{

			$laporan_januari = Pemesanan::whereMonth('created_at','=',$januari)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->count();

			$laporan_februari = Pemesanan::whereMonth('created_at','=',$februari)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->count();

			$laporan_maret = Pemesanan::whereMonth('created_at','=',$maret)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->count();

			$laporan_april = Pemesanan::whereMonth('created_at','=',$april)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->count();

			$laporan_mei = Pemesanan::whereMonth('created_at','=',$mei)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->count();

			$laporan_juni = Pemesanan::whereMonth('created_at','=',$juni)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->count();

			$laporan_juli = Pemesanan::whereMonth('created_at','=',$juli)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->count();

			$laporan_agustus = Pemesanan::whereMonth('created_at','=',$agustus)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->count();

			$laporan_september = Pemesanan::whereMonth('created_at','=',$september)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->count();

			$laporan_oktober = Pemesanan::whereMonth('created_at','=',$oktober)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->count();

			$laporan_november = Pemesanan::whereMonth('created_at','=',$november)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->count();

			$laporan_desember = Pemesanan::whereMonth('created_at','=',$desember)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->count();
		}
		
		
		//return $laporan_agustus;	
		return view('kepala-desa.laporan-berkala.laporan-berkala-pengunjung',compact('laporan_januari','laporan_februari','laporan_maret','laporan_april','laporan_mei','laporan_juni','laporan_juli','laporan_agustus','laporan_september','laporan_oktober','laporan_november','laporan_desember','year','cari_tahun'));
	}


	public function laporan_berkala_pemesanan_paket(Request $request){

	//paket wisata
		$paket_terlaris = DB::table('pemesanans')
		->join('pakets', 'pemesanans.paket_id', '=', 'pakets.id')
		->select(DB::raw('paket_id, count(pemesanans.id) as total_orderan'))
		->groupBy('paket_id')
		->where('pemesanans.status_pemesanan', 1)
		->orderBy('total_orderan', 'DESC')
		->get();

		// return $paket_terlaris;
		$nama_paket = [];
		
		foreach ($paket_terlaris as $terlaris => $value) {
			
			$paket = Paket::where('id',$value->paket_id)->first();
			$nama_paket[] = $paket->nama_paket;
		}


		// return $paket_terlaris;

		$month = Carbon::now()->format('m');
		$cari_bulan = $request->cari_bulan;

		
		
		if ($cari_bulan == null) {
			$total_orderan = [];

			foreach ($paket_terlaris as $orderan => $value) {

				$orderan = DB::table('pemesanans')
				->join('pakets', 'pemesanans.paket_id', '=', 'pakets.id')
				->select(DB::raw('paket_id, count(pemesanans.id) as total_orderan'))
				->groupBy('paket_id')
				->where('paket_id', $value->paket_id)
				->where('pemesanans.status_pemesanan', 1)
				->whereMonth('pemesanans.created_at','=',$month)
				->count();

				$total_orderan[] = $orderan;
			}
		}else{
			$total_orderan = [];

			foreach ($paket_terlaris as $orderan => $value) {

				$orderan = DB::table('pemesanans')
				->join('pakets', 'pemesanans.paket_id', '=', 'pakets.id')
				->select(DB::raw('paket_id, count(pemesanans.id) as total_orderan'))
				->groupBy('paket_id')
				->where('paket_id', $value->paket_id)
				->where('pemesanans.status_pemesanan', 1)
				->whereMonth('pemesanans.created_at','=',$cari_bulan)
				->count();

				$total_orderan[] = $orderan;
			}
		}
		


		return view('kepala-desa.laporan-berkala.laporan-berkala-paket-wisata',compact('nama_paket','total_orderan','cari_bulan','month'));
	}



	public function laporan_berkala_pendapatan(Request $request){

		$cari_tahun = $request->cari_tahun;

		$januari = '01';
		$februari = '02';
		$maret = '03';
		$april = '04';
		$mei = '05';
		$juni = '06';
		$juli = '07';
		$agustus = '08';
		$september = '09';
		$oktober = '10';
		$november = '11';
		$desember = '12';

		$year = Carbon::now()->format('Y');
		


		if ($cari_tahun == null) {
			$laporan_januari = Pemesanan::whereMonth('created_at','=',$januari)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_februari = Pemesanan::whereMonth('created_at','=',$februari)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_maret = Pemesanan::whereMonth('created_at','=',$maret)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_april = Pemesanan::whereMonth('created_at','=',$april)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_mei = Pemesanan::whereMonth('created_at','=',$mei)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_juni = Pemesanan::whereMonth('created_at','=',$juni)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_juli = Pemesanan::whereMonth('created_at','=',$juli)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_agustus = Pemesanan::whereMonth('created_at','=',$agustus)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_september = Pemesanan::whereMonth('created_at','=',$september)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_oktober = Pemesanan::whereMonth('created_at','=',$oktober)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_november = Pemesanan::whereMonth('created_at','=',$november)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_desember = Pemesanan::whereMonth('created_at','=',$desember)
			->whereYear('created_at','=',$year)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

		}else{

			$laporan_januari = Pemesanan::whereMonth('created_at','=',$januari)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_februari = Pemesanan::whereMonth('created_at','=',$februari)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_maret = Pemesanan::whereMonth('created_at','=',$maret)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_april = Pemesanan::whereMonth('created_at','=',$april)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_mei = Pemesanan::whereMonth('created_at','=',$mei)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_juni = Pemesanan::whereMonth('created_at','=',$juni)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_juli = Pemesanan::whereMonth('created_at','=',$juli)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_agustus = Pemesanan::whereMonth('created_at','=',$agustus)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_september = Pemesanan::whereMonth('created_at','=',$september)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_oktober = Pemesanan::whereMonth('created_at','=',$oktober)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_november = Pemesanan::whereMonth('created_at','=',$november)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');

			$laporan_desember = Pemesanan::whereMonth('created_at','=',$desember)
			->whereYear('created_at','=',$cari_tahun)
			->where('status_pemesanan',1)
			->sum('jumlah_pembayaran');
		}

		return view('kepala-desa.laporan-berkala.laporan-berkala-pendapatan',compact('laporan_januari','laporan_februari','laporan_maret','laporan_april','laporan_mei','laporan_juni','laporan_juli','laporan_agustus','laporan_september','laporan_oktober','laporan_november','laporan_desember','year','cari_tahun'));
	}




}
