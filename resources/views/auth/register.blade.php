<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Pelayanan Disdik | Login </title>
    <link rel="icon" href="{{ url('img/indohijab.png') }}" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="{{ url('css/login.css') }}" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

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
                urls: ['css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/atlantis.min.css') }}">
    <link rel="stylesheet" href="{{ url('vendors/ladda/ladda-themeless.min.css') }}">
    <link rel="stylesheet" href="{{ url('vendors/jquery-confirm/jquery-confirm.css') }}">
    <link rel="stylesheet" href="{{ url('css/custom/select2-atlantis.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/custom/login-added.css') }}" />

    <style type="text/css">
        @media (max-width: 570px) {
            .image {
                display: block;
                position: absolute;
            }
        }

        .container:before {
            background-image: #03a3bb;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">

                <form class="sign-in-form" id="formLogin">
                    <h2 class="title"> Register </h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Nama" name="nama" required="" />
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="input-field">
                                <i class="fas fa-at"></i>
                                <input type="text" placeholder="Username" name="username" required="" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-field">
                                <i class="fas fa-envelope"></i>
                                <input type="email" placeholder="Email" name="email" required="" />
                            </div>
                        </div>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="password" required="" />
                    </div>
                    <button type="submit" class="btn btn-primary btn-round">
                        Login
                    </button>

                    <p class="message-error text-center text-danger"></p>

                    <p align="center">
                        Sudah memiliki akun? <a href="{{ route('login') }}"> Klik Disini </a>
                    </p>

                    <p class="social-text text-center">
                        Copyright &copy; | {{ date('Y') }} <br>
                        <a href="javascript:void(0);"> by Luchi </a>
                    </p>
                </form>

            </div>
        </div>



        <div class="panels-container">
            <div class="panel left-panel">
                <img src="{{ url('img/title.png') }}" class="image" alt="">
            </div>
            <div class="panel right-panel">
                <img src="{{ url('img/title.png') }}" class="image" alt="">
            </div>
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
    <script src="{{ url('js/myJs.js') }}"></script>

    <script type="text/javascript">
        $(function() {

            const $formLogin = $('#formLogin');
            const $formLoginSubmitBtn = $('#formLogin').find(`[type="submit"]`).ladda();


            $formLogin.on('submit', function(e) {
                e.preventDefault();
                $('.message-error').html('')

                const formData = $(this).serialize();
                $formLoginSubmitBtn.ladda('start')

                ajaxSetup();
                $.ajax({
                        url: `{{ route('register') }}`,
                        method: 'post',
                        data: formData,
                        dataType: 'json'
                    })
                    .done(response => {
                        successNotification('Berhasil', 'Berhasil Mendaftar')
                        setTimeout(() => {
                            window.location.href = `{{ route('login') }}`
                        }, 1000)
                    })
                    .fail(error => {
                        $formLoginSubmitBtn.ladda('stop');
                        ajaxErrorHandling(error, $form);
                    })
            })

        })
    </script>

</body>

</html>
