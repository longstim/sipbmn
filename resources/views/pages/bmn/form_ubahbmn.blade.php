@extends('layouts.dashboard')
@section('page_heading','Daftar Barang')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{url('bmn')}}">Barang</a></li>
  <li class="breadcrumb-item active">Ubah Barang</li>
</ol>
@endsection
@section('content')
<div class="row">
	<!-- left column -->
	<div class="col-md-12">
	<!-- jquery validation -->
		<div class="card card-primary">
		  <div class="card-header">
		    <h3 class="card-title">Ubah Data</h3>
		  </div>
	      <div>
	        @if(Session::has('message'))
	            <input type="hidden" name="txtMessage" id="idmessage" value="{{Session::has('message')}}"></input>
	            <input type="hidden" name="txtMessage_text" id="idmessage_text" value="{{Session::get('message')}}"></input>
	        @endif
	      </div>
		  <!-- /.card-header -->
		  <!-- form start -->
		  <form role="form" id="ubahbmn" method="post" action="{{url('prosesubahbmn')}}" enctype="multipart/form-data" >
		  	{{ csrf_field() }}
 
			<div class="card-body">
				<div class="row">
				    <div class="col-md-6">
				    	 <input type="hidden" name="id" class="form-control" id="txtID" value="{{$bmn->id}}"></input>

			      	<div class="form-group">
				        <label>Kode BMN</label>
				         <select name="aset" id="id_aset" class="form-control select2bs4" style="width: 100%;">
	                        <option value="" selected="selected">-- Pilih Satu --</option>
	                        @foreach($aset as $data)
	                            <option value="{{$data->id}}" @if($data->id == $bmn->id_subsubkelompok_bmn) selected @endif>{{"[".$data->kode_golongan.".".$data->kode_bidang.".".$data->kode_kelompok.".".$data->kode_subkelompok.".".$data->kode."] ".$data->nama}}</option>
	                        @endforeach
	                    </select>
				      </div>
							<div class="form-group">
				        <label>NUP</label>
				        <input type="text" name="nup" class="form-control" id="txtNUP" value="{{$bmn->nup}}" readonly>
				      </div>
				      <div class="form-group">
				        <label>Ruangan</label>
				         <select name="ruangan" id="id_ruangan" class="form-control select2bs4" style="width: 100%;">
	                        <option value="" selected="selected">-- Pilih Satu --</option>
	                        @foreach($ruangan as $data)
	                            <option value="{{$data->id}}" @if($data->id == $bmn->id_ruangan) selected @endif>{{"[".$data->kode."] ".$data->nama}}</option>
	                        @endforeach
	                    </select>
				      </div>
				      <div class="form-group">
				        <label>Merk</label>
				        <input type="text" name="merk" class="form-control" id="txtMerk" value="{{$bmn->merk}}">
				      </div>
				      <div class="form-group">
					      	<label>Keterangan</label>
					        <textarea name="keterangan" class="form-control" id="txtKeterangan" rows="2" placeholder="Keterangan">{{$bmn->keterangan}}</textarea>
					    </div>
					  </div>


					  <div class="col-md-6">
					     <div class="form-group">
				        <label>Harga</label>
				        <input type="text" name="harga" class="form-control" id="txtHarga" value="{{$bmn->harga}}">
				      </div>

				  	  <div class="form-group">
				        <label>Tanggal Perolehan</label>
				        <div class="input-group date">
	                  <input type="text" name="tanggal" class="form-control" id="datepicker" placeholder="dd/mm/yyyy" value="{{date('d/m/Y', strtotime($bmn->tanggal))}}">
	                  <div class="input-group-prepend">
	                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
	                  </div>
	               </div>
			      	</div>
			      	<div class="form-group">
				        <label>Kondisi</label>
				         <select name="kondisi" id="id_kondisi" class="form-control select2bs4" style="width: 100%;">
	                    <option value="" selected="selected">-- Pilih Satu --</option>
	                    <option value="Baik" @if($bmn->kondisi == "Baik") selected @endif>Baik</option>
	                    <option value="Rusak Ringan" @if($bmn->kondisi == "Rusak Ringan") selected @endif>Rusak Ringan</option>
	                    <option value="Rusak Berat" @if($bmn->kondisi == "Rusak Berat") selected @endif>Rusak Berat</option>
	                </select>
				      </div>
			      	<div class="form-group">
				      	<label>Upload Foto</label>
		      	    <div class="custom-file">
	                  <input type="file" name="foto"class="custom-file-input" id="customFile">
	                  <label class="custom-file-label" for="customFile">Pilih File</label>
	              </div>
	            </div>
	            <?php
	            	$blank = "blank.png"
	            ?>
	            <div class="form-group">
	              		<img class="profile-user-img img-fluid img-bordered-md"
                         src="{{asset('image/bmn/'.($bmn->foto != null ? $bmn->foto : $blank)) }}"
                         alt="Foto Barang">	
              </div>
						</div>
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


<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
	$(document).ready(function () {

	  $('#ubahbmn').validate({
	    rules: {
		    aset: {
	        required: true
	      },
	      ruangan: {
	        required: true
	      },
	      merk: {
	        required: true
	      },
	      jumlah: {
	        required: true
	      },
	      harga: {
	        required: true
	      },
	      tanggal: {
	        required: true
	      },
	      kondisi: {
	        required: true
	      },
	    },
	    messages: {
	      aset: {
	        required: "Kode BMN harus dipilih."
	      },
	      ruangan: {
	        required: "Ruangan harus dipilih."
	      },
	      merk: {
	        required: "Merk harus diisi."
	      },
	      jumlah: {
	        required: "Jumlah harus diisi."
	      }, 
	      harga: {
	        required: "Harga harus diisi."
	      },
	      tanggal: {
	        required: "Tanggal harus diisi."
	      },
	      kondisi: {
	        required: "Tanggal harus diisi."
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
      $("#detailtable").DataTable({
        "paging": true,
	      "lengthChange": false,
	      "searching": false,
	      "ordering": true,
	      "info": true,
	      "autoWidth": false,
	      "responsive": true,
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

	});

	$(function () {
  	bsCustomFileInput.init();
	});

</script>
@endsection