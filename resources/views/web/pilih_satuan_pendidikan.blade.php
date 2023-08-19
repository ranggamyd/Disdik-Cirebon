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
			
			@foreach(\App\Models\KategoriPendidikan::all() as $kategori)
			<div class="card">
				<div class="card-header">
					{{ $kategori->nama_kategori }}
				</div>
				<div class="card-body">
					<div class="row">
						@foreach($kategori->pendidikan as $pendidikan)
						<div class="col-lg-4">
							<div class="card">
								<div class="card-body py-5">
									<p class="mb-0 h1 text-center"> {{ $pendidikan->singkatan }} </p>
								</div>
							</div>
							<a class="btn btn-primary d-block mt-3 mb-4" href="{{ url('buat-permohonan/'.$pendidikan->id_pendidikan) }}">
								Ajukan Sekarang
							</a>
						</div>
						@endforeach
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</section>
</main>
@endsection