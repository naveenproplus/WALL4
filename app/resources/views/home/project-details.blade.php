@extends('home.home-layout')

@section('home-content')
    <!-- Banner  -->
    <div class="slidearea bannerside">
        <div class="side-contact-info">
            <ul>
                <li><i class="fas fa-phone-alt"></i>{{ $Company['Phone-Number'] }}</li>
                <li><i class="fas fa-envelope"></i>{{ $Company['Email'] }}</li>
            </ul>
        </div>
        <div class="dz-bnr-inr style-1 overlay-left edit-content" id="img-services-bnr"
            style="background-image:url({{ url('/') }}/{{ $Project->ProjectImage }});">
            <div class="container-fluid">
                <div class="dz-bnr-inr-entry">
                    <h1>{{ $Project->ProjectName }}</h1>
                    <!-- Breadcrumb Row -->
                    <nav aria-label="breadcrumb" class="breadcrumb-row">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item">Projects</li>
                            <li class="breadcrumb-item">Project Details</li>
                        </ul>
                    </nav>
                    <!-- Breadcrumb Row End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <section class="section-full content-inner-2 port-detail"
        style="background-image:url({{ url('/') }}/assets/home/images/background/bg2.png); background-position:right bottom; background-size:100%; background-repeat:no-repeat;">
        <div class="container">
            <div class="row mb-lg-5 mb-3 ">
                <div class="col-lg-6 col-md-12 align-self-center aos-item" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-delay="400">
                    <div class="widget ext-sidebar-menu">
                        <ul class="menu">
                            <h2 class="dz-title">{{ $Project->SDesc }}</h2>
                            <p>{{ $Project->LDesc }}</p>
                            <div class="icon-bx-wraper style-7 left m-b30">
                                <div class="icon-bx-sm bg-primary">
                                    <span class="icon-cell"><i class="flaticon-blueprint"></i></span>
                                </div>
                                <div class="icon-content">
                                    <h4 class="title m-b5">Project Type</h4>
                                    <p>{{ $Project->ProjectAreaName }}</p>
                                </div>
                            </div>
                            <div class="icon-bx-wraper style-7 left m-b30">
                                <div class="icon-bx-sm bg-primary">
                                    <span class="icon-cell"><i class="flaticon-concept"></i></span>
                                </div>
                                <div class="icon-content">
                                    <h4 class="title m-b5">Service Name</h4>
                                    <p>{{ $Project->ServiceName }}</p>
                                </div>
                            </div>
                            <div class="icon-bx-wraper style-7 left m-b30">
                                <div class="icon-bx-sm bg-primary">
                                    <span class="icon-cell"><i class="flaticon-placeholder"></i></span>
                                </div>
                                <div class="icon-content">
                                    <h4 class="title m-b5">Project Location</h4>
                                    <p>{{ $Project->ProjectAddress }}</p>
                                </div>
                            </div>
                            <div class="icon-bx-wraper style-7 left m-b30">
                                <div class="icon-bx-sm bg-primary">
                                    <span class="icon-cell"><i class="flaticon-telephone"></i></span>
                                </div>
                                <div class="icon-content">
                                    <h4 class="title m-b5">Call Us</h4>
                                    <p>+91 {{ $Company['Phone-Number'] }}</p>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 m-b30 aos-item" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-delay="600">
                    <img src="{{ url('/') }}/{{ $Project->ProjectImage }}" class="d-lg-block" alt="">
                </div>
            </div>
            {{-- <div class="row">
            <div class="col-lg-7 col-md-5 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <img src="{{url('/')}}/assets/home/images/work/pic3.jpg" alt="">
            </div>
            <div class="col-lg-5 col-md-7 align-self-center  aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                <ul class="info-list">
                    <li>
                        <h2 class="text-primary">100%</h2>
                        <h4>Work Completed</h4>
                    </li>
                    <li>
                        <h2 class="text-primary">250</h2>
                        <h4>Workers Have Done</h4>
                    </li>
                    <li>
                        <h2 class="text-primary">480</h2>
                        <h4>In Days Completed</h4>
                    </li>
                </ul>
            </div>
        </div> --}}
        </div>
    </section>
    <div class="content-inner-2">
        <div class="container">
            <div class="row lightgallery">
                {{-- <div class="col-lg-12 col-md-12 m-b30 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <div class="video-bx content-media style-2 shadow">
                    <img src="images/video/pic2-2.jpg" alt="">
                    <div class="video-btn aos-item aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="400">
                        <a href="https://www.youtube.com/watch?v=sNCv3_NTNtU" class="popup-youtube"><i class="fas fa-play"></i></a>
                    </div>
                </div>	
            </div> --}}
                @foreach ($Project->ProjectGallery as $item)
                    <div class="col-lg-4 col-md-4 m-b30 aos-item" data-aos="fade-up" data-aos-duration="1000"
                        data-aos-delay="200">
                        <div class="dz-box overlay style-1">
                            <div class="dz-media">
                                <img src="{{ url('/') }}/{{ $item }}" alt="">
                            </div>
                            <div class="dz-info">
                                <span data-exthumbimage="{{ url('/') }}/{{ $item }}"
                                    data-src="{{ url('/') }}/{{ $item }}" class="view-btn lightimg"
                                    title="{{ $Project->Slug }}"></span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

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
                    <a href="{{ url('/') }}/projects" class="btn-link">See All Projects <i
                            class="fas fa-plus scale08"></i></a>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="swiper-container swiper-portfolio lightgallery aos-item" data-aos="fade-in" data-aos-duration="1000"
                data-aos-delay="400">
                <div class="swiper-wrapper">
                    @foreach ($Projects->where('Slug', '!=', $Project->Slug)->shuffle() as $key => $item)
                        <div class="swiper-slide">
                            <div class="dz-box overlay style-1 @if ($key % 2 != 0) mt-5 @endif">
                                <div class="dz-media">
                                    <img src="{{ url('/') }}/{{ $item->ProjectImage }}"
                                        alt="{{ basename($item->ProjectImage) }}">
                                </div>
                                <div class="dz-info">
                                    <span data-exthumbimage="{{ $item->ProjectImage }}"
                                        data-src="{{ $item->ProjectImage }}" class="view-btn lightimg"
                                        title="{{ $item->ServiceName }}"></span>
                                    <h6 class="sub-title">{{ $item->ServiceName }}</h6>
                                    <h4 class="title m-b15"><a
                                            href="{{ url('/') }}/projects/{{ $item->Slug }}">{{ $item->ProjectName }}
                                            <span>{{ $item->ProjectAddress }}</span></a></h4>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="content-inner bg-secondary subscribe-area"
            style="background-image: url({{ url('/') }}/assets/home/images/background/bg2-1.png); background-position: center;">

        </div>
    </section>
@endsection

@section('scripts')
@endsection
