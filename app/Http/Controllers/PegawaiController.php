<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\List_;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PegawaiController extends Controller
{   
    public function index()
    {
        $hasil = DB::table('pegawai')->distinct('id')->count('id');
         
        return view('isi', ['data' => $hasil]);
    }
    public function list()
    {
          // mengambil data dari table pegawai
        
        $hasil = DB::table('pegawai')->paginate(10);
        return view('data-pegawai', ['data' => $hasil]);
    }
    public function simpan(Request $req)
    {
        DB::insert(
            'insert into pegawai (nip,nama, alamat) values (?, ?, ?)',
            [$req->nip, $req->nama, $req->alamat]
        );
        $hasil = DB::table('pegawai')->paginate(10);
        return view('data-pegawai', ['data' => $hasil]);
    }
    public function hapus($req)
    {
        Log::info('proses hapus dengan id=' . $req);
        DB::delete('delete from pegawai where id = ?', [$req]);

        $hasil = DB::table('pegawai')->paginate(10);
        return view('data-pegawai', ['data' => $hasil]);
    }
    public function ubah($req)
    {
        $hasil = DB::select('select * from pegawai where id = ?', [$req]);
        return view('ubah-data', ['data' => $hasil]);
    }
    public function rubah(Request $req)
    {
        
        Log::info($req);
        DB::update(
            'update pegawai set ' .
                'nip=?, ' .
                'nama=?, ' .
                'alamat=? where id=? ',
            [
                $req->nip,
                $req->nama,
                $req->alamat,
                $req->id
            ]
        );
        $hasil = DB::table('pegawai')->paginate(10);
        return view('data-pegawai', ['data' => $hasil]);
    }
    public function detail($req)
    {   //DB::table('pegawai')->where('id', '$req')->paginate(10);
    //$hasil = DB::table('pegawai')->where('id', '$req')->paginate(10);
        $hasil = DB::select('select * from pegawai where id = ?', [$req]);


        return view('detail', ['data' => $hasil]);
    }

    public function cari(Request $request)
    {
        // menangkap data pencarian
        $cari = $request->cari;
 
            // mengambil data dari table pegawai sesuai pencarian data
        $hasil = DB::table('pegawai')
        ->where('nama','like',"%".$cari."%")
        ->paginate(10);
 
            // mengirim data pegawai ke view index
        return view('data-pegawai', ['data' => $hasil]);
 
    }
}
