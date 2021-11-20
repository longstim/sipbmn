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

class BMNController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except("detailbmn");
    }

    public function daftarbmn()
    {
       $bmn=DB::table('md_bmn')
            ->leftjoin('md_subsubkelompok_bmn AS t1', 'md_bmn.id_subsubkelompok_bmn', '=', 't1.id')
            ->leftjoin('md_ruangan AS t2', 'md_bmn.id_ruangan', '=', 't2.id')
            ->select('md_bmn.*', 't1.nama AS nama_aset', 't1.satuan AS satuan', 't2.kode AS kode_ruangan')
            ->get(); 

        return view('pages.bmn.daftarbmn', compact('bmn'));
    }

    public function tambahbmn()
    {
        $bmn=DB::table('md_bmn')->get();

        $aset=DB::table('md_subsubkelompok_bmn')
             ->leftjoin('md_subkelompok_bmn AS t1', 'md_subsubkelompok_bmn.id_subkelompok_bmn', '=', 't1.id')
            ->leftjoin('md_kelompok_bmn AS t2', 't1.id_kelompok_bmn', '=', 't2.id')
            ->leftjoin('md_bidang_bmn AS t3', 't2.id_bidang', '=', 't3.id')
            ->leftjoin('md_golongan_bmn AS t4', 't3.id_golongan', '=', 't4.id')
            ->select('md_subsubkelompok_bmn.*', 't1.kode AS kode_subkelompok', 't2.kode AS kode_kelompok', 't3.kode AS kode_bidang', 't4.kode AS kode_golongan')
            ->get();

        $ruangan=DB::table('md_ruangan')->get();
                 
        return view('pages.bmn.form_tambahbmn',['bmn'=>$bmn, 'aset'=>$aset,'ruangan'=>$ruangan]);
    }

    public function prosestambahbmn(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $newTanggal = Carbon::createFromFormat('d/m/Y', $tanggal)->format('Y-m-d');

        /*$validatedData = $request->validate([
          'id_subsubkelompok_bmn' => 'required',
          'merk' => 'required',
          'harga' => 'required',
          'tanggal' => 'required',
        ]);*/

         $asetdb=DB::table('md_subsubkelompok_bmn')->where('md_subsubkelompok_bmn.id','=',$request->input('aset'))
            ->leftjoin('md_subkelompok_bmn AS t1', 'md_subsubkelompok_bmn.id_subkelompok_bmn', '=', 't1.id')
            ->leftjoin('md_kelompok_bmn AS t2', 't1.id_kelompok_bmn', '=', 't2.id')
            ->leftjoin('md_bidang_bmn AS t3', 't2.id_bidang', '=', 't3.id')
            ->leftjoin('md_golongan_bmn AS t4', 't3.id_golongan', '=', 't4.id')
            ->select('md_subsubkelompok_bmn.*', 't1.kode AS kode_subkelompok', 't2.kode AS kode_kelompok', 't3.kode AS kode_bidang', 't4.kode AS kode_golongan')
            ->first();

        $kode_aset = $asetdb->kode_golongan.".".$asetdb->kode_bidang.".".$asetdb->kode_kelompok.".".$asetdb->kode_subkelompok.".".$asetdb->kode;

        $jumlah = $request->input('jumlah');
        $max_nup = DB::table('md_bmn')->where('id_subsubkelompok_bmn','=',$request->input('aset'))->max('nup');

        //var_dump($max_nup);
        for($i=0; $i<$jumlah; $i++)
        {
            $data = array(
              'id_subsubkelompok_bmn' => $request->input('aset'),
              'id_ruangan' => $request->input('ruangan'),
              'kode_aset' => $kode_aset,
              'nup' => ++$max_nup,
              'merk' => $request->input('merk'),
              'harga' => $request->input('harga'),
              'tanggal' => $newTanggal,
              'kondisi' => $request->input('kondisi'),
              'keterangan' => $request->input('keterangan'),
            );

            $insertID = DB::table('md_bmn')->insertGetId($data);
        }

        return Redirect::to('bmn')->with('message','Berhasil menyimpan data');
    }

    public function ubahbmn($id_bmn)
    {
        $bmn=DB::table('md_bmn')->where('id','=',$id_bmn)->first();

        $aset=DB::table('md_subsubkelompok_bmn')
            ->leftjoin('md_subkelompok_bmn AS t1', 'md_subsubkelompok_bmn.id_subkelompok_bmn', '=', 't1.id')
            ->leftjoin('md_kelompok_bmn AS t2', 't1.id_kelompok_bmn', '=', 't2.id')
            ->leftjoin('md_bidang_bmn AS t3', 't2.id_bidang', '=', 't3.id')
            ->leftjoin('md_golongan_bmn AS t4', 't3.id_golongan', '=', 't4.id')
            ->select('md_subsubkelompok_bmn.*', 't1.kode AS kode_subkelompok', 't2.kode AS kode_kelompok', 't3.kode AS kode_bidang', 't4.kode AS kode_golongan')->get();

        $ruangan=DB::table('md_ruangan')->get();
                 
        return view('pages.bmn.form_ubahbmn',['bmn'=>$bmn, 'aset'=>$aset,'ruangan'=>$ruangan]);
    }

    public function prosesubahbmn(Request $request)
    {        
        $tanggal = $request->input('tanggal');
        $newTanggal = Carbon::createFromFormat('d/m/Y', $tanggal)->format('Y-m-d');
        
        $namafile="";

        $rowbmn=DB::table('md_bmn')->where('id','=',$request->input('id'))->first();

        if(!empty($rowbmn))
        {
            $namafile = $rowbmn->foto;
        }

        if($request->hasFile('foto'))
        {
             $foto = $request->file('foto');
             $namafile = $foto->getClientOriginalName();
        }      

        $asetdb=DB::table('md_subsubkelompok_bmn')->where('md_subsubkelompok_bmn.id','=',$request->input('aset'))
            ->leftjoin('md_subkelompok_bmn AS t1', 'md_subsubkelompok_bmn.id_subkelompok_bmn', '=', 't1.id')
            ->leftjoin('md_kelompok_bmn AS t2', 't1.id_kelompok_bmn', '=', 't2.id')
            ->leftjoin('md_bidang_bmn AS t3', 't2.id_bidang', '=', 't3.id')
            ->leftjoin('md_golongan_bmn AS t4', 't3.id_golongan', '=', 't4.id')
            ->select('md_subsubkelompok_bmn.*', 't1.kode AS kode_subkelompok', 't2.kode AS kode_kelompok', 't3.kode AS kode_bidang', 't4.kode AS kode_golongan')
            ->first();

        $kode_aset = $asetdb->kode_golongan.".".$asetdb->kode_bidang.".".$asetdb->kode_kelompok.".".$asetdb->kode_subkelompok.".".$asetdb->kode;

        $data = array(
          'id_subsubkelompok_bmn' => $request->input('aset'),
          'id_ruangan' => $request->input('ruangan'),
          'kode_aset' => $kode_aset,
          'merk' => $request->input('merk'),
          'harga' => $request->input('harga'),
          'tanggal' => $newTanggal,
          'kondisi' => $request->input('kondisi'),
          'keterangan' => $request->input('keterangan'),
          'foto' => $namafile,
        );

        if($request->hasFile('foto'))
        {
            $tujuan_upload = public_path(). '/image/bmn/';
            $foto->move($tujuan_upload, $foto->getClientOriginalName());
        }

        DB::table('md_bmn')->where('id','=',$request->input('id'))->update($data);
  
        return Redirect::to('bmn')->with('message','Berhasil menyimpan data');
    }

    public function hapusbmn($id_bmn)
    {
        $bmn = DB::table('md_bmn')->where('id','=',$id_bmn)->delete();

        return Redirect::to('bmn')->with('message','Berhasil menghapus data');
    }

    public function generateqrcode($id_bmn)
    {
        $bmn=DB::table('md_bmn')->where('id','=',$id_bmn)->first();

        $link = 'https://baristandmedan.kemenperin.go.id/sipbmn/public/detailbmn/';

        $qrcode = QrCode::size(250)
                ->generate($link.$bmn->id);

        return view('pages.bmn.qrcodebmn',compact('qrcode','bmn'));
    }

    public function detailbmn($id_bmn)
    {
      $bmn=DB::table('md_bmn')->where('md_bmn.id','=',$id_bmn)
                ->leftjoin('md_subsubkelompok_bmn AS t1', 'md_bmn.id_subsubkelompok_bmn', '=', 't1.id')
                ->leftjoin('md_ruangan AS t2', 'md_bmn.id_ruangan', '=', 't2.id')
                ->select('md_bmn.*', 't1.nama AS nama_aset', 't1.satuan AS satuan', 't2.kode AS kode_ruangan', 't2.nama AS nama_ruangan')
                ->first();

      return view('pages.bmn.detailbmn', ['bmn'=>$bmn]);
    }

    public function statistik()
    {
        $bmn=DB::select('SELECT id_subsubkelompok_bmn, t1.*, COUNT(id_subsubkelompok_bmn) AS JlhBMN, t2.kode AS kode_subkelompok, t3.kode AS kode_kelompok, t4.kode AS kode_bidang, t5.kode AS kode_golongan FROM md_bmn 
            LEFT JOIN md_subsubkelompok_bmn AS t1 ON md_bmn.id_subsubkelompok_bmn = t1.id
            LEFT JOIN md_subkelompok_bmn AS t2 ON t1.id_subkelompok_bmn = t2.id
            LEFT JOIN md_kelompok_bmn AS t3 ON t2.id_kelompok_bmn = t3.id
            LEFT JOIN md_bidang_bmn AS t4 ON t3.id_bidang = t4.id
            LEFT JOIN md_golongan_bmn AS t5 ON t4.id_golongan = t5.id
            GROUP BY id_subsubkelompok_bmn');

        return view('pages.bmn.statistikbmn', compact('bmn'));
    }

    public function daftarperbmn($id_subsubkelompokbmn)
    {
             $bmn=DB::table('md_bmn')->where('md_bmn.id_subsubkelompok_bmn','=',$id_subsubkelompokbmn)
                ->leftjoin('md_subsubkelompok_bmn AS t1', 'md_bmn.id_subsubkelompok_bmn', '=', 't1.id')
                ->leftjoin('md_ruangan AS t2', 'md_bmn.id_ruangan', '=', 't2.id')
                ->select('md_bmn.*', 't1.nama AS nama_aset', 't1.satuan AS satuan', 't2.kode AS kode_ruangan', 't2.nama AS nama_ruangan')
                ->get();

        return view('pages.bmn.daftarperbmn', compact('bmn'));
    }
}
