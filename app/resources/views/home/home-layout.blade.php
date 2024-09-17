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
	
	<meta http-equiv="Permissions-Policy" content="accelerometer=(self)">
	
	<!-- Title -->
	<title>{{ $Company['Name'] }}</title>
	
	<!-- Favicon icon -->
    <link rel="icon" type="image/png" href="{{ url('/') }}/assets/images/logo/icon.png">
    
	<!-- Stylesheet -->
	<link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/home/vendor/twentytwenty-master/css/twentytwenty.css">
    <link href="{{ url('/') }}/assets/home/vendor/lightgallery/css/lightgallery.min.css" rel="stylesheet">
	<link href="{{ url('/') }}/assets/home/vendor/magnific-popup/magnific-popup.min.css" rel="stylesheet">
	<link href="{{ url('/') }}/assets/home/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
	<link href="{{ url('/') }}/assets/home/vendor/aos/aos.css" rel="stylesheet">
	<link href="{{ url('/') }}/assets/home/vendor/rangeslider/rangeslider.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/sweetalert2.css?r={{ date('dmyHis') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/toastr.css?r={{ date('dmyHis') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/plugins/image-cropper/image-cropper.css?r={{ date('dmyHis') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/fontawesome.css?r={{ date('dmyHis') }}">
	
	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
	
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="{{ url('/') }}/assets/home/css/style.css">
	<link class="skin" rel="stylesheet" href="{{ url('/') }}/assets/home/css/skin/skin-1.css">

</head>
<body id="bg" class="scrollbar">
	<style>
		@keyframes zoom {
			0% {
				transform: scale(1);
			}
			50% {
				transform: scale(1.05);
			}
			100% {
				transform: scale(1);
			}
		}

		.zoom {
			animation: zoom 0.4s ease-in-out;
		}


	</style>
<div id="loading-area" class="loading-page-1">
	<div class="loading-area">
		{{-- <p>Loading</p> --}}
		<img loading="lazy" src="{{$Company['Logo']}}" alt="">
		<span></span>
	</div>
</div>
<div class="page-wraper">
	<div class="force-overflow">
		@if($isEdit)
			<div class="row justify-content center py-1" style="background-color: black;">
				<div class="col-4 d-flex align-items-center">
					<a href="{{ url('/') }}/admin/home/content" class="btnBack btn btn-sm btn-outline-light rounded mx-3">Back</a>
				</div>
				<div class="col-4">
					<h3 class="text-center text-light">You are in Website Edit View</h3>
				</div>
				<div class="col-4">
				</div>
			</div>
		@endif
		<!-- Header -->
		<header class="site-header mo-left header style-1">
			<!-- Main Header -->
			<div class="sticky-header main-bar-wraper navbar-expand-lg">
				<div class="main-bar clearfix">
					<div class="container-fluid clearfix">
						<!-- Website Logo -->
						<div class="logo-header mostion logo-dark">
							<a href="{{ url('/') }}"><img src="{{$Company['Logo']}}" alt=""></a>
						</div>
						<!-- Nav Toggle Button -->
						<button class="navbar-toggler collapsed navicon justify-content-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
							<span></span>
							<span></span>
							<span></span>
						</button>
						<!-- Extra Nav -->
						<div class="extra-nav">
							<div class="extra-cell">
								<div class="extra-icon-box w-auto">
									<li><a href="{{$Company['youtube']}}" target="_blank"><i {{-- style="background-color: #ec1414"  --}}class="fab fa-youtube"></i></a></li>
								</div>
								<div class="extra-icon-box w-auto">
									<li><a href="{{$Company['facebook']}}" target="_blank" ><i {{-- style="background-color: #1877F2"  --}}class="fab fa-facebook-f"></i></a></li>
								</div>
								<div class="extra-icon-box w-auto">
									<li><a href="{{$Company['instagram']}}" target="_blank"><i {{-- style="background-color: #dd30c6"  --}}class="fab fa-instagram"></i></a></li>
								</div>
								<div class="extra-icon-box w-auto">
									<i class="fas fa-map-marker-alt"></i>
									<h6 class="title">{{$Company['CityName']}} - {{$Company['PostalCode']}}</h6>
								</div>
								<!-- Quik Search -->
								{{-- <div class="search-inhead">
									<div class="dz-quik-search">
										<form action="#">
											<input name="search" value="" type="text" class="form-control" placeholder="Search">
											<span  id="quik-search-remove"><i class="ti-close"></i></span>
										</form>
									</div>
									<a class="search-link" id="quik-search-btn" href="javascript:void(0);">
										<i class="flaticon-loupe"></i>
									</a>
								</div> --}}
								<div class="menu-btn navicon">
									<span></span>
									<span></span>
									<span></span>
								</div>
							</div>
						</div>
						<div class="header-nav navbar-collapse collapse justify-content-end" id="navbarNavDropdown">
							<div class="logo-header logo-dark">
								<a href="{{ url('/') }}"><img loading="lazy" src="{{$Company['Logo']}}" alt=""></a>
							</div>
							<ul class="nav navbar-nav navbar navbar-left">	
								<li class="sub-menu-down">
									<a href="{{ url('/') }}">Home</a>
								</li>
								<li class="sub-menu-down">
									<a href="{{ url('/') }}/about-us">About Us</a>
									{{-- <ul class="sub-menu">
										<li><a href="{{ url('/') }}/teams">Teams</a></li>
										<li><a href="{{ url('/') }}/faq">FAQ</a></li>
									</ul> --}}
								</li>
								<li class="sub-menu-down">
									<a href="{{ url('/') }}/projects">Projects</a>
								</li>
								<li class="sub-menu-down">
									<a href="{{ url('/') }}/services">Services</a>
								</li>
								<li>
									<a href="{{ url('/') }}/contact-us">Contact Us</a>
								</li>
							</ul>
							<div class="dz-social-icon">
								<ul>
									<li><a href="{{$Company['facebook']}}" target="_blank" ><i class="fab fa-facebook-f"></i></a></li>
									<li><a href="{{$Company['instagram']}}" target="_blank"><i class="fab fa-instagram"></i></a></li>
									<li><a href="{{$Company['twitter']}}" target="_blank"><i class="fab fa-twitter"></i></a></li>
									<li><a href="{{$Company['youtube']}}" target="_blank"><i class="fab fa-youtube"></i></a></li>
								</ul>
							</div>	
						</div>
					</div>
				</div>
			</div>
			<!-- Main Header End -->
		</header>
		<!-- Header End -->
		
		<div class="contact-sidebar">
			<div class="contact-box">
				<div class="logo-contact logo-dark">
					<a href="{{ url('/') }}"><img loading="lazy" src="{{$Company['Logo']}}" alt=""></a>
				</div>
				<div class="m-b50 contact-text">
					<div class="dz-title">
						<h4>About US</h4>
						<div class="dz-separator style-1 text-primary mb-0"></div>
					</div>
					<p>
						{!!$Contents['footer-about-us']!!}
					</p>
					<a href="{{ url('/') }}/about-us" class="btn btn-primary btn-sm btn-rounded">READ MORE</a>
				</div>
				{{-- <div class="dz-title">
					<h4>Gallery</h4>
					<div class="dz-separator style-1 text-primary mb-0"></div>
				</div> --}}
				<div class="widget bg-white widget_gallery">
					<ul id="lightgallery" class="lightgallery m-b0">
						@foreach ($Gallery as $item)
							<li>
								<div class="dlab-post-thum dlab-img-effect">
									<span data-exthumbimage="{{ url('/') }}/{{$item->GalleryImage}}" data-src="{{ url('/') }}/{{$item->GalleryImage}}" class="lightimg" title="{{$item->GalleryName}}">	<img loading="lazy" src="{{ url('/') }}/{{$item->GalleryImage}}" alt="{{$item->GalleryName}}"> 
									</span>
								</div>
							</li>
						@endforeach
					</ul>
				</div>	
			</div>	
		</div>
		<div class="menu-close"></div>
		
		<div class="page-content bg-white">


			@yield('home-content')

			
		</div>
		<!-- Footer -->
		<footer class="site-footer style-1" id="footer">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 aos-item" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
						<div class="footer-bg edit-content" id="img-footer-bg" style=" background-image: url({{ url('/') }}/{{$Contents['img-footer-bg']}});"></div>
					</div>
					<div class="col-lg-7">
						<div class="footer-top">
							<div class="row">
								<div class="col-md-12 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
									<div class="footer-logo logo-light">
										<a href="#"><img loading="lazy" src="{{ url('/') }}/{{$Company['Logo-Light']}}" alt="Footer Logo"></a>
									</div>
								</div>	
								<div class="col-md-5 col-sm-6 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
									<div class="widget widget_services">
										<h4 class="footer-title">Our Links</h4>
										<ul>
											<li><a href="{{ url('/') }}">Home</a></li>
											<li><a href="{{ url('/') }}/about-us">About Us</a></li>
											<li><a href="{{ url('/') }}/services">Services</a></li>
											<li><a href="{{ url('/') }}/projects">Projects</a></li>
											{{-- <li><a href="{{ url('/') }}/blogs">Blogs</a></li> --}}
											<li><a href="{{ url('/') }}/contact-us">Contact Us</a></li>
										</ul>
									</div>
									
								</div>
								<div class="col-md-7 col-sm-6 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
									<div class="widget widget_about">
										<h4 class="footer-title">About Us</h4>
										<p class="edit-content" id="footer-about-us">{!!$Contents['footer-about-us']!!}</p>
										<div class="widget_getintuch pt-2">
											<ul>
												{{-- <li>
													<i class="las la-map-marker-alt"></i>
													<span>{{$Company['Address']}},{{$Company['CityName']}} - {{$Company['PostalCode']}}</span>
												</li> --}}
												<li>
													<i class="las la-phone-volume"></i>
													<span>+91 {{$Company['Phone-Number']}}{{$Company['Mobile-Number'] ? ', +91 ' . $Company['Mobile-Number'] : "" }}</span>
												</li>
											</ul>
										</div>
										<ul class="social-list style-1">
											<li><a href="{{$Company['facebook']}}" target="_blank" ><i class="fab fa-facebook-f"></i></a></li>
											<li><a href="{{$Company['instagram']}}" target="_blank"><i class="fab fa-instagram"></i></a></li>
											<li><a href="{{$Company['twitter']}}" target="_blank"><i class="fab fa-twitter"></i></a></li>
											<li><a href="{{$Company['youtube']}}" target="_blank"><i class="fab fa-youtube"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- footer bottom part -->
			<div class="footer-bottom">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-md-6 text-center text-md-start"> 
							<span class="copyright-text">Copyright © 2024 <span class="text-primary">{{$Company['Name']}}</span> All rights reserved.</span>
						</div>
						<div class="col-md-6 text-center text-md-end"> 
							<ul class="footer-link d-inline-block">
								<li><a href="{{ url('/') }}/privacy-policy">Privacy Policy</a></li>
								<li><a href="{{ url('/') }}/terms-and-conditions">Terms & Conditions</a></li>
							</ul>	
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- Footer End -->
		@if($isEdit)
			<input type="file" class="imageScrop d-none" data-remove="0" data-is-cover-image="0" id="txtUploadImage">
			<div class="modal medium" tabindex="-1" role="dialog" id="ImgCrop">
				<div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document" >
					<div class="modal-content">
						<div class="modal-header pt-10 pb-10">
							<h5 class="modal-title">Image Crop</h5>
							<button type="button" class="close display-none" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-12">
									<img style="width:100%" src="" id="ImageCrop" data-id="">
								</div>
							</div>
							<div class="row mt-10 d-flex justify-content-center">
								<div class="col-sm-12 docs-buttons d-flex justify-content-center">
									<div class="btn-group">
										<button class="btn btn-outline-primary" type="button" data-method="rotate" data-option="-45" title="Rotate Left"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;rotate&quot;, -45)"><span class="fa fa-rotate-left"></span></span></button>
										<button class="btn btn-outline-primary" type="button" data-method="rotate" data-option="45" title="Rotate Right"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;rotate&quot;, 45)"><span class="fa fa-rotate-right"></span></span></button>
										<button class="btn btn-outline-primary" type="button" data-method="scaleX" data-option="-1" title="Flip Horizontal"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;scaleX&quot;, -1)"><span class="fa fa-arrows-h"></span></span></button>
										<button class="btn btn-outline-primary" type="button" data-method="scaleY" data-option="-1" title="Flip Vertical"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;scaleY&quot;, -1)"><span class="fa fa-arrows-v"></span></span></button>
										<button class="btn btn-outline-primary" type="button" data-method="reset" title="Reset"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;reset&quot;)"><span class="fa fa-refresh"></span></span></button>
										<button class="btn btn-outline-primary btn-upload" id="btnUploadImage" title="Upload image file"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="Import image with Blob URLs"><span class="fa fa-upload"></span></span></button>
										<?php
											$Images=array("jpg","jpeg","png","gif","bmp","tiff");
											if(isset($FileTypes)){
												if(array_key_exists("category",$FileTypes)){
													if(array_key_exists("Images",$FileTypes['category'])){
														$Images=$FileTypes['category']['Images'];
													}
												}
											}
											$Images=".".implode(",.",$Images);
										?>
										<input class="sr-only display-none" id="inputImage" type="file" name="file" accept="{{$Images}}">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-outline-dark" id="btnCropModelClose">Close</button>
							<button type="button" class="btn btn-outline-info" id="btnCropApply">Apply</button>
						</div>
					</div>
				</div>
			</div>
		@endif
		<button class="free-quote" type="button">FREE QUOTE</button>
		<div id="free-quote-modal" class="modal">
			<div class="modal-content">
				<div class="modal-title"><h4>Book a Free Consultation<span class="close" style="position: relative;top: -3px;">×</span></h4></div>
				<form id="quoteForm">
					<div class="form-group">
						<label for="txtMName">Name *</label>
						<input class="form-control" type="text" id="txtMName" name="name">
						<div class="errors err-sm" id="txtMName-err"></div>
					</div>
					<div class="form-group">
						<label for="txtMMobNo">Mobile Number *</label>
						<input class="form-control" type="tel" id="txtMMobNo" name="mobile">
						<div class="errors err-sm" id="txtMMobNo-err"></div>
					</div>
					<div class="form-group">
						<label for="txtMEmail">Email *</label>
						<input class="form-control" type="email" id="txtMEmail" name="email">
						<div class="errors err-sm" id="txtMEmail-err"></div>
					</div>
					<button type="button" id="btnMSave" class="btn rounded text-right">Register</button>
				</form>
			</div>
		</div>
	</div>
</div>


<!-- JAVASCRIPT FILES -->
<script src="{{ url('/') }}/assets/home/js/jquery.min.js"></script><!-- JQUERY.MIN JS -->
<script src="{{ url('/') }}/assets/home/vendor/bootstrap/js/bootstrap.bundle.min.js"></script><!-- BOOTSTRAP.MIN JS -->
<script src="{{ url('/') }}/assets/home/vendor/counter/waypoints-min.js"></script><!-- WAYPOINTS JS -->
<script src="{{ url('/') }}/assets/home/vendor/counter/counterup.min.js"></script><!-- COUNTERUP JS -->
<script src="{{ url('/') }}/assets/home/vendor/magnific-popup/magnific-popup.js"></script><!-- MAGNIFIC POPUP JS -->
<script src="{{ url('/') }}/assets/home/vendor/lightgallery/js/lightgallery-all.min.js"></script><!-- LIGHTGALLERY -->
<script src="{{ url('/') }}/assets/home/vendor/masonry/isotope.pkgd.min.js"></script><!-- ISOTOPE -->
<script src="{{ url('/') }}/assets/home/vendor/imagesloaded/imagesloaded.js"></script><!-- IMAGESLOADED -->
<script src="{{ url('/') }}/assets/home/vendor/masonry/masonry-4.2.2.js"></script><!-- MASONRY -->
<script src="{{ url('/') }}/assets/home/vendor/twentytwenty-master/js/jquery.event.move.js"></script>
<script src="{{ url('/') }}/assets/home/vendor/twentytwenty-master/js/jquery.twentytwenty.js"></script>
<script src="{{ url('/') }}/assets/home/vendor/swiper/swiper-bundle.min.js"></script><!-- OWL-CAROUSEL -->
<script src="{{ url('/') }}/assets/home/vendor/aos/aos.js"></script><!-- AOS -->
<script src="{{ url('/') }}/assets/home/js/dz.carousel.js"></script><!-- OWL-CAROUSEL -->
<script src="{{ url('/') }}/assets/home/js/dz.ajax.js"></script><!-- AJAX -->
<script src="{{ url('/') }}/assets/home/js/custom.js"></script><!-- CUSTOM JS -->
<script src="{{ url('/') }}/assets/home/vendor/rangeslider/rangeslider.js"></script><!-- RANGESLIDER -->
<script src="{{ url('/') }}/assets/js/sweet-alert/sweetalert.min.js?r={{ date('dmyHis') }}"></script>
<script src="{{ url('/') }}/assets/js/toastr.min.js?r={{ date('dmyHis') }}"></script>
<script src="{{ url('/') }}/assets/plugins/image-cropper/cropper.js"></script>


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
				@if(!$isEdit && !isset($PageTitle))
					/* var video = $('#IntroVideo');
					video.play(); */
					setTimeout(() => {$('.free-quote').click();}, 2000);
				@endif
				clearInterval(checkExist);
			}
		}, 100);

		@if($isEdit)

			$('a:not(.btnBack)').on('click', function(e) {
				e.preventDefault();
			});
			
			const btnLoading=async($this) =>{
				let loadingText = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing';
				if ($($this).html() !== loadingText) {
					$this.data('original-text', $($this).html());
					$this.html(loadingText);
				}
			}
			const btnReset=async($this)=> {
				$('.waves-ripple').remove();
				$this.html($this.data('original-text'));
				$this.removeAttr('disabled');
			}

			const InitCropper=async (imgSrc,slug)=>{
				var uploadedImageURL;
				var URL = window.URL || window.webkitURL;
				let AspectRatio;

				await getImageAspectRatio(imgSrc).then((aspectRatio) => {
					AspectRatio = aspectRatio;
				}).catch((error) => {
					console.error('Error loading image:', error);
				});
				var options = {
					aspectRatio: AspectRatio,
					preview: '.img-preview'
				};
				var $image = $('#ImageCrop').cropper('destroy').attr('src', imgSrc).attr('data-id', slug).cropper(options);
				$('#ImgCrop').modal({ backdrop: 'static', keyboard: false });
				$('#inputImage').trigger('click');
				$('.docs-buttons').on('click', '[data-method]', function() {
					var $this = $(this);
					var data = $this.data();
					var cropper = $image.data('cropper');
					var cropped;
					var $target;
					var result;
					if (cropper && data.method) {
						data = $.extend({}, data);
						if (typeof data.target !== 'undefined') {
							$target = $(data.target);
							if (typeof data.option === 'undefined') {
								try {
									data.option = JSON.parse($target.val());
								} catch (e) {
									console.log(e.message);
								}
							}
						}
						cropped = cropper.cropped;
						switch (data.method) {
							case 'rotate':
								if (cropped && options.viewMode > 0) {
									$image.cropper('clear');
								}
								break;
							case 'getCroppedCanvas':
								if (uploadedImageType === 'image/jpeg') {
									if (!data.option) {
										data.option = {};
									}
									data.option.fillColor = '#fff';
								}
								break;
						}
						result = $image.cropper(data.method, data.option, data.secondOption);
						switch (data.method) {
							case 'rotate':
								if (cropped && options.viewMode > 0) {
									$image.cropper('crop');
								}
								break;
							case 'scaleX':
							case 'scaleY':
								$(this).data('option', -data.option);
								break;
							case 'getCroppedCanvas':
								if (result) {
									$('#getCroppedCanvasModal').modal().find('.modal-body').html(result);
									if (!$download.hasClass('disabled')) {
										download.download = uploadedImageName;
										$download.attr('href', result.toDataURL(uploadedImageType));
									}
								}
								break;
						}
					}
				});
				$('#inputImage').change(function() {
					$('#ImgCrop').modal('show');
					var files = this.files;
					var file;
					if (!$image.data('cropper')) {
						return;
					}
					if (files && files.length) {
						file = files[0];
						if (/^image\/\w+$/.test(file.type)) {
							uploadedImageName = file.name;
							uploadedImageType = file.type;
							if (uploadedImageURL) {
								URL.revokeObjectURL(uploadedImageURL);
							}
							uploadedImageURL = URL.createObjectURL(file);
							$image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
							// $('#inputImage').val('');
						} else {
							window.alert('Please choose an image file.');
						}
					}
				});
				$(document).on('click', '#btnUploadImage', function() {
					$('#inputImage').trigger('click');
				});

				$(document).on('click','#btnCropApply',function(){
					btnLoading($('#btnCropApply'));
					var canvas = $image.cropper('getCroppedCanvas');
					if (!canvas) {
						return;
					}
					canvas.toBlob(function(blob) {
						var file = new File([blob], 'croppedImage.png', { type: 'image/png' });

						var id = $image.attr('data-id');

						let formData = new FormData();
						formData.append('Slug', id);
						formData.append('croppedImage', file);

						$.ajax({
							type: "post",
							url: "{{ url('/') }}/admin/home/content/image-update", 
							headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
							data: formData,
							processData: false,
							contentType: false,
							success: function(response) {
								if (response.status == true) {
									var element = $('#' + id);
									var newImageUrl = response.ImageUrl + '?t=' + new Date().getTime();
									if (element.is('img')) {
										element.attr('src', newImageUrl);
									} else {
										element.css('background-image', 'url(' + newImageUrl + ')');
									}
									$('#ImgCrop').modal('hide');
									btnReset($('#btnCropApply'));
								}
							}
						});
					});
				});

				$('#btnCropCancel').on('click', function() {
					var id = $image.attr('data-id');
					$('#' + id).val("");
					$('#ImgCrop').modal('hide');
				});
				$(document).on('click','#btnCropModelClose',function(){
					$('#ImgCrop').modal('hide');
				});
				console.log(options);
			}

			const ClearChanges=(button)=>{
				let editElement = button.parent().parent().find('.edit-content');
				var editDiv = button.parent();

				var editButton = $('<button type="button" class="btn btn-sm btn-dark rounded btnEditContent" style="box-shadow: none;"><span class="text-warning"><i class="fas fa-pencil-alt"></i></span></button>');
				editDiv.empty().append(editButton);

				editElement.prop('contenteditable', false);
				editElement.css('background-color', '');

				$('.btnEditContent').removeClass('d-none');
			}

			const getImageAspectRatio= async (imageUrl)=>{
				return new Promise((resolve, reject) => {
					const image = new Image();
					image.onload = () => {
						const aspectRatio = image.width / image.height;
						resolve(aspectRatio);
					};
					image.onerror = (error) => {
						reject(error);
					};
					image.src = imageUrl;
				});
			}

			const getData=()=>{
				let formData={
					HomeContents : []
				};
				$('.edit-content[contenteditable="true"]').each(function(){
					let data = {
						Slug : $(this).attr('id'),
						Content : $(this).html(),
					}
					formData.HomeContents.push(data);
				});
				return formData;
			}

			$('.edit-content').each(function() {
				var editDiv = $('<div class="divEdit"></div>');
				var editButton = $('<button type="button" class="btn btn-sm btn-dark rounded btnEditContent p-2" style="box-shadow: none;"><span class="text-warning"><i class="fas fa-pencil-alt"></i></span></button>');
				editDiv.append(editButton);
				if($(this).hasClass('inner-content')){
					editDiv.css({
						'position': 'absolute',
						'top': '10%',
						'right': '50%',
						'z-index': '1'
					});
				}else{
					editDiv.css({
						'position': 'absolute',
						'top': '2%',
						'right': '2%',
						'z-index': '1'
					});

				}

				$(this).parent().append(editDiv);
			});

			$(document).on('click', '.btnEditContent', async function() {
				let editElement = $(this).parent().parent().find('.edit-content');
				
				var imgSrc = editElement.attr('src');
				var slug = editElement.attr('id');
				var styleAttr = editElement.attr('style');
				
				if (!imgSrc && styleAttr && styleAttr.includes('background-image')) {
					var matches = styleAttr.match(/url\(['"]?([^'"]+)['"]?\)/);
					if (matches && matches.length > 1) {
						imgSrc = matches[1];
					}
				}
				if (imgSrc) {
					InitCropper(imgSrc,slug);
				} else {
					editElement.prop('contenteditable', true);
					editElement.css('background-color', 'rgb(112 164 66)');

					var editDiv = $(this).parent();
					var cancelButton = $('<button type="button" class="btn btn-sm btn-dark rounded btnCancelEdit mr-2" style="box-shadow: none; margin-right: 3px;"><span class="text-danger"><i class="fas fa-times"></i></span></button>');

					var updateButton = $('<button type="button" class="btn btn-sm btn-dark rounded btnUpdateEdit" style="box-shadow: none;"><span class="text-success"><i class="fas fa-check"></i></span></button>');

					editDiv.empty().append(cancelButton).append(updateButton);
					$('.btnEditContent').addClass('d-none');
				}
			});

			$(document).on('click', '.btnCancelEdit', function() {
				ClearChanges($(this));
			});

			$(document).on('click', '.btnUpdateEdit', async function() {
				var button = $(this);
				let formData = await getData();
				if (formData.HomeContents.length > 0){
					swal({
						title: "Are you sure?",
						text: "You want Update this Content!",
						type: "warning",
						showCancelButton: true,
						confirmButtonClass: "btn-outline-success",
						confirmButtonText: "Yes, Update it!",
						closeOnConfirm: false
					},function(){
						swal.close();
						$.ajax({
							type:"post",
							url:"{{ url('/') }}/admin/home/content/update",
							headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
							data:formData,
							success:function(response){
								if(response.status==true){
									toastr.success(response.message, "Success", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0}) 
									ClearChanges(button);
								}else{
									toastr.error(response.message, "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
								}
							}
						});
					});
				}
			});
			
		@else
		
			setInterval(function() {
				$('.btn-next').click();
			}, 4000)


			// Free Consultation Part 

			var modal = $('#free-quote-modal');

			var btn = $(".free-quote");
			var span = $(".close");
			btn.on('click', function() {
				modal.show();
			});
			span.on('click', function() {
				modal.hide();
			});
			$(window).on('click', function(event) {
				if ($(event.target).is(modal)) {
					modal.removeClass('zoom');

					setTimeout(function() {
						modal.addClass('zoom');
					}, 10);
				}
			});



			const isMValidEMail=(email)=>{
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				return emailReg.test( email );
			}

			const clearMContactData=async()=>{
				$('#txtMName').val('');
				$('#txtMEmail').val('');
				$('#txtMMobileNumber').val('');
			}
			const McontactFormValidation=(formData)=>{
				let status=true;
				$('.errors').html('');
				if(formData.FName==""){
					$('#txtMName-err').html('Name is required');status=false;
				}
				if(formData.Email==""){
					$('#txtMEmail-err').html('Email is required');status=false;
				}else if(isMValidEMail(formData.Email)==false){
					$('#txtMEmail-err').html('Email not valid');status=false;
				}

				if(formData.MobileNumber==""){
					$('#txtMMobNo-err').html('Mobile Number is required');status=false;
				}else if(formData.MobileNumber.length!=10){
					$('#txtMMobNo-err').html('The Mobile Number must be 10 digits');status=false;
				}
				return status;
			}
			const onMContactSubmit = function() {
				let formData={}
				formData.FName=$('#txtMName').val();
				formData.Email=$('#txtMEmail').val();
				formData.MobileNumber=$('#txtMMobNo').val();

				let status=McontactFormValidation(formData);
				if(status){
					$.ajax({
						type:"post",
						url:"{{url('/')}}/save/contact-enquiry",
						data:formData,
						dataType:"json",
						headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
						success:function(response){
							if(response.status==true){
								toastr.success(response.message, "Success", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0});
								modal.hide();
								$('#txtMName').val('');
								$('#txtMEmail').val('');
								$('#txtMMobNo').val('');
							}else{
								toastr.error(response.message, "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0}) 
							}
						}
					});
				}
			};
			$(document).on('click', '#btnMSave', function(e) {
				e.preventDefault();
				onMContactSubmit();
			});

		@endif
		
	});
</script>

@yield('scripts')
</body>
</html>