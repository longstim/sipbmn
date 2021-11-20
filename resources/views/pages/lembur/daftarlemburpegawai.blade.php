@extends('layouts.dashboard')
@section('page_heading','Daftar Lembur Per Pegawai')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{url('lembur')}}">Lembur Pegawai</a></li>
  <li class="breadcrumb-item active">Daftar Lembur Pegawai</li>
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
     <form role="form" id="daftarlemburpegawaiform" method="post" action="{{url('daftarlemburpegawai')}}" >
        {{ csrf_field() }}
      <div class=" form-group row">
        <div class="col-sm-8 row">
          <label class="col-sm-2 col-form-label">Nama :</label>
          <div class="col-sm-8">
              <select onchange="this.form.submit()" name="pegawai" id="slcPegawai" class="form-control select2bs4" style="width: 100%;">
                  <option value="" selected="selected">-- Pilih Satu --</option>
                  @foreach($pegawai as $data)
                      <option value="{{$data->id}}" @if($data->id == $id_pegawai) selected @endif>{{$data->nama}}</option>
                  @endforeach
              </select>
          </div>
        </div>
        <div class="col-sm-4">
              <h4 class="float-right">Total: {{formatRupiah($totaluanglembur)}}</h4>
        </div>
      </div>
      </form>
    </div>

    <div class="col-12">
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
              <th>Nama</th>
              <th>NIP</th>
              <th>Tanggal Lembur</th>
              <th>Bidang Pekerjaan</th>
              <th>Uraian Pekerjaan</th>
              <th>Jam Lembur</th>
              <th>Uang Lembur</th>
              <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @php
            $no = 0
            @endphp
            @foreach($lemburpegawai as $data)  
               <tr>
                  <td>{{++$no}}</td>
                  <td>{{$data['nama']}}</td>
                  <td>{{$data['nip']}}</td>
                  <td>{{customTanggal($data['tanggal_lembur_awal'], "j M Y")}}</td>
                  <td>{{$data['bidang_pekerjaan']}}</td>
                  <td>{{$data['uraian_pekerjaan']}}</td>
                  <td>{{$data['jam_lembur']!= "" ? $data['jam_lembur'] : ""}}</td>
                  <td>{{formatRupiah($data['uanglembur'])}}</td>
                  <td>
                      @php
                      $tanggallembur = customTanggal($data['tanggal_lembur_awal'], "d/m/Y");
                      @endphp
                      <a href="#" title="Tambah" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-jam-lembur" onclick ="datajamlemburdetail( {{ $data['id'] }}, '{{ $tanggallembur }}' )"><i class="fas fa-plus"></i></i></a>
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

  <!-- Modal Tambah Detail -->
<div class="modal fade" id="modal-jam-lembur">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
         <div class="row">
      <!-- left column -->
      <div class="col-md-12">
      <!-- jquery validation -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Tambah Jam Lembur</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" id="tambahjamlemburdetail" method="post" action="{{url('prosestambahjamlemburdetail')}}" >
            {{ csrf_field() }}

            <div class="card-body">

                <input type="hidden" name="id_detail" class="form-control" id="txtIDDetail"></input>
                <input type="hidden" name="id_jamlemburdetail" class="form-control" id="txtIDJamLemburDetail"></input>

                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" class="form-control" id="txtNama" readonly>
                </div>

                <div class="form-group">
                  <label>Tanggal Lembur</label>
                  <input type="text" name="tanggal_lembur" class="form-control" id="txtTanggalLembur" readonly>
                </div>

                <div class="form-group">
                  <label>Jam Lembur</label>
                  <input type="text" name="jam_lembur" class="form-control" id="txtJamLembur" placeholder="Jam Lembur">
                </div>
            </div>
                <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Tambah Detail-->

  <script src="{{asset('js/jquery.min.js')}}"></script>
  <script>
    $( document ).ready(function () {

      $('#tambahjamlemburdetail').validate({
      rules: {
        tanggal_lembur: {
          required: true
        },
        jam_lembur: {
          required: true,
          number: true,
        },
      },
      messages: {
        tanggal_lembur: {
          required: "Tanggal Lembur harus diisi."
        },
        jam_lembur: {
          required: "Jam Lembur harus diisi.",
          number: "Jam Lembur harus diisi dengan angka."
        },
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });


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


  function datajamlemburdetail(id_lemburdetail, tanggallembur)
  {
      //alert(id_lemburdetail);
      if(id_lemburdetail!="")
      {
        $.ajax({
            url: "jsonlemburdetail/"+id_lemburdetail,
            type : 'GET',
            datatype: "json",
              success:function(data)
              {
                  //alert(data);
                  var output = JSON.parse(data);
                  console.log(output);

                  $("#txtIDDetail").val(id_lemburdetail);
                  $("#txtNama").val(output.nama);
                  $("#txtTanggalLembur").val(tanggallembur);
              } 
          });
      }
      else
      {
          $("#txtIDDetail").val("");
          $("#txtNama").val("");
          $("#txtTanggalLembur").val("");
      }
  }
  </script>
@endsection