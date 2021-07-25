<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pemesanan;



class GuideController extends Controller
{
    public function index(){


		return view('guide.index');
	}

	public function guide_jadwal(){
		
		$guide_jadwal = Pemesanan::where('status_pemesanan',1)->where('created_at','>', date('y-m-d'))->get();
		
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
}
