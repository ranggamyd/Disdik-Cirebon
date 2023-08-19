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
						<label> Nama Persyaratan {!! Template::required() !!} </label>
						<input type="text" name="nama_persyaratan" placeholder="Nama Persyaratan" class="form-control" required>
						<span class="invalid-feedback"></span>
					</div>

					<div class="form-group">
						<label> Pendidikan {!! Template::required() !!} </label>
						<select name="id_pendidikan" style="width: 100%;" required>
							@foreach(\App\Models\Pendidikan::all() as $pendidikan)
							<option value="{{ $pendidikan->id_pendidikan }}"> {{ $pendidikan->nama_pendidikan }} </option>
							@endforeach
						</select>
						<span class="invalid-feedback"></span>
					</div>
					
					<div class="form-group">
						<label> Tipe Input {!! Template::required() !!} </label>
						<select name="tipe_input" style="width: 100%;" required>
							<option value="File upload"> File upload </option>
							<option value="Text input"> Text input </option>
							<option value="Multiple choise"> Multiple choise </option>
						</select>
						<span class="invalid-feedback"></span>
					</div>

					<div id="opsi-multiple"></div>

					<div class="form-group">
						<label> Wajib Dilengkapi {!! Template::required() !!} </label>
						<select name="is_required" class="form-control" required>
							<option value="1"> Ya </option>
							<option value="0"> Tidak </option>
						</select>
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
			$form.find(`[name="nama_persyaratan"]`).focus();
			$form.find(`[name="id_pendidikan"]`).val('').trigger('change')
			$form.find(`[name="tipe_input"]`).val('').trigger('change')
		}

		$form.find(`[name="id_pendidikan"]`).select2({
			'placeholder' : '- Pilih Pendidikan -'
		})

		$form.find(`[name="tipe_input"]`).select2({
			'placeholder' : '- Pilih Tipe Input -'
		})

		$form.on('submit', function(e){
			e.preventDefault();
			clearInvalid();

			let formData = $(this).serialize();
			$formSubmitBtn.ladda('start');

			ajaxSetup();
			$.ajax({
				url: `{{ route('persyaratan.store') }}`,
				method: 'POST',
				data: formData,
				dataType: 'json'
			})
			.done(response => {
				let { message } = response;
				successNotification('Berhasil', message)

				setTimeout(() => {
					window.location.href = `{{ route('persyaratan') }}`
				}, 1000)
			})
			.fail(error => {
				$formSubmitBtn.ladda('stop');
				ajaxErrorHandling(error, $form);
			})
		})

		$form.find(`[name="tipe_input"]`).on('change', function(){
			const value = $(this).val()

			if(value == 'Multiple choise') {
				$form.find('#opsi-multiple').html($('#opsi-multiple-template').text())
			} else {
				$form.find('#opsi-multiple').html('')
			}
		})

		resetForm();

	})

</script>

<script type="text/html" id="opsi-multiple-template">
	<div class="form-group">
		<label> Opsi Multiple Choise {!! Template::required() !!} </label>
		<div class="mt-1 mb-2">
			Catatan : Setiap baris mewakili 1 opsi
		</div>
		<textarea class="form-control" name="opsi_multiple" rows="5" placeholder="Setiap baris mewakili 1 opsi" required></textarea>
	</div>
</script>
@endsection