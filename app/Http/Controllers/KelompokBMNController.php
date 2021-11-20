<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DB;
Use Redirect;
use Auth;
use DateTime;
use DateInterval;
use DatePeriod;

class KelompokBMNController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function daftarkelompokbmn()
    {
        $kelompokbmn=DB::table('md_kelompok_bmn')
                ->leftjoin('md_bidang_bmn AS t1', 'md_kelompok_bmn.id_bidang', '=', 't1.id')
                ->leftjoin('md_golongan_bmn AS t2', 't1.id_golongan', '=', 't2.id')
                ->select('md_kelompok_bmn.*', 't1.kode AS kode_bidang', 't2.kode AS kode_golongan')
                ->get();

        return view('pages.kelompokbmn.daftarkelompokbmn', compact('kelompokbmn'));
    }

    public function tambahkelompokbmn()
    {
        $kelompokbmn=DB::table('md_kelompok_bmn')->get();
        $bidang=DB::table('md_bidang_bmn')       
                ->leftjoin('md_golongan_bmn AS t1', 'md_bidang_bmn.id_golongan', '=', 't1.id')
                ->select('md_bidang_bmn.*', 't1.kode AS kode_golongan')
                ->get();

        return view('pages.kelompokbmn.form_tambahkelompokbmn',['kelompokbmn'=>$kelompokbmn, 'bidang'=>$bidang]);
    }

    public function prosestambahkelompokbmn(Request $request)
    {
        $validatedData = $request->validate([
          'kode' => 'required',
          'nama' => 'required',
          'bidang' => 'required',
        ]);

        $data = array(
          'kode' => $request->input('kode'),
          'nama' => $request->input('nama'),
          'id_bidang' => $request->input('bidang'),
          'keterangan' => $request->input('keterangan'),
        );

        $insertID = DB::table('md_kelompok_bmn')->insertGetId($data);

        return Redirect::to('kelompokbmn')->with('message','Berhasil menyimpan data');
    }

    public function ubahkelompokbmn($id_kelompokbmn)
    {
        $kelompokbmn=DB::table('md_kelompok_bmn')->where('md_kelompok_bmn.id','=',$id_kelompokbmn)
                ->leftjoin('md_bidang_bmn AS t1', 'md_kelompok_bmn.id_bidang', '=', 't1.id')
                ->leftjoin('md_golongan_bmn AS t2', 't1.id_golongan', '=', 't2.id')
                ->select('md_kelompok_bmn.*', 't1.kode AS kode_bidang', 't2.kode AS kode_golongan')
                ->first();

        $bidang=DB::table('md_bidang_bmn')       
            ->leftjoin('md_golongan_bmn AS t1', 'md_bidang_bmn.id_golongan', '=', 't1.id')
            ->select('md_bidang_bmn.*', 't1.kode AS kode_golongan')
            ->get();

        return view('pages.kelompokbmn.form_ubahkelompokbmn', ['kelompokbmn'=>$kelompokbmn, 'bidang'=>$bidang]);
    }

    public function prosesubahkelompokbmn(Request $request)
    {
        $data = array(
          'kode' => $request->input('kode'),
          'nama' => $request->input('nama'),
          'id_bidang' => $request->input('bidang'),
          'keterangan' => $request->input('keterangan'),
        );

        DB::table('md_kelompok_bmn')->where('id','=',$request->input('id'))->update($data);
  
        return Redirect::to('kelompokbmn')->with('message','Berhasil menyimpan data');
    }

    public function hapuskelompokbmn($id_kelompokbmn)
    {
        $ruangan = DB::table('md_kelompok_bmn')->where('id','=',$id_kelompokbmn)->delete();

        return Redirect::to('kelompokbmn')->with('message','Berhasil menghapus data');
    }

    public function jsondatabidang($id_bidang)
    {
        $bidang=DB::table('md_bidang_bmn')->where('md_bidang_bmn.id','=',$id_bidang)  
            ->leftjoin('md_golongan_bmn AS t1', 'md_bidang_bmn.id_golongan', '=', 't1.id')
            ->select('md_bidang_bmn.*', 't1.kode AS kode_golongan')
            ->first(); 

        $hasil = array(
            "kode_golongan" => $bidang->kode_golongan,
            "kode_bidang" => $bidang->kode,
        );

        return json_encode($hasil);
    }
}
