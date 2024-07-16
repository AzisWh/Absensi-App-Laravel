<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function create(){

        $today = date('Y-m-d');
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $cek = DB::table('presensi')->where('tanggal_presensi', $today)->where('nim', $nim)->count();
        return view('presensi.create',compact('cek'));
    }

    public function store(Request $request){

        $nim = Auth::guard('mahasiswa')->user()->nim;
        $tanggal_presensi = date('Y-m-d');
        $jam = date('H:i:s');
        // $latitudekantor = -6.982243732547198;
        // $longtitudkantor = 110.41295305719896;
        $latitudekantor = -6.9793956;
        $longtitudkantor = 110.4096816;
        
        $lokasi = $request->lokasi;
        // dd($lokasi);
        $lokasiuser = explode(',',$lokasi);
        $latituduser = $lokasiuser[0];
        $longtituduser = $lokasiuser [1];
        //distance
        $jarak = $this->distance($latitudekantor,$longtitudkantor,$latituduser,$longtituduser);
        $radius = round($jarak['meters']);
        // dd($radius);


        $cek = DB::table('presensi')->where('tanggal_presensi', $tanggal_presensi)->where('nim', $nim)->count();
        if($cek > 0){
            $ket = "out";
        }else{
            $ket = "in";
        }
        $image = $request->image;
        // echo $image;
        // die;
        $folderPath = "public/uploads/absensi/";
        $formatName = $nim."-".$tanggal_presensi."_".$ket;
        $image_parts = explode(";base64,",$image); 
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName.".png";
        $file = $folderPath.$fileName;
       
        
        // cek radius
        if($radius > 20){
            echo "error|Berada diluar radius, anda berada di ".$radius." meter dari kantor|";
        }else{
            // jika sudah absen maka update data pulang
            if($cek > 0){ 
                $data_pulang = [
                
                    'jam_out' => $jam,
                    'foto_out' => $fileName,
                    'lokasi_out' => $lokasi,
                ];
                $update = DB::table('presensi')->where('tanggal_presensi', $tanggal_presensi)->where('nim', $nim)->update($data_pulang);
                if($update){
                    echo "success|Terimakasih, Selamat beristirahat|out";
                    Storage::put($file,$image_base64);
                }
                else{
                    echo "error|Presensi Error|out";
                }
            }else{
                // jika belum absen maka simpan data masuk
                $data = [
                    'nim' => $nim,
                    'tanggal_presensi' => $tanggal_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileName,
                    'lokasi_in' => $lokasi,
                ];
                $simpan = DB::table('presensi')->insert($data);
                if($simpan){
                    echo "success|Terimakasih, Selamat magang|in";
                    Storage::put($file,$image_base64);
                }
                else{
                    echo "error|Presensi Error|in";
                }
            }
        }
       
       
    }

    // distance controller
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editProfile(){

        $nim = Auth::guard('mahasiswa')->user()->nim;
        $mahasiswa = DB::table('mahasiswa')->where('nim',$nim)->first();
        // dd($mahasiswa);

        return view('presensi.editProfile', compact('mahasiswa'));
    }

    public function updateprofile(Request $request){
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);

        //cek foto
        $mahasiswa = DB::table('mahasiswa')->where('nim', $nim)->first();

        if($request->hasFile('foto')){
            $foto = $nim.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = $mahasiswa->foto_profile;
        }

        if(empty($request->password)){
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto_profile' => $foto,
            ];
        }else{
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto_profile' => $foto,
                'password' => $password,
            ];
        }

        $update = DB::table('mahasiswa')->where('nim',$nim)->update($data);
        if($update){
            if($request->hasFile('foto')){
                $folderPath = "public/uploads/mahasiswa";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return redirect()->back()->with('success','Data berhasil diupdate');
        }else{
            // return redirect()->route('presensi.editProfile')->with('error','Data gagal diupdate');
            return redirect()->back()->with('error','Data gagal diupdate');
        }
       
    }

    public function history(){

        $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Desember"];
        return view('presensi.history', compact('namabulan'));
    }

    public function gethistory(Request $request){
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // echo $bulan."dan".$tahun;

        $nim = Auth::guard('mahasiswa')->user()->nim;
        $history = DB::table('presensi')
        ->whereRaw('MONTH(tanggal_presensi)="'.$bulan.'"')
        ->whereRaw('YEAR(tanggal_presensi)="'.$tahun.'"')
        ->where('nim',$nim)->orderBy('tanggal_presensi')->get();

        // dd($history);
        return view('presensi.gethistori', compact('history'));
    }

    public function izin(){
        $nim = Auth::guard('mahasiswa')->user()->nim;

        $dataizin = DB::table('ijin')->where('nim',$nim)->get();
        return view('presensi.izin',compact('dataizin'));
    }

    public function makeizin(){

        
        return view('presensi.makeizin');
    }

    public function storeizin(Request $request){

        $nim = Auth::guard('mahasiswa')->user()->nim;

        $tanggal_izin = $request->tanggal_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'nim' => $nim,
            'tanggal_izin' => $tanggal_izin,
            'status' => $status,
            'keterangan' => $keterangan,
        ];

        $simpan = DB::table('ijin')->insert($data);

        if($simpan){
            return redirect('/presensi/izin')->with('success','Data berhasil disimpan');
        }else{
            return redirect('/presensi/izin')->with('error','Data gagal disimpan');
        }
        
    }

    public function izinkonfir(){

        $izinsakit = DB::table('ijin')
        ->join('mahasiswa','ijin.nim','=','mahasiswa.nim')
        ->orderBy('tanggal_izin','desc')
        ->get();
        return view('presensi.izinkonfir', compact('izinsakit'));
    }

    public function approveizin(Request $request){

        $status_acc = $request->status_acc;
        $id_izinform = $request->id_izinform;
        $update = DB::table('ijin')
        ->where('id',$id_izinform)->update([
            'status_acc' => $status_acc
        ]);
        if($update){
            return Redirect::back()->with('success','data berhasil terupdate');
        }else{
            return Redirect::back()->with('warning','data gagal terupdate');
        }
    }

    public function batalizin($id){
        $update = DB::table('ijin')
        ->where('id',$id)->update([
            'status_acc' => 0
        ]);
        if($update){
            return Redirect::back()->with('success','data berhasil terupdate');
        }else{
            return Redirect::back()->with('warning','data gagal terupdate');

        }
    }

    public function monitoring(){

        return view('presensi.monitoring');
    }

    public function getpresensi(Request $request){

        $tanggal = $request->tanggal;

        $presensi = DB::table('presensi')
        ->select('presensi.*','nama_lengkap','asal')
        ->join('mahasiswa','presensi.nim','=','mahasiswa.nim')
        ->where('tanggal_presensi',$tanggal)->get();

        return view('presensi.getpresensi', compact('presensi'));
    }
}
