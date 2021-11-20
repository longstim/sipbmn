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

class SubkelompokBMNController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function daftarsubkelompokbmn()
    {
        $subkelompokbmn=DB::table('md_subkelompok_bmn')
            ->leftjoin('md_kelompok_bmn AS t1', 'md_subkelompok_bmn.id_kelompok_bmn', '=', 't1.id')
            ->leftjoin('md_bidang_bmn AS t2', 't1.id_bidang', '=', 't2.id')
            ->leftjoin('md_golongan_bmn AS t3', 't2.id_golongan', '=', 't3.id')
            ->select('md_subkelompok_bmn.*', 't1.kode AS kode_kelompok','t2.kode AS kode_bidang', 't3.kode AS kode_golongan')
            ->get();

        return view('pages.subkelompokbmn.daftarsubkelompokbmn', compact('subkelompokbmn'));
    }

    public function tambahsubkelompokbmn()
    {
        $subkelompokbmn=DB::table('md_subkelompok_bmn')->get();
        $kelompokbmn=DB::table('md_kelompok_bmn')
            ->leftjoin('md_bidang_bmn AS t2', 'md_kelompok_bmn.id_bidang', '=', 't2.id')
            ->leftjoin('md_golongan_bmn AS t3', 't2.id_golongan', '=', 't3.id')
            ->select('md_kelompok_bmn.*', 't2.kode AS kode_bidang', 't3.kode AS kode_golongan')
            ->get();

        return view('pages.subkelompokbmn.form_tambahsubkelompokbmn',['subkelompokbmn'=>$subkelompokbmn, 'kelompokbmn'=>$kelompokbmn]);
    }

    public function prosestambahsubkelompokbmn(Request $request)
    {
        $validatedData = $request->validate([
          'kode' => 'required',
          'nama' => 'required',
        ]);

        $data = array(
          'kode' => $request->input('kode'),
          'nama' => $request->input('nama'),
          'id_kelompok_bmn' => $request->input('kelompokbmn'),
          'keterangan' => $request->input('keterangan'),
        );

        $insertID = DB::table('md_subkelompok_bmn')->insertGetId($data);

        return Redirect::to('subkelompokbmn')->with('message','Berhasil menyimpan data');
    }

    public function ubahsubkelompokbmn($id_subkelompokbmn)
    {
        $subkelompokbmn=DB::table('md_subkelompok_bmn')->where('md_subkelompok_bmn.id','=',$id_subkelompokbmn)
            ->leftjoin('md_kelompok_bmn AS t1', 'md_subkelompok_bmn.id_kelompok_bmn', '=', 't1.id')
            ->leftjoin('md_bidang_bmn AS t2', 't1.id_bidang', '=', 't2.id')
            ->leftjoin('md_golongan_bmn AS t3', 't2.id_golongan', '=', 't3.id')
            ->select('md_subkelompok_bmn.*', 't1.kode AS kode_kelompok','t2.kode AS kode_bidang', 't3.kode AS kode_golongan')
            ->first();
        
        $kelompokbmn=DB::table('md_kelompok_bmn')
            ->leftjoin('md_bidang_bmn AS t2', 'md_kelompok_bmn.id_bidang', '=', 't2.id')
            ->leftjoin('md_golongan_bmn AS t3', 't2.id_golongan', '=', 't3.id')
            ->select('md_kelompok_bmn.*', 't2.kode AS kode_bidang', 't3.kode AS kode_golongan')
            ->get();

        return view('pages.subkelompokbmn.form_ubahsubkelompokbmn', ['subkelompokbmn'=>$subkelompokbmn, 'kelompokbmn'=>$kelompokbmn]);
    }

    public function prosesubahsubkelompokbmn(Request $request)
    {
        $data = array(
          'kode' => $request->input('kode'),
          'nama' => $request->input('nama'),
          'id_kelompok_bmn' => $request->input('kelompokbmn'),
          'keterangan' => $request->input('keterangan'),
        );

        DB::table('md_subkelompok_bmn')->where('id','=',$request->input('id'))->update($data);
  
        return Redirect::to('subkelompokbmn')->with('message','Berhasil menyimpan data');
    }

    public function hapussubkelompokbmn($id_subkelompokbmn)
    {
        $subkelompokbmn = DB::table('md_subkelompok_bmn')->where('id','=',$id_subkelompokbmn)->delete();

        return Redirect::to('subkelompokbmn')->with('message','Berhasil menghapus data');
    }

    public function jsondatakelompok($id_kelompok)
    {
        $kelompokbmn=DB::table('md_kelompok_bmn')->where('md_kelompok_bmn.id','=',$id_kelompok)
            ->leftjoin('md_bidang_bmn AS t1', 'md_kelompok_bmn.id_bidang', '=', 't1.id')
            ->leftjoin('md_golongan_bmn AS t2', 't1.id_golongan', '=', 't2.id')
            ->select('md_kelompok_bmn.*', 't1.kode AS kode_bidang', 't2.kode AS kode_golongan')
            ->first(); 

        $hasil = array(
            "kode_golongan" => $kelompokbmn->kode_golongan,
            "kode_bidang" => $kelompokbmn->kode_bidang,
            "kode_kelompok" => $kelompokbmn->kode,
        );

        return json_encode($hasil);
    }
}
