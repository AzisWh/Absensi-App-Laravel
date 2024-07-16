<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{
    public function index(){

        $today = date('Y-m-d');
        $bulanini = date('m') * 1; 
        $tahunini = date('Y'); //2024
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $absentoday = DB::table('presensi')
        ->where('nim',$nim)
        ->where('tanggal_presensi',$today)
        ->first();
        $historyabsen = DB::table('presensi')
        ->where('nim',$nim)
        ->whereRaw('MONTH(tanggal_presensi)="'.$bulanini.'"')
        ->whereRaw('YEAR(tanggal_presensi)="'.$tahunini.'"')
        ->orderBy('tanggal_presensi')
        ->get();

        // dd($historyabsen);
        //hitung berapa x absen pada bulan aktif per bulan
        $rekapabsen = DB::table('presensi')
        ->selectRaw('COUNT(nim) as jmlhadir, SUM(IF(jam_in > "11:40",1,0)) as jmlterlambat')
        ->where('nim',$nim)
        ->whereRaw('MONTH(tanggal_presensi)="'.$bulanini.'"')
        ->whereRaw('YEAR(tanggal_presensi)="'.$tahunini.'"')
        ->first();
        // dd($rekapabsen);
        $nama = Auth::guard('mahasiswa')->user()->nama_lengkap;
        $asal = Auth::guard('mahasiswa')->user()->asal;

        $dataizin = DB::table('ijin')
        ->selectRaw('SUM(IF(status = "1", 1,0)) as jmlizin,
        SUM(IF(status = "2", 1,0)) as jmlsakit')
        ->where('nim',$nim)
        ->whereRaw('MONTH(tanggal_izin)="'.$bulanini.'"')
        ->whereRaw('YEAR(tanggal_izin)="'.$tahunini.'"')
        ->where('status_acc', 1)
        ->first();
        

        $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Desember"];

        return view('dashboard.index', compact('absentoday','historyabsen','nama','asal','namabulan','bulanini','tahunini'
                    ,'rekapabsen', 'dataizin'));
    }

    public function admindashboard() {

        $todayDate = date("Y-m-d");
        $rekapabsen = DB::table('presensi')
        ->selectRaw('COUNT(nim) as jmlhadir, SUM(IF(jam_in > "08:00",1,0)) as jmlterlambat')
        ->where('tanggal_presensi',$todayDate)
        ->first();

        $dataizin = DB::table('ijin')
        ->selectRaw('SUM(IF(status = "1", 1,0)) as jmlizin,
        SUM(IF(status = "2", 1,0)) as jmlsakit')
        ->where('tanggal_izin',$todayDate)
        ->where('status_acc', 1)
        ->first();

        return view('dashboard.admindashboard', compact('rekapabsen','dataizin'));
    }


}
