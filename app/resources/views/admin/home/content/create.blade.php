@extends('layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/home/vendor/twentytwenty-master/css/twentytwenty.css">
    <link href="{{url('/')}}/assets/home/vendor/lightgallery/css/lightgallery.min.css" rel="stylesheet">
	<link href="{{url('/')}}/assets/home/vendor/magnific-popup/magnific-popup.min.css" rel="stylesheet">
	<link href="{{url('/')}}/assets/home/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
	<link href="{{url('/')}}/assets/home/vendor/aos/aos.css" rel="stylesheet">
	{{-- <link href="{{url('/')}}/assets/home/vendor/switcher/switcher.css" rel="stylesheet"> --}}
	<link href="{{url('/')}}/assets/home/vendor/rangeslider/rangeslider.css" rel="stylesheet">
	
	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
	
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="{{url('/')}}/assets/home/css/style.css">
	{{-- <link class="skin" rel="stylesheet" href="{{url('/')}}/assets/home/css/skin/skin-1.css"> --}}
@endsection

@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin"><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Master</li>
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin/master/category">{{$PageTitle}}</a></li>
					<li class="breadcrumb-item">@if($isEdit) Update @else Create @endif</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row  d-flex justify-content-center ">
		<div class="col-sm-12 ">
			<div class="row">
				<div class="col-sm-12">
					<div class="card">
						<div class="card-header text-center">
							<div class="form-row align-items-center">
								<div class="col-md-4">	</div>
								<div class="col-md-4 my-2"><h5>{{$PageTitle}}</h5></div>
								<div class="col-md-4 my-2 text-right text-md-right">
								</div>
							</div>
						</div>
                        <div class="card-body">
                            <div class="row mt-20">
                                {{-- <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="txtSectionName"> Section Name  </label>
                                        <input type="text" @if($isEdit) Disabled @endif class="form-control" place-holder="Section Name" id="txtSectionName" value="<?php if($isEdit){ echo $EditData[0]->SectionName;} ?>">
                                        <div class="errors" id="txtSectionName-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="lstPosition"> Position </label>
                                        <select class="form-control" id="lstPosition">
                                            <option value="Before Service" @if($isEdit) @if($EditData[0]->ContentPosition=="Before Service") selected @endif @endif>Before Service</option>
                                            <option value="After Service" @if($isEdit) @if($EditData[0]->ContentPosition=="After Service") selected @endif @endif>After Service</option>
                                        </select>
                                        <div class="errors" id="lstPosition-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="lstPlace"> After</label>
                                        <select class="form-control select2" id="lstPlace" data-selected="<?php if($isEdit){ echo $After;}  ?>">
                                            <option value="Begining">Begining</option>
                                        </select>
                                        <div class="errors" id="lstPlace-err"></div>
                                    </div>
                                </div> --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="lstPlace"> Edit</label>
                                        
                                    </div>
                                </div>
                                {{-- <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="txtPageName"> Page Content </label>
                                        <div id="editor" >
                                            <?php if($isEdit){ echo $EditData[0]->Content;} ?>
                                        </div>
                                        <div class="errors" id="txtPageName-err"></div>
                                    </div>
                                </div> --}}
                                <div class="col-sm-12">
                                    <div class="card home-content-edit">
                                        <div class="card-body">
                                            {{-- @include('home.sample',['Content'=>$EditData[0]->Content]) --}}
                                            <iframe src="{{$EditData[0]->Content}}" frameborder="0"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12 text-right">                            
                                    @if($crud['view']==true)
                                        <a href="{{url('/')}}/admin/home/content/" class="btn btn-sm btn-outline-dark" id="btnCancel">Back</a>
                                    @endif
                                    @if(($crud['view']==true)&&($crud['edit']==true))
                                        <button class="btn btn-outline-success btn-sm" id="btnSave" type="button" >@if($isEdit) Update @else Create @endif</button>
                                    @endif
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
    $(document).ready(function(){
        const appInit=()=>{
            $('.cannot-edit').addClass('d-none');
            // initCKEditor();
            getSections();
        }
        const getSections=()=>{
            let Position=$('#lstPosition').val();
            $('#lstPlace').select2('destroy');
            $('#lstPlace option').remove();
            $('#lstPlace').append('<option value="Begining" data-ordering="0">Begining</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/home/content/get/section-names",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                data:{Position:Position,TranNo:"<?php if($isEdit==true){ echo $TranNo;} ?>"},
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.CID==$('#lstPlace').attr('data-selected')){selected="selected";}
                        $('#lstPlace').append('<option  '+selected+' data-ordering="'+Item.OrderBy+'" value="'+Item.TranNo+'">'+Item.SectionName+' </option>');
                    }
                }
            });
            $('#lstPlace').select2();
        }
        const getData=()=>{
            let formData={};
            formData.SectionName=$('#txtSectionName').val();
            formData.Position=$('#lstPosition').val();
            formData.Ordering=$('#lstPlace').val();
            formData.OrderBy=$('#lstPlace option:selected').attr('data-ordering');
            formData.Content=CKEDITOR.instances.editor.getData();
            return formData;
        }
        $(document).on('change','#lstPosition',function(){
            getSections();
        })
        $(document).on('click','#btnSave',function(){
            swal({
                title: "Are you sure?",
                text: "You want @if($isEdit==true)Update @else Save @endif this Content!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-success",
                confirmButtonText: "Yes, @if($isEdit==true)Update @else Save @endif it!",
                closeOnConfirm: false
            },function(){
                let formData=getData();
                swal.close();
                btnLoading($('#btnSave'));
                @if($isEdit) let posturl="{{url('/')}}/admin/home/content/edit/{{$TranNo}}"; @else let posturl="{{url('/')}}/admin/home/content/create"; @endif
                $.ajax({
                    type:"post",
                    url:posturl,
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:formData,
                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                    complete: function(e, x, settings, exception){btnReset($('#btnSave'));ajaxIndicatorStop();},
                    success:function(response){
                        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
                        if(response.status==true){
                            swal({
                                title: "SUCCESS",
                                text: response.message,
                                type: "success",
                                showCancelButton: false,
                                confirmButtonClass: "btn-outline-success",
                                confirmButtonText: "Okay",
                                closeOnConfirm: false
                            },function(){
                                @if($isEdit==true) window.location.replace("{{url('/')}}/admin/home/content"); @else window.location.reload();@endif
                            });    
                        }else{
                            toastr.error(response.message, "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                        }
                    }
                });
            });
        });

        appInit();
    });
</script>
@endsection
@section('script')
    {{-- <script src="{{url('/')}}/assets/home/vendor/bootstrap/js/bootstrap.bundle.min.js"></script><!-- BOOTSTRAP.MIN JS --> --}}
    <script src="{{url('/')}}/assets/home/js/custom.js"></script><!-- CUSTOM JS -->
    <script src="{{url('/')}}/assets/home/vendor/counter/waypoints-min.js"></script><!-- WAYPOINTS JS -->
    <script src="{{url('/')}}/assets/home/vendor/counter/counterup.min.js"></script><!-- COUNTERUP JS -->
    {{-- <script src="{{url('/')}}/assets/home/vendor/magnific-popup/magnific-popup.js"></script><!-- MAGNIFIC POPUP JS --> --}}
    {{-- <script src="{{url('/')}}/assets/home/vendor/lightgallery/js/lightgallery-all.min.js"></script><!-- LIGHTGALLERY --> --}}
    {{-- <script src="{{url('/')}}/assets/home/vendor/masonry/isotope.pkgd.min.js"></script><!-- ISOTOPE --> --}}
    {{-- <script src="{{url('/')}}/assets/home/vendor/imagesloaded/imagesloaded.js"></script><!-- IMAGESLOADED --> --}}
    {{-- <script src="{{url('/')}}/assets/home/vendor/masonry/masonry-4.2.2.js"></script><!-- MASONRY --> --}}
    {{-- <script src="{{url('/')}}/assets/home/vendor/twentytwenty-master/js/jquery.event.move.js"></script> --}}
    {{-- <script src="{{url('/')}}/assets/home/vendor/twentytwenty-master/js/jquery.twentytwenty.js"></script> --}}
    {{-- <script src="{{url('/')}}/assets/home/vendor/swiper/swiper-bundle.min.js"></script><!-- OWL-CAROUSEL --> --}}
    <script src="{{url('/')}}/assets/home/vendor/aos/aos.js"></script><!-- AOS -->
    {{-- <script src="{{url('/')}}/assets/home/js/dz.carousel.js"></script><!-- OWL-CAROUSEL --> --}}
    {{-- <script src="{{url('/')}}/assets/home/js/dz.ajax.js"></script><!-- AJAX --> --}}
    {{-- <script src="{{url('/')}}/assets/home/vendor/rangeslider/rangeslider.js"></script><!-- RANGESLIDER --> --}}

    <script>
        $(document).ready(function() {
            var maxHeight = 0;
            $('.service-content').each(function() {
                var height = $(this).outerHeight();
                if (height > maxHeight) {
                    maxHeight = height;
                }
            });

            $('.service-content').css('height', maxHeight + 'px');
            
            var checkExist = setInterval(function() {
                if ($('.DZ-bt-buy-now').length || $('.DZ-bt-support-now').length) {
                    $('.DZ-bt-buy-now').remove();
                    $('.DZ-bt-support-now').remove();
                    clearInterval(checkExist);
                }
            }, 100);

        });
    </script>
@endsection