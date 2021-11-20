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


class SubsubkelompokBMNController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function daftarsubsubkelompokbmn()
    {
        $subsubkelompokbmn=DB::table('md_subsubkelompok_bmn')
            ->leftjoin('md_subkelompok_bmn AS t1', 'md_subsubkelompok_bmn.id_subkelompok_bmn', '=', 't1.id')
            ->leftjoin('md_kelompok_bmn AS t2', 't1.id_kelompok_bmn', '=', 't2.id')
            ->leftjoin('md_bidang_bmn AS t3', 't2.id_bidang', '=', 't3.id')
            ->leftjoin('md_golongan_bmn AS t4', 't3.id_golongan', '=', 't4.id')
            ->select('md_subsubkelompok_bmn.*', 't1.kode AS kode_subkelompok', 't2.kode AS kode_kelompok', 't3.kode AS kode_bidang', 't4.kode AS kode_golongan')
            ->get();

        return view('pages.subsubkelompokbmn.daftarsubsubkelompokbmn', compact('subsubkelompokbmn'));
    }

    public function tambahsubsubkelompokbmn()
    {
        $subsubkelompokbmn=DB::table('md_subsubkelompok_bmn')->get();
        $subkelompokbmn=DB::table('md_subkelompok_bmn')
            ->leftjoin('md_kelompok_bmn AS t1', 'md_subkelompok_bmn.id_kelompok_bmn', '=', 't1.id')
            ->leftjoin('md_bidang_bmn AS t2', 't1.id_bidang', '=', 't2.id')
            ->leftjoin('md_golongan_bmn AS t3', 't2.id_golongan', '=', 't3.id')
            ->select('md_subkelompok_bmn.*', 't1.kode AS kode_kelompok', 't2.kode AS kode_bidang', 't3.kode AS kode_golongan')
            ->get();

        return view('pages.subsubkelompokbmn.form_tambahsubsubkelompokbmn',['subsubkelompokbmn'=>$subsubkelompokbmn, 'subkelompokbmn'=>$subkelompokbmn]);
    }

    public function prosestambahsubsubkelompokbmn(Request $request)
    {
        $validatedData = $request->validate([
          'kode' => 'required',
          'nama' => 'required',
          'satuan' => 'required',
        ]);

        $data = array(
          'kode' => $request->input('kode'),
          'nama' => $request->input('nama'),
          'satuan' => $request->input('satuan'),
          'id_subkelompok_bmn' => $request->input('subkelompokbmn'),
          'keterangan' => $request->input('keterangan'),
        );

        $insertID = DB::table('md_subsubkelompok_bmn')->insertGetId($data);

        return Redirect::to('subsubkelompokbmn')->with('message','Berhasil menyimpan data');
    }

    public function ubahsubsubkelompokbmn($id_subsubkelompokbmn)
    {
        $subsubkelompokbmn=DB::table('md_subsubkelompok_bmn')->where('md_subsubkelompok_bmn.id','=',$id_subsubkelompokbmn)
            ->leftjoin('md_subkelompok_bmn AS t1', 'md_subsubkelompok_bmn.id_subkelompok_bmn', '=', 't1.id')
            ->leftjoin('md_kelompok_bmn AS t2', 't1.id_kelompok_bmn', '=', 't2.id')
            ->leftjoin('md_bidang_bmn AS t3', 't2.id_bidang', '=', 't3.id')
            ->leftjoin('md_golongan_bmn AS t4', 't3.id_golongan', '=', 't4.id')
            ->select('md_subsubkelompok_bmn.*', 't1.kode AS kode_subkelompok', 't2.kode AS kode_kelompok','t3.kode AS kode_bidang', 't4.kode AS kode_golongan')
            ->first();

        $subkelompokbmn=DB::table('md_subkelompok_bmn')
            ->leftjoin('md_kelompok_bmn AS t1', 'md_subkelompok_bmn.id_kelompok_bmn', '=', 't1.id')
            ->leftjoin('md_bidang_bmn AS t2', 't1.id_bidang', '=', 't2.id')
            ->leftjoin('md_golongan_bmn AS t3', 't2.id_golongan', '=', 't3.id')
            ->select('md_subkelompok_bmn.*', 't1.kode AS kode_kelompok', 't2.kode AS kode_bidang', 't3.kode AS kode_golongan')
            ->get();

        return view('pages.subsubkelompokbmn.form_ubahsubsubkelompokbmn', ['subsubkelompokbmn'=>$subsubkelompokbmn, 'subkelompokbmn'=>$subkelompokbmn]);
    }

    public function prosesubahsubsubkelompokbmn(Request $request)
    {
        $data = array(
          'kode' => $request->input('kode'),
          'nama' => $request->input('nama'),
          'satuan' => $request->input('satuan'),
          'id_subkelompok_bmn' => $request->input('subkelompokbmn'),
          'keterangan' => $request->input('keterangan'),
        );

        DB::table('md_subsubkelompok_bmn')->where('id','=',$request->input('id'))->update($data);
  
        return Redirect::to('subsubkelompokbmn')->with('message','Berhasil menyimpan data');
    }

    public function hapussubsubkelompokbmn($id_subsubkelompokbmn)
    {
        $subsubkelompokbmn = DB::table('md_subsubkelompok_bmn')->where('id','=',$id_subsubkelompokbmn)->delete();

        return Redirect::to('subsubkelompokbmn')->with('message','Berhasil menghapus data');
    }

    public function jsondatasubkelompok($id_subkelompok)
    {
        $subkelompokbmn=DB::table('md_subkelompok_bmn')->where('md_subkelompok_bmn.id','=',$id_subkelompok)
            ->leftjoin('md_kelompok_bmn AS t1', 'md_subkelompok_bmn.id_kelompok_bmn', '=', 't1.id')
            ->leftjoin('md_bidang_bmn AS t2', 't1.id_bidang', '=', 't2.id')
            ->leftjoin('md_golongan_bmn AS t3', 't2.id_golongan', '=', 't3.id')
            ->select('md_subkelompok_bmn.*', 't1.kode AS kode_kelompok', 't2.kode AS kode_bidang', 't3.kode AS kode_golongan')
            ->first(); 

        $hasil = array(
            "kode_golongan" => $subkelompokbmn->kode_golongan,
            "kode_bidang" => $subkelompokbmn->kode_bidang,
            "kode_kelompok" => $subkelompokbmn->kode_kelompok,
            "kode_subkelompok" => $subkelompokbmn->kode,
        );

        return json_encode($hasil);
    }
}
