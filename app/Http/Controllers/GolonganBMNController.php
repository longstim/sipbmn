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

class GolonganBMNController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function daftargolongan()
    {
        $golongan=DB::table('md_golongan_bmn')->get();
        return view('pages.golongan.daftargolongan', compact('golongan'));
    }

    public function tambahgolongan()
    {
        $golongan=DB::table('md_golongan_bmn')->get();

        return view('pages.golongan.form_tambahgolongan',['golongan'=>$golongan]);
    }

    public function prosestambahgolongan(Request $request)
    {
        $validatedData = $request->validate([
          'kode' => 'required|string|unique:md_golongan_bmn,kode',
          'nama' => 'required',
        ]);

        $data = array(
          'kode' => $request->input('kode'),
          'nama' => $request->input('nama'),
          'keterangan' => $request->input('keterangan'),
        );

        $insertID = DB::table('md_golongan_bmn')->insertGetId($data);

        return Redirect::to('golongan')->with('message','Berhasil menyimpan data');
    }

    public function ubahgolongan($id_golongan)
    {
        $golongan=DB::table('md_golongan_bmn')->where('id','=',$id_golongan)->first();

        return view('pages.golongan.form_ubahgolongan', ['golongan'=>$golongan]);
    }

    public function prosesubahgolongan(Request $request)
    {
        $data = array(
          'kode' => $request->input('kode'),
          'nama' => $request->input('nama'),
          'keterangan' => $request->input('keterangan'),
        );

        DB::table('md_golongan_bmn')->where('id','=',$request->input('id'))->update($data);
  
        return Redirect::to('golongan')->with('message','Berhasil menyimpan data');
    }

    public function hapusgolongan($id_golongan)
    {
        $golongan = DB::table('md_golongan_bmn')->where('id','=',$id_golongan)->delete();

        return Redirect::to('golongan')->with('message','Berhasil menghapus data');
    }
}
