<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public function index(Request $request){

        $search = $request->query('search');
        if ($search) {
            $mahasiswa = DB::table('mahasiswa')
                ->where('nama_lengkap', 'like', "%{$search}%")
                ->orderBy('nama_lengkap')
                ->get();
        } else {
            $mahasiswa = DB::table('mahasiswa')
                ->orderBy('nama_lengkap')
                ->get();
        }

        return view('mahasiswa.index',compact('mahasiswa'));
    }

    public function store(Request $request){
        

        $nim = $request->nim;
        $nama_lengkap = $request->nama_lengkap;
        $asal = $request->asal;
        $no_hp = $request->no_hp;

        // default password
        $password = Hash::make('123');
        
        
        if($request->hasFile('foto_profile')){
            $foto = $nim.".".$request->file('foto_profile')->getClientOriginalExtension();
        }else{
            $foto = null;
        }

        try{
            $data = [
                'nim'=> $nim,
                'nama_lengkap'=> $nama_lengkap,
                'asal'=> $asal,
                'no_hp'=> $no_hp,
                'foto_profile'=> $foto,
                'password'=> $password
            ];
            $simpan = DB::table('mahasiswa')->insert($data);
            if($simpan){
                if($request->hasFile('foto_profile')){
                    $folderPath = "public/uploads/mahasiswa";
                    $request->file('foto_profile')->storeAs($folderPath, $foto);
                }
                return Redirect()->back()->with('success','Data berhasil ditambah');
            }
        }catch(Exception $e){
            // dd($e);
            return Redirect()->back()->with('warning','Data gagal ditambah');
        }
    }

    public function edit (Request $request){

        $nim = $request->nim;
        $mahasiswa = DB::table('mahasiswa')->where('nim',$nim)->first();
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request){

        

        $nim = $request->nim;
        $nama_lengkap = $request->nama_lengkap;
        $asal = $request->asal;
        $no_hp = $request->no_hp;

        // default password
        $password = Hash::make('123');
        $old_foto = $request->old_foto_profile;
        
        if($request->hasFile('foto_profile')){
            $foto = $nim.".".$request->file('foto_profile')->getClientOriginalExtension();
        }else{
            $foto = $old_foto;
        }

        try{
            $data = [
                'nama_lengkap'=> $nama_lengkap,
                'asal'=> $asal,
                'no_hp'=> $no_hp,
                'foto_profile'=> $foto,
                'password'=> $password
            ];
            $update = DB::table('mahasiswa')->where('nim',$nim)->update($data);;
            if($update){
                if($request->hasFile('foto_profile')){
                    $folderPath = "public/uploads/mahasiswa";
                    $folderPathOld = "public/uploads/mahasiswa".$old_foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto_profile')->storeAs($folderPath, $foto);
                }
                return Redirect()->back()->with('success','Data berhasil diupdate');
            }
        }catch(Exception $e){
            // dd($e);
            return Redirect()->back()->with('warning','Data gagal diupdate');
        }
    }

    public function destroy($nim)
    {
        try {
            $mahasiswa = DB::table('mahasiswa')->where('nim', $nim)->first();
            if ($mahasiswa->foto_profile) {
                Storage::delete('public/uploads/mahasiswa/' . $mahasiswa->foto_profile);
            }
            DB::table('mahasiswa')->where('nim', $nim)->delete();
            return Redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (Exception $e) {
            return Redirect()->back()->with('warning', 'Data gagal dihapus');
        }
    }


}
