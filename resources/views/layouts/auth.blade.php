<!DOCTYPE html>
<html>
<head>
	<title> {{ Setting::getValue('app_title', 'ERP') }} | @yield('title') </title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<meta content="{{ csrf_token() }}" name="_token">

	<link rel="icon" href="{{ url('img/erp/favicon.png') }}" type="image/x-icon"/>
	<script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

	<!-- Fonts and icons -->
	<script src="{{ url('js/plugin/webfont/webfont.min.js') }}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ url('css/atlantis.min.css') }}">

	<link rel="stylesheet" href="{{ url('css/custom/app.css') }}">
	<link rel="stylesheet" href="{{ url('css/custom/login.css') }}">

	<link rel="stylesheet" href="{{ url('vendors/ladda/ladda-themeless.min.css') }}">
	<link rel="stylesheet" href="{{ url('vendors/pace/white/pace-theme-flash.css') }}">
	<style type="text/css">
		* {
			box-sizing: border-box;
		}
	</style>

</head>
<body>

	<div class="auth-box">
		<div class="auth-banner"></div>
		<div class="auth-form">
			<h1 align="center"> Login </h1>
			<form id="formLogin">
				<div class="form-group">
					<div class="input-with-icon">
						<i class="icon icon-user"></i>
						<input id="username" type="text" name="username" class="form-control input-border-bottom" placeholder="Username" required>
					</div>
					<span class="invalid-feedback"></span>
				</div>

				<div class="form-group">
					<div class="input-with-icon">
						<i class="icon icon-lock"></i>
						<input id="password" type="password" name="password" class="form-control input-border-bottom" placeholder="Password" required>
					</div>
					<span class="invalid-feedback"></span>
				</div>

				<button class="btn btn-block btn-primary mt-2" type="submit">
					<i class="icon-login mr-2"></i> Login
				</button>

				<p class="message-error text-danger mt-2" align="center"></p>
			</form>
		</div>
	</div>

	<script src="{{ url('js/core/jquery.3.2.1.min.js') }}"></script>
	<script src="{{ url('js/core/popper.min.js') }}"></script>
	<script src="{{ url('js/core/bootstrap.min.js') }}"></script>


	<!-- Bootstrap Notify -->
	<script src="{{ url('js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

	<!-- Atlantis JS -->
	<script src="{{ url('js/atlantis.min.js') }}"></script>

	<script src="{{ url('vendors/ladda/spin.min.js') }}"></script>
	<script src="{{ url('vendors/ladda/ladda.min.js') }}"></script>
	<script src="{{ url('vendors/ladda/ladda.jquery.min.js') }}"></script>
	<script src="{{ url('vendors/pace/pace.min.js') }}"></script>
	<script src="{{ url('js/myJs.js') }}"></script>

	<script>
		
		$(function(){

			const $formLogin = $('#formLogin');
			const $formLoginSubmitBtn = $('#formLogin').find(`[type="submit"]`).ladda();

			$formLogin.on('submit', function(e){
				e.preventDefault();
				$('.message-error').html('')

				const formData = $(this).serialize();
				$formLoginSubmitBtn.ladda('start')

				ajaxSetup();
				$.ajax({
					url: `{{ route('login') }}`,
					method: 'post',
					data: formData,
					dataType: 'json'
				})
				.done(response => {
					successNotification('Berhasil', 'Login Berhasil')
					setTimeout(() => {
						window.location.href = `{{ route('dashboard') }}`
					}, 1000)
				})
				.fail(error => {
					$formLoginSubmitBtn.ladda('stop');
					// ajaxErrorHandling(error);
					$('.message-error').html('Username/Password Salah')
				})
			})

		})

	</script>

</body>
</html>