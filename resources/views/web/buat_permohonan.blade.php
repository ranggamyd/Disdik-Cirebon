@extends('layouts.web')


@section('content')
<main id="main" data-aos="fade-up">
	<section class="breadcrumbs">
		<div class="container">
			<div class="d-flex justify-content-between align-items-center">
				<h2> {{ $title }} </h2>
				<ol>
					<li><a href="{{ url('/') }}"> Beranda </a></li>
					<li> {{ $title }} </li>
				</ol>
			</div>
		</div>
	</section>
	
	<section class="inner-page">
		<div class="container">
			<h2 align="center" class="mb-5"> Izin Pendirian Satuan Pendidikan </h2>

			<form id="form">
				<div class="card mb-4">
					<div class="card-header">
						Informasi Yayasan
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="mb-3">
									<label class="d-block mb-2"> Nama Yayasan {!! Template::required() !!} </label>
									<input type="text" name="nama_yayasan" class="form-control" placeholder="Nama Yayasan" required>
								</div>

								<div class="mb-3">
									<label class="d-block mb-2"> Nama Ketua Yayasan {!! Template::required() !!} </label>
									<input type="text" name="nama_ketua_yayasan" class="form-control" placeholder="Nama Ketua Yayasan" required>
								</div>

								<div class="mb-3">
									<label class="d-block mb-2"> Email {!! Template::required() !!} </label>
									<input type="email" name="email" class="form-control" placeholder="Email" required>
								</div>

								<div class="mb-3">
									<label class="d-block mb-2"> No Telepon {!! Template::required() !!} </label>
									<input type="text" name="no_telp" class="form-control" placeholder="No Telepon" required>
								</div>
							</div>

							<div class="col-lg-6">
								<div class="mb-3">
									<label class="d-block mb-2"> Nama Pendidikan {!! Template::required() !!} </label>
									<input type="text" class="form-control" name="nama_pendidikan" placeholder="Nama Pendidikan" required>
								</div>

								<div class="mb-3">
									<label class="d-block mb-2"> Nama Kepala Pendidikan {!! Template::required() !!} </label>
									<input type="text" name="nama_kepala_pendidikan" class="form-control" placeholder="Nama Kepala Pendidikan" required>
								</div>

								<div class="mb-3">
									<label class="d-block mb-2"> Alamat Lengkap {!! Template::required() !!} </label>
									<input type="text" name="alamat" class="form-control" placeholder="Alamat Lengkap" required>
								</div>
							</div>
						</div>
					</div>
				</div>


				<div class="card mb-4">
					<div class="card-header">
						Informasi Yayasan
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th width="50"> No. </th>
										<th> Nama Persyaratan </th>
										<th> Input Form </th>
									</tr>
								</thead>
								<tbody>
									@foreach($pendidikan->persyaratan as $persyaratan)
									<tr>
										<td> {{ $loop->iteration }} </td>
										<td> {{ $persyaratan->nama_persyaratan }} </td>
										<td>
											@if($persyaratan->tipe_input == 'Text input')
												@if($persyaratan->is_required)
												<input type="text" name="persyaratan[{{ $persyaratan->id_persyaratan }}]" class="form-control" placeholder="{{ $persyaratan->nama_persyaratan }}" required>
												@else
												<input type="text" name="persyaratan[{{ $persyaratan->id_persyaratan }}]" class="form-control" placeholder="{{ $persyaratan->nama_persyaratan }}">
												@endif
											@elseif($persyaratan->tipe_input == 'File upload')
												@if($persyaratan->is_required)
												<input type="file" name="persyaratan[{{ $persyaratan->id_persyaratan }}]" class="form-control" required>
												@else
												<input type="file" name="persyaratan[{{ $persyaratan->id_persyaratan }}]" class="form-control">
												@endif
											@endif
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<hr>

				<button class="btn btn-primary" type="submit">
					Ajukan Permohonan
				</button>
				
			</form>

		</div>
	</section>
</main>
@endsection


@section('style')
<link rel="stylesheet" href="{{ url('vendors/ladda/ladda-themeless.min.css') }}">
<link rel="stylesheet" href="{{ url('vendors/toastr/toastr.css') }}">
@endsection


@section('script')
<script src="{{ url('js/jquery.min.js') }}"></script>
<script src="{{ url('vendors/ladda/spin.min.js') }}"></script>
<script src="{{ url('vendors/ladda/ladda.min.js') }}"></script>
<script src="{{ url('vendors/ladda/ladda.jquery.min.js') }}"></script>
<script src="{{ url('vendors/toastr/toastr.js') }}"></script>
<script src="{{ url('js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ url('js/myJs.js') }}"></script>
<script type="text/javascript">
	$(function(){

		$form = $('#form')
		$submitBtn = $form.find(`[type="submit"]`).ladda()

		$form.on('submit', function(e){
			e.preventDefault()

			const formData = new FormData(this);
			$submitBtn.ladda('start')

			ajaxSetup()
			$.ajax({
				url: `{{ url('save-buat-permohonan/'.$pendidikan->id_pendidikan) }}`,
				method: 'post',
				dataType: 'json',
				data: formData,
				contentType: false,
				processData: false,
			})
			.done(response => {
				successNotification('Berhasil', response.message)

				setTimeout(() => {
					window.location.href = `{{ url('permohonan') }}/${response.no_pendaftaran}`
				}, 1000)
			})
			.fail(error => {
				const { responseJSON } = error
				const { message } = responseJSON
				$submitBtn.ladda('stop')
				toastr.warning(message, 'Peringatan')
			})
		})

	})
</script>
@endsection