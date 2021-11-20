@extends('layouts.dashboard')
@section('page_heading','Ruangan')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{url('ruangan')}}">Ruangan</a></li>
  <li class="breadcrumb-item active">Ubah Ruangan</li>
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
		  <form role="form" id="ubahruangan" method="post" action="{{url('prosesubahruangan')}}" >
		  	{{ csrf_field() }}
	
			<div class="card-body">
				<div class="row">
				    <div class="col-md-6">
			        <input type="hidden" name="id" class="form-control" id="txtID" value="{{$ruangan->id}}"></input>
				      <div class="form-group">
				        <label>Kode</label>
				        <input type="text" name="kode" class="form-control" id="txtKode" value="{{$ruangan->kode}}">
				      </div>
				      <div class="form-group">
				        <label>Nama Ruangan</label>
				        <input type="text" name="nama" class="form-control" id="txtNama" value="{{$ruangan->nama}}">
				      </div>
				      <div class="form-group">
				        <label>Penanggungjawab</label>
				        <input type="text" name="penanggungjawab" class="form-control" id="txtPenanggungjawab" value="{{$ruangan->penanggungjawab}}">
				      </div>
				      <div class="form-group">
					      	<label>Keterangan</label>
					        <textarea name="keterangan" class="form-control" id="txtKeterangan" rows="2">{{$ruangan->keterangan}}</textarea>
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
	  $('#ubahruangan').validate({
	    rules: {
	      kode: {
	        required: true
	      },
	      nama: {
	        required: true
	      },
	      penanggungjawab: {
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
	      penanggungjawab: {
	        required: "Penanggungjawab harus diisi."
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
</script>
@endsection