 <!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- Meta -->
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="author" content="DexignZone">
	<meta name="robots" content="index, follow">
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta property="og:title" content="">
	<meta property="og:description" content="">
	<meta name="format-detection" content="telephone=no">
	<meta name="_token" content="{{ csrf_token() }}" />

	
	<!-- Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Title -->

	<!-- Favicon icon -->
    <link rel="icon" type="image/png" href="{{url('/')}}/assets/images/logo/icon.png">
    
	<!-- Stylesheet -->
	<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/home/vendor/twentytwenty-master/css/twentytwenty.css">
    <link href="{{url('/')}}/assets/home/vendor/lightgallery/css/lightgallery.min.css" rel="stylesheet">
	<link href="{{url('/')}}/assets/home/vendor/magnific-popup/magnific-popup.min.css" rel="stylesheet">
	<link href="{{url('/')}}/assets/home/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
	<link href="{{url('/')}}/assets/home/vendor/aos/aos.css" rel="stylesheet">
	{{-- <link href="{{url('/')}}/assets/home/vendor/switcher/switcher.css" rel="stylesheet"> --}}
	<link href="{{url('/')}}/assets/home/vendor/rangeslider/rangeslider.css" rel="stylesheet">
	
	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
	
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="{{url('/')}}/assets/home/css/style.css">
	<link class="skin" rel="stylesheet" href="{{url('/')}}/assets/home/css/skin/skin-1.css">

</head>
<body id="bg">
@yield('content')
<!-- JAVASCRIPT FILES -->
<script src="{{url('/')}}/assets/home/js/jquery.min.js"></script><!-- JQUERY.MIN JS -->
<script src="{{url('/')}}/assets/home/vendor/bootstrap/js/bootstrap.bundle.min.js"></script><!-- BOOTSTRAP.MIN JS -->
<script src="{{url('/')}}/assets/home/vendor/counter/waypoints-min.js"></script><!-- WAYPOINTS JS -->
<script src="{{url('/')}}/assets/home/vendor/counter/counterup.min.js"></script><!-- COUNTERUP JS -->
<script src="{{url('/')}}/assets/home/vendor/magnific-popup/magnific-popup.js"></script><!-- MAGNIFIC POPUP JS -->
<script src="{{url('/')}}/assets/home/vendor/lightgallery/js/lightgallery-all.min.js"></script><!-- LIGHTGALLERY -->
<script src="{{url('/')}}/assets/home/vendor/masonry/isotope.pkgd.min.js"></script><!-- ISOTOPE -->
<script src="{{url('/')}}/assets/home/vendor/imagesloaded/imagesloaded.js"></script><!-- IMAGESLOADED -->
<script src="{{url('/')}}/assets/home/vendor/masonry/masonry-4.2.2.js"></script><!-- MASONRY -->
<script src="{{url('/')}}/assets/home/vendor/twentytwenty-master/js/jquery.event.move.js"></script>
<script src="{{url('/')}}/assets/home/vendor/twentytwenty-master/js/jquery.twentytwenty.js"></script>
<script src="{{url('/')}}/assets/home/vendor/swiper/swiper-bundle.min.js"></script><!-- OWL-CAROUSEL -->
<script src="{{url('/')}}/assets/home/vendor/aos/aos.js"></script><!-- AOS -->
<script src="{{url('/')}}/assets/home/js/dz.carousel.js"></script><!-- OWL-CAROUSEL -->
<script src="{{url('/')}}/assets/home/js/dz.ajax.js"></script><!-- AJAX -->
<script src="{{url('/')}}/assets/home/js/custom.js"></script><!-- CUSTOM JS -->
<script src="{{url('/')}}/assets/home/vendor/rangeslider/rangeslider.js"></script><!-- RANGESLIDER -->

<script>
	$(document).ready(function() {
		var maxHeight = 0;
		$('.service-content').each(function() {
			var height = $(this).outerHeight();
			if (height > maxHeight) {
				maxHeight = height;
			}
		});

		$('.service-content').css('height', maxHeight + 'px');
		
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