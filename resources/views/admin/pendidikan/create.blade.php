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
						<label> Nama Pendidikan {!! Template::required() !!} </label>
						<input type="text" name="nama_pendidikan" placeholder="Nama Pendidikan" class="form-control" required>
						<span class="invalid-feedback"></span>
					</div>
					
					<div class="form-group">
						<label> Singkatan {!! Template::required() !!} </label>
						<input type="text" name="singkatan" placeholder="Singkatan" class="form-control" required>
						<span class="invalid-feedback"></span>
					</div>

					<div class="form-group">
						<label> Kategori {!! Template::required() !!} </label>
						<select name="id_kategori" style="width: 100%;" required>
							@foreach(\App\Models\KategoriPendidikan::all() as $kategori)
							<option value="{{ $kategori->id_kategori }}"> {{ $kategori->nama_kategori }} </option>
							@endforeach
						</select>
						<span class="invalid-feedback"></span>
					</div>

					<div class="form-group">
						<label> Deskripsi {!! Template::required() !!} </label>
						<input type="text" name="deskripsi" placeholder="Deskripsi" class="form-control" required>
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
			$form.find(`[name="nama_pendidikan"]`).focus();
			$form.find(`[name="id_kategori"]`).val('').trigger('change')
		}

		$form.find(`[name="id_kategori"]`).select2({
			'placeholder' : '- Pilih Kategori -'
		})

		$form.on('submit', function(e){
			e.preventDefault();
			clearInvalid();

			let formData = $(this).serialize();
			$formSubmitBtn.ladda('start');

			ajaxSetup();
			$.ajax({
				url: `{{ route('pendidikan.store') }}`,
				method: 'POST',
				data: formData,
				dataType: 'json'
			})
			.done(response => {
				let { message } = response;
				successNotification('Berhasil', message)

				setTimeout(() => {
					window.location.href = `{{ route('pendidikan') }}`
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