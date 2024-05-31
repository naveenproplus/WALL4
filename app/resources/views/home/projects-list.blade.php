@for ($i = 0; $i < count($Projects); $i++)
    <div class="col single-column">
        <div class="card project-card border-0">
            <div class="image">
                <a href="{{ url('/') }}/projects/{{ $Projects[$i]->Slug }}"><img
                        src="{{ url('/') }}/{{ $Projects[$i]->ProjectImage }}" class="card-img-top"
                        alt="..."></a>
                <div class="button-group">
                    <button title="Enquiry" class="btnEnquiry" data-name="{{ $Projects[$i]->ProjectName }}"
                        data-slug="{{ $Projects[$i]->Slug }}"
                        data-id="{{ Helper::EncryptDecrypt('encrypt', $Projects[$i]->Slug) }}"><i
                            class="fa-solid fa-message"></i></button>
                </div>
            </div>
            <div class="content project-description">
                <div class="caption"><br>
                    <h4 class="project-title text-center"><a
                            href="{{ url('/') }}/projects/{{ $Projects[$i]->Slug }}">{{ $Projects[$i]->ProjectName }}</a>
                    </h4>
                    @if ($Settings['show-price-on-home'] == true)
                        <div class="price-rating">
                            <div class="price">
                                <span class="price-new"><i class="fa-solid fa-indian-rupee-sign"></i>
                                    {{ NumberFormat($Projects[$i]->Price, $Settings['price-decimals']) }}</span>
                            </div>
                        </div>
                    @endif

                    <p class="description"><?php echo substr($Projects[$i]->ProjectAddress, 0, 200) . '..'; ?></p>
                </div>
            </div>
        </div>
    </div>
@endfor
