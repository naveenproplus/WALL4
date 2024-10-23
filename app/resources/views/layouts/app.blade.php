<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="ProPlus Logics">
    <meta name="_token" content="{{ csrf_token() }}" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/') }}/assets/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('/') }}/assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('/') }}/assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="{{ url('/') }}/assets/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#8e4684">
    <meta name="theme-color" content="#ffffff">
    <!-- Required meta tags -->

    <title>{{ $PageTitle }} - {{ $Company['Name'] }}</title>
    {{-- <link rel="icon" type="image/x-icon" href="{{url('/')}}/{{$Company['Logo']}}"> --}}
    <link rel="icon" type="image/png" href="{{url('/')}}/assets/images/logo/icon.png">

    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700&amp;display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/fontawesome.css?r={{ date('dmyHis') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/icofont.css?r={{ date('dmyHis') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/themify.css?r={{ date('dmyHis') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/flag-icon.css?r={{ date('dmyHis') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/feather-icon.css?r={{ date('dmyHis') }}">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/bootstrap.css?r={{ date('dmyHis') }}">

    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/plugins/image-cropper/image-cropper.css?r={{ date('dmyHis') }}">
    <!-- DataTable css-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/datatables.css?r={{ date('dmyHis') }}">
    <link rel="stylesheet" href="{{ url('/') }}/assets/plugins/DataTable/css/responsive.dataTables.min.css?r={{ date('dmyHis') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/datatable-extension.css?r={{ date('dmyHis') }}">

    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/js/lightbox/css/lightgallery.css?r={{ date('dmyHis') }}">

    <!-- sweetalert css-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/sweetalert2.css?r={{ date('dmyHis') }}">
    <!-- select2 css-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/select2.css?r={{ date('dmyHis') }}">
    <!-- toastr css-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/toastr.css?r={{ date('dmyHis') }}">
    <!-- dropify css-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/plugins/dropify/css/dropify.min.css?r={{ date('dmyHis') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/loader.css?r={{ date('dmyHis') }}">


    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/style.css?r={{ date('dmyHis') }}">
    <link id="color" rel="stylesheet" href="{{ url('/') }}/assets/css/color-1.css?r={{ date('dmyHis') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/responsive.css?r={{ date('dmyHis') }}">

    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/custom-n.css?r={{ date('dmyHis') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/custom.css?r={{ date('dmyHis') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/js/bootstrap-multiselect/bootstrap-multiselect.css?r={{ date('dmyHis') }}">

    @yield('css')

    <script src="{{ url('/') }}/assets/js/jquery-3.5.1.min.js?r={{ date('dmyHis') }}"></script>

    <script src="{{ url('/') }}/assets/js/select2/select2.full.min.js?r={{ date('dmyHis') }}"></script>
    <script src="{{ url('/') }}/assets/js/select2/select2-custom.js?r={{ date('dmyHis') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>


    <!-- sweetalert JS-->
    <script src="{{ url('/') }}/assets/js/sweet-alert/sweetalert.min.js?r={{ date('dmyHis') }}"></script>
    <!-- toastr JS-->
    <script src="{{ url('/') }}/assets/js/toastr.min.js?r={{ date('dmyHis') }}"></script>
    <!-- Select2 JS-->
    <script src="{{ url('/') }}/assets/js/select2/select2.full.min.js?r={{ date('dmyHis') }}"></script>
    <!-- dropify JS-->
    <script src="{{ url('/') }}/assets/plugins/dropify/js/dropify.js?r={{ date('dmyHis') }}"></script>
    <!-- bootbox JS-->
    <script src="{{ url('/') }}/assets/plugins/bootbox-js/bootbox.min.js?r={{ date('dmyHis') }}"></script>
    <!-- DataTable JS-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js?r={{ date('dmyHis') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js?r={{ date('dmyHis') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.min.js?r={{ date('dmyHis') }}"></script>

    <script src="{{ url('/') }}/assets/plugins/DataTable/js/jquery.dataTables.min.js?r={{ date('dmyHis') }}">
    </script>
    <script
        src="{{ url('/') }}/assets/js/datatable/datatable-extension/dataTables.buttons.min.js?r={{ date('dmyHis') }}">
    </script>
    <script
        src="{{ url('/') }}/assets/js/datatable/datatable-extension/buttons.colVis.min.js?r={{ date('dmyHis') }}">
    </script>
    <script
        src="{{ url('/') }}/assets/js/datatable/datatable-extension/dataTables.autoFill.min.js?r={{ date('dmyHis') }}">
    </script>
    <script
        src="{{ url('/') }}/assets/js/datatable/datatable-extension/dataTables.select.min.js?r={{ date('dmyHis') }}">
    </script>
    <script
        src="{{ url('/') }}/assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js?r={{ date('dmyHis') }}">
    </script>
    <script
        src="{{ url('/') }}/assets/js/datatable/datatable-extension/buttons.html5.js?r={{ date('dmyHis') }}">
    </script>
    <script
        src="{{ url('/') }}/assets/js/datatable/datatable-extension/buttons.print.js?r={{ date('dmyHis') }}">
    </script>
    <script
        src="{{ url('/') }}/assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js?r={{ date('dmyHis') }}">
    </script>
    <script
        src="{{ url('/') }}/assets/plugins/DataTable/js/dataTables.responsive.min.js?r={{ date('dmyHis') }}">
    </script>
    <script src="{{ url('/') }}/assets/js/dataTableExport.js?r={{ date('dmyHis') }}"></script>

    <script type="text/javascript"
        src="{{ url('/') }}/assets/js/devtools-detector.min.js?r={{ date('dmyHis') }}"></script>
    <script
        src="{{ url('/') }}/assets/js/bootstrap-multiselect/bootstrap-multiselect.js?r={{ date('dmyHis') }}">
    </script>
    <script src="{{ url('/') }}/assets/js/custom-prototype.js?r={{ date('dmyHis') }}"></script>
    <script src="{{ url('/') }}/assets/js/custom-prototype.js?r={{ date('dmyHis') }}"></script>

    <script src="{{ url('/') }}/assets/plugins/ckeditor/ckeditor.js"></script>
    <script src="{{ url('/') }}/assets/plugins/ckeditor/custom.js"></script>


    <script src="{{ url('/') }}/assets/plugins/image-cropper/cropper.js"></script>
</head>

<body oncontextmenu="return true;">
    <textarea style="display: none;" id="txtThemeOption">{{ json_encode($Theme) }}</textarea>
    <input type="hidden" name="txtActiveName" id="txtActiveName" value="{{ $ActiveMenuName }}">
    <input type="hidden" name="txtRootUrl" id="txtRootUrl" value="{{ url('/') }}/">
    <div id="divsettings" class="display-none">{{ json_encode($Settings) }}</div>
    <!-- Loader starts-->
    <div class="loader-wrapper">
        <div class="theme-loader"></div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <div class="page-main-header">
            <div class="main-header-right">
                <div class="main-header-left">
                    <div class="logo-wrapper">
                        <a href="{{ url('/') }}/admin"><img
                                src="{{ url('/') }}/assets/images/logo/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="mobile-sidebar">
                    <div class="media-body text-right switch-sm">
                        <label class="switch">
                            <input id="sidebar-toggle" type="checkbox" data-toggle=".container"
                                checked="checked"><span class="switch-state"></span>
                        </label>
                    </div>
                </div>
                <div class="nav-right col pull-right right-menu">
                    <ul class="nav-menus">
                        <li class="px-0"></li>
                        <li class="theme-setting"><i data-feather="settings"></i></li>
                        <!--<li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>-->

                        <li class="onhover-dropdown px-0"><span class="media user-header"><img
                                    class="mr-2 rounded-circle img-35 oneIsone"
                                    src="{{ url('/') }}/{{ $UInfo->ProfileImage }}" alt=""><span
                                    class="media-body"><span class="f-12 f-w-600">{{ $UInfo->Name }}</span><span
                                        class="d-block">{{ $UInfo->RoleName }}</span></span>
                            </span>
                            <ul class="profile-dropdown onhover-show-div">
                                <!--<li><a href="{{ url('/') }}/admin/users-and-permissions/profile"><i data-feather="user"> </i>Profile</a></li>-->
                                <li><a href="{{ url('/') }}/admin/users-and-permissions/change-password/"><i
                                            data-feather="user"> </i>Password Change</a></li>
                                <li onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i data-feather="log-in"></i>Logout </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
            </div>
        </div>
        <!-- Page Header Ends                              -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper sidebar-icon">
            <nav-menus></nav-menus>
            <header class="main-nav">
                <nav>
                    <div class="main-navbar">
                        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                        <div id="mainnav">
                            <ul class="nav-menu custom-scrollbar " id="MenuNav">
                                <li class="back-btn">
                                    <div class="mobile-back text-right"><span>Back</span><i
                                            class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
                                </li>
                                <?php
                                echo $menus;
                                ?>
                            </ul>
                        </div>
                        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                    </div>
                </nav>
            </header>
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                @yield('content')
                <div class="modal  medium" tabindex="-1" role="dialog" id="ImgCrop">
                    <div class="modal-dialog modal-dialog-centered" role="document" ">
                        <div class="modal-content">
                            <div class="modal-header pt-10 pb-10">
                                <h5 class="modal-title">Image Crop</h5>
                                <button type="button" class="close display-none" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <img style="width:100%" src="" id="ImageCrop" data-id="">
                                    </div>
                                </div>
                                <div class="row mt-10 d-flex justify-content-center">
                                    <div class="col-sm-12 docs-buttons d-flex justify-content-center">
                                        <div class="btn-group">
                                            <button class="btn btn-outline-primary" type="button" data-method="rotate" data-option="-45" title="Rotate Left"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;rotate&quot;, -45)"><span class="fa fa-rotate-left"></span></span></button>
                                            <button class="btn btn-outline-primary" type="button" data-method="rotate" data-option="45" title="Rotate Right"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;rotate&quot;, 45)"><span class="fa fa-rotate-right"></span></span></button>
                                            <button class="btn btn-outline-primary" type="button" data-method="scaleX" data-option="-1" title="Flip Horizontal"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;scaleX&quot;, -1)"><span class="fa fa-arrows-h"></span></span></button>
                                            <button class="btn btn-outline-primary" type="button" data-method="scaleY" data-option="-1" title="Flip Vertical"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;scaleY&quot;, -1)"><span class="fa fa-arrows-v"></span></span></button>
                                            <button class="btn btn-outline-primary" type="button" data-method="reset" title="Reset"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;reset&quot;)"><span class="fa fa-refresh"></span></span></button>
                                            <button class="btn btn-outline-primary btn-upload" id="btnUploadImage" title="Upload image file"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="Import image with Blob URLs"><span class="fa fa-upload"></span></span></button>
                                            <?php
                                                $Images=array("jpg","jpeg","png","gif","bmp","tiff");
                                                if(isset($FileTypes)){
                                                    if(array_key_exists("category",$FileTypes)){
                                                        if(array_key_exists("Images",$FileTypes['category'])){
                                                            $Images=$FileTypes['category']['Images'];
                                                        }
                                                    }
                                                }
                                                $Images=".".implode(",.",$Images);
                                            ?>
                                            <input class="sr-only display-none" id="inputImage" type="file" name="file" accept="{{$Images}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-dark"  id="btnCropModelClose">Close</button>
                                <button type="button" class="btn btn-outline-info" id="btnCropApply">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer start-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 footer-copyright">
                            <p class="mb-0">Copyright &copy; @if (date('Y') == '2023')
                                    {{ date('Y') }}
                                @else
                                    2024-{{ date('Y') }}
                                @endif <a class="text-bold-800 grey darken-2"
                                    href="https://propluslogics.com/" target="_blank">Web Development Company </a>,
                                All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- latest jquery-->

    <!-- Bootstrap js-->
    <script src="{{ url('/') }}/assets/js/bootstrap/popper.min.js?r={{ date('dmyHis') }}"></script>
    <script src="{{ url('/') }}/assets/js/bootstrap/bootstrap.js?r={{ date('dmyHis') }}"></script>
    <!-- feather icon js-->
    <script src="{{ url('/') }}/assets/js/icons/feather-icon/feather.min.js?r={{ date('dmyHis') }}"></script>
    <script src="{{ url('/') }}/assets/js/icons/feather-icon/feather-icon.js?r={{ date('dmyHis') }}">
    </script>

    <!-- Service Zoom -->
    <script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js?r={{ date('dmyHis') }}"></script>
    <script src="{{ url('/') }}/assets/js/lightbox/js/lightgallery.js?r={{ date('dmyHis') }}"></script>
    <script src="{{ url('/') }}/assets/js/wheelzoom/wheelzoom.js?r={{ date('dmyHis') }}"></script>

    <!-- Sidebar jquery-->
    <script src="{{ url('/') }}/assets/js/sidebar-menu.js?r={{ date('dmyHis') }}"></script>
    <script src="{{ url('/') }}/assets/js/config.js?r={{ date('dmyHis') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ url('/') }}/assets/js/tooltip-init.js?r={{ date('dmyHis') }}"></script>
    <!-- Plugins JS Ends-->


    <!-- Theme js-->
    <script src="{{ url('/') }}/assets/js/script.js?r={{ date('dmyHis') }}"></script>
    <script src="{{ url('/') }}/assets/js/theme-customizer/customizer.js?r={{ date('dmyHis') }}"></script>
    <!-- login js-->
    <script src="{{ url('/') }}/assets/js/custom.js?r={{ date('dmyHis') }}"></script>
    <script src="{{ url('/') }}/assets/js/customFileUpload.js?r={{ date('dmyHis') }}"></script>
    <script src="{{ url('/') }}/assets/js/support.js?r={{ date('dmyHis') }}"></script>
    <!-- Plugin used-->
    @yield('script')

</body>

</html>
