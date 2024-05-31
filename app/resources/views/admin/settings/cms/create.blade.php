@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}/admin"><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Settings</li>
                    <li class="breadcrumb-item"><a href="{{url('/admin/settings/cms/')}}">{{$PageTitle}}</a></li>
					<li class="breadcrumb-item">Update</li>
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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txtPageName"> Page Name  </label>
                                        <input type="text" Disabled class="form-control" place-holder="Page Name" id="txtPageName" value="<?php if($isEdit){ echo $EditData[0]->PageName;} ?>">
                                        <div class="errors" id="txtPageName-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="txtPageName"> Page Content </label>
                                        <div id="editor" >
                                            <?php if($isEdit){ echo $EditData[0]->PageContent;} ?>
                                        </div>
                                        <div class="errors" id="txtPageName-err"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12 text-right">                            
                                    @if($crud['view']==true)
                                        <a href="{{url('/')}}/admin/settings/cms/" class="btn btn-sm btn-outline-dark" id="btnCancel">Back</a>
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
            initCKEditor();
        }
		$('#btnSave').click(function(){
                let formData={pageContent:CKEDITOR.instances.editor.getData()};
                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this Page Content!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true)Update @else Save @endif it!",
                    closeOnConfirm: false
                },
                function(){
                    swal.close();
                    btnLoading($('#btnSave'));
                    @if($isEdit) let posturl="{{url('/')}}/admin/settings/cms/edit/{{$CID}}"; @else let posturl="{{url('/')}}/admin/settings/cms-pages"; @endif
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
                                    @if($isEdit==true)
                                        window.location.replace("{{url('/')}}/admin/settings/cms");
                                    @else
                                        window.location.reload();
                                    @endif
                                });    
                            }else{
                                toastr.error(response.message, "Failed", {
                                    positionClass: "toast-top-right",
                                    containerId: "toast-top-right",
                                    showMethod: "slideDown",
                                    hideMethod: "slideUp",
                                    progressBar: !0
                                })
                            }
                        }
                    });
                });
		});
        appInit();
    });
</script>
@endsection