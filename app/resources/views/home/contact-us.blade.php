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
        <div class="dz-bnr-inr style-1 overlay-left edit-content" id="img-contact-us-bnr" style="background-image: url({{url('/')}}/{{$Contents['img-contact-us-bnr']}});">
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
    <section class="content-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 m-b30 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    <div class="icon-bx-wraper style-8 bg-white h-100" data-name="01">
                        <div class="icon-md m-r20">
                            <span class="icon-cell text-primary"><i class="flaticon-telephone"></i></span> 
                        </div>
                        <div class="icon-content">
                            <h4 class="tilte m-b10">Call Now</h4>
                            <p class="m-b0">+91 {{$Company['Phone-Number']}},@if($Company['Mobile-Number'])<br> +91 {{ $Company['Mobile-Number'] }} @endif</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 m-b30 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">
                    <div class="icon-bx-wraper style-8 bg-white h-100" data-name="02">
                        <div class="icon-md m-r20">
                            <span class="icon-cell text-primary"><i class="flaticon-email"></i></span> 
                        </div>
                        <div class="icon-content">
                            <h4 class="tilte m-b10">Email Now</h4>
                            <p class="m-b0">{{$Company['Email']}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 m-b30 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                    <div class="icon-bx-wraper style-8 bg-white h-100" data-name="03">
                        <div class="icon-md m-r20">
                            <span class="icon-cell text-primary"><i class="flaticon-placeholder"></i></span>
                        </div>
                        <div class="icon-content">
                            <h4 class="tilte m-b10">Location</h4>
                            <p class="m-b0">{{$Company['Address']}} <br>{{$Company['CityName']}} - {{$Company['PostalCode']}}.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Form -->
    <section class="content-inner-1 pt-0">
        @if($Company['google-map-status']==true)
            <div class="map-iframe">
                <iframe src="{{$Company['google-embed-map']}}&z=10" class="align-self-stretch radius-sm" style="border:0; width:100%; min-height:100%;" allowfullscreen></iframe>
            </div>
        @else
            <div style="height: 300px;">
            </div>
        @endif
        <div class="container">
            <div class="contact-area aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                <div class="section-head style-1 text-center">
                    <h6 class="sub-title text-primary">Contact Us</h6>
                    <h2 class="title">Get In Touch With Us</h2>
                </div>
                <form class="dz-form dzForm contact-bx">
                    <div class="row sp10">
                        <div class="col-sm-6 m-b20">
                            <div class="input-group">
                                <input type="text" id="txtFName" class="form-control" placeholder="First Name *">
                            </div>
                            <div class="errors err-sm" id="txtFName-err"></div>
                        </div>
                        <div class="col-sm-6 m-b20">
                            <div class="input-group">
                                <input type="text" id="txtLName" class="form-control" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="col-sm-6 m-b20">
                            <div class="input-group">
                                <input type="text" id="txtEmail" class="form-control" placeholder="Email *">
                            </div>
                            <div class="errors err-sm" id="txtEmail-err"></div>
                        </div>
                        <div class="col-sm-6 m-b20">
                            <div class="input-group">
                                <input type="number" id="txtMobNo" class="form-control" placeholder="Mobile No *">
                            </div>       
                            <div class="errors err-sm" id="txtMobNo-err"></div>
                        </div>
                        <div class="col-sm-12 m-b20">
                            <div class="input-group">
                                <input type="text" id="txtSubject" class="form-control" placeholder="Subject *">
                            </div>
                            <div class="errors err-sm" id="txtSubject-err"></div>
                        </div>
                        <div class="col-sm-12 m-b20">
                            <div class="input-group">
                                <textarea rows="5" class="form-control" id="txtMessage" placeholder="Message *"></textarea>
                            </div>
                            <div class="errors err-sm" id="txtMessage-err"></div>
                        </div>
                        <div class="col-sm-12 text-center">
                            <button type="button" id="btnSave" class="btn btn-primary btn-rounded shadow-primaryz btn-ov-secondary btn-home-sec-1">SUBMIT <i class="m-l10 fas fa-caret-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    {{-- <script src="https://www.google.com/recaptcha/api.js?onload=onloadContactCallback&render=explicit" async defer></script> --}}

    <script>
        const isValidEMail=(email)=>{
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            return emailReg.test( email );
        }

        const clearContactData=async()=>{
            $('#txtFName').val('');
            $('#txtLName').val('');
            $('#txtEmail').val('');
            $('#txtMobileNumber').val('');
            $('#txtSubject').val('');
            $('#txtMessage').val('');
            $('#txtName').val('');
        }
        const contactFormValidation=(formData)=>{
            let status=true;
            $('.errors').html('');
            if(formData.FName==""){
                $('#txtFName-err').html('First Name is required');status=false;
            }
            if(formData.Email==""){
                $('#txtEmail-err').html('Email is required');status=false;
            }else if(isValidEMail(formData.Email)==false){
                $('#txtEmail-err').html('Email not valid');status=false;
            }

            if(formData.MobileNumber==""){
                $('#txtMobNo-err').html('Mobile Number is required');status=false;
            }else if(formData.MobileNumber.length!=10){
                $('#txtMobNo-err').html('The Mobile Number must be 10 digits');status=false;
            }

            if(formData.Subject==""){
                $('#txtSubject-err').html('Subject is required');status=false;
            }
            if(formData.Message==""){
                $('#txtMessage-err').html('Message is required');status=false;
            }
            return status;
        }
        const onContactSubmit = function() {
            let formData={}
            formData.FName=$('#txtFName').val();
            formData.LName=$('#txtLName').val();
            formData.Email=$('#txtEmail').val();
            formData.MobileNumber=$('#txtMobNo').val();
            formData.Subject=$('#txtSubject').val();
            formData.Message=$('#txtMessage').val();

            let status=contactFormValidation(formData);
            if(status){
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/save/contact-enquiry",
                    data:formData,
                    dataType:"json",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success:function(response){
                        if(response.status==true){
                            toastr.success(response.message, "Success", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0});
                            $('#txtFName, #txtLName, #txtMobNo, #txtEmail, #txtSubject, #txtMessage').val('');
                            $("html, body").animate({scrollTop: 0}, "slow");
                        }else{
                            toastr.error(response.message, "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0}) 
                            if(response['errors']!=undefined){
								$('.errors').html('');
								$.each( response['errors'], function( KeyName, KeyValue ) { 
									if(KeyName=="Name"){$('#txtName-err').html(KeyValue);}
									if(KeyName=="Email"){$('#txtEmail-err').html(KeyValue);}
									if(KeyName=="MobileNumber"){$('#MobileNumber-err').html(KeyValue);}
									if(KeyName=="Subject"){$('#txtSubject-err').html(KeyValue);}
									if(KeyName=="Message"){$('#txtMessage-err').html(KeyValue);}
								});
							}
                        }
                    }
                });
            }
        };
        $(document).on('click', '#btnSave', function() {
            onContactSubmit();
        });
    </script>
@endsection
