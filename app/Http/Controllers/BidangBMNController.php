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

class BidangBMNController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function daftarbidang()
    {
        $bidang=DB::table('md_bidang_bmn')
                ->leftjoin('md_golongan_bmn AS t1', 'md_bidang_bmn.id_golongan', '=', 't1.id')
                ->select('md_bidang_bmn.*', 't1.kode AS kode_golongan')
                ->get();

        return view('pages.bidang.daftarbidang', compact('bidang'));
    }

    public function tambahbidang()
    {
        $bidang=DB::table('md_bidang_bmn')->get();
        $golongan=DB::table('md_golongan_bmn')->get();

        return view('pages.bidang.form_tambahbidang',['bidang'=>$bidang, 'golongan'=>$golongan]);
    }

    public function prosestambahbidang(Request $request)
    {
        $validatedData = $request->validate([
          'kode' => 'required',
          'golongan' =>'required',
          'nama' => 'required',
        ]);

        $data = array(
          'id_golongan' => $request->input('golongan'),
          'kode' => $request->input('kode'),
          'nama' => $request->input('nama'),
          'keterangan' => $request->input('keterangan'),
        );

        $insertID = DB::table('md_bidang_bmn')->insertGetId($data);

        return Redirect::to('bidang')->with('message','Berhasil menyimpan data');
    }

    public function ubahbidang($id_bidang)
    {
        $bidang=DB::table('md_bidang_bmn')->where('md_bidang_bmn.id','=',$id_bidang)
                ->leftjoin('md_golongan_bmn AS t1', 'md_bidang_bmn.id_golongan', '=', 't1.id')
                ->select('md_bidang_bmn.*', 't1.kode AS kode_golongan')
                ->first();
        $golongan=DB::table('md_golongan_bmn')->get();

        return view('pages.bidang.form_ubahbidang', ['bidang'=>$bidang, 'golongan'=>$golongan]);
    }

    public function prosesubahbidang(Request $request)
    {
        $data = array(
          'kode' => $request->input('kode'),
          'nama' => $request->input('nama'),
          'keterangan' => $request->input('keterangan'),
        );

        DB::table('md_bidang_bmn')->where('id','=',$request->input('id'))->update($data);
  
        return Redirect::to('bidang')->with('message','Berhasil menyimpan data');
    }

    public function hapusneraca($id_neraca)
    {
        $neraca = DB::table('md_neraca_bmn')->where('id','=',$id_neraca)->delete();

        $antrianpoli = DB::table('md_kelompok_bmn')->where('id_neraca_bmn','=',$id_neraca)->delete();

        return Redirect::to('neraca')->with('message','Berhasil menghapus data');
    }

    public function jsondatagolongan($id_golongan)
    {
        $golongan=DB::table('md_golongan_bmn')->where('id','=',$id_golongan)->first();

        $hasil = array(
            "kode_golongan" => $golongan->kode,
        );

        return json_encode($hasil);
    }

}
