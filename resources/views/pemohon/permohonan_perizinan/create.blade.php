@extends('layouts.template')


@section('content')
<form id="form">
	<div class="row">
		
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title"> 
						<span class="d-inline-block">
							{{ $title ?? 'Judul' }}
						</span>
					</h4>
				</div>

				<div class="card-body">

					{!! Template::requiredBanner() !!}

					<input type="hidden" name="id_pendidikan" value="{{ $pendidikan->id_pendidikan }}">

					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label> Nama Yayasan {!! Template::required() !!} </label>
								<input type="text" name="nama_yayasan" class="form-control" placeholder="Nama Yayasan" required>
							</div>

							<div class="form-group">
								<label> Nama Ketua Yayasan {!! Template::required() !!} </label>
								<input type="text" name="nama_ketua_yayasan" class="form-control" placeholder="Nama Ketua Yayasan" required>
							</div>

							<div class="form-group">
								<label> Email {!! Template::required() !!} </label>
								<input type="email" name="email" class="form-control" placeholder="Email" required>
							</div>

							<div class="form-group">
								<label> No Telepon {!! Template::required() !!} </label>
								<input type="text" name="no_telp" class="form-control" placeholder="No Telepon" required>
							</div>
						</div>

						<div class="col-lg-6">
							<div class="form-group">
								<label> Nama Pendidikan {!! Template::required() !!} </label>
								<input type="text" class="form-control" name="nama_pendidikan" placeholder="Nama Pendidikan" required>
							</div>

							<div class="form-group">
								<label> Nama Kepala Pendidikan {!! Template::required() !!} </label>
								<input type="text" name="nama_kepala_pendidikan" class="form-control" placeholder="Nama Kepala Pendidikan" required>
							</div>

							<div class="form-group">
								<label> Alamat Lengkap {!! Template::required() !!} </label>
								<input type="text" name="alamat" class="form-control" placeholder="Alamat Lengkap" required>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<h4 class="card-title"> 
						<span class="d-inline-block">
							Persyaratan
						</span>
					</h4>
				</div>

				<div class="card-body">

					{!! Template::requiredBanner() !!}

					<br>

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
									<td>
										{{ $persyaratan->nama_persyaratan }}
										@if($persyaratan->is_required)
										{!! Template::required() !!}
										@endif
									</td>
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
										@elseif($persyaratan->tipe_input == 'Multiple choise')
											@if($persyaratan->is_required)
											<select class="form-control" name="persyaratan[{{ $persyaratan->id_persyaratan }}]" required>
												<option selected disabled> - Pilih - </option>
												@foreach($persyaratan->opsiMultiple() as $opsi)
												<option value="{{ $opsi }}"> {{ $opsi }} </option>
												@endforeach
											</select>
											@else
											<select class="form-control" name="persyaratan[{{ $persyaratan->id_persyaratan }}]">
												<option selected disabled> - Pilih - </option>
												@foreach($persyaratan->opsiMultiple() as $opsi)
												<option value="{{ $opsi }}"> {{ $opsi }} </option>
												@endforeach
											</select>
											@endif
										@endif
									</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>

					<hr>

					<button class="btn btn-primary" type="submit">
						<i class="fas fa-save mr-1"></i> Simpan
					</button>

				</div>
			</div>
		</div>


	</div>
</form>
@endsection


@section('scripts')
<script>
	
	$(function(){

		const $form = $('#form');
		const $formSubmitBtn = $form.find(`[type="submit"]`).ladda();

		const resetForm = () => {
			$form[0].reset();
			$form.find(`[name="nama_yayasan"]`).focus();
		}

		$form.on('submit', function(e){
			e.preventDefault();
			clearInvalid();

			let formData = new FormData(this);
			$formSubmitBtn.ladda('start');

			ajaxSetup();
			$.ajax({
				url: `{{ route('permohonan_perizinan.store') }}`,
				method: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false
			})
			.done(response => {
				let { message } = response;
				successNotification('Berhasil', message)

				setTimeout(() => {
					window.location.href = `{{ route('permohonan_perizinan') }}`
				}, 1000)
			})
			.fail(error => {
				$formSubmitBtn.ladda('stop');
				ajaxErrorHandling(error, $form);
			})
		})

		resetForm();

	})

</script>
@endsection