@extends('home.home-layout')
@section('home-content')
<style>
    .image-container {
        position: relative;
        display: inline-block;
    }

    .image-container img {
        display: block;
        width: 100%;
    }

    .center-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #f80000;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
    }
    .center-button:hover {
        background-color: #f80000;
        color: white;

    }
</style>
<!-- Banner  -->
<div class="slidearea bannerside">
    <div class="side-contact-info">
        <ul>
            <li><i class="fas fa-phone-alt"></i>+91 {{$Company['Phone-Number']}}</li>
            <li><i class="fas fa-envelope"></i>{{$Company['Email']}}</li>
        </ul>
    </div>
    <div class="dz-bnr-inr style-1 overlay-left edit-content" id="img-about-us-bnr" style="background-image: url({{url('/')}}/{{$Contents['img-about-us-bnr']}});">
        <div class="container-fluid">
            <div class="dz-bnr-inr-entry">
                <h1>{{$PageTitle}}</h1>
                <!-- Breadcrumb Row -->
                <nav aria-label="breadcrumb" class="breadcrumb-row">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}/admin"><i class="f-16 fa fa-home"></i></a></li>
                        <li class="breadcrumb-item">{{$PageTitle}}</li>
                    </ul>
                </nav>
                <!-- Breadcrumb Row End -->
            </div>
        </div>
    </div>
</div>
<!-- Banner End -->
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
                <div class="accordion dz-accordion about-faq" id="aboutFaq">
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

<!-- Work Process -->
<section class="content-inner-2">
    <div class="edit-content" id="work-process">
        {!!$Contents['work-process']!!}
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
                                <span data-exthumbimage="{{url('/')}}/{{$item->ProjectImage}}" data-src="{{url('/')}}/{{$item->ProjectImage}}" class="view-btn lightimg" title="{{$item->ServiceName}}"></span>
                                <h6 class="sub-title">{{$item->ServiceName}}</h6>
                                <h4 class="title m-b15"><a href="{{-- {{url('/')}}/projects/{{$item->Slug}} --}}javascript:void(0);">{{$item->ProjectName}} <span>{{$item->ProjectAddress}}</span></a></h4>
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
<section class="content-inner-2" style="background-image:url({{url('/')}}/assets/home/images/background/bg2.png); background-position:right bottom; background-size:100%; background-repeat:no-repeat;">
    <div class="container">
        <div class="section-head style-1 text-center">
            <h6 class="sub-title text-primary">TESTIMONIAL</h6>
            <h2 class="title">What Our Clients Says</h2>
        </div>
        <div class="row">
            <div class="col-lg-6 align-self-center aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                <div class="swiper-container swiper-client">
                    <div class="swiper-wrapper">
                        @foreach ($TestimonialClients as $key=>$item)
                            <div class="swiper-slide" data-rel="{{$key+1}}">
                                <div class="testimonial-1">
                                    <div class="testimonial-info">
                                        <div class="flaticon-quotation quote-icon"></div>
                                        @if($item->Testimonial)
                                            <div class="testimonial-text">
                                                <p>{{$item->Testimonial}}</p>
                                            </div>
                                        @endif
                                        @if($item->Thumbnail)
                                            <div class="image-container">
                                                <img loading="lazy" src="{{ url('/') }}/{{$item->Thumbnail}}" alt="Testimonial Image">
                                                <a href="{{ $item->VideoURL ?? '#' }}" type="button" target="_blank" class="btn center-button"><i class="fa fa-play"></i></a>

                                            </div>
                                        @endif
                                        <div class="testimonial-detail">
                                            <h4 class="testimonial-name">{{$item->Name}}</h4>
                                            <span class="testimonial-position text-primary">{{$item->CityName}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="client-area">		
                    <svg viewBox="0 0 574 511" class="client-bg aos-item" data-aos="fade-in" data-aos-duration="800" data-aos-delay="200" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><path stroke="var(--primary)" stroke-width="3" fill="none" d="M466.253 161.575c32.408-59.804 26.317-127.495-35.817-124.214-21.983 1.159-42.258 16.216-64.265 17.762-20.248 1.425-39.152-7.801-56.128-17.686-34.373-20.017-65.685-58.278-103.358-16.906-25.654 28.169 3.163 72.215-24.694 97.514-8.698 7.905-22.479 9.509-33.89 10.987-28.345 3.671-50.444 8.129-77.333 21.075-50.333 24.214-63.016 41.712-68.009 72.376-5.411 33.246 18.459 81.167 57.923 86.892 47.337 6.875 62.6-27.975 115.202-20.21 44.397 6.545 37.678 43.589 36.73 76.523-1.791 62.123 48.901 88.979 106.445 67.392 18.747-7.036 54.435-25.45 61.781-46.766 5.929-17.204-8.925-38.223-12.682-54.363-13.218-56.766 52.37-36.554 90.575-32.547 36.51 3.834 98.693 4.263 110.935-52.659 4.2-19.531-24.295-55.633-42.521-58.503-25.786-4.051-73.433-3.538-60.894-26.667z"></path><path fill-rule="evenodd" fill="var(--rgba-primary-1)" d="M421.378 125.766c-2.044-75.742-45.622-137.651-103.734-99.88-20.562 13.364-31.734 39.18-52.103 52.929-18.739 12.652-42.114 14.28-63.996 14.201-44.308-.167-95.824-19.637-109.124 41.255-9.059 41.463 43.273 67.904 30.49 107.825-3.989 12.47-16.39 21.694-26.574 29.475-25.3 19.327-44.135 35.937-62.865 63.401-35.069 51.394-37.558 75.336-25.296 107.699 13.297 35.087 63.014 68.02 104.272 51.562 49.494-19.732 44.809-61.853 99.879-83.658 46.474-18.414 60.624 21.064 78.052 53.364 32.873 60.926 96.733 58.6 140.221 5.725 14.167-17.228 38.338-54.87 33.553-79.523-3.863-19.899-29.899-31.903-42.513-45.38-44.367-47.4 30.162-64.432 69.25-81.845 37.355-16.637 97.582-50.856 77.688-112.586-6.827-21.182-54.423-40.137-73.603-32.754-27.132 10.453-72.81 37.485-73.597 8.19z"></path></svg>
                    
                    <ul class="aos-item" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="600">
                        @foreach ($TestimonialClients as $key=>$item)
                            <li data-member="{{$key+1}}"><a href="#" class="dzclient1"><img loading="lazy" src="{{url('/')}}/{{$item->ProfileImage}}" alt=""></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Teams -->
<section class="content-inner-2">
    <div class="container">
        <div class="row section-head-bx align-items-center">
            <div class="col-md-8">
                <div class="section-head style-1">
                    <h6 class="sub-title text-primary">OUR TEAMS</h6>
                    <h2 class="title">Meet Our Teammates</h2>
                </div>
            </div>
            <div class="col-md-4 text-start text-md-end mb-4 mb-md-0">
                <a href="{{url('/')}}/teams" class="btn-link">See All <i class="fas fa-plus scale08"></i></a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="swiper-container swiper-team about-page-swiper-team">
            <div class="swiper-wrapper">
                @foreach($Employees->where('Designation','!=',"CEO") as $emp)
                    <div class="swiper-slide">
                        <div class="card dz-team style-1">
                            <div class="card-media">
                                <img src="{{$emp->ProfileImage}}" alt="{{$emp->FirstName}}">
                            </div>
                            <div class="card-body">
                                <h5 class="dz-name m-b5"><a href="javascript:void(0);">{{$emp->FirstName}} {{$emp->LastName ?? $emp->LastName}}</a></h5>
                                <span class="dz-position">{{$emp->Designation}}</span>
                            <ul class="dz-social">
                                    <li><a href="javascript:void(0);"><i class="fab fa-skype"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="fab fa-facebook"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="fab fa-google-plus"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
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

@endsection
@section('scripts')

@endsection