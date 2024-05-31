<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta -->
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="author" content="">
	<meta name="robots" content="index, follow">
	<meta name="keywords" content="architect, Architect Studio, architecture, architecture design, architecture farms, building, building company, construction, contractors, house design, interior, interior design, modern architecture, office design, real estate">
	<meta name="description" content="">
	<meta property="og:title" content="">
	<meta property="og:description" content="">
	<meta name="format-detection" content="telephone=no">
	
	<!-- Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- Title -->
	<title>404 Error</title>

	<!-- Favicon icon -->
    <link rel="icon" type="image/png" href="{{url('/')}}/assets/images/logo/icon.png">
	
	<!-- Stylesheet -->
	<link href="{{url('/')}}/assets/home/vendor/rangeslider/rangeslider.css" rel="stylesheet">
	<link href="{{url('/')}}/assets/home/vendor/aos/aos.css" rel="stylesheet">
	
    <!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
	
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="{{url('/')}}/assets/home/css/style.css">
	<link class="skin" rel="stylesheet" href="{{url('/')}}/assets/home/css/skin/skin-1.css">
	
</head>
<body id="bg">
<div id="loading-area" class="loading-page-1">
	<div class="loading-area">
		<p>Loading</p>
		<span></span>
	</div>
</div>
<div class="page-wraper">
	<div class="under-construct">
		<div class="inner-box">
			<div class="logo-header logo-dark">
				<a href="{{url('/')}}"><img src="{{url('/')}}/uploads/settings/company/logo/logo.png" alt="WALL4"></a>
			</div>	
			<div class="dz-content">
				<div class="error-page text-center">
					<div class="dlab_error">404</div>
					<h2 class="error-head">We are sorry. But the page you are looking for cannot be found.</h2>
					<a href="{{url('/')}}" class="btn btn-primary radius-no btn-rounded"><span class="p-lr15">BACK TO HOMEPAGE</span></a>
				</div>
			</div>
		</div>
	</div>
</div>	
<!-- JAVASCRIPT FILES ========================================= -->
<script src="{{url('/')}}/assets/home/js/jquery.min.js"></script><!-- JQUERY.MIN JS -->
<script src="{{url('/')}}/assets/home/js/custom.js"></script><!-- CUSTOM JS -->
<script src="{{url('/')}}/assets/home/vendor/bootstrap/js/bootstrap.bundle.min.js"></script><!-- BOOTSTRAP.MIN JS -->
<script src="{{url('/')}}/assets/home/vendor/aos/aos.js"></script><!-- AOS -->
<script src="{{url('/')}}/assets/home/vendor/rangeslider/rangeslider.js"></script><!-- RANGESLIDER -->
<script>
	$(document).ready(function() {
		
		var checkExist = setInterval(function() {
			if ($('.DZ-bt-buy-now').length || $('.DZ-bt-support-now').length) {
				$('.DZ-bt-buy-now').remove();
				$('.DZ-bt-support-now').remove();
				clearInterval(checkExist);
			}
		}, 100);
		
	});
</script>
</body>
</html>