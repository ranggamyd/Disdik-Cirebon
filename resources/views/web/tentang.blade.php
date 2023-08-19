@extends('layouts.web')


@section('content')
<main id="main" data-aos="fade-up">
	<section class="breadcrumbs">
		<div class="container">
			<div class="d-flex justify-content-between align-items-center">
				<h2> Pelayanan Perizininan Satuan Pendidikan </h2>
				<ol>
					<li><a href="{{ url('/') }}"> Beranda </a></li>
					<li> Pelayanan Perizininan Satuan Pendidikan </li>
				</ol>
			</div>
		</div>
	</section>
	
	<section class="inner-page">
		<div class="container">

			<h2 align="center" class="mb-3"> Tentang Kami </h2>

			<div class="row mb-5">
				<div class="col-lg-5">
					<img src="{{ url('img/disdik.png') }}" class="img-fluid">
				</div>

				<div class="col-lg-7">
					<h3>
						Pelayanan Perizinan Pendidikan<br>
						Wilayah Kab. Cirebon
					</h3>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</p>
				</div>
			</div>

			<h2 align="center"> Informasi Tambahan </h2>

			<p>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</p>
		</div>
	</section>
</main>
@endsection