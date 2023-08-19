@extends('layouts.template')


@section('styles')
<style type="text/css">
	.btn-primary {
		color: #fff !important;
	}
</style>
@endsection


@section('content')
<div class="row">

	<div class="col-lg-7">
		<div class="card">
			
			<div class="card-header">
				<h4 class="card-title"> 
					<span class="d-inline-block">
						Data Diri
					</span>
				</h4>
			</div>

			<div class="card-body">

				<form id="form">

					{!! Template::requiredBanner() !!}

					<div class="row mt-2">
						
						<div class="col-lg-6">
							<div class="form-group">
								<label> Kode </label>
								<input type="text" class="form-control" placeholder="Kode" value="{{ auth()->user()->userCode() }}" readonly>
							</div>
							<div class="form-group">
								<label> Email </label>
								<input type="email" name="email" class="form-control" placeholder="Email" value="{{ auth()->user()->email }}">
								<span class="invalid-feedback"></span>
							</div>
						</div>

						<div class="col-lg-6">
							<div class="form-group">
								<label> Nama {!! Template::required() !!} </label>
								<input type="text" name="name" class="form-control" placeholder="Nama" value="{{ auth()->user()->name }}" required>
								<span class="invalid-feedback"></span>
							</div>
							<div class="form-group">
								<label> No Telepon </label>
								<input type="text" name="phone_number" class="form-control" placeholder="No Telepon" value="{{ auth()->user()->phone_number }}">
								<span class="invalid-feedback"></span>
							</div>
						</div>

					</div>

					<hr>

					<div class="row">

						<div class="col-lg-6">
							<div class="form-group">
								<label> Foto Saat Ini </label> <br>
								<img src="{{ auth()->user()->avatarLink() }}" style="border-radius: 100% !important; width: 250px; height: 250px; object-position: center; object-fit: cover;">
							</div>	
						</div>

						<div class="col-lg-6">
							<div class="form-group">
								<label> Foto Baru </label> <br>
								<input type="file" name="avatar" class="form-control">
							</div>

							<div class="form-group">
								<label> Preview </label> <br>
								<span id="preview-label"> Belum ada </span>
								<img id="preview-photo" src="" style="display: none; max-width: 150px; max-height: 150px;">
							</div>
						</div>

					</div>

					<hr>

					<div class="row">

						<div class="col-lg-6">
							<div class="form-group">
								<label> Username {!! Template::required() !!} </label> <br>
								<input type="text" name="username" class="form-control" placeholder="Username" value="{{ auth()->user()->username }}" required>
								<span class="invalid-feedback"></span>
							</div>	
						</div>

						<div class="col-lg-6">
							<div class="form-group">
								<label> Password </label> <br>
								<input type="password" name="password" class="form-control" placeholder="Isi Jika Ingin Ganti Password">
								<span class="invalid-feedback"></span>
							</div>
						</div>

					</div>

					<hr>

					<button type="submit" class="btn btn-primary">
						<i class="fas fa-save mr-1"></i> Simpan
					</button>

				</form>
			</div>

		</div>
	</div>

</div>
@endsection


@section('scripts')
<script>
	
	$(function(){

		$form = $('#form')
		$formSubmitBtn = $form.find(`[type="submit"]`).ladda();

		$form.find(`[name="name"]`).focus();

		$form.find('[name="avatar"]').on('change', function(){
			let file = $(this).val();
			
			if(file!=="") {
				let fileType = this.files[0].type;

				if(fileType.substring(0, 5) != "image") {
					warningNotification('Peringatan', 'File harus berupa foto');
					$(this).val('');
				} else {
					let reader = new FileReader();

					reader.onload = function(e) {
						$('#preview-photo').attr('src', e.target.result);
					}

					reader.readAsDataURL(this.files[0]);

					$('#preview-photo').show();
					$('#preview-label').hide();
				}
			} else {
				$('#preview-photo').hide();
				$('#preview-label').show();
			}
		});

		$form.on('submit', function(e){
			e.preventDefault();
			clearInvalid();

			let formData = new FormData(this);
			$formSubmitBtn.ladda('start')

			ajaxSetup();
			$.ajax({
				url: `{{ route('profile.update') }}`,
				data: formData,
				method: 'post',
				dataType: 'json',
				contentType : false,
				processData : false,
			})
			.done(response => {
				let { message } = response;
				successNotification('Berhasil', message)

				setTimeout(() => {
					window.location.href = `{{ route('profile') }}`
				}, 1500)
			})
			.fail(error => {
				$formSubmitBtn.ladda('stop');
				ajaxErrorHandling(error, $form);
			})
		})

	})

</script>
@endsection