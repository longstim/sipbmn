@extends('layouts.dashboard')
@section('page_heading','Sub Kelompok BMN')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{url('subkelompokbmn')}}">Sub Kelompok BMN</a></li>
  <li class="breadcrumb-item active">Tambah Sub Kelompok BMN</li>
</ol>
@endsection
@section('content')
<div class="row">
	<!-- left column -->
	<div class="col-md-12">
	<!-- jquery validation -->
		<div class="card card-primary">
		  <div class="card-header">
		    <h3 class="card-title">Tambah Data</h3>
		  </div>
	      <div>
	        @if(Session::has('message'))
	            <input type="hidden" name="txtMessage" id="idmessage" value="{{Session::has('message')}}"></input>
	            <input type="hidden" name="txtMessage_text" id="idmessage_text" value="{{Session::get('message')}}"></input>
	        @endif
	      </div>
		  <!-- /.card-header -->
		  <!-- form start -->
		  <form role="form" id="tambahsubkelompokbmn" method="post" action="{{url('prosestambahsubkelompokbmn')}}" >
		  	{{ csrf_field() }}
	
			<div class="card-body">
				<div class="row">
				    <div class="col-md-6">
			      	<div class="form-group">
				        <label>Kelompok BMN</label>
				         <select name="kelompokbmn" id="id_kelompokbmn" class="form-control select2bs4" onchange="datakelompok(this.value)" style="width: 100%;">
	                        <option value="" selected="selected">-- Pilih Satu --</option>
	                        @foreach($kelompokbmn as $data)
	                            <option value="{{$data->id}}">{{"[".$data->kode_golongan.".".$data->kode_bidang.".".$data->kode."] ".$data->nama}}</option>
	                        @endforeach
	                    </select>
				      </div>
				      <div class="form-group">
				      	<div class="row">
					        <div class="col-md-2">
					        	<label>Gol</label>
					        	<input type="text" name="kode_gol" class="form-control" id="txtKodeGol" readonly>
					        </div>
					        <div class="col-md-2">
					         <label>Bidang</label>
					        	<input type="text" name="kode_bid" class="form-control" id="txtKodeBid" readonly>
	                </div>
	                <div class="col-md-2">
						        <label>Kel.</label>
						        <input type="text" name="kode_kel" class="form-control" id="txtKodeKel" readonly>
						      </div>
								<div class="col-md-2">
					        <label>Sub Kel.</label>
					        <input type="text" name="kode" class="form-control{{ $errors->has('kode') ? ' is-invalid' : '' }}" id="txtKode" value="{{old('kode') }}" placeholder="Kode">
				            @if ($errors->has('kode'))
	                    <span class="invalid-feedback" role="alert">
	                        <strong>{{ $errors->first('kode') }}</strong>
	                    </span>
	                  @endif
	                </div>
                </div>
				      </div>
				      <div class="form-group">
				        <label>Nama Sub Kelompok BMN</label>
				        <input type="text" name="nama" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" id="txtNama" value="{{old('nama') }}" placeholder="Nama Sub Kelompok BMN">
				      </div>
	
				      <div class="form-group">
					      	<label>Keterangan</label>
					        <textarea name="keterangan" class="form-control" id="txtKeterangan" rows="2" placeholder="Keterangan"></textarea>
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
	  $('#tambahsubkelompokbmn').validate({
	    rules: {
	      kode: {
	        required: true
	      },
	      nama: {
	        required: true
	      },
	      kelompokbmn: {
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
	      kelompokbmn: {
	        required: "Kelompok BMN harus dipilih."
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

	 function datakelompok(id_kelompok)
   {
	    //alert(id_kelompok);
	    var APP_URL = {!! json_encode(url('/')) !!};

	    if(id_kelompok!="")
	    {
	      $.ajax({
		        url: APP_URL+'/jsondatakelompok/'+id_kelompok,
		        type : 'GET',
		        datatype: "json",
		        success:function(data)
		        {
		          //alert(data);
		          var output = JSON.parse(data);
		          console.log(output);
	            $("#txtKodeGol").val(output.kode_golongan);
	            $("#txtKodeBid").val(output.kode_bidang);
	            $("#txtKodeKel").val(output.kode_kelompok);
		        } 
	      	});
	    }
	    else
	    {
	      	$("#txtKodeGol").val("");
	      	$("#txtKodeBid").val("");
	      	$("#txtKodeKel").val("");
	    }
  }
</script>
@endsection