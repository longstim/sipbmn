<html>
<head>
<title>Nota Dinas Lembur</title>
  <style type="text/css">
      td {font-family:"arial"; font-size:11pt}
      th {font-family:"arial"; font-weight:bold; font-size:11pt}
      a {text-decoration:none;}
      a:hover {color:red}
      textarea {font-family:"arial"; font-size:9pt}
      input {font-family:"arial"; font-size:9pt}
  </style>
  <link REL="shortcut icon" HREF="/favicon.ico" TYPE="image/x-icon">
</head>

<body bgcolor="white" onload="window.print()"> 
<font face="arial">
<center>

  <table border=0 width="650">
     <tr>
      <td colspan="1" cellpadding="4"><a href="#"><img src="{{asset('image/logobim.png')}}" width="180px"></a>
      </td>
      <td align="right"><b style="font-size:11pt">Dok. No: F-BIM-055/1-II-00/13</b></td>
      </td>
    </tr>
    <tr>
        <td><br><br><b style="font-size:15pt"><u>FORM PERMINTAAN / PEMAKAIAN</u></b><br>
      </td>
    </tr>
  </table>

  <table border=0 width="650">
    <tr>
      <td>
         <br>
        <table>
          <tr >
            <td width="50%">Nama</td>
            <td>:</td>
            <td>{{$peminjaman->nama_pegawai}}</td>
          </tr>
            <tr >
            <td>NIP</td>
            <td>:</td>
            <td>{{$peminjaman->NIP}}</td>
          </tr>
          </tr>
            <tr >
            <td>Jabatan</td>
            <td>:</td>
            <td>{{$peminjaman->jabatan." ".$peminjaman->jenjangjabatan}}</td>
          </tr>
          </tr>
            <tr >
            <td>Unit</td>
            <td>:</td>
            <td>{{$peminjaman->unitkerja}}</td>
          </tr>
          <tr >
            <td>Tanggal</td>
            <td>:</td>
            <td>{{customTanggal($peminjaman->tanggal, "j M Y")}}</td>
          </tr>
          <tr>
            <td>Keperluan</td>
            <td>:</td>
            <td>{{$peminjaman->keperluan}}</td>
          </tr>
          <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td>{{$peminjaman->keterangan}}</td>
          </tr>
           <tr border="1">
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <table border=0 width="100%">
          <tr>
            <br><br><br>
            <td align="center"><br><br>
              Disetujui oleh<br/>
              Kepala Sub Bag Tata Usaha<br/>
              <br><br><br><br>
              <u>Hardiana Sriyati</u>
              <br>NIP. 196804061993032002
            </td>
            <td align="center"><br><br>
              Diketahui oleh<br/>
              Atasan Langsung<br/>
              <br><br><br><br>
              <u>{{$atasan->nama_atasan}}</u>
              <br>NIP. {{$atasan->NIP}}
            </td>
            <td align="center"><br><br>
              Medan, {{customTanggal($peminjaman->tanggal, "j M Y")}}<br>
              Peminjam<br/>
              <br><br><br><br>
              <u>{{$peminjaman->nama_pegawai}}</u>
              <br>NIP. {{$peminjaman->NIP}}
            </td>
          </tr>
        </table>
    </tr>
  </table>
</center>
</font>

</body>
</html>
