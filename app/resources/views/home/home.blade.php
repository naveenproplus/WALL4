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
								<img src="{{url('/')}}/{{$Contents['img-home-slider1']}}" class="edit-content" id="img-home-slider1" data-swiper-parallax="30%" alt="">
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
								<img src="{{url('/')}}/{{$Contents['img-home-slider2']}}" class="edit-content" id="img-home-slider2" data-swiper-parallax="30%" alt="">
							</div>
							<div class="silder-content" data-swiper-parallax="-40%">
								<div class="inner-content edit-content" id="home-slider-content2">
									{!!$Contents['home-slider-content2']!!}	
								</div>
								<div class="overlay-slide" data-swiper-parallax="100%"></div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="silder-img overlay-black-light">
								<img src="{{url('/')}}/{{$Contents['img-home-slider3']}}" class="edit-content" id="img-home-slider3" data-swiper-parallax="30%" alt="">
							</div>
							<div class="silder-content" data-swiper-parallax="-40%">
								<div class="inner-content edit-content" id="home-slider-content3">
									{!!$Contents['home-slider-content3']!!}
								</div>
								<div class="overlay-slide" data-swiper-parallax="100%"></div>
							</div>
						</div>
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
							<div class="img1 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200"><img src="{{url('/')}}/{{$Contents['img-about-us-animation1']}}" alt="" class="edit-content" id="img-about-us-animation1"></div>
							<div class="img2 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400"><img src="{{url('/')}}/{{$Contents['img-about-us-animation2']}}" alt="" class="edit-content" id="img-about-us-animation2"></div>
							<div class="img3 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600"><img src="{{url('/')}}/{{$Contents['img-about-us-animation3']}}" alt="" class="edit-content" id="img-about-us-animation3"></div>
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
							<img src="{{url('/')}}/assets/home/images/video/pic2-2.jpg" alt="">
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
									<p class="m-b30 service-content">{{$item->Title}}</p>
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
						@foreach ($LatestProjects as $key=>$item)
							<div class="swiper-slide">
								<div class="dz-box overlay style-1 @if($key % 2 != 0)mt-5 @endif">
									<div class="dz-media">
										<img src="{{$item->ProjectImage}}" alt="{{$item->ProjectImage}}">
									</div>
									<div class="dz-info">
										<span data-exthumbimage="{{$item->ProjectImage}}" data-src="{{$item->ProjectImage}}" class="view-btn lightimg" title="{{$item->ServiceName}}"></span>
										<h6 class="sub-title">{{$item->ServiceName}}</h6>
										<h4 class="title m-b15"><a href="{{url('/')}}/projects/{{$item->Slug}}">{{$item->ProjectName}} <span>{{$item->ProjectAddress}}</span></a></h4>
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
		
		<!-- Testimonial -->
		{{-- <section class="content-inner-2" style="background-image:url({{url('/')}}/assets/home/images/background/bg2.png); background-position:right bottom; background-size:100%; background-repeat:no-repeat;">
			<div class="container">
				<div class="section-head style-1 text-center">
					<h6 class="sub-title text-primary">TESTIMONIAL</h6>
					<h2 class="title">What Our Clients Says</h2>
				</div>
				<div class="row">
					<div class="col-lg-6 align-self-center aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
						<div class="swiper-container swiper-client">
							<div class="swiper-wrapper">
								<div class="swiper-slide" data-rel="1">
									<div class="testimonial-1">
										<div class="testimonial-info">
											<div class="flaticon-quotation quote-icon"></div>
											<div class="testimonial-text">
												<p>Phasellus facilisis urna at ultrices egestas. Nulla mi arcu, finibus non lectus non, mollis tempus enim. Curabitur vel ipsum eget augue pharetra tempus ac eget ipsum. Fusce vestibulum leo quis bibendum placerat. Duis porttitor mi at mauris auctor eleifend. Cras sed nibh sem. Proin quis ligula eget purus eleifend euismod. Sed rhoncus nunc vitae diam.</p>
											</div>
											<div class="testimonial-detail">
												<h4 class="testimonial-name">George Carson</h4> 
												<span class="testimonial-position text-primary">CEO Founder</span> 
											</div>
										</div>
									</div>
								</div>
								<div class="swiper-slide" data-rel="2">
									<div class="testimonial-1">
										<div class="testimonial-info">
											<div class="flaticon-quotation quote-icon"></div>
											<div class="testimonial-text">
												<p>Phasellus facilisis urna at ultrices egestas. Nulla mi arcu, finibus non lectus non, mollis tempus enim. Curabitur vel ipsum eget augue pharetra tempus ac eget ipsum. Fusce vestibulum leo quis bibendum placerat. Duis porttitor mi at mauris auctor eleifend. Cras sed nibh sem. Proin quis ligula eget purus eleifend euismod. Sed rhoncus nunc vitae diam.</p>
											</div>
											<div class="testimonial-detail">
												<h4 class="testimonial-name">Freddie Ronan</h4> 
												<span class="testimonial-position text-primary">CEO Founder</span> 
											</div>
										</div>
									</div>
								</div>
								<div class="swiper-slide" data-rel="3">
									<div class="testimonial-1">
										<div class="testimonial-info">
											<div class="flaticon-quotation quote-icon"></div>
											<div class="testimonial-text">
												<p>Phasellus facilisis urna at ultrices egestas. Nulla mi arcu, finibus non lectus non, mollis tempus enim. Curabitur vel ipsum eget augue pharetra tempus ac eget ipsum. Fusce vestibulum leo quis bibendum placerat. Duis porttitor mi at mauris auctor eleifend. Cras sed nibh sem. Proin quis ligula eget purus eleifend euismod. Sed rhoncus nunc vitae diam.</p>
											</div>
											<div class="testimonial-detail">
												<h4 class="testimonial-name">Ethan Jacoby</h4> 
												<span class="testimonial-position text-primary">CEO Founder</span> 
											</div>
										</div>
									</div>
								</div>
								<div class="swiper-slide" data-rel="4">
									<div class="testimonial-1">
										<div class="testimonial-info">
											<div class="flaticon-quotation quote-icon"></div>
											<div class="testimonial-text">
												<p>Phasellus facilisis urna at ultrices egestas. Nulla mi arcu, finibus non lectus non, mollis tempus enim. Curabitur vel ipsum eget augue pharetra tempus ac eget ipsum. Fusce vestibulum leo quis bibendum placerat. Duis porttitor mi at mauris auctor eleifend. Cras sed nibh sem. Proin quis ligula eget purus eleifend euismod. Sed rhoncus nunc vitae diam.</p>
											</div>
											<div class="testimonial-detail">
												<h4 class="testimonial-name">Charlie Kane</h4> 
												<span class="testimonial-position text-primary">CEO Founder</span> 
											</div>
										</div>
									</div>
								</div>
								<div class="swiper-slide" data-rel="5">
									<div class="testimonial-1">
										<div class="testimonial-info">
											<div class="flaticon-quotation quote-icon"></div>
											<div class="testimonial-text">
												<p>Phasellus facilisis urna at ultrices egestas. Nulla mi arcu, finibus non lectus non, mollis tempus enim. Curabitur vel ipsum eget augue pharetra tempus ac eget ipsum. Fusce vestibulum leo quis bibendum placerat. Duis porttitor mi at mauris auctor eleifend. Cras sed nibh sem. Proin quis ligula eget purus eleifend euismod. Sed rhoncus nunc vitae diam.</p>
											</div>
											<div class="testimonial-detail">
												<h4 class="testimonial-name">Alfie Mason</h4> 
												<span class="testimonial-position text-primary">CEO Founder</span> 
											</div>
										</div>
									</div>
								</div>
								<div class="swiper-slide" data-rel="6">
									<div class="testimonial-1">
										<div class="testimonial-info">
											<div class="flaticon-quotation quote-icon"></div>
											<div class="testimonial-text">
												<p>Phasellus facilisis urna at ultrices egestas. Nulla mi arcu, finibus non lectus non, mollis tempus enim. Curabitur vel ipsum eget augue pharetra tempus ac eget ipsum. Fusce vestibulum leo quis bibendum placerat. Duis porttitor mi at mauris auctor eleifend. Cras sed nibh sem. Proin quis ligula eget purus eleifend euismod. Sed rhoncus nunc vitae diam.</p>
											</div>
											<div class="testimonial-detail">
												<h4 class="testimonial-name">Archie Parker</h4> 
												<span class="testimonial-position text-primary">CEO Founder</span> 
											</div>
										</div>
									</div>
								</div>
							
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="client-area">
							<svg viewBox="0 0 574 511" class="client-bg aos-item" data-aos="fade-in" data-aos-duration="800" data-aos-delay="200" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><path stroke="var(--primary)" stroke-width="3" fill="none" d="M466.253 161.575c32.408-59.804 26.317-127.495-35.817-124.214-21.983 1.159-42.258 16.216-64.265 17.762-20.248 1.425-39.152-7.801-56.128-17.686-34.373-20.017-65.685-58.278-103.358-16.906-25.654 28.169 3.163 72.215-24.694 97.514-8.698 7.905-22.479 9.509-33.89 10.987-28.345 3.671-50.444 8.129-77.333 21.075-50.333 24.214-63.016 41.712-68.009 72.376-5.411 33.246 18.459 81.167 57.923 86.892 47.337 6.875 62.6-27.975 115.202-20.21 44.397 6.545 37.678 43.589 36.73 76.523-1.791 62.123 48.901 88.979 106.445 67.392 18.747-7.036 54.435-25.45 61.781-46.766 5.929-17.204-8.925-38.223-12.682-54.363-13.218-56.766 52.37-36.554 90.575-32.547 36.51 3.834 98.693 4.263 110.935-52.659 4.2-19.531-24.295-55.633-42.521-58.503-25.786-4.051-73.433-3.538-60.894-26.667z"></path><path fill-rule="evenodd" fill="var(--rgba-primary-1)" d="M421.378 125.766c-2.044-75.742-45.622-137.651-103.734-99.88-20.562 13.364-31.734 39.18-52.103 52.929-18.739 12.652-42.114 14.28-63.996 14.201-44.308-.167-95.824-19.637-109.124 41.255-9.059 41.463 43.273 67.904 30.49 107.825-3.989 12.47-16.39 21.694-26.574 29.475-25.3 19.327-44.135 35.937-62.865 63.401-35.069 51.394-37.558 75.336-25.296 107.699 13.297 35.087 63.014 68.02 104.272 51.562 49.494-19.732 44.809-61.853 99.879-83.658 46.474-18.414 60.624 21.064 78.052 53.364 32.873 60.926 96.733 58.6 140.221 5.725 14.167-17.228 38.338-54.87 33.553-79.523-3.863-19.899-29.899-31.903-42.513-45.38-44.367-47.4 30.162-64.432 69.25-81.845 37.355-16.637 97.582-50.856 77.688-112.586-6.827-21.182-54.423-40.137-73.603-32.754-27.132 10.453-72.81 37.485-73.597 8.19z"></path></svg>
							<ul class="aos-item" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="600">
								<li data-member="1"><a href="#" class="dzclient1"><img src="{{url('/')}}/assets/home/images/testimonials/pic1.jpg" alt=""></a></li>
								<li data-member="2"><a href="#" class="dzclient2"><img src="{{url('/')}}/assets/home/images/testimonials/pic2.jpg" alt=""></a></li>
								<li data-member="3"><a href="#" class="dzclient3"><img src="{{url('/')}}/assets/home/images/testimonials/pic3.jpg" alt=""></a></li>
								<li data-member="4"><a href="#" class="dzclient4"><img src="{{url('/')}}/assets/home/images/testimonials/pic4.jpg" alt=""></a></li>
								<li data-member="5"><a href="#" class="dzclient5"><img src="{{url('/')}}/assets/home/images/testimonials/pic5.jpg" alt=""></a></li>
								<li data-member="6"><a href="#" class="dzclient6"><img src="{{url('/')}}/assets/home/images/testimonials/pic6.jpg" alt=""></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section> --}}

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
							<div class="content-media right edit-content">
								<img src="{{url('/')}}/assets/home/images/video/pic2-1.jpg" alt="">
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Blog -->
		{{-- <section class="content-inner bg-gray line-img" style="background-image:url({{url('/')}}/assets/home/images/background/bg2.png); background-position:right bottom; background-size:100%; background-repeat:no-repeat;">
			<div class="container">
				<div class="section-head style-1 text-center">
					<h6 class="sub-title text-primary">OUR BLOG</h6>
					<h2 class="title">Latest News Feed</h2>
				</div> 
				<div class="blog-area">
					<div class="row">
						<div class="col-lg-4 col-md-12 m-b30">
							<div class="dz-card blog-grid style-1 aos-item h-100 overlay-post" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="200">
								<div class="dz-media">
									<a href="blog-details.html"><img src="{{url('/')}}/assets/home/images/blog/pic1.jpg" alt=""></a>
								</div>
								<div class="dz-info">
									<div class="dz-meta">
										<ul>
											<li class="post-date"><strong>20</strong><span>March</span></li>
											<li class="post-category"><a href="javascript:void(0);">Architectural</a></li>
											<li class="post-user">By <a href="javascript:void(0);">John Doe</a></li>
										</ul>
									</div>
									<h5 class="dz-title"><a href="blog-details.html">Sed lacinia pulvinar odio, nec tempus augue.</a></h5>
									<div class="read-more">
										<a href="blog-details.html" class="btn btn-primary btn-rounded btn-sm hover-icon">
											<span>Read More</span>
											<i class="fas fa-arrow-right"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 m-b30">
							<div class="dz-card blog-grid style-1 aos-item h-100" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="500">
								<div class="dz-media">
									<a href="blog-details.html"><img src="{{url('/')}}/assets/home/images/blog/blog-grid/pic2.jpg" alt=""></a>
								</div>
								<div class="dz-info">
									<div class="dz-meta">
										<ul>
											<li class="post-date"><strong>15</strong><span>March</span></li>
											<li class="post-category"><a href="javascript:void(0);">Architectural</a></li>
											<li class="post-user">By <a href="javascript:void(0);">John Doe</a></li>
										</ul>
									</div>
									<h5 class="dz-title"><a href="blog-details.html">Integer vestibulum rutrum aliquet cras.</a></h5>
									<div class="read-more">
										<a href="blog-details.html" class="btn btn-primary btn-rounded btn-sm hover-icon">
											<span>Read More</span>
											<i class="fas fa-arrow-right"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 m-b30">
							<div class="dz-card blog-grid style-1 aos-item h-100" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="800">
								<div class="dz-media">
									<a href="blog-details.html"><img src="{{url('/')}}/assets/home/images/blog/blog-grid/pic3.jpg" alt=""></a>
								</div>
								<div class="dz-info">
									<div class="dz-meta">
										<ul>
											<li class="post-date"><strong>05</strong><span>March</span></li>
											<li class="post-category"><a href="javascript:void(0);">Architectural</a></li>
											<li class="post-user">By <a href="javascript:void(0);">John Doe</a></li>
										</ul>
									</div>
									<h5 class="dz-title"><a href="blog-details.html">Aenean sit amet ex nec nisl consectetur iaculis.</a></h5>
									<div class="read-more">
										<a href="blog-details.html" class="btn btn-primary btn-rounded btn-sm hover-icon">
											<span>Read More</span>
											<i class="fas fa-arrow-right"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section> --}}

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
									<img class="logo-main" src="{{url('/')}}/{{$item->ProfileImage}}" alt="{{$item->Name}}" height="100px" width="100px">
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

