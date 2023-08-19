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
						<label> Nama Lengkap {!! Template::required() !!} </label>
						<input type="text" name="nama_lengkap" placeholder="Nama Lengkap" class="form-control" required>
						<span class="invalid-feedback"></span>
					</div>
					
					<div class="form-group">
						<label> Username {!! Template::required() !!} </label>
						<input type="text" name="username" placeholder="Username" class="form-control" required>
						<span class="invalid-feedback"></span>
					</div>

					<div class="form-group">
						<label> Email {!! Template::required() !!} </label>
						<input type="email" name="email" placeholder="Email" class="form-control" required>
						<span class="invalid-feedback"></span>
					</div>

					<div class="form-group">
						<label> Password {!! Template::required() !!} </label>
						<input type="password" name="password" placeholder="Password" class="form-control" required>
						<span class="invalid-feedback"></span>
					</div>

					<div class="form-group">
						<label> Jenis Kelamin {!! Template::required() !!} </label>
						<select name="jk" class="form-control" required>
							<option value="P"> Perempuan </option>
							<option value="L"> Laki-laki </option>
						</select>
						<span class="invalid-feedback"></span>
					</div>

					<div class="form-group">
						<label> No Telepon {!! Template::required() !!} </label>
						<input type="text" name="no_telp" placeholder="No Telepon" class="form-control" required>
						<span class="invalid-feedback"></span>
					</div>

					<div class="form-group">
						<label> Alamat {!! Template::required() !!} </label>
						<input type="text" name="alamat" placeholder="Alamat" class="form-control" required>
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
			$form.find(`[name="nama_lengkap"]`).focus();
		}


		$form.on('submit', function(e){
			e.preventDefault();
			clearInvalid();

			let formData = $(this).serialize();
			$formSubmitBtn.ladda('start');

			ajaxSetup();
			$.ajax({
				url: `{{ route('user.store') }}`,
				method: 'POST',
				data: formData,
				dataType: 'json'
			})
			.done(response => {
				let { message } = response;
				successNotification('Berhasil', message)

				setTimeout(() => {
					window.location.href = `{{ route('user') }}`
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