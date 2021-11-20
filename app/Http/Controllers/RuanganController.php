<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use DB;
Use Redirect;
use Auth;
use DateTime;
use DateInterval;
use DatePeriod;

class RuanganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function daftarruangan()
    {
        $ruangan=DB::table('md_ruangan')->get();
        return view('pages.ruangan.daftarruangan', compact('ruangan'));
    }

    public function tambahruangan()
    {
        $ruangan=DB::table('md_ruangan')->get();

        return view('pages.ruangan.form_tambahruangan',['ruangan'=>$ruangan]);
    }

    public function prosestambahruangan(Request $request)
    {
        $validatedData = $request->validate([
          'kode' => 'required|string|unique:md_ruangan,kode',
          'nama' => 'required',
          'penanggungjawab' => 'required',
        ]);

        $data = array(
          'kode' => $request->input('kode'),
          'nama' => $request->input('nama'),
          'penanggungjawab' => $request->input('penanggungjawab'),
          'keterangan' => $request->input('keterangan'),
        );

        $insertID = DB::table('md_ruangan')->insertGetId($data);

        return Redirect::to('ruangan')->with('message','Berhasil menyimpan data');
    }

    public function ubahruangan($id_ruangan)
    {
        $ruangan=DB::table('md_ruangan')->where('id','=',$id_ruangan)->first();

        return view('pages.ruangan.form_ubahruangan', ['ruangan'=>$ruangan]);
    }

    public function prosesubahruangan(Request $request)
    {        
        $data = array(
          'kode' => $request->input('kode'),
          'nama' => $request->input('nama'),
          'penanggungjawab' => $request->input('penanggungjawab'),
          'keterangan' => $request->input('keterangan'),
        );

        DB::table('md_ruangan')->where('id','=',$request->input('id'))->update($data);
  
        return Redirect::to('ruangan')->with('message','Berhasil menyimpan data');
    }

    public function hapusruangan($id_ruangan)
    {
        $ruangan = DB::table('md_ruangan')->where('id','=',$id_ruangan)->delete();

        return Redirect::to('ruangan')->with('message','Berhasil menghapus data');
    }
}
