
<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{$PageTitle}} - {{$Company['Name']}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="ProPlus Logics">
    <meta name="_token" content="{{ csrf_token() }}"/>

    <link rel="apple-touch-icon" sizes="180x180" href="{{url('/')}}/assets/home/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{url('/')}}/assets/home/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('/')}}/assets/home/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="{{url('/')}}/assets/home/images/favicon/site.webmanifest">
    <meta name="msapplication-TileColor" content="#8e4684">
    <meta name="theme-color" content="#ffffff">
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{url('/')}}/assets/home/css/bootstrap.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="{{url('/')}}/assets/home/css/bootstrap-icons.css" type="text/css" media="all">
    <!-- font-awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{url('/')}}/assets/home/style.css" type="text/css" media="all">
    <link rel="stylesheet" href="{{url('/')}}/assets/home/css/custom.css" type="text/css" media="all">
    <link rel="stylesheet" href="{{url('/')}}/assets/home/css/loader.css" type="text/css" media="all">
    <!-- Animated Text CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.3.0/animate.css" rel="stylesheet">
    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="{{url('/')}}/assets/home/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{url('/')}}/assets/home/css/owl.theme.default.min.css">
    <!-- Mega-menu css -->
    <link rel="stylesheet" href="{{url('/')}}/assets/home/css/themability_megamenu.css">
    <link rel="stylesheet" href="{{url('/')}}/assets/plugins/lightbox/css/lightbox.css">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css2?family=Ribeye+Marrow&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- icomoon CSS -->
    <link rel="stylesheet" href="{{url('/')}}/assets/home/font/themability-font.css" type="text/css" media="all">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/toastr.css">
    <!-- Main jquery js -->
    <script src="{{url('/')}}/assets/home/js/vendors/jquery-v3.6.4.min.js"></script>
    <!-- bootbox JS-->
    <script src="{{url('/')}}/assets/plugins/bootbox-js/bootbox.min.js"></script>
    
</head>

<body class="common-home">
    <!-- header menu -->
    <header>
        <div class="container">
            <div class="row header-inner align-items-center sub_sub_menu">
                <div class="col-xl-2 col-lg-6 col-sm-6 header-left">
                    <div id="logo"> <a href="{{url('/')}}/">
                            <img src="{{url('/')}}/{{$Company['Logo']}}" title="Your Store" alt="Your Store" class="img-fluid">
                        </a>
                    </div>
                </div>
                <div class="header-center text-lg-center col-xl-8 col-lg-12 d-none d-lg-block">
                    <div class="themability_megamenu-style-dev">
                        <div class="responsive themability_default">
                            <nav class="navbar-default">
                                <div class=" container-themability_megamenu   horizontal">
                                    <div class="navbar-header">
                                        <button type="button" id="show-themability_megamenu" data-toggle="collapse" class="navbar-toggle">
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                    </div>
                                    <div class="themability_megamenu-wrapper megamenu_typeheader">
                                        <span id="remove-themability_megamenu" class="fa-solid fa-xmark remove-themability_megamenu"></span>
                                        <div class="themability_megamenu-pattern">
                                            <div class="container">
                                                <ul class="themability_megamenu" data-megamenuid="48" data-transition="slide" data-animationtime="500">
                                                    <li >
                                                        <a href="{{url('/')}}">
                                                            <span><strong>Home</strong></span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{url('/')}}/about-us">
                                                            <span><strong>About us</strong></span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{url('/')}}/services">
                                                            <span><strong>Services</strong></span>
                                                        </a>
                                                    </li>
                                                     <li>
                                                        <a href="{{url('/')}}/projects">
                                                            <span><strong>Projects</strong></span>
                                                        </a>
                                                    </li>
                                                      <li>
                                                        <a href="{{url('/')}}/faq">
                                                            <span><strong>FAQ</strong></span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{url('/')}}/contact-us">
                                                            <span><strong>Contact Us</strong></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
                <!--mobile menu -->
                <div class="header-right col-xl-2 col-lg-6 col-sm-6   d-lg-none">
                    <div class="themability_megamenu-style-dev">
                        <div class="responsive themability_default">
                            <nav class="navbar-default">
                                <div class=" container-themability_megamenu   horizontal">
                                    <div class="navbar-header text-right right">
                                        <button type="button" id="show-themability_megamenu1" data-toggle="collapse" class="navbar-toggle">
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                    </div>
                                    <div class="themability_megamenu-wrapper megamenu_typeheader">
                                        <span id="remove-themability_megamenu1"  class="fa-solid fa-xmark remove-themability_megamenu"></span>
                                        <div class="themability_megamenu-pattern">
                                            <div class="container">
                                                <ul class="themability_megamenu" data-megamenuid="48" data-transition="slide" data-animationtime="500">
                                                    <li >
                                                        <a href="{{url('/')}}">
                                                            <span><strong>Home</strong></span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{url('/')}}/about-us">
                                                            <span><strong>About us</strong></span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{url('/')}}/services">
                                                            <span><strong>Services</strong></span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{url('/')}}/contact-us">
                                                            <span><strong>Contact Us</strong></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="page-content loading">
        <div class="pcontent">
            @yield('content')
        </div>
        <div class="loader p-0 m-0">
                <div class="text-animation">
                    <div class="text-wrapper">
                        <h2 style="font-size:{{$Settings['home-page-loading-text-font-size']}}px;">{{$Settings['home-page-loading-text']}}</h2>
                        <h2 style="font-size:{{$Settings['home-page-loading-text-font-size']}}px">{{$Settings['home-page-loading-text']}}</h2>
                    </div>
                </div>
        </div>
    </div>

    <!-- footer -->
    <footer class="mt-45">
        <div class="container">
            <div class="footer-top">
                <div class="row d-flex justify-content-center">
                    <div class="col-sm-4">
                        <div class="position-footer-left">
                            <div>
                                <h2 class="toggled">contact</h2>
                                <ul class="list-unstyled">
                                    <li>
                                        <div class="site">
                                            <div class="contact_title"><i class="fa-solid fa-location-dot"></i></div>
                                            <div class="contact_site">{{$Company['FullAddress']}}</div>
                                        </div>
                                    </li>
                                    @if($Company['Phone-Number']!="")
                                    <li>
                                        <div class="phone">
                                            <div class="contact_title"><i class="fa fa-phone" aria-hidden="true"></i></div>
                                            <div class="contact_site">+{{$Company['CallCode']}} {{$Company['Phone-Number']}}</div>
                                        </div>
                                    </li>
                                    @endif
                                    @if($Company['Mobile-Number']!="")
                                    <li>
                                        <div class="fax">
                                            <div class="contact_title"><i class="fa fa-phone"></i></div>
                                            <div class="contact_site">+{{$Company['CallCode']}} {{$Company['Mobile-Number']}}</div>
                                        </div>
                                    </li>
                                    @endif
                                    <li>
                                        <div class="email">
                                            <div class="contact_title"><i class="fa fa-envelope"></i></div>
                                            <div class="contact_site"><a href="mailto:{{$Company['Email']}}">{{$Company['Email']}}</a></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <h2 class="toggled">Information</h2>
                        <ul class="list-unstyled">
                            @if($Settings['isEnabledTermsConditions'])
                                <li><a href="{{url('/')}}/terms-and-conditions">Terms &amp; Conditions</a></li>
                            @endif
                                <li><a href="{{url('/')}}/about-us">About Us</a></li>
                                <li><a href="{{url('/')}}/services">Services</a></li>
                            @if($Settings['isEnabledPrivacyPolicy'])
                                <li><a href="{{url('/')}}/privacy-policy">Privacy Policy</a></li>
                            @endif
                            <li><a href="{{url('/')}}/contact-us">Contact Us</a></li>

                            @if($Settings['isEnabledHelp'])
                                <li><a href="{{url('/')}}/help">Help</a></li>
                            @endif
                        </ul>
                    </div>

                    <div class="col-sm-4 find_us_on">

                        <div class="position-footer-right">
                            @if($FooterAboutUs!="")
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="toggled">About us</h2>
                                    <div class="text-justify mb-3"><?php echo $FooterAboutUs; ?></div>
                                </div>
                            </div>
                            @endif
                            @if(($Company['facebook']!="")||($Company['facebook']!="")||($Company['twitter']!="")||($Company['pinterest']!="")||($Company['youtube']!="")||($Company['linkedin']!=""))
                            <div>
                                <h2 class="toggled">find us on</h2>
                                <div class="follow-link">
                                    <div class="social-media">
                                        @if($Company['facebook']!="")<a target="_blank" href="{{$Company['facebook']}}"><i class="fa-brands fa-facebook-f"></i></a> @endif
                                        @if($Company['instagram']!="")<a target="_blank" href="{{$Company['instagram']}}"><i class="fa-brands fa-instagram"></i></a> @endif
                                        @if($Company['twitter']!="")<a target="_blank" href="{{$Company['twitter']}}"><i class="fa-brands fa-twitter"></i></a> @endif
                                        @if($Company['pinterest']!="")<a target="_blank" href="{{$Company['pinterest']}}"><i class="fa-brands fa-pinterest"></i></a> @endif
                                        @if($Company['youtube']!="")<a target="_blank" href="{{$Company['youtube']}}"><i class="fa-brands fa-youtube"></i></a> @endif
                                        @if($Company['linkedin']!="")<a target="_blank" href="{{$Company['linkedin']}}"><i class="fa-brands fa-linkedin"></i></a> @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            <p class="copyright">© {{date("Y")}} Wall Four - All Rights Reserved.</p>
        </div>
    </footer>
    <a class="scrollToTop back-to-top" href="" data-toggle="tooltip" title="" data-original-title="Top" style="display: block;" data-bs-original-title=""><i class="fa fa-angle-up"></i></a>
    <!-- Bootstrap js -->
    <script src="{{url('/')}}/assets/home/js/popper.min.js"></script>
    <script src="{{url('/')}}/assets/home/js/bootstrap.min.js"></script>
    <!-- wow js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <!--owl javascript -->
    <script src="{{url('/')}}/assets/home/js/owl.carousel.min.js"></script>
    <!-- Main js -->
    <script src="{{url('/')}}/assets/home/js/theme.js"></script>
    <!-- mega-menu js -->
    <script src="{{url('/')}}/assets/home/js/themability_megamenu.js"></script>
    <script src="{{url('/')}}/assets/plugins/lightbox/js/lightbox.js"></script>
    <script src="{{url('/')}}/assets/js/custom-prototype.js"></script>
    <script src="{{url('/')}}/assets/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

    <script>
        const getData=()=>{
            let formData={}
            formData.Name=$('#txtName').val();
            formData.Email=$('#txtEmail').val();
            formData.MobileNumber=$('#txtMobileNumber').val();
            formData.Subject=$('#txtSubject').val();
            formData.Message=$('#txtMessage').val();
            formData.ServiceID=$('#txtServiceID').val();
            return formData;
        }
        const formValidation=(formData)=>{
            let status=true;
            $('.errors').html('');
            if(formData.Name==""){
                $('#txtName-err').html(' Name is required');status=false;
            }
            if(formData.Email==""){
                $('#txtEmail-err').html(' Email is required');status=false;
            }else if(formData.Email.isValidEMail()==false){
                $('#txtEmail-err').html(' Email not valid');status=false;
            }

            if(formData.MobileNumber==""){
                $('#txtMobileNumber-err').html(' Mobile Number is required');status=false;
            }else if(!$.isNumeric(formData.MobileNumber)){
                $('#txtMobileNumber-err').html('The Moile Number must be a numeric value');status=false;
            }else if(formData.MobileNumber.length!=10){
                $('#txtMobileNumber-err').html('The Mobile Number required 10 digit number.');status=false;
            }

            if(formData.Subject==""){
                $('#txtSubject-err').html(' Subject is required');status=false;
            }
            if(formData.Message==""){
                $('#txtMessage-err').html(' Message is required');status=false;
            }
            return status;
        }
        var onSubmit = function(token) {
            let formData=getData();
            let status=formValidation(formData);
            if(status){
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/save/service-enquiry",
                    data:formData,
                    dataType:"json",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success:function(response){
                        if(response.status==true){
                            toastr.success(response.message, "Success", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                            bootbox.hideAll();
                        }else{
                            grecaptcha.reset();
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
            }else{
                grecaptcha.reset();
            }
        };
        var onloadCallback = function() {
          grecaptcha.render('submit', {
            'sitekey' : '6LevXs4nAAAAAEz6aDge943m-mG1xnzjJg99x1bI',
            'callback' : onSubmit
          });
        };
    </script>
    <script>

        $(document).ready(function(){
            setTimeout(() => {
                $('.page-content').removeClass('loading');
            }, 200);
            $(document).on('click','.btnEnquiry',function(){
                let id=$(this).attr('data-id');
                let Slug=$(this).attr('data-slug')
                let ServiceName=$(this).attr('data-name')
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/get/service-enquiry-form",
                    data:{id,Slug,ServiceName},
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success:function(response){
                        bootbox.dialog({
                            title: 'Service Enquiry - '+ServiceName,
                            closeButton: true,
                            message: response,
                            size:'large',
                            buttons: {
                            }
                        });
                    }
                });
            });
            $(document).on('submit','#frmServiceEnquiry',function(e){
                e.preventDefault();
            })
        })
    </script>
</body>

</html>