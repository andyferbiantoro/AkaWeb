<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paket;
use App\Pemesanan;
use App\Pembayaran;
use App\User;
use App\Galeri;
use Auth;
use DB;
use Illuminate\Support\Str;

class PengunjungController extends Controller
{

	

	public function landingpage(){
		$paket_wisata = Paket::orderBy('id','DESC')->where('id', '>', '1')->where('status_paket',1)->get();
		$data_galeri = Galeri::orderBy('id','DESC')->get();

		return view('landingpage-pengunjung.index',compact('paket_wisata','data_galeri'));
	}


	public function index(){
		
		$data_pemesanan = DB::table('pemesanans')
		->join('pakets', 'pemesanans.paket_id', '=', 'pakets.id')
		->select('pemesanans.*','pakets.nama_paket')
		->where('user_id',Auth::user()->id)
		->where('status_pemesanan',0)
		->orderBy('pemesanans.id','DESC')
		->get();


		return view('pengunjung.index',compact('data_pemesanan'));
	}

	public function tambah_pesanan(){
		$data_paket=Paket::orderBy('id','DESC')->where('id', '>', '1')->where('status_paket',1)->get();

		return view('pengunjung.tambah-pesanan',compact('data_paket'));
	}



	public function proses_tambah_pesanan(Request $request){

		
		$data_pesananan = new Pemesanan();
		

		$data_pesananan->user_id = $request->input('user_id');
		$data_pesananan->paket_id  = $request->input('paket_id');
		$data_pesananan->kategori_pemesanan = $request->input('kategori_pemesanan');
		$data_pesananan->tanggal_berkunjung = $request->input('tanggal_berkunjung');
		$data_pesananan->pukul_kunjungan = $request->input('pukul_kunjungan');
		$data_pesananan->jumlah_pengunjung = $request->input('jumlah_pengunjung');
		$data_pesananan->jumlah_pembayaran = $request->input('jumlah_pembayaran');
		$data_pesananan->status_pemesanan = 0;
		$data_pesananan->nomor_pemesanan =  rand(100, 999);
		$data_pesananan->jenis_pembayaran = $request->input('jenis_pembayaran');
		

		$data_pesananan->save();

		return redirect('/pengunjung-data_pemesanan')->with('success', 'Pemesanan Baru Berhasil Ditambahkan');
	}

	public function batalkan_pesanan($id){

		$data_pemesanan = Pemesanan::findOrFail($id);
		$data_pemesanan->delete();

		return redirect()->back()->with('success', 'Data Pemesanan Berhasil Dibatalkan');
	}
	

	public function data_pembayaran(){
		//ambil data pemesanan yang sudah dibayar
		$data_pemesanan_lunas = DB::table('pemesanans')
		->join('pakets', 'pemesanans.paket_id', '=', 'pakets.id')
		->select('pemesanans.*','pakets.nama_paket')
		->where('user_id',Auth::user()->id)
		->where('status_pemesanan',1)
		->orderBy('pemesanans.id','DESC')
		->get();


		return view('pengunjung.pembayaran-pengunjung',compact('data_pemesanan_lunas'));
	}


	public function tambah_pembayaran(){
		//ambil data paket yang belum dibayar
		$data_paket = DB::table('pemesanans')
		->join('pakets', 'pemesanans.paket_id', '=', 'pakets.id')
		->select('pemesanans.*','pakets.nama_paket')
		->where('user_id',Auth::user()->id)
		->where('status_pemesanan',0)
		->orderBy('pemesanans.id','DESC')
		->get();

		return view('pengunjung.tambah-pembayaran',compact('data_paket'));
	}


	public function proses_tambah_pembayaran(Request $request){

		
		$data_pembayaran = new Pembayaran();
		

		$data_pembayaran->pemesanan_id = $request->input('pemesanan_id');
		$data_pembayaran->tanggal_pembayaran  = $request->input('tanggal_pembayaran');
		$data_pembayaran->metode_pembayaran = $request->input('metode_pembayaran');
		$data_pembayaran->status_pembayaran = 1;
		
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

       	$guide_id = User::where('role_id',3)->pluck('id'); 
       	// dd($guide);
         $this->received(Auth::user()->id);
         $this->received_guide($guide_id);

		return redirect('/pengunjung-data_pembayaran')->with('success', 'Pembayaran  Berhasil Dilakukan');
	}



	public function received($id)
	{
		$pengunjung = User::where('id',Auth::user()->id)->first();
       

        $this->_sendEmail($pengunjung);

	}

	public function received_guide($id)
	{
		
       	$guide = User::where('role_id',3)->get();
       	
        $this->_sendEmailGuide($guide);

	}

	public function _sendEmail($id_user)
	{
		$message = new \App\Mail\OrderShipped($id_user);
		\Mail::to($id_user->email)->send($message);
	}

	public function _sendEmailGuide($id_user)
	{
		
		foreach ($id_user as $key => $value) {

		$message = new \App\Mail\OrderShippedGuide($value);
		\Mail::to($value->email)->send($message);
		}
		
	}

	public function get_paket_wisata($id){

		$paket = Paket::where('id',$id)->first();

		return response()->json([

			'paket' => $paket
		]);
		
	}
}