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
    <div class="dz-bnr-inr style-1 overlay-left" style="background-image: url({{url('/')}}/assets/home/images/teams-banner.jpg);">
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
<!-- Banner End -->
<section class="section-full content-inner" style="background-image:url(assets/home/images/background/bg2.png); background-position:right bottom; background-size:100%; background-repeat:no-repeat;">
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-4 m-b30 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                        <div class="card dz-team style-1">
                            <div class="card-media">
                                <img src="{{$CEO->ProfileImage}}" alt="" height="600px" width="500px">
                            </div>
                            <div class="card-body">
                                <h5 class="dz-name m-b5"><a href="javascript:void(0);">{{$CEO->FirstName}} {{$CEO->LastName ?? $COE->LastName}}</a></h5>
                                <span class="dz-position">{{$CEO->Designation}}</span>
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
                </div>
                <div class="row justify-content-center">
                    @foreach($Employees->where('Level',2)->shuffle()->take(4) as $emp)
                        <div class="col-md-6 col-lg-3 m-b30 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                            <div class="card dz-team style-1">
                                <div class="card-media">
                                    <img src="{{$emp->ProfileImage}}" alt="" height="600px" width="500px">
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
                <div class="row justify-content-center">
                    @foreach($Employees->where('Level',3)->shuffle()->take(4) as $emp)
                        <div class="col-md-6 col-lg-3 m-b30 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                            <div class="card dz-team style-1">
                                <div class="card-media">
                                    <img src="{{$emp->ProfileImage}}" alt="" height="600px" width="500px">
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
    </div> --}}
    @foreach ($FormattedEmployees as $key=>$item)
    @if($key != 'CEO')
        <div class="container">
            <div class="row section-head-bx align-items-center">
                <div class="col-md-8">
                    <div class="section-head style-1">
                        <h6 class="sub-title text-primary">{{$key}}</h6>
                        <h2 class="title">{{$key}}</h2>
                    </div>
                </div>
            </div>
        </div>
    @endif
        <div class="container-fluid">
            <div class="swiper-container swiper-team">
                <div class="swiper-wrapper d-flex justify-content-center">
                    @foreach($item as $emp)
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
    @endforeach
</section>



@endsection
@section('scripts')
<script>
        $(document).ready(function(){
            
            $('.swiper-slide-duplicate').remove();

        });

</script>
@endsection

