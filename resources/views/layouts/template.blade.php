<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title> Pelayanan Disdik | {{ $title ?? 'Judul' }} </title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<meta content="{{ csrf_token() }}" name="_token">

	<!-- <link rel="icon" href="{{ url('img/logo/icon.png') }}" type="image/x-icon"/> -->

	<!-- Fonts and icons -->
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

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ url('css/atlantis.min.css') }}">

	<link rel="stylesheet" href="{{ url('css/custom/app.css') }}">

	<link rel="stylesheet" href="{{ url('vendors/ladda/ladda-themeless.min.css') }}">
	<link rel="stylesheet" href="{{ url('vendors/pace/blue/pace-theme-loading-bar.css') }}">
	<link rel="stylesheet" href="{{ url('vendors/jquery-confirm/jquery-confirm.css') }}">
	<link rel="stylesheet" href="{{ url('vendors/clockpicker/dist/bootstrap-clockpicker.min.css') }}">
	<link rel="stylesheet" href="{{ url('vendors/select2/select2.css') }}">
	<link rel="stylesheet" href="{{ url('css/custom/select2-atlantis.css') }}">

	<style type="text/css">
		select.is-invalid ~ .select2-container .select2-selection--single {
			border-color: var(--red);
		}
	</style>

	@yield('styles')
</head>

<body>
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="blue">

				<a href="{{ url('dashboard') }}" class="logo">
					<img src="{{ url('img/title.png') }}" alt="navbar brand" class="navbar-brand" style="width: 150px;">
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
					data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						<i class="icon-menu"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">

				<div class="container-fluid">
					<div class="collapse" id="search-nav">
					</div>
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li class="nav-item toggle-nav-search hidden-caret">
							<a class="nav-link" data-toggle="collapse" href="#search-nav" role="button"
								aria-expanded="false" aria-controls="search-nav">
								<i class="fa fa-search"></i>
							</a>
						</li>

						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"
								aria-expanded="false">
								<div class="avatar-sm">
									<img src="{{ url('img/default-avatar.jpg') }}" alt="{{ auth()->user()->nama_lengkap }}"
										class="avatar-img rounded-circle">
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									<li>
										<div class="user-box">
											<div class="avatar-lg"><img src="{{ url('img/default-avatar.jpg') }}"
													alt="Foto Profil" class="avatar-img rounded"></div>
											<div class="u-text">
												<h4> {{ auth()->user()->nama }} </h4>
												<p class="text-muted">
													{{ auth()->user()->role }}
												</p>
											</div>
										</div>
									</li>
									<li>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="javascript:void(0);"
											onclick="$('#formLogout').submit();">Logout</a>
									</li>
								</div>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<!-- End Navbar -->
		</div>
		<!-- Sidebar -->
		<div class="sidebar sidebar-style-2">
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<ul class="nav nav-danger" id="menu-nav">
						
						@include('layouts.menu.menu')

					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">

				@if (isset($breadcrumbs))

					<div class="page-inner">
						<div class="page-header">
							<h4 class="page-title"> {{ $title ?? 'Judul' }} </h4>
							<ul class="breadcrumbs">
								<li class="nav-home">
									<a href="#">
										<i class="flaticon-home"></i>
									</a>
								</li>

								@foreach ($breadcrumbs as $breadcrumb)
									<li class="separator">
										<i class="flaticon-right-arrow"></i>
									</li>
									<li class="nav-item">
										<a href="{{ $breadcrumb['link'] }}"> {{ $breadcrumb['title'] }} </a>
									</li>
								@endforeach

							</ul>
						</div>
						@yield('content')

					</div>
				@else
					@yield('content')

				@endif


			</div>
			<footer class="footer">
				<div class="container-fluid">
					<div class="copyright ml-auto">
						Copyright &copy; {{ date('Y') }} | <a href="javascript:void(0);"> by Luchi </a>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<form action="{{ route('logout') }}" method="POST" id="formLogout">
		{{ csrf_field() }}
	</form>

	@yield('modal')

	<!--   Core JS Files   -->
	<script src="{{ url('js/core/jquery.3.2.1.min.js') }}"></script>
	<script src="{{ url('js/core/popper.min.js') }}"></script>
	<script src="{{ url('js/core/bootstrap.min.js') }}"></script>

	<!-- jQuery UI -->
	<script src="{{ url('js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
	<script src="{{ url('js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ url('js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>


	<!-- Chart JS -->
	<script src="{{ url('js/plugin/chart.js/chart.min.js') }}"></script>

	<!-- jQuery Sparkline -->
	<script src="{{ url('js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

	<!-- Chart Circle -->
	<script src="{{ url('js/plugin/chart-circle/circles.min.js') }}"></script>

	<!-- Datatables -->
	<script src="{{ url('js/plugin/datatables/datatables.min.js') }}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{ url('js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

	<!-- jQuery Vector Maps -->
	<script src="{{ url('js/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
	<script src="{{ url('js/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script>

	<!-- Sweet Alert -->
	<script src="{{ url('js/plugin/sweetalert/sweetalert.min.js') }}"></script>

	<!-- Atlantis JS -->
	<script src="{{ url('js/atlantis.min.js') }}"></script>

	<script src="{{ url('vendors/ladda/spin.min.js') }}"></script>
	<script src="{{ url('vendors/ladda/ladda.min.js') }}"></script>
	<script src="{{ url('vendors/ladda/ladda.jquery.min.js') }}"></script>
	<script src="{{ url('vendors/jquery-confirm/jquery-confirm.js') }}"></script>
	<script src="{{ url('vendors/select2/select2.min.js') }}"></script>
	<script src="{{ url('vendors/clockpicker/dist/bootstrap-clockpicker.min.js') }}"></script>
	<script src="{{ url('js/myJs.js') }}"></script>

	<script type="text/javascript">
		const setActiveMenu = () => {
			let isFoundLink = false;
			let path = [];
			window.location.pathname.split("/").forEach(item => {
				if (item !== "") path.push(item);
			})
			let lengthPath = path.length;
			let lengthUse = lengthPath;
			let origin = window.location.origin;

			while (lengthUse >= 1) {
				let link = '';
				for (let i = 0; i < lengthUse; i++) {
					link += `/${path[i]}`;
				}
				$.each($('#menu-nav').find('a'), (i, elem) => {
					if ($(elem).attr('href') == `${origin}${link}`) {
						$(elem).parent('li').addClass('active')
						$(elem).parents('li.nav-item').addClass('active').addClass('submenu')
						$(elem).parents('li.nav-item').find(`.collapse`).addClass('show')
					}
				})

				if (isFoundLink) break;
				lengthUse--;
			}
		}


		setActiveMenu();
	</script>

	@yield('scripts')
</body>

</html>
