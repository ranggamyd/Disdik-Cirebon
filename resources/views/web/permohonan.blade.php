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

			@if($permohonan->status == 'Tertunda')
			<h2 align="center" class="mb-2"> Permohonan Tertunda, Harap Menunggu Konfirmasi </h2>
			<p align="center" class="mb-4"> Hasil Konfirmasi Akan Dikirim Via Email </p>
			@elseif($permohonan->status == 'Diterima')
			<h2 align="center" class="mb-2"> Permohonan Diterima </h2>
			<p align="center" class="mb-4"> Harap Untuk Mengecek Email </p>
			@else
			<h2 align="center" class="mb-2"> Permohonan Ditolak  </h2>
			<p align="center" class="mb-4"> Harap Untuk Mengecek Email </p>
			@endif

			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-lg-6">
							<div class="mb-3">
								<div class="mb-2"><b> Nomor Pendaftaran </b></div>
								<div> {{ $permohonan->no_pendaftaran }} </div>
							</div>

							<div class="mb-3">
								<div class="mb-2"><b> Nama Yayasan </b></div>
								<div> {{ $permohonan->nama_yayasan }} </div>
							</div>

							<div class="mb-3">
								<div class="mb-2"><b> Nama Ketua Yayasan </b></div>
								<div> {{ $permohonan->nama_ketua_yayasan }} </div>
							</div>

							<div class="mb-3">
								<div class="mb-2"><b> Email </b></div>
								<div> {{ $permohonan->email }} </div>
							</div>

							<div class="mb-3">
								<div class="mb-2"><b> Nomor Telepon </b></div>
								<div> {{ $permohonan->no_telp }} </div>
							</div>
						</div>

						<div class="col-lg-6">
							<div class="mb-3">
								<div class="mb-2"><b> Tanggal Permohonan </b></div>
								<div> {{ $permohonan->created_at->format('d/m/Y') }} </div>
							</div>

							<div class="mb-3">
								<div class="mb-2"><b> Nama PKBM </b></div>
								<div> {{ $permohonan->nama_pendidikan }} </div>
							</div>

							<div class="mb-3">
								<div class="mb-2"><b> Nama Ketua PKBM </b></div>
								<div> {{ $permohonan->nama_kepala_pendidikan }} </div>
							</div>

							<div class="mb-3">
								<div class="mb-2"><b> Alamat Lengkap </b></div>
								<div> {{ $permohonan->alamat }} </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
@endsection