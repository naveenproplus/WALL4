@extends('home.home-layout')

@section('home-content')
<!-- Banner  -->
	<div class="slidearea bannerside">
		<div class="side-contact-info">
			<ul>
				<li><i class="fas fa-phone-alt"></i>{{$Company['Phone-Number']}}</li>
				<li><i class="fas fa-envelope"></i>{{$Company['Email']}}</li>
			</ul>
		</div>
		<div class="dz-bnr-inr style-1 overlay-left" style="background-image: url(assets/home/images/banner/bnr7.jpg);">
			<div class="container-fluid">
				<div class="dz-bnr-inr-entry">
					<h1>FAQs</h1>
					<!-- Breadcrumb Row -->
					<nav aria-label="breadcrumb" class="breadcrumb-row">
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ url('/') }}/admin"><i class="f-16 fa fa-home"></i></a></li>
							<li class="breadcrumb-item">FAQs</li>
						</ul>
					</nav>
					<!-- Breadcrumb Row End -->
				</div>
			</div>
		</div>
	</div>
<!-- Banner End -->

	<section class="section-full content-inner" style="background-image:url(assets/home/images/background/bg2.png); background-position:right bottom; background-size:100%; background-repeat:no-repeat;">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="accordion dz-accordion accordion-sm" id="accordionFaq">
						@foreach ($FAQ as $index => $item)
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
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@section('scripts')

@endsection
