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
    @foreach ($FormattedEmployees as $key => $item)
        @if ($key != 'CEO')
            <div class="container">
                <div class="row section-head-bx align-items-center">
                    <div class="col-md-8">
                        <div class="section-head style-1">
                            <h6 class="sub-title text-primary">{{ $key }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="container-fluid">
            <div id="team-swiper-container-{{ $loop->index }}" class="swiper-container" data-slide-count="{{ count($item) }}">
                <div class="swiper-wrapper">
                    @foreach ($item as $emp)
                        <div class="swiper-slide @if(count($item) == 1) single-slide @endif">
                            <div class="card dz-team style-1">
                                <div class="card-media">
                                    <img src="{{ $emp->ProfileImage }}" alt="{{ $emp->FirstName }}">
                                </div>
                                <div class="card-body">
                                    <h5 class="dz-name m-b5">
                                        <a href="javascript:void(0);">{{ $emp->FirstName }} {{ $emp->LastName }}</a>
                                    </h5>
                                    <span class="dz-position">{{ $emp->Designation ?? $emp->Dept }}</span>
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
    $(document).ready(function () {
        $('.swiper-container').each(function () {
            const $this = $(this);
            const slideCount = parseInt($this.data('slide-count'), 10);
            const needsLoop = slideCount > 1 && slideCount * 326.6 > $this.outerWidth();

            if($this.outerWidth() > 575 && slideCount < 4){
                $(this).find('.swiper-wrapper').addClass('justify-content-center');
            }

            new Swiper(`#${$this.attr('id')}`, {
                slidesPerView: 4,
                spaceBetween: 30,
                speed: 1500,
                loop: needsLoop,
                navigation: {
                    nextEl: '.swiper-button-next3',
                    prevEl: '.swiper-button-prev3',
                },
                autoplay: needsLoop ? {
                    delay: 1500,
                    disableOnInteraction: false,
                } : false,
                breakpoints: {
                    1500: {
                        slidesPerView: 5,
                    },
                    1200: {
                        slidesPerView: 4,
                    },
                    991: {
                        slidesPerView: 3,
                    },
                    576: {
                        slidesPerView: 2,
                    },
                    100: {
                        slidesPerView: 1,
                    },
                },
            });
        });

    });


</script>
@endsection

