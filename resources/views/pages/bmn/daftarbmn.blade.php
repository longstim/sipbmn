@extends('layouts.dashboard')
@section('page_heading','Daftar Barang')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item active">Daftar Barang</li>
</ol>
@endsection
@section('content')
<style>
  #dropdown-action-id
  {
    min-width: 5rem;
  }

  #dropdown-action-id .dropdown-item:hover
  {
    color:#007bff;
  }

  #dropdown-action-id .dropdown-item:active
  {
    color:#fff;
  }
</style>
  <div class="row">
    <div class="col-12">
      <a href="{{ url('/tambahbmn') }}" class="btn btn-primary btn-md" role="button">Tambah</a>
      <p></p>
      <div>
        @if(Session::has('message'))
            <input type="hidden" name="txtMessage" id="idmessage" value="{{Session::has('message')}}"></input>
            <input type="hidden" name="txtMessage_text" id="idmessage_text" value="{{Session::get('message')}}"></input>
        @endif
      </div>
      <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-hover table-striped">
            <thead>
            <tr style="background-color:#1d809f; color:#fff">
              <th>No</th>
              <th width="100px">Kode BMN</th>
              <th>Nama</th>
              <th>Merk</th>
              <th>Nilai Perolehan</th>
              <th>Satuan</th>
              <th>Tanggal Perolehan</th>
              <th>Kondisi</th>
              <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @php
            $no = 0
            @endphp
            @foreach($bmn as $data)  
               <tr>
                  <td>{{++$no}}</td>
                  <td>{{$data->kode_aset."-".$data->nup}}</td>
                  <td>{{$data->nama_aset}}</td>
                  <td>{{$data->merk}}</td>
                  <td>{{formatRupiah($data->harga)}}</td>
                  <td>{{$data->satuan}}</td>
                  <td>{{customTanggal($data->tanggal, "j M Y")}}</td>
                  <td>{{$data->kondisi}}</td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><i class="fas fa-check nav-icon"></i>
                      <span class="caret"></span>
                      </button>
                      <div class="dropdown-menu" id="dropdown-action-id">
                        <a class="dropdown-item" href="qrcodebmn/{{$data->id}}">QR Code</a> 
                        <a class="dropdown-item" href="detailbmn/{{$data->id}}">Detail</a>
                        <a class="dropdown-item" href="ubahbmn/{{$data->id}}">Ubah Data</a>                   
                        <a class="dropdown-item swalDelete" href="hapusbmn/{{$data->id}}">Hapus Data</a>
                      </div>
                    </div>
                  </td>
               </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>

  <script src="{{asset('js/jquery.min.js')}}"></script>
  <script>
    $( document ).ready(function () {

      //DataTable
      $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
      });

      //SweetAlert Success
      var message = $("#idmessage").val();
      var message_text = $("#idmessage_text").val();

      if(message=="1")
      {
        Swal.fire({     
           icon: 'success',
           title: 'Success!',
           text: message_text,
           showConfirmButton: false,
           timer: 1500
        })
      }

      //SweetAlert Delete
     $(document).on("click", ".swalDelete",function(event) {  
        event.preventDefault();
        const url = $(this).attr('href');

        Swal.fire({
          title: 'Apakah anda yakin menghapus data ini?',
          text: 'Anda tidak akan dapat mengembalikan data ini!',
          icon: 'error',
          showCancelButton: true,
          confirmButtonColor: '#dc3545',
          confirmButtonText: 'Ya, Hapus',
          cancelButtonText: 'Batal'
        }).then((result) => {
        if (result.value) 
        {
            window.location.href = url;
        }
      });
    });
  });
  </script>
@endsection