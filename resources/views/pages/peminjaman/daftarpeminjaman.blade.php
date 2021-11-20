@extends('layouts.dashboard')
@section('page_heading','Daftar Peminjaman')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item active">Daftar Peminjaman</li>
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
      <a href="{{ url('permohonanpeminjaman') }}" class="btn btn-primary btn-md" role="button">Buat Permohonan</a>
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
              <th>Nama Pegawai</th>
              <th>Kode BMN</th>
              <th>Nama Barang</th>
              <th>Tanggal</th>
              <th>Keperluan</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @php
            $no = 0
            @endphp
            @foreach($peminjaman as $data)  
               <tr>
                  <td>{{++$no}}</td>
                  <td>{{$data['nama_pegawai']}}</td>
                  <td>{{$data['kode_golongan'].".".$data['kode_bidang'].".".$data['kode_kelompok'].".".$data['kode_subkelompok'].".".$data['kode_aset']}}</td>
                  <td>{{$data['nama_aset']}}</td>
                  <td>{{customTanggal($data['tanggal'], "j M Y")}}</td>
                  <td>{{$data['keperluan']}}</td>
                  <td>
                  @php
                    if($data['status']=="pengajuan")
                    {
                  @endphp
                       <span class="badge badge-info">{{$data['status']}}</span>
                  @php
                    }
                    else if($data['status']=="disetujui atasan")
                    {
                  @endphp
                      <span class="badge badge-warning">{{$data['status']}}</span>
                  @php
                    }
                    else if($data['status']=="disetujui Kasubbag TU")
                    {
                  @endphp
                      <span class="badge badge-warning">{{$data['status']}}</span>
                  @php
                    }
                     else if($data['status']=="tidak disetujui")
                    {
                  @endphp
                      <span class="badge badge-danger">{{$data['status']}}</span>
                  @php
                    }
                    else if($data['status']=="dipinjam")
                    {
                  @endphp
                      <span class="badge badge-success">{{$data['status']}}</span>
                  @php
                    }
                  else if($data['status']=="dikembalikan")
                    {
                  @endphp
                      <span class="badge badge-primary">{{$data['status']}}</span>
                  @php
                    }
                    else
                    {
                  @endphp
                        {{$data['status']}}
                  @php
                    }
                  @endphp

                  </td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><i class="fas fa-check nav-icon"></i>
                      <span class="caret"></span>
                      </button>
                      <div class="dropdown-menu" id="dropdown-action-id">   
                        <a class="dropdown-item" href="cetakformpeminjaman/{{$data['id']}}">Cetak Form</a>             
                        <a class="dropdown-item swalDelete" href="hapuspeminjaman/{{$data['id']}}">Hapus Data</a>
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