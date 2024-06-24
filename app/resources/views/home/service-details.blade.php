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
		<div class="dz-bnr-inr style-1 overlay-left edit-content" id="img-services-bnr" style="background-image:url({{url('/')}}/{{$Service->ServiceImage}});">
			<div class="container-fluid">
				<div class="dz-bnr-inr-entry">
					<h1>{{$Service->ServiceName}}</h1>
					<!-- Breadcrumb Row -->
					<nav aria-label="breadcrumb" class="breadcrumb-row">
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
							<li class="breadcrumb-item">Services</li>
							<li class="breadcrumb-item">Service Details</li>
						</ul>
					</nav>
					<!-- Breadcrumb Row End -->
				</div>
			</div>
		</div>
	</div>
<!-- Banner End -->
<!-- About US -->
<section class="section-full content-inner-2" style="background-image:url({{url('/')}}/assets/home/images/background/bg2.png); background-position:right bottom; background-size:100%; background-repeat:no-repeat;">
    <div class="container">
        <div class="row">
            {{-- <div class="col-sm-12">
                <img loading="lazy" src="{{url('/')}}/{{$Service->ServiceImage}}" class="m-b30 w-100" alt="">
            </div> --}}
            <div class="col-lg-8 col-md-7 aos-item" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="500">
                <div class="service-detail">
                    <div class="dz-page-text">
                        <h2 class="title mb-2">{{$Service->Title}}</h2>
                        <p>{{$Service->Description1}}</p>
                        <div class="row lightgallery">
                            <div class="col-lg-6">
                                <img loading="lazy" src="{{url('/')}}/{{$Service->ServiceGallery[0] ?? ''}}" class="m-b30 w-100" alt="">
                                {{-- <div class="dz-box overlay style-1">
                                    <div class="dz-media">
                                        <img loading="lazy" src="{{url('/')}}/{{$Service->ServiceGallery[0] ?? ''}}" alt="{{$Service->ServiceName}}">
                                    </div>
                                    <div class="dz-info">
                                        <span data-exthumbimage="{{url('/')}}/{{$Service->ServiceGallery[0] ?? ''}}" data-src="{{url('/')}}/{{$Service->ServiceGallery[0] ?? ''}}" class="view-btn lightimg"></span>
                                    </div>
                                </div> --}}
                                <p class="m-b0">{{$Service->Description2}}</p>
                            </div>
                            <div class="col-lg-6">
                                <img loading="lazy" src="{{url('/')}}/{{$Service->ServiceGallery[1] ?? ''}}" class="m-b30 w-100" alt="">
                                <p class="m-b0">{{$Service->Description3}}</p>
                            </div>
                        </div>	
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-5 m-b30 aos-item right" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="300">
                <div class="sticky-top">
                    <div class="widget ext-sidebar-menu">
                        <ul class="menu">
                            @foreach ($Services->where('Slug','!=',$Service->Slug)->shuffle()->take(6) as $key=>$item)
                                <li @if($key == 0)class="active" @endif><a href="{{url('/')}}/services/{{$item->Slug}}">{{$item->ServiceName}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="content-inner subscribe-area" style="background-image: url({{url('/')}}/assets/home/images/background/bg2-1.png); background-position: center;">
        <div class="container">
            <div class="row subscribe-content">
                <div class="col-lg-6 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    <div class="section-head style-1 mb-0">
                        <h6 class="sub-title text-primary">Free Service Estimate</h6>
                        <h2 class="title">Book a FREE consultation</h2>
                    </div>
                </div>
                <div class="col-lg-3 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                    <form class="dzSubscribe dz-subscription mt-3" method="post">
                        <div class="dzSubscribeMsg Msg dz-subscription-msg"></div>
                        <div class="input-group">
                            <input id="txtName" required="required" class="form-control" placeholder="Name" type="text">
                        </div>
                        <div class="errors err-sm text-center" id="txtName-err"></div>
                    </form>
                </div>
                <div class="col-lg-3 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                    <form class="dzSubscribe dz-subscription mt-3" method="post">
                        <div class="dzSubscribeMsg Msg dz-subscription-msg"></div>
                        <div class="input-group">
                            <input id="txtMobNo" required="required" class="form-control" placeholder="Mobile" type="text">
                            <button name="submit" type="button" id="btnSaveServiceEnq" class="btn btn-primary btn-rounded">
                                <span class="m-r10">Register</span>
                                <i class="fa fa-paper-plane"></i>
                            </button>
                        </div>
                        <div class="errors err-sm text-center" id="txtMobNo-err"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Top Clients -->
<section class="content-inner-1">
    <div class="container">
        <div class="section-head style-1 text-center">
            <h6 class="sub-title text-primary">Brands</h6>
            <h2 class="title">Our Top Clients</h2>
        </div>
        <div class="swiper-container clients-swiper">
            <div class="swiper-wrapper">
                @foreach ($TopClients as $item)
                    <div class="swiper-slide">
                        <div class="clients-logo aos-item" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="100">
                            <img loading="lazy" class="logo-main" src="{{url('/')}}/{{$item->ProfileImage}}" alt="{{$item->Name}}" height="100px" width="100px">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>

    const clearContactData=async()=>{
        $('#txtName').val('');
        $('#txtMobileNumber').val('');
    }
    const contactFormValidation=(formData)=>{
        
    }
    $(document).on('click', '#btnSaveServiceEnq', function() {
        let formData={}
        formData.Name=$('#txtName').val();
        formData.MobileNumber=$('#txtMobNo').val();
        formData.ServiceID="{{$Service->ServiceID}}";

        let status=true;
        $('.errors').html('');
        if(formData.Name==""){
            $('#txtName-err').html('Enter yor name');status=false;
        }

        if(formData.MobileNumber==""){
            $('#txtMobNo-err').html('Enter a mobile no');status=false;
        }else if(isNaN(formData.MobileNumber) || formData.MobileNumber.length!==10){
            $('#txtMobNo-err').html('Enter a valid mobile no');status=false;
        }
        if(status){
            $.ajax({
                type:"post",
                url:"{{url('/')}}/save/service-enquiry",
                data:formData,
                dataType:"json",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                success:function(response){
                    if(response.status==true){
                        $('#txtName').val('');
                        $('#txtMobNo').val('');
                        toastr.success(response.message, "Success", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0}) 
                    }else{
                        toastr.error(response.message, "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0}) 
                    }
                }
            });
        }
    });

</script>
@endsection
