@extends('home.home-layout')

@section('home-content')
<!-- Banner  -->
<div class="slidearea bannerside">
	<div class="side-contact-info">
		<ul>
            <li><i class="fas fa-phone-alt"></i>+91 {{$Company['Phone-Number']}}</li>
			<li><i class="fas fa-envelope"></i>{{$Company['Email']}}</li>
		</ul>
	</div>
	<div class="dz-bnr-inr style-1 overlay-left edit-content" id="img-services-bnr" style="background-image:url({{url('/')}}/{{$Contents['img-services-bnr']}});">
		<div class="container-fluid">
			<div class="dz-bnr-inr-entry">
				<h1>{{$PageTitle}}</h1>
				<!-- Breadcrumb Row -->
				<nav aria-label="breadcrumb" class="breadcrumb-row">
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
						<li class="breadcrumb-item">{{$PageTitle}}</li>
					</ul>
				</nav>
				<!-- Breadcrumb Row End -->
			</div>
		</div>
	</div>
</div>

<!-- All Services -->
<section class="section-full content-inner" style="background-image:url({{url('/')}}/assets/home/images/background/bg2.png); background-position:right bottom; background-size:100%; background-repeat:no-repeat;">
	<div class="container">
		<div class="row">
			@foreach ($Services as $item)
				<div class="col-lg-4 col-sm-6 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
					<div class="icon-bx-wraper style-3 m-b30">
						<div class="icon-xl m-b30"> 
							<a href="javascript:void(0);" class="icon-cell"><i class="flaticon-{{$item->ServiceIcon ? $item->ServiceIcon : 'blueprint-1'}}"></i></a>
						</div>
						<div class="icon-content">
						<h4 class="title m-b10"><a href="{{url('/')}}">{{$item->ServiceName}}</a></h4>
							<p class="m-b30 service-content">{{$item->Description1}}</p>
							<a href="{{url('/')}}/services/{{$item->Slug}}" class="btn btn-primary btn-rounded btn-sm hover-icon">
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
