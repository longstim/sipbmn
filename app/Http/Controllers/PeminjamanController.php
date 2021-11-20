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

class PeminjamanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except("detailbmn");
    }

    public function daftarpeminjaman()
    {
       $username = Auth::user()->username;

       if(Auth::user()->role == "admin")
       {
          $peminjaman=DB::table('td_peminjaman_detail')
            ->leftjoin('td_peminjaman_header AS t1', 'td_peminjaman_detail.id_peminjaman_header', '=', 't1.id')
            ->leftjoin('users AS t2', 't1.username', '=', 't2.username')
            ->leftjoin('md_subsubkelompok_bmn AS t3', 'td_peminjaman_detail.id_subsubkelompok_bmn','=', 't3.id')
            ->leftjoin('md_subkelompok_bmn AS t4', 't3.id_subkelompok_bmn', '=', 't4.id')
            ->leftjoin('md_kelompok_bmn AS t5', 't4.id_kelompok_bmn', '=', 't5.id')
            ->leftjoin('md_bidang_bmn AS t6', 't5.id_bidang', '=', 't6.id')
            ->leftjoin('md_golongan_bmn AS t7', 't6.id_golongan', '=', 't7.id')
            ->select('td_peminjaman_detail.*', 't1.id AS id_header', 't1.tanggal AS tanggal', 't1.keperluan AS keperluan', 't1.keterangan AS keterangan', 't2.name AS nama_pegawai', 't3.kode AS kode_aset', 't3.nama AS nama_aset', 't4.kode AS kode_subkelompok', 't5.kode AS kode_kelompok', 't6.kode AS kode_bidang', 't7.kode AS kode_golongan')
            ->get(); 
       }
       else
       {
          $peminjaman=DB::table('td_peminjaman_detail')
            ->leftjoin('td_peminjaman_header AS t1', 'td_peminjaman_detail.id_peminjaman_header', '=', 't1.id')
            ->leftjoin('users AS t2', 't1.username', '=', 't2.username')
            ->leftjoin('md_subsubkelompok_bmn AS t3', 'td_peminjaman_detail.id_subsubkelompok_bmn','=', 't3.id')
            ->leftjoin('md_subkelompok_bmn AS t4', 't3.id_subkelompok_bmn', '=', 't4.id')
            ->leftjoin('md_kelompok_bmn AS t5', 't4.id_kelompok_bmn', '=', 't5.id')
            ->leftjoin('md_bidang_bmn AS t6', 't5.id_bidang', '=', 't6.id')
            ->leftjoin('md_golongan_bmn AS t7', 't6.id_golongan', '=', 't7.id')
            ->where('t1.username', '=', $username)
            ->select('td_peminjaman_detail.*', 't1.id AS id_header', 't1.tanggal AS tanggal', 't1.keperluan AS keperluan', 't1.keterangan AS keterangan', 't2.name AS nama_pegawai', 't3.kode AS kode_aset', 't3.nama AS nama_aset', 't4.kode AS kode_subkelompok', 't5.kode AS kode_kelompok', 't6.kode AS kode_bidang', 't7.kode AS kode_golongan')
            ->get(); 

       }

        $newPeminjaman = array();
        $newIndex = 0;

        foreach ($peminjaman as $index => $value) 
        {
            foreach ($value as $key => $data) 
            {
                $newPeminjaman[$newIndex][$key] = $data;
            }

            $status=DB::select('SELECT id_peminjaman_header, status FROM td_status_pinjam WHERE tanggal = (SELECT MAX(tanggal) FROM td_status_pinjam WHERE id_peminjaman_header='.$value->id_header.')');

            $newPeminjaman[$newIndex]['status']="";

            if(!empty($status))
            {
                $newPeminjaman[$newIndex]['status'] = $status[0]->status;
            }
       
            $newIndex = $newIndex + 1;
        }

        return view('pages.peminjaman.daftarpeminjaman', ['peminjaman'=>$newPeminjaman]);
    }

    public function daftarapproval()
    {
        $username = Auth::user()->username;

        if(Auth::user()->role == "admin" || Auth::user()->role == "kasubbagtu")
        {
            $peminjaman=DB::table('td_peminjaman_detail')
                ->leftjoin('td_peminjaman_header AS t1', 'td_peminjaman_detail.id_peminjaman_header', '=', 't1.id')
                ->leftjoin('users AS t2', 't1.username', '=', 't2.username')
                ->leftjoin('md_subsubkelompok_bmn AS t3', 'td_peminjaman_detail.id_subsubkelompok_bmn','=', 't3.id')
                ->leftjoin('md_subkelompok_bmn AS t4', 't3.id_subkelompok_bmn', '=', 't4.id')
                ->leftjoin('md_kelompok_bmn AS t5', 't4.id_kelompok_bmn', '=', 't5.id')
                ->leftjoin('md_bidang_bmn AS t6', 't5.id_bidang', '=', 't6.id')
                ->leftjoin('md_golongan_bmn AS t7', 't6.id_golongan', '=', 't7.id')
                ->leftjoin('md_pegawai AS t8', 't2.username', '=', 't8.nip')
                ->leftjoin('td_pegawai_unitkerja AS t9', 't8.id', '=', 't9.id_pegawai')
                ->select('td_peminjaman_detail.*', 't1.id AS id_header', 't1.tanggal AS tanggal', 't1.keperluan AS keperluan', 't1.keterangan AS keterangan', 't2.name AS nama_pegawai', 't3.kode AS kode_aset', 't3.nama AS nama_aset', 't4.kode AS kode_subkelompok', 't5.kode AS kode_kelompok', 't6.kode AS kode_bidang', 't7.kode AS kode_golongan', 't9.id_unitkerja AS unitkerja')
                ->get(); 
        }
        else
        {
            $unit=DB::table('users')->where('users.username', '=', $username)
                ->leftjoin('md_pegawai AS t1', 'users.username', '=', 't1.nip')
                ->leftjoin('td_pegawai_unitkerja AS t2', 't1.id', '=', 't2.id_pegawai')
                ->select('users.*', 't2.id_unitkerja AS unitkerja')
                ->first();


            $peminjaman=DB::table('td_peminjaman_detail')
                ->where('t9.id_unitkerja', '=', $unit->unitkerja)
                ->leftjoin('td_peminjaman_header AS t1', 'td_peminjaman_detail.id_peminjaman_header', '=', 't1.id')
                ->leftjoin('users AS t2', 't1.username', '=', 't2.username')
                ->leftjoin('md_subsubkelompok_bmn AS t3', 'td_peminjaman_detail.id_subsubkelompok_bmn','=', 't3.id')
                ->leftjoin('md_subkelompok_bmn AS t4', 't3.id_subkelompok_bmn', '=', 't4.id')
                ->leftjoin('md_kelompok_bmn AS t5', 't4.id_kelompok_bmn', '=', 't5.id')
                ->leftjoin('md_bidang_bmn AS t6', 't5.id_bidang', '=', 't6.id')
                ->leftjoin('md_golongan_bmn AS t7', 't6.id_golongan', '=', 't7.id')
                ->leftjoin('md_pegawai AS t8', 't2.username', '=', 't8.nip')
                ->leftjoin('td_pegawai_unitkerja AS t9', 't8.id', '=', 't9.id_pegawai')
                ->select('td_peminjaman_detail.*', 't1.id AS id_header', 't1.tanggal AS tanggal', 't1.keperluan AS keperluan', 't1.keterangan AS keterangan', 't2.name AS nama_pegawai', 't3.kode AS kode_aset', 't3.nama AS nama_aset', 't4.kode AS kode_subkelompok', 't5.kode AS kode_kelompok', 't6.kode AS kode_bidang', 't7.kode AS kode_golongan', 't9.id_unitkerja AS unitkerja')
                ->get(); 
        }

        if(Auth::user()->role == "admin")
        {
            $newPeminjaman = array();
            $newIndex = 0;

            foreach ($peminjaman as $index => $value) 
            {

                foreach ($value as $key => $data) 
                {
                    $newPeminjaman[$newIndex][$key] = $data;
                }

                $status=DB::select('SELECT id_peminjaman_header, status FROM td_status_pinjam WHERE tanggal = (SELECT MAX(tanggal) FROM td_status_pinjam WHERE id_peminjaman_header='.$value->id_header.')');

                $newPeminjaman[$newIndex]['status']="";

                if(!empty($status))
                {
                    $newPeminjaman[$newIndex]['status'] = $status[0]->status;
                }
           
                $newIndex = $newIndex + 1;
            }
        }
        else
        {
            $newPeminjaman = array();
            $newIndex = 0;

            foreach ($peminjaman as $index => $value) 
            {
                $status=DB::select('SELECT id_peminjaman_header, status FROM td_status_pinjam WHERE tanggal = (SELECT MAX(tanggal) FROM td_status_pinjam WHERE id_peminjaman_header='.$value->id_header.')');

                if(Auth::user()->role == "kasubbagtu")
                {
                    if(!empty($status))
                    {
                        if($status[0]->status=="disetujui atasan" || ($status[0]->status=="pengajuan" && $value->unitkerja == "2"))
                        {
                            $newPeminjaman[$newIndex]['status']="";
                            $newPeminjaman[$newIndex]['status'] = $status[0]->status;

                            foreach ($value as $key => $data) 
                            {
                                $newPeminjaman[$newIndex][$key] = $data;
                            }

                            $newIndex = $newIndex + 1;
                        }
                    }
                }
                else if(Auth::user()->role == "koordinator")
                {
                    if(!empty($status))
                    {
                        if($status[0]->status=="pengajuan")
                        {
                            $newPeminjaman[$newIndex]['status']="";
                            $newPeminjaman[$newIndex]['status'] = $status[0]->status;

                            foreach ($value as $key => $data) 
                            {
                                $newPeminjaman[$newIndex][$key] = $data;
                            }

                            $newIndex = $newIndex + 1;
                        }
                    }
                }

            }

            if($newIndex == 0)
            {
                $newPeminjaman = array();
            }
        }

        return view('pages.peminjaman.daftarapproval', ['peminjaman'=>$newPeminjaman]);
    }

    public function permohonanpeminjaman()
    {
        $peminjaman=DB::table('td_peminjaman_detail')
            ->leftjoin('td_peminjaman_header AS t1', 'td_peminjaman_detail.id_peminjaman_header', '=', 't1.id')
            ->select('td_peminjaman_detail.*', 't1.*')
            ->get();

       /* $daftarbmn=DB::table('md_bmn')
            ->leftjoin('md_subsubkelompok_bmn AS t1', 'md_bmn.id_subsubkelompok_bmn', '=', 't1.id')
            ->select('md_bmn.*', 't1.nama AS nama_aset')
            ->get();
        */

        $daftarbmn=DB::select('SELECT DISTINCT(md_bmn.id_subsubkelompok_bmn), t1.* FROM md_bmn LEFT JOIN md_subsubkelompok_bmn AS t1 ON md_bmn.id_subsubkelompok_bmn = t1.id');

        return view('pages.peminjaman.form_tambahpeminjaman',['peminjaman'=>$peminjaman, 'daftarbmn'=>$daftarbmn]);
    }

    public function prosespermohonanpeminjaman(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $newTanggal = Carbon::createFromFormat('d/m/Y', $tanggal)->format('Y-m-d');

        $username = Auth::user()->username;

        $dataheader = array(
          'username' => $username,
          'tanggal' => $newTanggal,
          'keperluan' => $request->input('keperluan'),
          'keterangan' => $request->input('keterangan'),
        );

        $insertIDHeader = DB::table('td_peminjaman_header')->insertGetId($dataheader);

        $datadetail = array(
          'id_peminjaman_header' => $insertIDHeader,
          'id_subsubkelompok_bmn' => $request->input('aset'),
          'keterangan' => $request->input('keterangan'),
        );

        $status = "pengajuan";

        $datastatus = array(
          'id_peminjaman_header' => $insertIDHeader,
          'username' => $username,
          'tanggal' => Carbon::now()->toDateTimeString(),
          'status' => $status,
        );

        $insertIDDetail= DB::table('td_peminjaman_detail')->insertGetId($datadetail);
        $insertIDStatus= DB::table('td_status_pinjam')->insertGetId($datastatus);

        return Redirect::to('peminjaman')->with('message','Berhasil menyimpan data');
    }


    public function hapuspeminjaman($id_peminjaman)
    {
        $peminjamanheader = DB::table('td_peminjaman_header')
            ->where('id','=',$id_peminjaman)
            ->delete();

        $peminjamandetail = DB::table('td_peminjaman_detail')
            ->where('id_peminjaman_header','=',$id_peminjaman)
            ->delete();

        $status = DB::table('td_status_pinjam')
            ->where('id_peminjaman_header','=',$id_peminjaman)
            ->delete();

        return Redirect::to('peminjaman')->with('message','Berhasil menghapus data');
    }

    public function approvalpeminjaman($id_peminjaman)
    {
      $peminjaman=DB::table('td_peminjaman_detail')
            ->where('id_peminjaman_header', '=', $id_peminjaman)
            ->leftjoin('td_peminjaman_header AS t1', 'td_peminjaman_detail.id_peminjaman_header', '=', 't1.id')
            ->leftjoin('users AS t2', 't1.username', '=', 't2.username')
            ->leftjoin('md_subsubkelompok_bmn AS t3', 'td_peminjaman_detail.id_subsubkelompok_bmn','=', 't3.id')
            ->leftjoin('md_subkelompok_bmn AS t4', 't3.id_subkelompok_bmn', '=', 't4.id')
            ->leftjoin('md_kelompok_bmn AS t5', 't4.id_kelompok_bmn', '=', 't5.id')
            ->leftjoin('md_bidang_bmn AS t6', 't5.id_bidang', '=', 't6.id')
            ->leftjoin('md_golongan_bmn AS t7', 't6.id_golongan', '=', 't7.id')
            ->select('td_peminjaman_detail.*', 't1.id AS id_header', 't1.tanggal AS tanggal', 't1.keperluan AS keperluan', 't1.keterangan AS keterangan', 't2.name AS nama_pegawai', 't3.id AS id_subsubkelompok_bmn', 't3.kode AS kode_aset', 't3.nama AS nama_aset', 't4.kode AS kode_subkelompok', 't5.kode AS kode_kelompok', 't6.kode AS kode_bidang', 't7.kode AS kode_golongan')
            ->first(); 

        $nup=DB::table('md_bmn')
            ->where('id_subsubkelompok_bmn', '=', $peminjaman->id_subsubkelompok_bmn)
            ->get(); 

        //var_dump($peminjaman);

        $newPeminjaman = array();
        $newIndex = 0;

        foreach ($peminjaman as $key => $data) 
        {
            $newPeminjaman[$newIndex][$key] = $data;
        }

        $status=DB::select('SELECT id_peminjaman_header, status FROM td_status_pinjam WHERE tanggal = (SELECT MAX(tanggal) FROM td_status_pinjam WHERE id_peminjaman_header='.$peminjaman->id_header.')');

        $newPeminjaman[$newIndex]['status']="";

        if(!empty($status))
        {
            $newPeminjaman[$newIndex]['status'] = $status[0]->status;
        }
       
        return view('pages.peminjaman.form_approvalpeminjaman', ['peminjaman'=>$newPeminjaman], ['nup'=>$nup]);
    }

    public function setujupeminjaman($id_peminjaman)
    {
        $dbstatus=DB::select('SELECT id_peminjaman_header, status FROM td_status_pinjam WHERE tanggal = (SELECT MAX(tanggal) FROM td_status_pinjam WHERE id_peminjaman_header='.$id_peminjaman.')');

        $status="pengajuan";

        if(!empty($dbstatus))
        {
            if($dbstatus[0]->status=="pengajuan")
            {
                $status = "disetujui atasan";
            }
            else if($dbstatus[0]->status=="disetujui atasan")
            {
                $status = "disetujui Kasubbag TU";
            }
            else if($dbstatus[0]->status=="disetujui Kasubbag TU")
            {
                $status = "dipinjam";
            }
            else if($dbstatus[0]->status=="dipinjam")
            {
                $status = "dipinjam";
            }
        }

        $username = Auth::user()->username; 

        $datastatus = array(
          'id_peminjaman_header' => $id_peminjaman,
          'username' => $username,
          'tanggal' => Carbon::now()->toDateTimeString(),
          'status' => $status,
        );

        $insertIDStatus= DB::table('td_status_pinjam')->insertGetId($datastatus);

       return Redirect::to('daftarapproval')->with('message','Permohonan disetujui');
    }

    public function tolakpeminjaman($id_peminjaman)
    {
        $status = "tidak disetujui";
        $username = Auth::user()->username; 

        $datastatus = array(
          'id_peminjaman_header' => $id_peminjaman,
          'username' => $username,
          'tanggal' => Carbon::now()->toDateTimeString(),
          'status' => $status,
        );

        $insertIDStatus= DB::table('td_status_pinjam')->insertGetId($datastatus);

       return Redirect::to('daftarapproval')->with('message','Permohonan ditolak');
    }

    public function prosesvalidasipeminjaman(Request $request)
    {
        $data = array(
          'id_bmn' => $request->input('bmn'),
        );

        $username = Auth::user()->username;
        $status = "dipinjam";

        if($request->input('statuspinjaman')=="dipinjam")
        {
            $status="dikembalikan";
        }
        
        $datastatus = array(
          'id_peminjaman_header' => $request->input('id'),
          'username' => $username,
          'tanggal' => Carbon::now()->toDateTimeString(),
          'status' => $status,
          'keterangan' => $request->input('keterangan'),
        );

        $insertIDStatus= DB::table('td_status_pinjam')->insertGetId($datastatus);

        DB::table('td_peminjaman_detail')->where('id_peminjaman_header','=',$request->input('id'))->update($data);

        return Redirect::to('daftarapproval')->with('message','Berhasil menyimpan data');
    }

    public function cetakformpeminjaman($id_peminjaman)
    {
        $peminjaman=DB::table('td_peminjaman_detail')
            ->where('id_peminjaman_header', '=', $id_peminjaman)
            ->leftjoin('td_peminjaman_header AS t1', 'td_peminjaman_detail.id_peminjaman_header', '=', 't1.id')
            ->leftjoin('users AS t2', 't1.username', '=', 't2.username')
            ->leftjoin('md_pegawai AS P', 't2.username', '=', 'P.nip')
            ->leftjoin('td_jabatan_pegawai', 'P.id', '=', 'td_jabatan_pegawai.id_pegawai')
            ->leftjoin('md_jabatan', 'td_jabatan_pegawai.id_jabatan', '=', 'md_jabatan.id')
            ->leftjoin('md_jenjang_jabatan', 'td_jabatan_pegawai.id_jenjang_jabatan', '=', 'md_jenjang_jabatan.id')
            ->leftjoin('td_pegawai_unitkerja AS U', 'P.id', '=', 'U.id_pegawai')
            ->leftjoin('md_unitkerja', 'U.id_unitkerja', '=', 'md_unitkerja.id')
            ->leftjoin('md_subsubkelompok_bmn AS t3', 'td_peminjaman_detail.id_subsubkelompok_bmn','=', 't3.id')
            ->leftjoin('md_subkelompok_bmn AS t4', 't3.id_subkelompok_bmn', '=', 't4.id')
            ->leftjoin('md_kelompok_bmn AS t5', 't4.id_kelompok_bmn', '=', 't5.id')
            ->leftjoin('md_bidang_bmn AS t6', 't5.id_bidang', '=', 't6.id')
            ->leftjoin('md_golongan_bmn AS t7', 't6.id_golongan', '=', 't7.id')
            ->select('td_peminjaman_detail.*', 't1.id AS id_header', 't1.tanggal AS tanggal', 't1.keperluan AS keperluan', 't1.keterangan AS keterangan', 't2.name AS nama_pegawai', 't3.id AS id_subsubkelompok_bmn', 't3.kode AS kode_aset', 't3.nama AS nama_aset', 't4.kode AS kode_subkelompok', 't5.kode AS kode_kelompok', 't6.kode AS kode_bidang', 't7.kode AS kode_golongan', 'P.nip AS NIP', 'U.id_unitkerja AS id_unitkerja', 'md_jabatan.jabatan AS jabatan', 'md_jenjang_jabatan.jenjang_jabatan AS jenjangjabatan', 'md_unitkerja.keterangan AS unitkerja')
            ->first(); 

        $atasan=DB::table('users')
            ->where('t2.id_unitkerja', '=', $peminjaman->id_unitkerja)
            ->where(function ($query) {
               $query->where('users.role', '=', 'koordinator')
                     ->orWhere('users.role', '=', 'kasubbagtu');
                 })
            ->leftjoin('md_pegawai AS t1', 'users.username', '=', 't1.nip')
            ->leftjoin('td_pegawai_unitkerja AS t2', 't1.id', '=', 't2.id_pegawai')
            ->select('users.*', 't1.nip AS NIP', 't1.nama AS nama_atasan')
            ->first(); 

          return view('pages.peminjaman.cetakformpeminjaman', ['peminjaman'=>$peminjaman, 'atasan'=>$atasan]);
    }
}
