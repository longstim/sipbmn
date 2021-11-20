@extends('layouts.dashboard')
@section('page_heading','Bidang')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{url('bidang')}}">Bidang</a></li>
  <li class="breadcrumb-item active">Ubah Bidang</li>
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
		  <form role="form" id="ubahbidang" method="post" action="{{url('prosesubahbidang')}}" >
		  	{{ csrf_field() }}
	
			<div class="card-body">
				<div class="row">
				    <div class="col-md-6">
			        <input type="hidden" name="id" class="form-control" id="txtID" value="{{$bidang->id}}"></input>
			        <div class="form-group">
				        <label>Golongan</label>
				         <select name="golongan" id="id_golongan" class="form-control select2bs4" onchange="datagolongan(this.value)" style="width: 100%;">
	                        <option value="" selected="selected">-- Pilih Satu --</option>
	                        @foreach($golongan as $data)
	                            <option value="{{$data->id}}" @if($data->id == $bidang->id_golongan) selected @endif>{{"[".$data->kode."] ".$data->nama}}</option>
	                        @endforeach
	                    </select>
				      </div>
				      <div class="form-group">
				      	<div class="row">
					        <div class="col-md-2">
					        	<label>Gol</label>
					        	<input type="text" name="kode_gol" class="form-control" id="txtKodeGol" value="{{$bidang->kode_golongan}}" readonly>
					        </div>
					        <div class="col-md-2">
				        		<label>Bidang</label>
				        		<input type="text" name="kode" class="form-control" id="txtKode" value="{{$bidang->kode}}">
				        	</div>
				        </div>
				      </div>
				      <div class="form-group">
				        <label>Nama Bidang</label>
				        <input type="text" name="nama" class="form-control" id="txtNama" value="{{$bidang->nama}}">
				      </div>
				      <div class="form-group">
					      	<label>Keterangan</label>
					        <textarea name="keterangan" class="form-control" id="txtKeterangan" rows="2">{{$bidang->keterangan}}</textarea>
					    </div>
					  </div>
			   	</div>

				  <div class="col-md-6">
					</div>
			</div>
			<!-- /.card-body -->

			<div class="card-footer">
		      <button type="submit" class="btn btn-primary">Simpan</button>
		  </div>
			
	  	</form>
		</div>
        <!-- /.row -->
	</div>
</div>

<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
	$(document).ready(function () {
	  $('#ubahbidang').validate({
	    rules: {
	      kode: {
	        required: true
	      },
	      nama: {
	        required: true
	      },
	      golongan: {
	        required: true
	      },
	    },
	    messages: {
	      kode: {
	        required: "Kode harus diisi."
	      },
	      nama: {
	        required: "Nama harus diisi."
	      },
	      golongan: {
	        required: "Golongan harus dipilih."
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


	 function datagolongan(id_golongan)
   {
	    //alert(id_golongan);
	    var APP_URL = {!! json_encode(url('/')) !!};

	    if(id_golongan!="")
	    {
	      $.ajax({
		        url: APP_URL+'/jsondatagolongan/'+id_golongan,
		        type : 'GET',
		        datatype: "json",
		        success:function(data)
		        {
		          //alert(data);
		          var output = JSON.parse(data);
		          console.log(output);
	            $("#txtKodeGol").val(output.kode_golongan);
		        } 
	      	});
	    }
	    else
	    {
	      	$("#txtKodeGol").val("");
	    }
  }
</script>
@endsection