@extends('layouts.home')
@section('content')
    @if (count($banner) > 0)
        <div class="home-demo home-banner container-fluid">
            <div class="row">
                <div class="large-12 columns">
                    <div class="owl-carousel owl-carousel-banner">
                        @for ($i = 0; $i < count($banner); $i++)
                            <div class="item">
                                <a href="{{ url('/') }}/contact-us"><img alt="mainbanner1" class="img-fluid"
                                        src="{{ url('/') }}/{{ $banner[$i]->BannerImage }}"></a>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (array_key_exists('Before Service', $Content))
        @for ($i = 0; $i < count($Content['Before Service']); $i++)
            <section class=" wow fadeInUp mt-45">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <?php echo $Content['Before Service'][$i]->Content; ?>
                        </div>
                    </div>
                </div>
            </section>
        @endfor
    @endif
    @if (count($Services) > 0)
        <div class="service-section wow fadeInUp mt-45">
            <div class="container">
                <div class="service-hedaing page-title category-featured">
                    <div class="page-title toggled">
                        <div class="row">
                            <div class="col-4"><span class="page-title-left"></span></div>
                            <div class="col-4">
                                <h3>Our Services</h3>
                            </div>
                            <div class="col-4 text-right"><a href="{{ url('/') }}/services"><span class="view-all">
                                        View All</span></a></div>
                        </div>
                    </div>
                    <div class="row">
                        @for ($i = 0; $i < count($Services); $i++)
                            <div class="col-sm-3 col-6">
                                <div class="item service">
                                    <div class="col col-xs-12 single-column">
                                        <div class="card service-card h-100 border-0">
                                            <div class="image">
                                                <a href="{{ url('/') }}/services/{{ $Services[$i]->Slug }}"><img
                                                        src="{{ url('/') }}/{{ $Services[$i]->ServiceImage }}"
                                                        class="card-img-top" alt="..."></a>
                                                <div class="button-group">
                                                    <button title="Enquiry" class="btnEnquiry"
                                                        data-name="{{ $Services[$i]->ServiceName }}"
                                                        data-slug="{{ $Services[$i]->Slug }}"
                                                        data-id="{{ Helper::EncryptDecrypt('encrypt', $Services[$i]->ServiceID) }}"><i
                                                            class="fa-solid fa-message"></i></button>
                                                </div>
                                            </div>
                                            <div class="content service-description">
                                                <div class="caption"><br>
                                                    <h4 class="service-title text-center"><a
                                                            href="{{ url('/') }}/services/{{ $Services[$i]->Slug }}">{{ $Services[$i]->ServiceName }}</a>
                                                    </h4>
                                                    <div class="price-rating text-center">
                                                        @if ($Settings['show-price-on-home'] == true)
                                                            <div class="price">
                                                                <span class="price-new"><i
                                                                        class="fa-solid fa-indian-rupee-sign"></i>
                                                                    {{ NumberFormat($Services[$i]->Price, $Settings['price-decimals']) }}</span>
                                                            </div>
                                                        @endif
                                                        <p class="description"><?php echo substr($Services[$i]->ShortDescription, 0, 200) . '..'; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (array_key_exists('After Service', $Content))
        @for ($i = 0; $i < count($Content['After Service']); $i++)
            <section class=" wow fadeInUp mt-45">
                <div class="container">
                    <div class="row">
                        <div class="col-12"><?php echo $Content['After Service'][$i]->Content; ?></div>
                    </div>
                </div>
            </section>
        @endfor
    @endif
    <style>
        #carouselExampleControls .carousel-item iframe {
            width: 720px;
            /* Adjust width as needed */
            height: 480px;
            /* Adjust height as needed */
            padding-top: 50px;
        }

        .carousel-container {
            display: flex;
            justify-content: center;
        }
    </style>

    <div class="container">
        <div class="carousel-container">
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            // Make AJAX request to fetch video URLs
            $.ajax({
                url: "{{ url('/') }}/get/links",
                headers: {
                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                },
                type: 'POST',
                success: function(response) {
                    // Call function to populate carousel with video links
                    populateCarousel(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

            // Function to populate carousel with video links
            function populateCarousel(videoLinks) {
                // Get the carousel inner container
                var carouselInner = $('#carouselExampleControls .carousel-inner');
                // Loop through each video link
                videoLinks.forEach(function(videoLink, index) {
                    // Create a carousel item
                    var carouselItem = $('<div class="carousel-item"></div>');
                    // Create an iframe element with specified width and height
                    var iframeElement = $('<iframe class="d-block" src="' + videoLink +
                        '" frameborder="0" allowfullscreen></iframe>');
                    // Append iframe to carousel item
                    carouselItem.append(iframeElement);
                    // Add 'active' class to first carousel item
                    if (index === 0) {
                        carouselItem.addClass('active');
                    }
                    // Append carousel item to carousel inner container
                    carouselInner.append(carouselItem);
                });
            }

            // Bootstrap carousel initialization
            $('#carouselExampleControls').carousel();
        });
    </script>


@endsection
