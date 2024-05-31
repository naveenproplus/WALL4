@extends('layouts.app')
@section('content')

<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-6">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin"><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">{{$PageTitle}}</li>
				</ol>
			</div>
			<div class="col-sm-12">
				 @if ($crud['restore'] == 1)
				<div class="bookmark pull-right">
                    {{-- <a href="{{url('/')}}/admin/home/gallery/deleted" class="btn btn sm btn-outline-dark" id="btnRestore">Restore</a> --}}
                </div>
				@endif
				 @if ($crud['add'] == 1)
                <div class="bookmark pull-right">
                    <a href="{{url('/')}}/admin/home/gallery/upload" class="btn btn sm btn-outline-dark" id="btnUploadGallery">Upload</a>
                </div>
				@endif
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>Gallery Images</h5>
				</div>
				<div class="my-gallery card-body row gallery-with-description" >
					@for($i=0;$i<count($galleryImages);$i++)
						<figure class="col-xl-4 col-sm-6" data-tran-no="{{$galleryImages[$i]->ID}}" >
							<a href="{{url('/')}}/{{$galleryImages[$i]->GalleryImage}}" data-lightbox="gallery-images">
								<img src="{{url('/')}}/{{$galleryImages[$i]->GalleryImage}}"  alt="Image {{$i}}">
							</a>
								<div class="caption text-center ">
									@if($crud['edit']==1)
										<button type="button" data-id="{{$galleryImages[$i]->ID}}" class="btn btn-sm btn-outline-warning btnEdit mr-10"><i class="fa fa-pencil"></i></button>
									@endif
									@if($crud['delete']==1)
										<button type="button" data-id="{{$galleryImages[$i]->ID}}" class="btn btn-sm btn-outline-danger btnDelete"><i class="fa fa-trash"></i></button>
									@endif
								</div>
						</figure>
					@endfor
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Container-fluid Ends-->
<link rel="stylesheet" href="{{url('/')}}/assets/plugins/lightbox/css/lightbox.css">
<script src="{{url('/')}}/assets/plugins/lightbox/js/lightbox.js"></script>
<script>
	$(document).ready(function(){

		$(document).on('click','.btnEdit',function(){
			window.location.replace("{{url('/')}}/admin/home/gallery/edit/"+ $(this).attr('data-id'));
		});
		$(document).on('click','.btnDelete',function(e){
        	e.preventDefault();
            var id = $(this).attr("data-id");
            swal({
                title: "Are you sure?",
                text: "You want to Delete this Category!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-success",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: false
            },function(){
                swal.close();
                $.ajax({
                    type: "post",
                	headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    url: "{{url('/')}}/admin/home/gallery/delete/"+ id,
                    success: function (response) {
                        if(response.status==true){
                            toastr.success(response.message, "Success", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",})
                        	$('figure[data-tran-no="'+id+'"]').remove();
                		}else{
							toastr.error(response.message, "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",})
						}
					}
            	});
        	});
		});
	});
</script>
@endsection