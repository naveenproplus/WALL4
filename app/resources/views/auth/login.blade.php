<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="author" content="ProPlus Logics">
		<meta name="_token" content="{{ csrf_token() }}"/>
		

		<link rel="apple-touch-icon" sizes="180x180" href="{{url('/')}}/assets/images/favicon/apple-touch-icon.png"> 
		<link rel="icon" type="image/png" href="{{ url('/') }}/assets/images/logo/icon.png">

		<link rel="manifest" href="{{url('/')}}/assets/images/favicon/site.webmanifest">
		<meta name="msapplication-TileColor" content="#8e4684">
		<meta name="theme-color" content="#ffffff">
    <!-- Required meta tags -->

		<title>Login - {{ config('app.name', 'Wall 4') }}</title>
		<!-- Google font-->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i&amp;display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700&amp;display=swap" rel="stylesheet">
		<!-- Font Awesome-->
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/fontawesome.css">
		<!-- ico-font-->
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/icofont.css">
		<!-- Themify icon-->
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/themify.css">
		<!-- Flag icon-->
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/flag-icon.css">
		<!-- Feather icon-->
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/feather-icon.css">
		<!-- Plugins css start-->
		<!-- Plugins css Ends-->
		<!-- Bootstrap css-->
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/bootstrap.css">
		<!-- App css-->
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/style.css">
		<link id="color" rel="stylesheet" href="{{url('/')}}/assets/css/color-1.css" media="screen">
		<!-- Responsive css-->
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/responsive.css">
		<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/custom.css">
		<style>
			.cont {
        overflow: hidden;
        position: relative;
        width: 500px;
        margin: 0 auto 0;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
			}
			.auth-bg-video .card-body .theme-form{
        width: 100% !important;
        text-align: left;
			}
		</style>
		<script src="{{url('/')}}/assets/js/jquery-3.5.1.min.js"></script>
		<!-- Bootstrap js-->
		<script src="{{url('/')}}/assets/js/bootstrap/popper.min.js"></script>
		<script src="{{url('/')}}/assets/js/bootstrap/bootstrap.js"></script>
		<!-- sweetalert JS-->
		<script src="{{url('/')}}/assets/js/sweet-alert/sweetalert.min.js?r={{date('dmyHis')}}"></script>
		<!-- toastr JS-->
		<script src="{{url('/')}}/assets/js/toastr.min.js?r={{date('dmyHis')}}"></script>
		<!-- Select2 JS-->
		<script src="{{url('/')}}/assets/js/select2/select2.full.min.js?r={{date('dmyHis')}}"></script>
		<!-- dropify JS-->
		<script src="{{url('/')}}/assets/plugins/dropify/js/dropify.min.js?r={{date('dmyHis')}}"></script>
	</head>
	<body>
		<!-- Loader starts-->
		<div class="loader-wrapper">
			<div class="theme-loader"></div>
		</div>
		<!-- Loader ends-->
		<!-- page-wrapper Start-->
		<div class="page-wrapper">
			<div class="container-fluid p-0">
				<!-- login page with video background start-->
				<div class="auth-bg-video">
					<video id="bgvid" poster="{{url('/')}}/assets/images/other-images/coming-soon-bg.jpg" playsinline="" autoplay="" muted="" loop="">
						<source src="http://admin.pixelstrap.com/xolo/assets/video/auth-bg.mp4" type="video/mp4">
					</video>
					<div class="authentication-box">
						<div class="mt-4">
							<div class="card shadow">
								<div class="card-header text-center">
									<h4>LOGIN</h4>
								</div>
								<div class="card-body  ">
									<div class="cont text-center">
										<div>
											<form class="theme-form" id="frmLogin">
												<div id="DivErrMsg" class="alert alert-danger dark text-center display-none" role="alert">This is a warning alert—check it out!</div>
												<div class="mb-3">
													<label class="col-form-label pt-0">User Name</label>
													<input class="form-control" type="text" required="" id="txtUserName">
													<div class="errors" id="txtUserName-err"></div>
												</div>
												<div class="mb-3">
													<label class="col-form-label">Password</label>
													<input class="form-control" type="password" required="" id="txtPassword">
													<div class="errors" id="txtPassword-err"></div>
												</div>
												<div class="checkbox p-0">
													<input id="chkRememberMe" type="checkbox">
													<label for="chkRememberMe">Remember me</label>
												</div>
												<div class="mb-3 row g-2 mt-3 mb-0">
													<button class="btn btn-primary d-block w-100" id="btnLogin" type="submit">LOGIN</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- login page with video background end-->
			</div>
		</div>
		<!-- latest jquery-->
		<!-- feather icon js-->
		<script src="{{url('/')}}/assets/js/icons/feather-icon/feather.min.js"></script>
		<script src="{{url('/')}}/assets/js/icons/feather-icon/feather-icon.js"></script>
		<!-- Sidebar jquery-->
		<script src="{{url('/')}}/assets/js/sidebar-menu.js"></script>
		<script src="{{url('/')}}/assets/js/config.js"></script>
		<!-- Plugins JS Ends-->
		<!-- Theme js-->
		<script src="{{url('/')}}/assets/js/script.js"></script>
		<!-- login js-->
		<!-- Plugin used-->
		<script src="{{url('/')}}/assets/js/custom.js"></script>
		<script>
			$(document).ready(function() {
				$('#frmLogin').submit((e) => {
					e.preventDefault();
					btnLoading($('#btnLogin'));
					var RememberMe = 0;
					if ($("#chkRememberMe").prop('checked') == true) {
						RememberMe = 1;
					}
					$('.errors').html('');
					$.ajax({
						type: "post",
						url: "{{url('/')}}/auth/login",
						headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
						data: {email: $('#txtUserName').val(),password: $('#txtPassword').val(),remember: RememberMe,_token: $('meta[name=_token]').attr('content')},
						error: function(e, x, settings, exception) {btnReset($('#btnLogin'));ajax_errors(e, x, settings, exception);},
						success: function(response) {
							btnReset($('#btnLogin'));
							if (response.status == true) {
								window.location.replace("{{url('/') }}/admin");
							} else {
								$('#DivErrMsg').removeClass('display-none');
								$('#DivErrMsg').html(response.message);
								if (response.email != undefined) {
								$('#txtUserName-err').html(response.email);
								}
								if (response.password != undefined) {
								$('#txtPassword-err').html(response.password);
								}
							}
						}
					});
				});
			});
		</script>
	</body>
</html>