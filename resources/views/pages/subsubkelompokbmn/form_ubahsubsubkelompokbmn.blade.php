@extends('layouts.dashboard')
@section('page_heading','Sub Sub Kelompok BMN')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{url('subsubkelompokbmn')}}">Sub Sub Kelompok BMN</a></li>
  <li class="breadcrumb-item active">Ubah Sub Sub Kelompok BMN</li>
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
		  <form role="form" id="ubahsubsubkelompokbmn" method="post" action="{{url('prosesubahsubsubkelompokbmn')}}" >
		  	{{ csrf_field() }}
	
			<div class="card-body">
				<div class="row">
				    <div class="col-md-6">
			        <input type="hidden" name="id" class="form-control" id="txtID" value="{{$subsubkelompokbmn->id}}"></input>
			      	<div class="form-group">
				        <label>Sub Kelompok BMN</label>
				         <select name="subkelompokbmn" id="id_subkelompokbmn" class="form-control select2bs4" onchange="datasubkelompok(this.value)" style="width: 100%;">
	                        <option value="" selected="selected">-- Pilih Satu --</option>
	                        @foreach($subkelompokbmn as $data)
	                            <option value="{{$data->id}}" @if($data->id == $subsubkelompokbmn->id_subkelompok_bmn) selected @endif>{{"[".$data->kode_golongan.".".$data->kode_bidang.".".$data->kode_kelompok.".".$data->kode."] ".$data->nama}}</option>
	                        @endforeach
	                    </select>
				      </div>
				            <div class="form-group">
				      	<div class="row">
					        <div class="col-md-2">
					        	<label>Gol</label>
					        	<input type="text" name="kode_gol" class="form-control" id="txtKodeGol" value="{{$subsubkelompokbmn->kode_golongan}}" readonly>
					        </div>
					        <div class="col-md-2">
					         <label>Bidang</label>
					        	<input type="text" name="kode_bid" class="form-control" id="txtKodeBid" value="{{$subsubkelompokbmn->kode_bidang}}" readonly>
	                </div>
	                <div class="col-md-2">
						        <label>Kel.</label>
						        <input type="text" name="kode_kel" class="form-control" id="txtKodeKel" value="{{$subsubkelompokbmn->kode_kelompok}}" readonly>
						      </div>
									<div class="col-md-2">
						        <label>Sub Kel.</label>
						        <input type="text" name="kode_subkel" class="form-control" id="txtKodeSubkel" value="{{$subsubkelompokbmn->kode_subkelompok}}" readonly>
	                </div>	
	                <div class="col-md-2">		
						        <label>Sub Sub</label>
						        <input type="text" name="kode" class="form-control{{ $errors->has('kode') ? ' is-invalid' : '' }}" id="txtKode" value="{{$subsubkelompokbmn->kode}}"> 
	                </div>
              	</div>
				      </div>
				      <div class="form-group">
				        <label>Nama Sub Sub Kelompok BMN</label>
				        <input type="text" name="nama" class="form-control" id="txtNama" value="{{$subsubkelompokbmn->nama}}">
				      </div>
				      <div class="form-group">
				        <label>Satuan</label>
				        <input type="text" name="satuan" class="form-control" id="txtSatuan" value="{{$subsubkelompokbmn->satuan}}">
				      </div>
				      <div class="form-group">
					      	<label>Keterangan</label>
					        <textarea name="keterangan" class="form-control" id="txtKeterangan" rows="2">{{$subsubkelompokbmn->keterangan}}</textarea>
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
	  $('#ubahsubsubkelompokbmn').validate({
	    rules: {
	      kode: {
	        required: true
	      },
	      nama: {
	        required: true
	      },
	      satuan: {
	        required: true
	      },
	      subkelompokbmn: {
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
	      satuan: {
	        required: "Satuan harus diisi."
	      },
	      subkelompokbmn: {
	        required: "Sub Kelompok BMN harus dipilih."
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

		 function datasubkelompok(id_subkelompok)
   {
	    //alert(id_subkelompok);
	    var APP_URL = {!! json_encode(url('/')) !!};

	    if(id_subkelompok!="")
	    {
	      $.ajax({
		        url: APP_URL+'/jsondatasubkelompok/'+id_subkelompok,
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
	            $("#txtKodeSubkel").val(output.kode_subkelompok);
		        } 
	      	});
	    }
	    else
	    {
	      	$("#txtKodeGol").val("");
	      	$("#txtKodeBid").val("");
	      	$("#txtKodeKel").val("");
	      	$("#txtKodeSubkel").val("");
	    }
  }

</script>
@endsection