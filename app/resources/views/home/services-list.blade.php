@for($i=0;$i<count($Services);$i++)
    <div class="col single-column">
        <div class="card service-card border-0">
            <div class="image">
                <a href="{{url('/')}}/services/{{$Services[$i]->Slug}}"><img src="{{url('/')}}/{{$Services[$i]->ServiceImage}}" class="card-img-top" alt="..."></a>
                <div class="button-group">
                    <button title="Enquiry" class="btnEnquiry" data-name="{{$Services[$i]->ServiceName}}" data-slug="{{$Services[$i]->Slug}}" data-id="{{Helper::EncryptDecrypt('encrypt',$Services[$i]->ServiceID)}}"><i class="fa-solid fa-message"></i></button>
                </div>
            </div>
            <div class="content service-description">
                <div class="caption"><br>
                    <h4 class="service-title text-center"><a href="{{url('/')}}/services/{{$Services[$i]->Slug}}">{{$Services[$i]->ServiceName}}</a></h4>
                    @if($Settings['show-price-on-home']==true)
                    <div class="price-rating">
                        <div class="price">
                            <span class="price-new"><i class="fa-solid fa-indian-rupee-sign"></i> {{NumberFormat($Services[$i]->Price,$Settings['price-decimals'])}}</span>
                        </div>
                    </div>
                    @endif
                    <p class="description"><?php echo substr($Services[$i]->ShortDescription, 0, 200) . ".."; ?></p>
                </div>
            </div>
        </div>
    </div>
@endfor