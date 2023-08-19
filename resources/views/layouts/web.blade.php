<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<title> Pelayanan Disdik @if(isset($title)) | {{ $title }} @endif </title>
		<meta content="HIMPANA" name="description">
		<meta content="HIMPANA" name="keywords">
		<meta content="{{ csrf_token() }}" name="_token">

		<script src="{{ url('js/plugin/webfont/webfont.min.js') }}"></script>
		<script>
			WebFont.load({
				google: {
					"families": ["Lato:300,400,700,900"]
				},
				custom: {
					"families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
						"simple-line-icons"
					],
					urls: [`{{ url('css/fonts.min.css') }}`]
				},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
		</script>

		<!-- Favicons -->
		<link href="{{ url('img/logo-himpana.png') }}" rel="icon">
		<link href="{{ url('img/logo-himpana.png') }}" rel="apple-touch-icon">
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
		<!-- Vendor CSS Files -->
		<link href="{{ url('web/vendor/aos/aos.css') }}" rel="stylesheet">
		<link href="{{ url('web/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ url('web/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
		<link href="{{ url('web/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
		<link href="{{ url('web/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
		<link href="{{ url('web/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
		<!-- Template Main CSS File -->
		<link href="{{ url('web/css/style.css') }}" rel="stylesheet">
		<!-- =======================================================
			* Template Name: BizLand
			* Updated: May 30 2023 with Bootstrap v5.3.0
			* Template URL: https://bootstrapmade.com/bizland-bootstrap-business-template/
			* Author: BootstrapMade.com
			* License: https://bootstrapmade.com/license/
			======================================================== -->

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

		@yield('style')
	</head>
	<body>
		<!-- ======= Top Bar ======= -->
		<!-- <section id="topbar" class="d-flex align-items-center">
			<div class="container d-flex justify-content-center justify-content-md-between">
				<div class="contact-info d-flex align-items-center">
					<i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">contact@example.com</a></i>
					<i class="bi bi-phone d-flex align-items-center ms-4"><span>+1 5589 55488 55</span></i>
				</div>
				<div class="social-links d-none d-md-flex align-items-center">
					<a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
					<a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
					<a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
					<a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
				</div>
			</div>
		</section> -->
		<!-- ======= Header ======= -->
		<header id="header" class="d-flex align-items-center">
			<div class="container d-flex align-items-center justify-content-between">
				<h1 class="logo">
					<a href="{{ url('/') }}">
						<img src="{{ url('img/disdik.png') }}">
						Pelayanan Disdik
					</a>
				</h1>
				<!-- Uncomment below if you prefer to use an image logo -->
				<!-- <a href="{{ url('/') }}" class="logo"><img src="{{ url('web/img/logo.png') }}" alt=""></a>-->
				<nav id="navbar" class="navbar">
					<ul>
						@include('layouts.menu.menu_web')
					</ul>
					<i class="bi bi-list mobile-nav-toggle"></i>
				</nav>
				<!-- .navbar -->
			</div>
		</header>

		@yield('content')

		<footer id="footer">
			<div class="container py-4">
				<div class="copyright">
					&copy; Copyright <strong><span> Luchi </span></strong>. All Rights Reserved
				</div>
			</div>
		</footer>
		<!-- End Footer -->
		<div id="preloader"></div>
		<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
		<!-- Vendor JS Files -->
		<script src="{{ url('web/vendor/purecounter/purecounter_vanilla.js') }}"></script>
		<script src="{{ url('web/vendor/aos/aos.js') }}"></script>
		<script src="{{ url('web/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ url('web/vendor/glightbox/js/glightbox.min.js') }}"></script>
		<script src="{{ url('web/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
		<script src="{{ url('web/vendor/swiper/swiper-bundle.min.js') }}"></script>
		<script src="{{ url('web/vendor/waypoints/noframework.waypoints.js') }}"></script>
		<script src="{{ url('web/vendor/php-email-form/validate.js') }}"></script>
		<!-- Template Main JS File -->
		<script src="{{ url('web/js/main.js') }}"></script>
		<!-- Swiper JS -->
		<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

		@yield('script')
	</body>
</html>