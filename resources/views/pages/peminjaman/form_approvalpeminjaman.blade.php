@extends('layouts.dashboard')
@section('page_heading','Peminjaman Barang')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{url('peminjaman')}}">Peminjaman</a></li>
  <li class="breadcrumb-item active">Persetujuan Peminjaman Barang</li>
</ol>
@endsection
@section('content')
<div class="row">
	<!-- left column -->
	<div class="col-md-12">
	<!-- jquery validation -->
		<div class="card card-primary">
		  <div class="card-header">
		    <h3 class="card-title">Persetujuan Peminjaman</h3>
		  </div>
	      <div>
	        @if(Session::has('message'))
	            <input type="hidden" name="txtMessage" id="idmessage" value="{{Session::has('message')}}"></input>
	            <input type="hidden" name="txtMessage_text" id="idmessage_text" value="{{Session::get('message')}}"></input>
	        @endif
	      </div>
		  	@php
		  			if($peminjaman[0]['status']=="disetujui Kasubbag TU" || $peminjaman[0]['status']=="dipinjam")
		  			{
		  	@endphp

		  	<form role="form" id="validasipeminjaman" method="post" action="{{url('prosesvalidasipeminjaman')}}" >
		  	{{ csrf_field() }}

		  	<div class="card-body">
          <div class="table-responsive">
            <table class="table">
            	<input type="hidden" name="id" class="form-control" id="txtID" value="{{$peminjaman[0]['id_header']}}"></input>

            	<input type="hidden" name="statuspinjaman" class="form-control {{ $errors->has('statuspeminjaman') ? ' is-invalid' : '' }}" id="txtStatusPinjaman" value="{{$peminjaman[0]['status']}}"></input>
            	<tr>
                <th style="width:50%">Pilih NUP</th>
	              <td>
	              	@php
	              		if($peminjaman[0]['status']=="dipinjam")
	              		{
	              	@endphp
	              			 <select name="bmn" id="id_bmn" class="form-control select2bs4" style="width: 100%;" disabled="disabled">
		                        <option value="" selected="selected">-- Pilih Satu --</option>
		                        @foreach($nup as $data)
		                            <option value="{{$data->id}}" @if($data->id == $peminjaman[0]['id_bmn']) selected @endif>{{$data->nup}}</option>
		                        @endforeach
		                	</select>
		               @php
	              		}
	              		else
	              		{
	              	 @endphp
					         <select name="bmn" id="id_bmn" class="form-control select2bs4" style="width: 100%;">
		                        <option value="" selected="selected">-- Pilih Satu --</option>
		                        @foreach($nup as $data)
		                            <option value="{{$data->id}}" @if($data->id == $peminjaman[0]['id_bmn']) selected @endif>{{$data->nup}}</option>
		                        @endforeach
		                </select>
		                @php
		                }
		               	@endphp
		             </td>
					    </tr>
              <tr>
                <th style="width:50%">Kode BMN</th>
                <td>{{$peminjaman[0]['kode_golongan'].".".$peminjaman[0]['kode_bidang'].".".$peminjaman[0]['kode_kelompok'].".".$peminjaman[0]['kode_subkelompok'].".".$peminjaman[0]['kode_aset']}}</td>
              </tr>
              <tr>
                <th style="width:50%">Nama Barang</th>
                <td>{{$peminjaman[0]['nama_aset']}}</td>
              </tr>
              <tr>
                <th style="width:50%">Tanggal</th>
                <td>{{customTanggal($peminjaman[0]['tanggal'], "j M Y")}}</td>
              </tr>
              <tr>
                <th style="width:50%">Keperluan</th>
                <td>{{$peminjaman[0]['keperluan']}}</td>
              </tr>
   	        	<tr>
                <th style="width:50%">Keterangan</th>
                <td>{{$peminjaman[0]['keterangan']}}</td>
              </tr>
             @php
	        		if($peminjaman[0]['status']=="dipinjam")
	        		{
	        	@endphp
	     				<tr>
                <th style="width:50%">Keterangan Pengembalian</th>
                <td>
                		<textarea name="keterangan" class="form-control" id="txtKeterangan" rows="2" placeholder="Keterangan"></textarea>
                </td>
              </tr>
            @php
              }
            @endphp
            </table>
           </div>
          </div>
			    <div class="card-footer text-right">
			    	@php
	        		if($peminjaman[0]['status']=="dipinjam")
	        		{
	        	@endphp
			     			<button type="submit" class="btn btn-success">Dikembalikan</button>
			     			&nbsp;&nbsp;&nbsp;
			     	@php
	        		}
	        	else
	        		{
	        	@endphp
	        			<button type="submit" class="btn btn-success">Validasi</button>
			     			&nbsp;&nbsp;&nbsp;
			     			<a class="btn btn-danger" href="tolakpeminjaman/{{$peminjaman[0]['id_header']}}" role="button">Batalkan</a>
	        	@php
	        		}
	        	 @endphp 
			    </div>
			  </form>
		    @php
		  			}
		  			else
		  			{
		  	@endphp

		  <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Kode BMN</th>
                <td>{{$peminjaman[0]['kode_golongan'].".".$peminjaman[0]['kode_bidang'].".".$peminjaman[0]['kode_kelompok'].".".$peminjaman[0]['kode_subkelompok'].".".$peminjaman[0]['kode_aset']}}</td>
              </tr>
              <tr>
                <th style="width:50%">Nama Barang</th>
                <td>{{$peminjaman[0]['nama_aset']}}</td>
              </tr>
              <tr>
                <th style="width:50%">Tanggal</th>
                <td>{{customTanggal($peminjaman[0]['tanggal'], "j M Y")}}</td>
              </tr>
              <tr>
                <th style="width:50%">Keperluan</th>
                <td>{{$peminjaman[0]['keperluan']}}</td>
              </tr>
              <tr>
                <th style="width:50%">Keterangan</th>
                <td>{{$peminjaman[0]['keterangan']}}</td>
              </tr>
            </table>
           </div>
        </div>

		    <div class="card-footer text-right">
		     		<a class="btn btn-success" href="setujupeminjaman/{{$peminjaman[0]['id_header']}}" role="button">Setuju</a> 
		     		&nbsp;&nbsp;&nbsp;
		     		<a class="btn btn-danger" href="tolakpeminjaman/{{$peminjaman[0]['id_header']}}" role="button">Tidak Setuju</a>   
		    </div>

		    @php
		  			}
		  	@endphp
		</div>
	</div>
</div>


<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
	$(document).ready(function () {

	  $('#validasipeminjaman').validate({
	    rules: {
		    bmn: {
	        required: true
	      },
	    },
	    messages: {
	      bmn: {
	        required: "NUP harus dipilih."
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