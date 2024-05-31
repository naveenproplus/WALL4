@extends('layouts.home')
@section('content')
    <div class="breadcrumb-main">
        <div class="container">
            <div class="breadcrumb-container">
                <h2 class="page-title">{{ $Service->ServiceName }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/') }}/services">Services</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ url('/') }}/services/{{ $Service->Slug }}">{{ $Service->ServiceName }}</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div id="service-info" class="container">
        <div class="row">
            <div id="content" class="col">
                <div class="pro-detail service-content">
                    <div class="row mb-3">
                        <div class="col-md-6 service-left">
                            <div class="thumbnails">
                                <div class="image magnific-popup pro-image">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="{{ url('/') }}/{{ $Service->ServiceImage }}" class="thumbnail"
                                                data-lightbox="image-1">
                                                <img src="{{ url('/') }}/{{ $Service->ServiceImage }}" id="prozoom"
                                                    title="{{ $Service->ServiceName }}" alt="{{ $Service->ServiceName }}"
                                                    class="img-thumbnail" data-zoom-image="#">
                                            </a>
                                        </div>
                                    </div>
                                    @if (count($Service->galleryImages) > 0)
                                        <div id="additional-carousel" class="additional owl-carousel"
                                            style="margin-top:30px">
                                            <div class="items">
                                                <div class="image-additional">
                                                    <div class="image-additional">
                                                        <a href="#" title="{{ $Service->ServiceName }}"
                                                            class="elevatezoom-gallery"
                                                            data-image="{{ url('/') }}/{{ $Service->ServiceImage }}"
                                                            data-zoom-image="{{ url('/') }}/{{ $Service->ServiceImage }}">
                                                            <img src="{{ url('/') }}/{{ $Service->ServiceImage }}"
                                                                title="{{ $Service->ServiceName }}"
                                                                alt="{{ $Service->ServiceName }}">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @for ($i = 0; $i < count($Service->galleryImages); $i++)
                                                <div class="items">
                                                    <div class="image-additional">
                                                        <div class="image-additional">
                                                            <a href="#" title="{{ $Service->ServiceName }}"
                                                                class="elevatezoom-gallery"
                                                                data-image="{{ url('/') }}/{{ $Service->galleryImages[$i]->ImageUrl }}"
                                                                data-zoom-image="{{ url('/') }}/{{ $Service->galleryImages[$i]->ImageUrl }}">
                                                                <img src="{{ url('/') }}/{{ $Service->galleryImages[$i]->ImageUrl }}"
                                                                    title="{{ $Service->ServiceName }}"
                                                                    alt="{{ $Service->ServiceName }}">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 service-right" style="padding-left:30px; margin-top:20px">
                            <h1>{{ $Service->ServiceName }}</h1>
                            <p class="mt-4 mb-4 service-short-description">{{ $Service->Description1 }}</p>
                            <hr>
                            <ul class="list-unstyled manufacturer-listpro ">
                                <li class="mt-4">
                                    <div class="row">
                                        <div class="col-6 col-sm-3"><span class="disc">Category :</span> <span
                                                class="full-right"></span></div>
                                        <div class="col-6 col-sm-9"><span class="disc1">
                                                {{ $Service->CategoryName }}</span></div>
                                    </div>
                                </li>




                                @if ($Settings['show-price-on-home'] == true)
                                    <li class="mt-4">
                                        <div class="row">
                                            <div class="col-6 col-sm-3"><span class="disc">Price</span> <span
                                                    class="full-right"> : </span></div>
                                            <div class="col-6 col-sm-9"><span class="disc1"> <i
                                                        class="fa-solid fa-indian-rupee-sign"></i>
                                                    {{ NumberFormat($Service->Price, $Settings['price-decimals']) }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                            <div id="service" class="service-option mt-5">
                                <div class="pro-cart">
                                    <button title="Enquiry" data-name="{{ $Service->ServiceName }}"
                                        data-slug="{{ $Service->Slug }}" data-id="{{ $Service->ServiceID }}"
                                        class="btn btn-primary btn-lg btn-block btnEnquiry"><i
                                            class="fa-solid fa-message"></i><span> Enquiry</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $description = str_replace('<p>', '', $Service->Description);
                $description = trim(str_replace('</p>', '', $description));
                $description = trim(str_replace('&nbsp;', '', $description));
                
                ?>
                @if ($description != '')
                    <div class="propage-tab mt-45">
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a href="#tab-description" class="nav-link">Description</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-description" class="tab-pane fade mb-4 active show">
                                <?php echo $Service->Description; ?>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <!-- Related_Service -->
            @if (count($RelatedServices) > 0)
                <div class="service-section wow fadeInUp mt-50 box related-services">
                    <div class="pro_page">
                        <div class="service-hedaing page-title category-featured">
                            <div class="page-title toggled">
                                <h3>Related Services</h3>
                            </div>
                            <div class="col-12">
                                <div id="carouselRelatedServices" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php
                                        // Ensure that there's at least one image in each carousel item
                                        $chunks = array_chunk($RelatedServices, 3);
                                        if (count($chunks) == 1 && count($RelatedServices) < 3) {
                                            // Only one chunk and less than 3 images, duplicate the first image
                                            $chunks[] = [$chunks[0][0]];
                                        } elseif (count($chunks) > 1 && count($chunks[count($chunks) - 1]) < 3) {
                                            // Last chunk has less than 3 images, add images from the previous chunk
                                            $lastChunkIndex = count($chunks) - 1;
                                            for ($i = count($chunks[$lastChunkIndex]); $i < 3; $i++) {
                                                $chunks[$lastChunkIndex][] = $chunks[$lastChunkIndex - 1][$i - count($chunks[$lastChunkIndex])];
                                            }
                                        }
                                        $totalChunks = count($chunks);
                                        ?>
                                        @foreach ($chunks as $index => $chunk)
                                            <div class="carousel-item @if ($index === 0) active @endif">
                                                <div class="row">
                                                    @foreach ($chunk as $Item)
                                                        <div class="col-4">
                                                            <div class="card service-card h-100 border-0">
                                                                <div class="image">
                                                                    <a
                                                                        href="{{ url('/') }}/services/{{ $Item->Slug }}">
                                                                        <img src="{{ url('/') }}/{{ $Item->ServiceImage }}"
                                                                            class="card-img-top"
                                                                            alt="{{ $Item->ServiceName }}">
                                                                    </a>
                                                                   
                                                                </div>
                                                                <div class="content service-description">
                                                                    <div class="caption">
                                                                        <h4 class="service-title"><br>
                                                                            <a
                                                                                href="{{ url('/') }}/services/{{ $Item->Slug }}">
                                                                                {{ $Item->ServiceName }}
                                                                            </a>
                                                                        </h4>
                                                                        @if ($Settings['show-price-on-home'] == true)
                                                                            <div class="price-rating">
                                                                                <div class="price">
                                                                                    <span class="price-new">
                                                                                        <i
                                                                                            class="fa-solid fa-indian-rupee-sign"></i>
                                                                                        {{ NumberFormat($Item->Price, $Settings['price-decimals']) }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        <p class="description">
                                                                            <?php echo substr($Item->Description1, 0, 200) . '..'; ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Controls -->
                                    @if ($totalChunks > 1)
                                        <a class="carousel-control-prev" href="#carouselRelatedServices" role="button"
                                            data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselRelatedServices" role="button"
                                            data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif




        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#carouselRelatedServices').carousel({
                interval: false // Disable auto sliding
            });

            // Manually handle slide transition
            $('#carouselRelatedServices .carousel-control-next').click(function() {
                $('#carouselRelatedServices').carousel('next');
                return false;
            });

            $('#carouselRelatedServices .carousel-control-prev').click(function() {
                $('#carouselRelatedServices').carousel('prev');
                return false;
            });
        });
    </script>
@endsection
