@extends('layouts.template')


@section('content')
<form id="form">
	<div class="row">
		
		<div class="col-lg-6">
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

					<div class="form-group">
						<label> Nama Kategori {!! Template::required() !!} </label>
						<input type="text" name="nama_kategori" placeholder="Nama Kategori" class="form-control" value="{{ $kategoriPendidikan->nama_kategori }}" required>
						<span class="invalid-feedback"></span>
					</div>

					<div class="form-group">
						<label> Deskripsi {!! Template::required() !!} </label>
						<input type="text" name="deskripsi" placeholder="Deskripsi" class="form-control" value="{{ $kategoriPendidikan->deskripsi }}" required>
						<span class="invalid-feedback"></span>
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
			$form.find(`[name="nama_kategori"]`).focus();
		}


		$form.on('submit', function(e){
			e.preventDefault();
			clearInvalid();

			let formData = $(this).serialize();
			$formSubmitBtn.ladda('start');

			ajaxSetup();
			$.ajax({
				url: `{{ route('kategori_pendidikan.update', $kategoriPendidikan->id_kategori) }}`,
				method: 'PUT',
				data: formData,
				dataType: 'json'
			})
			.done(response => {
				let { message } = response;
				successNotification('Berhasil', message)

				setTimeout(() => {
					window.location.href = `{{ route('kategori_pendidikan') }}`
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