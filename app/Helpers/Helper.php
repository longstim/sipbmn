<?php
   
	function customTanggal($date,$date_format)
	{
	    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);    
	}
	    
	function hitungUangLembur(int $jam_lembur, string $tanggal_lembur, string $gol)
    {
        $uanglembur = 0;

        $tanggal = \Carbon\Carbon::createFromFormat('Y-m-d', $tanggal_lembur)->format('w'); 

        $datalibur = DB::table('md_hari_libur')->where('tanggal','LIKE', $tanggal_lembur)->get();

        //dd($datalibur->count());

        if($gol=='I/a' || $gol=='I/b' || $gol=='I/c' || $gol=='I/d')
        {	
            $uanglembur = $jam_lembur * 13000;

            if($tanggal == '0' || $tanggal == '6' || $datalibur->count()>0)
            {   
                $uanglembur = $uanglembur * 2;
            }
        	
        	if($jam_lembur>=2)
        	{
        		$uanglembur = $uanglembur + 35000;
        	}
        }
        else if($gol=='II/a' || $gol=='II/b' || $gol=='II/c' || $gol=='II/d')
        {
            $uanglembur = $jam_lembur * 17000;

            if($tanggal == '0' || $tanggal == '6' || $datalibur->count()>0)
            {
                $uanglembur = $uanglembur * 2;
            }

            if($jam_lembur>=2)
        	{
        		$uanglembur = $uanglembur + 35000;
        	}
        }
        else if($gol=='III/a' || $gol=='III/b' || $gol=='III/c' || $gol=='III/d')
        {
            $uanglembur = $jam_lembur * 20000;

            if($tanggal == '0' || $tanggal == '6' || $datalibur->count()>0)
            {
                $uanglembur = $uanglembur * 2;
            }

            if($jam_lembur>=2)
        	{
        		$uanglembur = $uanglembur + 37000;
        	}
        }
        else if($gol=='IV/a' || $gol=='IV/b' || $gol=='IV/c' || $gol=='IV/d' ||  $gol=='IV/e')
        {
            $uanglembur = $jam_lembur * 25000;

            if($tanggal == '0' || $tanggal == '6' || $datalibur->count()>0)
            {
                $uanglembur = $uanglembur * 2;
            }

            if($jam_lembur>=2)
        	{
        		$uanglembur = $uanglembur + 41000;
        	}
        }

        return $uanglembur;
    }

    function formatRupiah($angka)
    { 
    	$hasil = "Rp ".number_format($angka,0, ',' , '.'); 

    	return $hasil; 
	}

    function getJamLembur($id_detail, $tanggal)
    {

        $datajamlembur = DB::table('td_lembur_detail_jam')
              ->where([
                          ['id_detail', '=', $id_detail],
                          ['tanggal_lembur', '=', $tanggal],
                      ])
              ->first();


        return $datajamlembur;
    }

    function getStatusPinjam($id_bmn)
    {

         $status=DB::select('SELECT id_peminjaman_header, status FROM td_status_pinjam WHERE tanggal = (SELECT MAX(tanggal) FROM td_status_pinjam JOIN td_peminjaman_detail ON td_status_pinjam.id_peminjaman_header = td_peminjaman_detail.id_peminjaman_header WHERE td_peminjaman_detail.id_bmn ='.$id_bmn.')');

         $statuspinjam = "Available";

         if(!empty($status))
         {
            if($status[0]->status=="dipinjam")
            {
                $statuspinjam = "sedang dipinjam";
            }
         }

        return $statuspinjam;
    }

    function getNotifikasi()
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

        return $newIndex;
    }

    function hitungNilaiAset($id_subsubkelompokbmn)
    {
        $totalnilai = DB::table('md_bmn')
            ->where('id_subsubkelompok_bmn', '=', $id_subsubkelompokbmn)
            ->sum('harga');

        return $totalnilai;
    }