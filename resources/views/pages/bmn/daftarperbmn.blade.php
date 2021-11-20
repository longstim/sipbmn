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
      <div>
        @if(Session::has('message'))
            <input type="hidden" name="txtMessage" id="idmessage" value="{{Session::has('message')}}"></input>
            <input type="hidden" name="txtMessage_text" id="idmessage_text" value="{{Session::get('message')}}"></input>
        @endif
      </div>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Kode BMN</th>
                <td>{{$bmn[0]->kode_aset}}</td>
              </tr>
              <tr>
                <th style="width:50%">Nama Barang</th>
                <td>{{$bmn[0]->nama_aset}}</td>
              </tr>
            </table>
           </div>

      <div class="card">
        <!-- /.card-header -->
         <div class="card-header">
             <h4 class="float-right">Total Nilai: {{formatRupiah(hitungNilaiAset($bmn[0]->id_subsubkelompok_bmn))}}</h4>
        </div>
        <div class="card-body">
          <table id="example1" class="table table-bordered table-hover table-striped">
            <thead>
            <tr style="background-color:#1d809f; color:#fff">
              <th>No</th>
              <th>NUP</th>
              <th>Merk</th>
              <th>Ruangan</th>
              <th>Nilai Perolehan</th>
              <th>Satuan</th>
              <th>Tanggal Perolehan</th>
              <th>Kondisi</th>
              <th>Keterangan</th>
            </tr>
            </thead>
            <tbody>
            @php
            $no = 0
            @endphp
            @foreach($bmn as $data)  
               <tr>
                  <td>{{++$no}}</td>
                  <td>{{$data->nup}}</td>
                  <td>{{$data->merk}}</td>
                  <td>{{$data->nama_ruangan}}</td>
                  <td>{{formatRupiah($data->harga)}}</td>
                  <td>{{$data->satuan}}</td>
                  <td>{{customTanggal($data->tanggal, "j M Y")}}</td>
                  <td>{{$data->kondisi}}</td>
                  <td>{{$data->keterangan}}</td>
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