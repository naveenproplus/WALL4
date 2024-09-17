@extends('home.home-layout')
@section('home-content')
<style>
	.video-bx.content-media.style-2 {
		position: relative;
		width: 100%;
		margin: 0 auto;
	}

	.video-bx.content-media.style-2 video {
		width: 100%;
		height: auto;
		display: block;
	}
</style>
<!-- Slider -->
		<div class="slidearea">
			<div class="side-contact-info">
				<ul>
					<li><i class="fas fa-phone-alt"></i>+91 {{$Company['Phone-Number']}}</li>
					<li><i class="fas fa-envelope"></i> {{$Company['Email']}}</li>
				</ul>
			</div>
			<div class="silder-one">
				<div class="swiper-container main-silder-swiper">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<div class="silder-img overlay-black-light">
								<img loading="lazy" src="{{url('/')}}/{{$Contents['img-home-slider1']}}" {{-- class="edit-content" --}} id="img-home-slider1" data-swiper-parallax="30%" alt="">
							</div>
							<div class="silder-content" data-swiper-parallax="-40%">
								<div class="inner-content edit-content" id="home-slider-content1">
									{!!$Contents['home-slider-content1']!!}
								</div>
								<div class="overlay-slide" data-swiper-parallax="100%"></div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="silder-img overlay-black-light">
								<img loading="lazy" src="{{url('/')}}/{{$Contents['img-home-slider2']}}" {{-- class="edit-content" --}} id="img-home-slider2" data-swiper-parallax="30%" alt="">
							</div>
							<div class="silder-content" data-swiper-parallax="-40%">
								<div class="inner-content edit-content" id="home-slider-content2">
									{!!$Contents['home-slider-content2']!!}	
								</div>
								<div class="overlay-slide" data-swiper-parallax="100%"></div>
							</div>
						</div>
						{{-- <div class="swiper-slide">
							<div class="silder-img overlay-black-light">
								<img loading="lazy" src="{{url('/')}}/{{$Contents['img-home-slider3']}}" class="edit-content" id="img-home-slider3" data-swiper-parallax="30%" alt="">
							</div>
							<div class="silder-content" data-swiper-parallax="-40%">
								<div class="inner-content edit-content" id="home-slider-content3">
									{!!$Contents['home-slider-content3']!!}
								</div>
								<div class="overlay-slide" data-swiper-parallax="100%"></div>
							</div>
						</div> --}}
					</div>
					<div class="slider-one-pagination">
						<!-- Add Navigation -->
						<div class="btn-prev swiper-button-prev1 swiper-button-white"><i class="las la-long-arrow-alt-left"></i></div>
						<div class="swiper-pagination swiper-pagination-white"></div>
						<div class="btn-next swiper-button-next1 swiper-button-white"><i class="las la-long-arrow-alt-right"></i></div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- About US -->
		<section class="section-full content-inner about-bx2" style="background-image:url({{url('/')}}/assets/home/images/background/bg2.png); background-position:right bottom; background-size:100%; background-repeat:no-repeat;">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<div class="dz-media">
							<div class="img1 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200"><img loading="lazy" src="{{url('/')}}/{{$Contents['img-about-us-animation1']}}" alt="" class="edit-content" id="img-about-us-animation1"></div>
							<div class="img2 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400"><img loading="lazy" src="{{url('/')}}/{{$Contents['img-about-us-animation2']}}" alt="" class="edit-content" id="img-about-us-animation2"></div>
							<div class="img3 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600"><img loading="lazy" src="{{url('/')}}/{{$Contents['img-about-us-animation3']}}" alt="" class="edit-content" id="img-about-us-animation3"></div>
						</div>
					</div>
					<div class="col-lg-6 align-self-center">
						<div class="year-exp edit-content" id="exp-years">
							{!!$Contents['exp-years']!!}
						</div>
						<p class="m-b30 aos-item edit-content" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400" id="exp-desc">{!!$Contents['exp-desc']!!}</p>
						<div class="accordion dz-accordion about-faq cannot-edit" id="aboutFaq">
							@foreach ($Services->shuffle()->take(3) as $index => $item)
								<div class="accordion-item">
									<h4 class="accordion-header">
										<a href="#" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#about{{$index}}" aria-expanded="true" aria-controls="about{{$index}}">
											<i class="flaticon-{{$item->ServiceIcon}}"></i>
											{{$item->ServiceName}}
											<span class="toggle-close"></span>
										</a>
									</h4>
									<div id="about{{$index}}" class="accordion-collapse collapse show" aria-labelledby="about{{$index}}" data-bs-parent="#aboutFaq">
										<div class="accordion-body">
											<p class="m-b0">{{$item->Description1}}</p>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<!-- Counter And  Video -->
		<section class="dz-content-bx style-3">
			<div class="dz-content-inner">
				<div class="row">
					<div class="col-xl-10 col-lg-12 counter-info aos-item" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200">
						<div class="row edit-content" id="overall-achievements">
							{!!$Contents['overall-achievements']!!}
						</div>
					</div>
				</div>
				<div class="row spno">
					<div class="col-lg-12">
						<div class="video-bx content-media style-2">
							<img loading="lazy" src="{{url('/')}}/assets/home/images/video/pic2-2.jpg" alt="">
							<div class="video-btn aos-item" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="400">
								<a href="{{$Company['youtube-url']}}" class="popup-youtube" target="_blank"><i class="fas fa-play"></i></a>
							</div>
							{{-- <video controls autoplay muted>
								<source src="uploads/home/videos/intro-video.mp4" type="video/mp4" id="IntroVideo">
							</video> --}}
							
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<!-- Services -->
		<section class="content-inner-2"  style="background-image:url({{url('/')}}/assets/home/images/background/bg1.png); background-position:left top; background-size:100%; background-repeat:no-repeat;">
			<div class="container">
				<div class="section-head style-1 text-center">
					<h6 class="sub-title text-primary">POPULAR SERVICES</h6>
					<h2 class="title">Our Featured Services</h2>
				</div>
				<div class="row">
					@foreach ($Services->shuffle()->take(6) as $item)
						<div class="col-lg-4 col-sm-6 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
							<div class="icon-bx-wraper style-3  m-b30">
								<div class="icon-xl m-b30"> 
									<a href="javascript:void(0);" class="icon-cell"><i class="flaticon-{{$item->ServiceIcon}}"></i></a>
								</div>
								<div class="icon-content">
								<h4 class="title m-b10"><a href="{{url('/')}}/services">{{$item->ServiceName}}</a></h4>
									<p class="m-b30 service-content">{{$item->Description1 ?? $item->Description2}}</p>
									<a href="{{url('/')}}/services" class="btn btn-primary btn-rounded btn-sm hover-icon">
										<span>Read More</span>
										<i class="fas fa-arrow-right"></i>
									</a>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</section>

		<!-- Projects -->
		<section class="content-inner-2">
			<div class="container">
				<div class="row section-head-bx align-items-center">
					<div class="col-md-8">
						<div class="section-head style-1">
							<h6 class="sub-title text-primary">OUR PROJECTS</h6>
							<h2 class="title">Our Latest Projects</h2>
						</div>
					</div>
					<div class="col-md-4 text-start text-md-end mb-4 mb-md-0">
						<a href="{{url('/')}}/projects" class="btn-link">See All Projects <i class="fas fa-plus scale08"></i></a>
					</div>
				</div>
			</div>
			<div class="container-fluid">
				<div class="swiper-container swiper-portfolio lightgallery aos-item" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="400">
					<div class="swiper-wrapper">
						@foreach ($Projects as $key=>$item)
							<div class="swiper-slide">
								<div class="dz-box overlay style-1 @if($key % 2 != 0)mt-5 @endif">
									<div class="dz-media">
										<img loading="lazy" src="{{url('/')}}/{{$item->ProjectImage}}" alt="{{$item->Slug}}">
									</div>
									<div class="dz-info">
										<span data-exthumbimage="{{url('/')}}/{{$item->ProjectImage}}" data-src="{{url('/')}}/{{$item->ProjectImage}}" class="view-btn lightimg" title="{{$item->ProjectAreaName}}"></span>
										<h6 class="sub-title">{{$item->ProjectAreaName}}</h6>
										<h4 class="title m-b15"><a href="{{-- {{url('/')}}/projects/{{$item->Slug}} --}} javascript:void(0);">{{$item->ProjectName}} <span>{{$item->ProjectAddress}}</span></a></h4>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>	
			</div>	
			<div class="content-inner bg-secondary subscribe-area" style="background-image: url({{url('/')}}/assets/home/images/background/bg2-1.png); background-position: center;">
				
			</div>
		</section>
		

		<!-- Faq -->
		<section class="section-full content-inner overflow-hidden" style="background-image:url({{url('/')}}/assets/home/images/background/bg1.png); background-position:left top; background-size:100%; background-repeat:no-repeat;">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-6 m-b30 aos-item aos-init aos-animate" data-aos="fade-right" data-aos-duration="800" data-aos-delay="300">
						<div class="twentytwenty-img-area">
							<div class="twentytwenty-wrapper twentytwenty-horizontal"><div class="twentytwenty-container">
								<iframe src="{{$Company['3d-map-link']}}" width="570" height="570" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
							<div class="twentytwenty-overlay"><div class="twentytwenty-before-label"></div><div class="twentytwenty-after-label"></div></div><div class="twentytwenty-handle"><span class="twentytwenty-left-arrow"></span><span class="twentytwenty-right-arrow"></span></div></div></div>
						</div>
					</div>
					<div class="col-lg-6 aos-item aos-init aos-animate" data-aos="fade-left" data-aos-duration="800" data-aos-delay="600">
						<div class="section-head style-1">
							<h6 class="sub-title text-primary">FAQ</h6>
							<h2 class="title">Get Every Answer From Here</h2>
						</div>
						<div class="accordion dz-accordion accordion-sm" id="accordionFaq">
							@foreach ($FAQ->shuffle()->take(3) as $index => $item)
								<div class="accordion-item">
									<h2 class="accordion-header">
										<a href="#" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse{{$index}}" aria-expanded="true" aria-controls="collapse{{$index}}">
											{{$item->FAQ}}
											<span class="toggle-close"></span>
										</a>
									</h2>
									<div id="collapse{{$index}}" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
										<div class="accordion-body">
											<p class="m-b0">{{$item->Answer}}</p>
										</div>
									</div>
								</div>
							@endforeach
						  <a href="{{url('/')}}/faq" class="btn shadow-primary btn-light btn-rounded btn-ov-secondary btn-home-sec-1">READ MORE <i class="m-l10 fas fa-caret-right"></i></a>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<!-- Our Strategy -->
		<section class="section-full dz-content-bx style-2 text-white" >
			<div class="dz-content-inner bg-dark" style="background-image: url({{url('/')}}/assets/home/images/background/bg2-1.png); background-position: center;">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 content-inner-1 aos-item edit-content" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200" id="our-strategy">
							{!!$Contents['our-strategy']!!}
						</div>
						<div class="col-lg-6 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
							<div class="content-media right">
								<img loading="lazy" src="{{url('/')}}/assets/home/images/video/pic2-1.jpg" alt="">
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Top Clients -->
		<section class="content-inner-1">
			<div class="container">
				<div class="section-head style-1 text-center">
					<h6 class="sub-title text-primary">Brands</h6>
					<h2 class="title">Our Top Clients</h2>
				</div>
				<div class="swiper-container clients-swiper">
					<div class="swiper-wrapper">
						@foreach ($TopClients as $item)
							<div class="swiper-slide">
								<div class="clients-logo aos-item" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="100">
									<img loading="lazy" class="logo-main" src="{{url('/')}}/{{$item->ProfileImage}}" alt="{{$item->Name}}" height="100px" width="100px">
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</section>
@endsection

@section('scripts')

@endsection

