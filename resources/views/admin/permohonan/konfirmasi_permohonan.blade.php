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

	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title"> 
					<span class="d-inline-block">
						Syarat & Ketentuan
					</span>
				</h4>
			</div>

			<div class="card-body">
				<form id="form">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label> Konfirmasi {!! Template::required() !!} </label>
								<div class="ml-4">
									<label class="d-inline-block">
										<input type="radio" class="form-check-input" name="konfirmasi" value="Diterima" required> Diterima
									</label>

									<label class="d-inline-block ml-5">
										<input type="radio" class="form-check-input" name="konfirmasi" value="Ditolak" required> Ditolak
									</label>
								</div>
							</div>

							<div class="form-group">
								<label> Surat Keputusan {!! Template::required() !!} </label>
								<input type="file" name="surat_keputusan" class="form-control" required>
							</div>
						</div>

						<div class="col-lg-6">
							<div class="form-group">
								<label> Tanggal {!! Template::required() !!} </label>
								<input type="date" name="tanggal" class="form-control" required>
							</div>

							<div class="form-group">
								<label> Catatan E-mail {!! Template::required() !!} </label>
								<textarea class="form-control" name="catatan_email" placeholder="Catatan Email" rows="4" required></textarea>
							</div>
						</div>
					</div>

					<hr>

					<div class="text-right">
						<button class="btn btn-primary" type="reset">
							<i class="fas fa-sync mr-1"></i> Reset
						</button>

						<button class="btn btn-primary" type="submit">
							<i class="fas fa-save mr-1"></i> Simpan
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</div>
@endsection


@section('scripts')
<script>
	
	$(function(){

		const $form = $('#form');
		const $formSubmitBtn = $form.find(`[type="submit"]`).ladda();

		$form.on('submit', function(e){
			e.preventDefault();
			clearInvalid();

			let formData = new FormData(this);
			$formSubmitBtn.ladda('start');

			ajaxSetup();
			$.ajax({
				url: `{{ route('permohonan.simpan_konfirmasi_permohonan', $permohonan->id_permohonan) }}`,
				method: 'POST',
				data: formData,
				dataType: 'json',
				contentType: false,
				processData: false,
			})
			.done(response => {
				let { message } = response;
				successNotification('Berhasil', message)

				setTimeout(() => {
					window.location.href = `{{ route('permohonan') }}`
				}, 1000)
			})
			.fail(error => {
				$formSubmitBtn.ladda('stop');
				ajaxErrorHandling(error, $form);
			})
		})

	})

</script>
@endsection