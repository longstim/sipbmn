<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>SIBMN BIM</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- DatePicker -->
  <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
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
        <h1>Detail Barang</h1>
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Kode BMN</th>
                <td>{{$bmn->kode_aset}}</td>
              </tr>
              <tr>
                <th style="width:50%">Nama Barang</th>
                <td>{{$bmn->nama_aset}}</td>
              </tr>
              <tr>
                <th style="width:50%">NUP</th>
                <td>{{$bmn->nup}}</td>
              </tr>
              <tr>
                <th style="width:50%">Ruangan</th>
                <td>{{'('.$bmn->kode_ruangan.') '.$bmn->nama_ruangan}}</td>
              </tr>
              <tr>
                <th style="width:50%">Merk</th>
                <td>{{$bmn->merk}}</td>
              </tr>
              <tr>
                <th style="width:50%">Harga Perolehan</th>
                <td>{{formatRupiah($bmn->harga)}}</td>
              </tr>
              <tr>
                <th style="width:50%">Tanggal Perolehan</th>
                <td>{{customTanggal($bmn->tanggal, "j M Y")}}</td>
              </tr>
              <tr>
                <th style="width:50%">Kondisi</th>
                <td>{{$bmn->kondisi}}</td>
              </tr>
              <tr>
                <th style="width:50%">Keterangan</th>
                <td>{{$bmn->keterangan}}</td>
              </tr>
              <tr>
                <th style="width:50%">Status Pinjaman</th>
                @php
                    if(getStatusPinjam($bmn->id) == "Available")
                    {
                @endphp
                      <td><span class="badge badge-success">{{getStatusPinjam($bmn->id)}}</span></td>
                @php
                    }
                    else
                    {
                @endphp
                      <td><span class="badge badge-warning">{{getStatusPinjam($bmn->id)}}</span></td>
                @php
                    }
                @endphp
              </tr>
              <tr>
                <th style="width:50%">Foto</th>
                <td> 
                  <?php
                    $blank = "blank.png"
                  ?>               
                  <img class="img-bordered-sm"
                          width="200px" 
                         src="{{asset('image/bmn/'.($bmn->foto != null ? $bmn->foto : $blank)) }}"
                         alt="Foto Barang">
                </td>
              </tr>
 
            </table>
           </div>
          </div>

          </div>

      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
</body>

  <script src="{{asset('js/jquery.min.js')}}"></script>
  <script>
    $( document ).ready(function () {

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
