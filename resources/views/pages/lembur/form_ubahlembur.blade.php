@extends('layouts.dashboard')
@section('page_heading','Lembur Pegawai')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{url('lembur')}}">Lembur Pegawai</a></li>
  <li class="breadcrumb-item active">Tambah Lembur Pegawai</li>
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
		  <form role="form" id="ubahlembur" method="post" action="{{url('prosesubahlembur')}}" >
		  	{{ csrf_field() }}
	
			<div class="card-body">
				<div class="row">
				    <div class="col-md-6">
				      
			          <input type="hidden" name="id" class="form-control" id="txtID" value="{{$lemburheader->id}}"></input>
			      	 
				      <div class="form-group">
				        <label>No. Surat</label>
				        <input type="text" name="no_surat" class="form-control" value="{{$lemburheader->no_surat}}" id="txtNoSurat" placeholder="Nomor Surat">
				      </div>
				      <div class="form-group">
				        <label>Tanggal Surat</label>
				        <div class="input-group date">
		                  <input type="text" name="tanggal_surat" class="form-control" value="{{date('d/m/Y', strtotime($lemburheader->tanggal_surat))}}" id="datepicker" placeholder="dd/mm/yyyy" value="{{date('d/m/Y', strtotime(now()))}}">
		                  <div class="input-group-prepend">
		                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
		                  </div>
	                	</div>
			      	  </div>
			      	  <div class="card">
			      	  	<div class="card-header">
			                <h4 class="card-title"><b>Yang Mengusulkan</b></h4>
			            </div>
			            <div class="card-body">
			      	      <div class="form-group">
					        <label>Nama</label>
					        <select name="diusulkan" class="form-control select2bs4" style="width: 100%;">
			                    <option value="" selected="selected">-- Pilih Satu --</option>
			                    @foreach($pegawai as $data)
			                        <option value="{{$data->id}}" @if($data->id == $lemburheader->diusulkan) selected @endif>{{$data->nama}}</option>
			                    @endforeach
			                </select>
					      </div>
					      <div class="form-group">
					        	<label>Jabatan</label>
					        	<input type="text" name="jabatan_pengusul" class="form-control" value="{{$lemburheader->jabatan_pengusul}}" id="txtJabatanPengusul" placeholder="Jabatan Yang Mengusulkan">
					      </div>
					    </div>
					  </div>
			      	</div>

				    <div class="col-md-6">
			      	    <div class="card">
				      	  	<div class="card-header">
				                <h4 class="card-title"><b>Yang Menyetujui</b></h4>
				            </div>
				            <div class="card-body">
							    <div class="form-group">
							        <label>Nama</label>
							        <select name="disetujui" class="form-control select2bs4" style="width: 100%;">
					                    <option value="" selected="selected">-- Pilih Satu --</option>
					                    @foreach($pegawai as $data)
					                        <option value="{{$data->id}}" @if($data->id == $lemburheader->disetujui) selected @endif>{{$data->nama}}</option>
					                    @endforeach
					                </select>
							    </div>
							    <div class="form-group">
							        <label>Jabatan</label>
							        <input type="text" name="jabatan_penyetuju" class="form-control" value="{{$lemburheader->jabatan_penyetuju}}" id="txtJabatanPenyetuju" placeholder="Jabatan Yang Menyetujui">
							    </div>
							</div>
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

		<div class="row" id="detailrow">
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title"><b>Detail Lembur Pegawai</b></h3>
                <a href="{{url('tambahlemburdetail/'.$lemburheader->id)}}" type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#modal-detail">Tambah Detail</a>
              </div>
              <div class="card-body">
             	<table id="detailtable" class="table table-striped">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>NIP</th>
                      <th>Gol</th>
                      <th>Tanggal Lembur</th>
                      <th>Bidang Pekerjaan</th>
                      <th>Uraian Pekerjaan</th>
                      <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
		            @php
		            $no = 0
		            @endphp
		            @foreach($lemburdetail as $data)  
		               <tr>
		                  <td>{{++$no}}</td>
		                  <td>{{$data->nama}}</td>
		                  <td>{{$data->nip}}</td>
		                  <td>{{$data->gol}}</td>
		                  <td>{{$data->tanggallemburawal.' s/d '.$data->tanggallemburakhir}}</td>
		                  <td>{{$data->bidang_pekerjaan}}</td>
		                  <td>{{$data->uraian_pekerjaan}}</td>
		                  <td>
		                    <div class="btn-group">
		                      <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><i class="fas fa-check nav-icon"></i>
		                      <span class="caret"></span>
		                      </button>
		                      <div class="dropdown-menu" id="dropdown-action-id">
		                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-detail2" onclick ="datalemburdetail({{$data->id}})">Ubah Data</a>
		                        <a class="dropdown-item swalDelete" href="{{url('hapuslemburdetail/'.$lemburheader->id.'/'.$data->id)}}">Hapus Data</a>
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
        </div>
        <!-- /.row -->
	</div>
</div>

<!-- Modal Tambah Detail -->
<div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="row">
			<!-- left column -->
			<div class="col-md-12">
			<!-- jquery validation -->
				<div class="card card-primary">
				  <div class="card-header">
				    <h3 class="card-title">Tambah Detail</h3>
				  </div>
				  <!-- /.card-header -->
				  <!-- form start -->
				  <form role="form" id="tambahlemburdetail" method="post" action="{{url('prosestambahlemburdetail')}}" >
				  	{{ csrf_field() }}
			
					<div class="card-body">
						<div class="row">
						    <div class="col-md-6">
					        	
					          <input type="hidden" name="id_header" class="form-control" id="txtIDHeader" value="{{$lemburheader->id}}"></input>

						      <div class="form-group">
						        <label>Nama Pegawai</label>
						        <select name="pegawai" class="form-control select2bs4" onchange="datapegawai(this.value)" style="width: 100%;">
				                    <option value="" selected="selected">-- Pilih Satu --</option>
				                    @foreach($pegawai as $data)
				                        <option value="{{$data->id}}">{{$data->nama}}</option>
				                    @endforeach
				                </select>
						      </div>
						      <div class="form-group">
						        <label>NIP</label>
						        <input type="text" name="nip" class="form-control" id="txtNIP" placeholder="NIP" readonly>
						      </div>
						      <div class="form-group">
						        <label>Pangkat/Gol.</label>
						        <input type="text" name="golongan" class="form-control" id="txtGolongan" placeholder="Golongan" readonly>
						      </div>
						    </div>
						    <div class="col-md-6">
						    	<div class="form-group">
							        <label>Tanggal Lembur</label>
							        <div class="row">
							        	 <div class="col-md-5">
									        <div class="input-group date">
							                  <input type="text" name="tanggal_lembur_awal" class="form-control" id="datepickerawal" placeholder="dd/mm/yyyy" value="{{date('d/m/Y', strtotime(now()))}}">
							                  <div class="input-group-prepend">
							                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
							                  </div>
						                	</div>
						                </div>
						                <div class="col-md-2">
						            		<h5 style="margin-left: 10px">s/d</h5>
						                </div>
						                <div class="col-md-5">
						                	<div class="input-group date">
							                  <input type="text" name="tanggal_lembur_akhir" class="form-control" id="datepickerakhir" placeholder="dd/mm/yyyy" value="{{date('d/m/Y', strtotime(now()))}}">
							                  <div class="input-group-prepend">
							                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
							                  </div>
						                	</div>
						                </div>
					                </div>
						      	</div>
							    <div class="form-group">
							      	<label>Bidang Pekerjaan</label>
							        <input type="text" name="bidang_pekerjaan" class="form-control" id="txtBidangPekerjaan" Placeholder="Bidang Pekerjaan"></textarea>
							    </div>

							    <div class="form-group">
							      	<label>Uraian Pekerjaan</label>
							        <textarea name="uraian_pekerjaan" class="form-control" id="txtUraianPekerjaan" rows="2" placeholder="Keterangan"></textarea>
							    </div>
							</div>
					    </div>
					</div>
						    <!-- /.card-body -->
				    <div class="card-footer">
				      <button type="submit" id="simpandetail" class="btn btn-primary">Simpan</button>
				    </div>
			  	</form>
				</div>
			</div>
		</div>
      </div>
    </div>
</div>
<!-- Modal Tambah Detail-->

<!-- Modal Ubah Detail -->
<div class="modal fade" id="modal-detail2">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="row">
			<!-- left column -->
			<div class="col-md-12">
			<!-- jquery validation -->
				<div class="card card-primary">
				  <div class="card-header">
				    <h3 class="card-title">Ubah Detail</h3>
				  </div>
				  <!-- /.card-header -->
				  <!-- form start -->
				  <form role="form" id="ubahlemburdetail" method="post" action="{{url('prosesubahlemburdetail')}}" >
				  	{{ csrf_field() }}
			
					<div class="card-body">
						<div class="row">
						    <div class="col-md-6">
					        	
					          <input type="hidden" name="id_header2" class="form-control" id="txtIDHeader2" value="{{$lemburheader->id}}"></input>

					           <input type="hidden" name="id_detail2" class="form-control" id="txtIDDetail2"></input>

						      <div class="form-group">
						        <label>Nama Pegawai</label>
						        <select name="pegawai2" id="slcPegawai2" class="form-control select2bs4" onchange="datapegawai2(this.value)" style="width: 100%;">
				                    <option value="" selected="selected">-- Pilih Satu --</option>
				                    @foreach($pegawai as $data)
				                        <option value="{{$data->id}}">{{$data->nama}}</option>
				                    @endforeach
				                </select>
						      </div>
						      <div class="form-group">
						        <label>NIP</label>
						        <input type="text" name="nip2" class="form-control" id="txtNIP2" placeholder="NIP" readonly>
						      </div>
						      <div class="form-group">
						        <label>Pangkat/Gol.</label>
						        <input type="text" name="golongan2" class="form-control" id="txtGolongan2" placeholder="Golongan" readonly>
						      </div>
						    </div>
						    <div class="col-md-6">
						    	<div class="form-group">
							        <label>Tanggal Lembur</label>
							        <div class="row">
							        	 <div class="col-md-5">
									        <div class="input-group date">
							                  <input type="text" name="tanggal_lembur_awal2" class="form-control" id="datepickerawal2" placeholder="dd/mm/yyyy" value="{{date('d/m/Y', strtotime(now()))}}">
							                  <div class="input-group-prepend">
							                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
							                  </div>
						                	</div>
						                </div>
						                <div class="col-md-2">
						            		<h5 style="margin-left: 10px">s/d</h5>
						                </div>
						                <div class="col-md-5">
						                	<div class="input-group date">
							                  <input type="text" name="tanggal_lembur_akhir2" class="form-control" id="datepickerakhir2" placeholder="dd/mm/yyyy" value="{{date('d/m/Y', strtotime(now()))}}">
							                  <div class="input-group-prepend">
							                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
							                  </div>
						                	</div>
						                </div>
					                </div>
						      	</div>
							    <div class="form-group">
							      	<label>Bidang Pekerjaan</label>
							        <input type="text" name="bidang_pekerjaan2" class="form-control" id="txtBidangPekerjaan2" Placeholder="Bidang Pekerjaan"></textarea>
							    </div>

							    <div class="form-group">
							      	<label>Uraian Pekerjaan</label>
							        <textarea name="uraian_pekerjaan2" class="form-control" id="txtUraianPekerjaan2" rows="2" placeholder="Keterangan"></textarea>
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
      </div>
    </div>
</div>
<!-- Modal Ubah Detail-->

<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
	$(document).ready(function () {

	  $('#ubahlembur').validate({
	    rules: {
	      no_surat: {
	        required: true
	      },
	      tanggal_surat: {
	        required: true
	      },
	      diusulkan: {
	        required: true,
	      },
	      jabatan_pengusul: {
	        required: true,
	      },
	      disetujui: {
	        required: true,
	      },
	      jabatan_penyetuju: {
	        required: true,
	      },
	    },
	    messages: {
	      no_surat: {
	        required: "Nomor Surat harus diisi."
	      },
	      tanggal_surat: {
	        required: "Tanggal Surat harus diisi."
	      },
	      diusulkan: {
	        required: "Nama harus diisi.",
	      },
	      jabatan_pengusul: {
	        required: "Jabatan harus diisi.",
	      },
	      disetujui: {
	        required: "Nama harus diisi.",
	      },
	      jabatan_penyetuju: {
	        required: "Jabatan harus diisi.",
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

	  $('#tambahlemburdetail').validate({
	    rules: {
	      pegawai: {
	        required: true
	      },
	      tanggal_lembur_awal: {
	        required: true
	      },
	      tanggal_lembur_akhir: {
	        required: true,
	      },
	      bidang_pekerjaan: {
	        required: true,
	      },
	      uraian_pekerjaan: {
	        required: true,
	      },
	    },
	    messages: {
	      pegawai: {
	        required: "Nama Pegawai harus dipilih."
	      },
	      tanggal_lembur_awal: {
	        required: "Tanggal Lembur harus diisi."
	      },
	      tanggal_lembur_akhir: {
	        required: "Tanggal lembur harus diisi.",
	      },
	      bidang_pekerjaan: {
	        required: "Bidang Pekerjaan harus diisi.",
	      },
	      uraian_pekerjaan: {
	        required: "Uraian Perkerjaan harus diisi.",
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

	  $('#tambahlemburdetail').validate({
	    rules: {
	      pegawai2: {
	        required: true
	      },
	      tanggal_lembur_awal2: {
	        required: true
	      },
	      tanggal_lembur_akhir2: {
	        required: true,
	      },
	      bidang_pekerjaan2: {
	        required: true,
	      },
	      uraian_pekerjaan2: {
	        required: true,
	      },
	    },
	    messages: {
	      pegawai2: {
	        required: "Nama Pegawai harus dipilih."
	      },
	      tanggal_lembur_awal2: {
	        required: "Tanggal Lembur harus diisi."
	      },
	      tanggal_lembur_akhir2: {
	        required: "Tanggal lembur harus diisi.",
	      },
	      bidang_pekerjaan2: {
	        required: "Bidang Pekerjaan harus diisi.",
	      },
	      uraian_pekerjaan2: {
	        required: "Uraian Perkerjaan harus diisi.",
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


    //datepicker
	$('#datepickerawal').datepicker({
	  format: 'dd/mm/yyyy',
	  autoclose: true
	})

	$('#datepickerakhir').datepicker({
	  format: 'dd/mm/yyyy',
	  autoclose: true
	})

	$('#datepickerawal2').datepicker({
	  format: 'dd/mm/yyyy',
	  autoclose: true
	})

	$('#datepickerakhir2').datepicker({
	  format: 'dd/mm/yyyy',
	  autoclose: true
	})

   });

   function datapegawai(id_pegawai)
   {
	    //alert(id_pegawai);
	    if(id_pegawai!="")
	    {
	      $.ajax({
		        url: '../jsondatapegawai/'+id_pegawai,
		        type : 'GET',
		        datatype: "json",
		        success:function(data)
		        {
		          //alert(data);
		          var output = JSON.parse(data);
		          console.log(output);

	              $("#txtNIP").val(output.nip);
	              $("#txtGolongan").val(output.gol);
		        } 
	      	});
	    }
	    else
	    {
	      	$("#txtNIP").val("");
	      	$("#txtGolongan").val("");
	    }
  	}


   function datapegawai2(id_pegawai)
   {
	    //alert(id_pegawai);
	    if(id_pegawai!="")
	    {
	      $.ajax({
		        url: '../jsondatapegawai/'+id_pegawai,
		        type : 'GET',
		        datatype: "json",
		        success:function(data)
		        {
		          //alert(data);
		          var output = JSON.parse(data);
		          console.log(output);

	              $("#txtNIP2").val(output.nip);
	              $("#txtGolongan2").val(output.gol);
		        } 
	      	});
	    }
	    else
	    {
	      	$("#txtNIP2").val("");
	      	$("#txtGolongan2").val("");
	    }
  	}

  	function datalemburdetail(id_lemburdetail)
   	{
	    //alert(id_lemburdetail);
	    if(id_lemburdetail!="")
	    {
	      $.ajax({
		        url: '../jsonlemburdetail/'+id_lemburdetail,
		        type : 'GET',
		        datatype: "json",
		        success:function(data)
		        {
		          //alert(data);
		          var output = JSON.parse(data);
		          console.log(output);

		          $("#txtIDDetail2").val(output.id);
              	  $("#slcPegawai2").val(output.id_pegawai).change();
	              $("#txtNIP2").val(output.nip);
	              $("#txtGolongan2").val(output.gol);
	              $("#datepickerawal2").val(output.tanggal_lembur_awal);
	              $("#datepickerakhir2").val(output.tanggal_lembur_akhir);
	              $("#txtBidangPekerjaan2").val(output.bidang_pekerjaan)
	              $("#txtUraianPekerjaan2").val(output.uraian_pekerjaan)
		        } 
	      	});
	    }
	    else
	    {
	      	$("#txtNIP2").val("");
	      	$("#txtGolongan2").val("");
	      	$("#txtBidangPekerjaan2").val("")
	      	$("#txtUraianPekerjaan2").val("")
	    }
  	}
</script>
@endsection