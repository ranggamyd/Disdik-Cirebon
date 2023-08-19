@extends('layouts.web')


@section('content')
<main id="main" data-aos="fade-up">
	<section class="breadcrumbs">
		<div class="container">
			<div class="d-flex justify-content-between align-items-center">
				<h2> Beranda </h2>
				<ol>
					<!-- <li><a href="{{ url('/') }}"> Beranda </a></li> -->
					<li> Beranda </li>
				</ol>
			</div>
		</div>
	</section>
	
	<section class="inner-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<img src="{{ url('img/disdik.png') }}" class="img-fluid">
				</div>

				<div class="col-lg-6">
					<h2>
						Pelayanan Perizinan Pendidikan<br>
						Wilayah Kab. Cirebon
					</h2>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</p>
					<!-- <a class="btn btn-primary mb-2" href="{{ url('pilih-satuan-pendidikan') }}">
						PENDIDIKAN FORMAL
					</a>
					<br>
					<a class="btn btn-outline-primary" href="{{ url('pilih-satuan-pendidikan') }}">
						PENDIDIKAN NON FORMAL
					</a> -->
				</div>
			</div>
		</div>
	</section>
</main>
@endsection