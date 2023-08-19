@extends('layouts.template')


@section('styles')
<style>
	.img-preview {
		cursor: pointer;
	}
</style>
@endsection


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
						<label> Visi {!! Template::required() !!} </label>
						<textarea class="form-control" name="visi" placeholder="Visi" rows="4" required>{{ setting('visi', '') }}</textarea>
						<span class="invalid-feedback"></span>
					</div>

					<div class="form-group">
						<label> Misi {!! Template::required() !!} </label>
						<textarea class="form-control" name="misi" placeholder="Misi" rows="8" required>{{ setting('misi', '') }}</textarea>
						<span class="invalid-feedback"></span>
					</div>

					<hr>

					<div class="form-group">
						<button class="btn btn-primary" type="submit">
							<i class="fa fa-save mr-1"></i> Simpan
						</button>
					</div>

				</div>
			</div>
		</div>

	</div>

</form>
@endsection


@section('scripts')
<script>
	
	$(function(){

		const $modal = $('#modal');
		const $form = $('#form');
		const $formSubmitBtn = $form.find(`[type="submit"]`).ladda();

		$form.on('submit', function(e){
			e.preventDefault();

			let formData = $(this).serialize();
			$formSubmitBtn.ladda('start');

			ajaxSetup();
			$.ajax({
				url: `{{ route('setting.visi_misi.save') }}`,
				method: 'POST',
				data: formData,
				dataType: 'json',
			})
			.done(response => {
				let { message } = response;
				successNotification('Berhasil', message)
				$formSubmitBtn.ladda('stop');
			})
			.fail(error => {
				$formSubmitBtn.ladda('stop');
				ajaxErrorHandling(error, $form);
			})
		})

	})

</script>
@endsection