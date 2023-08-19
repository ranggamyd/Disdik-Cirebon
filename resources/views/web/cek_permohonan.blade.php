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
			<h2 align="center" class="mb-5"> {{ $title }} </h2>

			<form id="form">

				<div class="row">
					<div class="col-lg-6 offset-lg-3">
						<table width="100%">
							<tr>
								<th> Nomor Pendaftaran </th>
								<td>
									<input type="text" name="no_pendaftaran" class="form-control" placeholder="Nomor Pendaftaran" required>
								</td>
							</tr>
							<tr>
								<th> PIN Perizinan </th>
								<td>
									<input type="password" name="pin_perizinan" class="form-control" placeholder="PIN Perizinan" required>
								</td>
							</tr>
						</table>
						
						<hr>
						
						<p align="center">
							<button class="btn btn-primary" type="submit">
								Cari
							</button>
						</p>
					</div>
				</div>

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
<script src="{{ url('js/myJs.js') }}"></script>
<script type="text/javascript">
	$(function(){

		$form = $('#form')
		$submitBtn = $form.find(`[type="submit"]`).ladda()

		$form.on('submit', function(e){
			e.preventDefault()

			const noPendaftaran = $form.find(`[name="no_pendaftaran"]`).val()

			setTimeout(() => {
				window.location.href = `{{ url('permohonan') }}/${noPendaftaran}`
			}, 1000)
		})

	})
</script>
@endsection