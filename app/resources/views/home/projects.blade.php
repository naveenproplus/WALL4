@extends('home.home-layout')
@section('home-content')

    <!-- Banner -->
    <div class="slidearea bannerside">
        <div class="side-contact-info">
            <ul>
                <li><i class="fas fa-phone-alt"></i>+91 {{ $Company['Phone-Number'] }}</li>
                <li><i class="fas fa-envelope"></i>{{ $Company['Email'] }}</li>
            </ul>
        </div>
        <div class="dz-bnr-inr style-1 overlay-left edit-content" id="img-project-bnr"
            style="background-image: url({{ url('/') }}/{{ $Contents['img-project-bnr'] }});">
            <div class="container-fluid">
                <div class="dz-bnr-inr-entry">
                    <h1>{{ $PageTitle }}</h1>
                    <!-- Breadcrumb Row -->
                    <nav aria-label="breadcrumb" class="breadcrumb-row">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item">{{ $PageTitle }}</li>
                        </ul>
                    </nav>
                    <!-- Breadcrumb Row End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- {{ $PageTitle }} -->
    <section class="content-inner line-img overflow-hidden">
        <div class="container">
            <div class="site-filters style-1 clearfix center">
                <ul class="filters" data-toggle="buttons">
                    <li data-filter="" class="btn">
                        <input type="radio">
                        <a href="javascript:void(0);">All</a>
                    </li>
                    <li data-filter=".Residential" class="btn">
                        <input type="radio">
                        <a href="javascript:void(0);">Residential</a>
                    </li>
                    <li data-filter=".Commercial" class="btn">
                        <input type="radio">
                        <a href="javascript:void(0);">Commercial</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container" id="divProjectArea">
            <ul id="masonry" class="row projectButton">
                @foreach ($ProjectArea as $key => $item)
                    <li class="card-container col-xl-4 col-md-6 col-sm-6 {{ $item->ProjectType }} m-b30 project-area projectButton"
                        id="liProjectArea{{ $key }}" data-project-area-id="{{ $item->ProjectAreaID }}">
                        <div class="dz-box overlay style-1">
                            <div class="dz-media">
                                <img loading="lazy" src="{{ url('/') }}/{{ $item->ProjectAreaImage }}"
                                    alt="{{ $item->ProjectAreaName }}">
                            </div>
                            <div class="dz-info">
                                <span
                                    data-exthumbimage{{ $key }}="{{ url('/') }}/{{ $item->ProjectAreaImage }}"
                                    data-src="{{ url('/') }}/{{ $item->ProjectAreaImage }}"
                                    class="view-btn lightimg{{ $key }}" title="{{ $item->ProjectAreaName }}"
                                    style="cursor: pointer">
                                </span>
                                <!-- Loaded via AJAX -->
                                <h6 class="sub-title">{{ $item->ProjectAreaName }}</h6>
                                <h4 class="title m-b15"><a href="javascript:void(0);">{{ $item->ProjectAreaName }}</a>
                                </h4>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <!-- Map & FAQs -->
    {{-- <section class="section-full content-inner overflow-hidden"
        style="background-image:url({{ url('/') }}/assets/home/images/background/bg1.png); background-position:left top; background-size:100%; background-repeat:no-repeat;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 m-b30 aos-item aos-init aos-animate" data-aos="fade-right" data-aos-duration="800"
                    data-aos-delay="300">
                    <div class="twentytwenty-img-area">
                        <div class="twentytwenty-wrapper twentytwenty-horizontal">
                            <div class="twentytwenty-container">
                                <iframe src="{{ $Company['3d-map-link'] }}" width="570" height="570" style="border:0;"
                                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                <div class="twentytwenty-overlay">
                                    <div class="twentytwenty-before-label"></div>
                                    <div class="twentytwenty-after-label"></div>
                                </div>
                                <div class="twentytwenty-handle"><span class="twentytwenty-left-arrow"></span><span
                                        class="twentytwenty-right-arrow"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 aos-item aos-init aos-animate" data-aos="fade-left" data-aos-duration="800"
                    data-aos-delay="600">
                    <div class="section-head style-1">
                        <h6 class="sub-title text-primary">FAQ</h6>
                        <h2 class="title">Get Every Answer From Here</h2>
                    </div>
                    <div class="accordion dz-accordion accordion-sm" id="accordionFaq">
                        @foreach ($FAQ->shuffle()->take(3) as $index => $item)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $index }}" aria-expanded="true"
                                        aria-controls="collapse{{ $index }}">
                                        {{ $item->FAQ }}
                                        <span class="toggle-close"></span>
                                    </a>
                                </h2>
                                <div id="collapse{{ $index }}" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFaq">
                                    <div class="accordion-body">
                                        <p class="m-b0">{{ $item->Answer }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <a href="{{ url('/') }}/faq"
                            class="btn shadow-primary btn-light btn-rounded btn-ov-secondary btn-home-sec-1">READ MORE <i
                                class="m-l10 fas fa-caret-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

            /* var ProjectTypeTrigger = setInterval(function() {
                if ($('#divProjectArea .project-area').length > 0) {
                    $('li[data-filter=".Residential"] input[type="radio"]').trigger('click');
                    if ($('#divProjectArea .project-area').length > 0 && $('.project-area.Commercial').css(
                            'display') == 'none') {
                        clearInterval(ProjectTypeTrigger);
                    }
                }
            }, 100); */

            $('.projectButton').on('click', function(event) {
                event.preventDefault();
                var projectAreaId = $(this).attr('data-project-area-id');

                if (projectAreaId) {
                    $.ajax({
                        type: "post",
                        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                        data:{projectAreaId},
                        url: "{{ route('get-project-images') }}",
                        success: function(response) {
                            var images = response.images;
                            var dynamicGallery = [];

                            images.forEach(function(image) {
                                dynamicGallery.push({
                                    'src': "{{ url('/') }}/" + image,
                                    'thumb': "{{ url('/') }}/" + image
                                });
                            });

                            $('#masonry').lightGallery({
                                dynamic: true,
                                dynamicEl: dynamicGallery,
                                loop: true,
                                thumbnail: true,
                                download: false,
                                share: false
                            });
                            $('#masonry').data('lightGallery');
                            
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching project images:", error);
                        }
                    });
                }
            });

            $(document).on('click', '.lg-close', function() {
                if ($('#masonry').data('lightGallery')) {
                    $('#masonry').data('lightGallery').destroy(true);
                }
            });
        });
    </script>
@endsection
