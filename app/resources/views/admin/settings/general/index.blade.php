@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin"><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Settings</li>
					<li class="breadcrumb-item">{{$PageTitle}}</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid ">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-6">
			<div class="card m-b-30">
				<div class="card-body">
					<div class="form-row">
                        <div class="col-sm-12">
                            <ul class="nav nav-pills justify-content-center settings" id="pills-icontab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="pills-general-tab" data-toggle="pill" href="#pills-general" role="tab" aria-controls="pills-general" aria-selected="false" data-original-title="" title=""><i class="fa fa-cogs" aria-hidden="true"></i> General</a></li>
                                <li class="nav-item"><a class="nav-link " id="pills-map-tab" data-toggle="pill" href="#pills-map" role="tab" aria-controls="pills-map" aria-selected="false" data-original-title="" title=""><i class="fa fa-map-marker" aria-hidden="true"></i> Map</a></li>
								<li class="nav-item"><a class="nav-link " id="pills-social-media-links-tab" data-toggle="pill" href="#pills-social-media-links" role="tab" aria-controls="pills-social-media-links" aria-selected="false" data-original-title="" title=""><i class="fa fa-facebook-square" aria-hidden="true"></i> Social Media Links</a></li>
								<li class="nav-item"><a class="nav-link " id="pills-meta-links-tab" data-toggle="pill" href="#pills-meta-links" role="tab" aria-controls="pills-meta-links" aria-selected="false" data-original-title="" title=""><i class="fa fa-check" aria-hidden="true"></i> Meta Data</a></li>
                            </ul>
                            <div class="tab-content m-t-30" id="pills-icontabContent">
                                <div class="tab-pane fade active show" id="pills-general" role="tabpanel" aria-labelledby="pills-general-tab">

									<div class="form-row">
										<div class="col-sm-6"><b>Date Format :</b></div>
										<div class="col-sm-6">
											<div class="form-group">
												<select class="form-control" id="lstDateFormat"  @if($crud['edit']==false) disabled @endif>
												@for($i=0;$i<count($DateFormats);$i++)
												<option @if($Settings['date-format']==$DateFormats[$i]->Format) selected @endif value="{{$DateFormats[$i]->Format}}">{{$DateFormats[$i]->Format}} ( {{date($DateFormats[$i]->Format)}} )</option>
												@endfor
												</select>
												<div class="errors" id="lstDateFormat-err"></div>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-sm-6"><b>Time Format :</b></div>
										<div class="col-sm-6">
											<div class="form-group">
												<select class="form-control" id="lstTimeFormat"  @if($crud['edit']==false) disabled @endif>
												@for($i=0;$i<count($TimeFormats);$i++)
												<option @if($Settings['time-format']==$TimeFormats[$i]->Format) selected @endif value="{{$TimeFormats[$i]->Format}}">{{$TimeFormats[$i]->Format}} ( {{date($TimeFormats[$i]->Format)}} )</option>
												@endfor
												</select>
												<div class="errors" id="lstTimeFormat-err"></div>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-sm-6"><b>Price Decimals :</b></div>
										<div class="col-sm-6">
											<div class="form-group">
												<select class="form-control" id="lstPrice"  @if($crud['edit']==false) disabled @endif>
												<option value="auto">Default</option>
												@for($i=0;$i<=10;$i++)
												<option @if($Settings['price-decimals']==$i) selected @endif value="{{$i}}">{{$i}}</option>
												@endfor
												</select>
												<div class="errors" id="lstPrice-err"></div>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-sm-6"><b>Percentage Decimals :</b></div>
										<div class="col-sm-6">
											<div class="form-group">
												<select class="form-control" id="lstPercentage"  @if($crud['edit']==false) disabled @endif>
												<option value="auto">Default</option>
												@for($i=0;$i<=10;$i++)
												<option @if($Settings['percentage-decimals']==$i) selected @endif value="{{$i}}">{{$i}}</option>
												@endfor
												</select>
												<div class="errors" id="lstPercentage-err"></div>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-sm-6"><b>Upload Size / per :</b></div>
										<div class="col-sm-6">
											<div class="form-group">
												<div class="input-group">
													<?php
														$UploadSize=$Settings['upload-limit'];
														?>
													<input type="number" step=1 class="form-control" min=1 id="txtImgUploadSize" value="{{substr($UploadSize,0,strlen($UploadSize)-1)}}" @if($crud['edit']==false) disabled @endif>
													<select class="form-control" id="lstImgUploadSizeType"   @if($crud['edit']==false) disabled @endif>
													<!--<option value="B" @if(substr($UploadSize,strlen($UploadSize)-1)=="B") selected @endif>Bytes</option>-->
													<option value="K" @if(substr($UploadSize,strlen($UploadSize)-1)=="K") selected @endif>KB</option>
													<option value="M" @if(substr($UploadSize,strlen($UploadSize)-1)=="M") selected @endif>MB</option><!--
														<option value="G" @if(substr($UploadSize,strlen($UploadSize)-1)=="G") selected @endif>GB</option>-->
													</select>
												</div>
												<div class="errors" id="txtImgUploadSize-err"></div>
											</div>
										</div>
									</div>
									{{-- <div class="form-row">
										<div class="col-sm-6"><b>Front End Loading Text :</b></div>
										<div class="col-sm-6">
											<div class="form-group">
												<input type="text" step=1 class="form-control" min=1 id="txtLoadingText" value="{{$Settings['home-page-loading-text']}}" @if($crud['edit']==false) disabled @endif>
												<div class="errors" id="txtLoadingText-err"></div>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-sm-6"><b>Front End Loading Text Size :</b></div>
										<div class="col-sm-6">
											<div class="form-group">
												<select class="form-control" id="lstLoadingTextSize"  @if($crud['edit']==false) disabled @endif>
												@for($i=40;$i<=120;$i++)
												<option @if($Settings['home-page-loading-text-font-size']==$i) selected @endif value="{{$i}}">{{$i}}</option>
												@endfor
												</select>
												<div class="errors" id="lstLoadingTextSize-err"></div>
											</div>
										</div>
									</div> --}}
                                </div>
                                <div class="tab-pane fade" id="pills-map" role="tabpanel" aria-labelledby="pills-map-tab">
                                    <div class="row d-flex justify-content-center mb-10">
                                        <div class="col-sm-3 col-11">
                                            <div class="checkbox checkbox-info"><input @if($Company['google-map-status']) checked @endif id="chkEmbedMap" type="checkbox" ><label for="chkEmbedMap">Show Google Map</label></div>
                                        </div>
                                    </div>
                                    <div class="row mapStatus" style="@if($Company['google-map-status']==false) display:none @endif">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="">Google Embed Map Url <span class="required"> * </span></label>
                                                <input type="url" class="form-control" id="txtMapEmbedUrl" value="{{$Company['google-embed-map']}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mapStatus" style="@if($Company['google-map-status']==false) display:none @endif">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <iframe id="google-map" src="{{$Company['google-embed-map']}}" width="100%" height="450" class="b-r-10 shadow-sm" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-social-media-links" role="tabpanel" aria-labelledby="pills-social-media-links-tab">
                                    
									<div class="form-row">
										<div class="col-sm-4 pt-15"><b>Facebook :</b></div>
										<div class="col-sm-8">
											<div class="form-group">
												<input type="url" class="form-control" id="txtfacebook" value="{{$Company['facebook']}}">
												<div class="errors" id="txtfacebook-err"></div>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-sm-4 pt-15"><b>Twitter :</b></div>
										<div class="col-sm-8">
											<div class="form-group">
												<input type="url" class="form-control" id="txtTwitter" value="{{$Company['twitter']}}">
												<div class="errors" id="txtTwitter-err"></div>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-sm-4 pt-15"><b>Youtube :</b></div>
										<div class="col-sm-8">
											<div class="form-group">
												<input type="url" class="form-control" id="txtYoutube" value="{{$Company['youtube']}}">
												<div class="errors" id="txtYoutube-err"></div>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-sm-4 pt-15"><b>Instagram :</b></div>
										<div class="col-sm-8">
											<div class="form-group">
												<input type="url" class="form-control" id="txtInstagram" value="{{$Company['instagram']}}">
												<div class="errors" id="txtInstagram-err"></div>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-sm-4 pt-15"><b>LinkedIn :</b></div>
										<div class="col-sm-8">
											<div class="form-group">
												<input type="url" class="form-control" id="txtLinkedIn" value="{{$Company['linkedin']}}">
												<div class="errors" id="txtLinkedIn-err"></div>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-sm-4 pt-15"><b>3d Map URL :</b></div>
										<div class="col-sm-8">
											<div class="form-group">
												<input type="url" class="form-control" id="txt3dMapLink" value="{{$Company['3d-map-link']}}">
												<div class="errors" id="txt3dMapLink-err"></div>
											</div>
										</div>
									</div>
                                </div>
                                <div class="tab-pane fade" id="pills-meta-links" role="tabpanel" aria-labelledby="pills-meta-links-tab">
									@foreach ($MetaData as $item)
										<div class="accordion" id="accordionExample{{$item->Slug}}" data-slug="{{$item->Slug}}">
											<div class="accordion-item my-2">
												<h2 class="accordion-header" id="heading{{$item->Slug}}">
													<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$item->Slug}}" aria-expanded="false" aria-controls="collapse{{$item->Slug}}">
														{{$item->Title}}
													</button>
												</h2>
												<div id="collapse{{$item->Slug}}" class="accordion-collapse collapse" aria-labelledby="heading{{$item->Slug}}" data-bs-parent="#accordionExample{{$item->Slug}}">
													<div class="accordion-body">
														<!-- Title input -->
														<div class="form-row">
															<div class="col-sm-4 pt-15"><b>Title :</b></div>
															<div class="col-sm-8">
																<div class="form-group">
																	<input type="text" class="form-control txtTitle" id="title{{$item->Slug}}" value="{{ $item->MetaTitle }}" placeholder="Enter Title">
																	<div class="errors err-sm" id="title{{$item->Slug}}-err"></div>
																</div>
															</div>
														</div>
														<!-- Meta Description input -->
														<div class="form-row mt-3">
															<div class="col-sm-4 pt-15"><b>Meta Description :</b></div>
															<div class="col-sm-8">
																<div class="form-group">
																	<textarea class="form-control txtDescription" id="description{{$item->Slug}}" rows="3" placeholder="Enter Meta Description">{{ $item->Description }}</textarea>
																	<div class="errors err-sm" id="description{{$item->Slug}}-err"></div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									@endforeach
                                </div>
                            </div>
                        </div>
					</div>
				</div>
                <div class="card-footer">
					<div class="form-row">
                        <div class="col-sm-12 text-right">
                            @if($crud['edit']==true)
                                <button class="btn btn-outline-success btn-sm" id="btnUpdate" type="button" >Update</button>
                            @endif
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function(){
        const appInit=()=>{
        }
        const getData=async ()=>{
			$('.errors').html('');
			let status = true;
            let activeTab=$('ul.settings li.nav-item a.nav-link.active').attr('id');
            let formData=new FormData();
            if(activeTab=="pills-map-tab"){
                formData.append('sType','map');
                let enableStatus=$('#chkEmbedMap').prop('checked')?1:0;
                formData.append('google-map-status',enableStatus);
                formData.append('google-embed-map',$('#txtMapEmbedUrl').val());
            }else if(activeTab=="pills-social-media-links-tab"){
                formData.append('sType','social-media-links');
                formData.append('facebook',$('#txtfacebook ').val());
                formData.append('twitter',$('#txtTwitter ').val());
                formData.append('instagram',$('#txtInstagram ').val());
                formData.append('youtube',$('#txtYoutube ').val());
                formData.append('linkedin',$('#txtLinkedIn ').val());
                formData.append('3d-map-link',$('#txt3dMapLink ').val());
            }else if(activeTab=="pills-general-tab"){
                formData.append('sType','general');
				formData.append('date-format',$('#lstDateFormat').val());
				formData.append('time-format',$('#lstTimeFormat').val());
				formData.append('price-decimals',$('#lstPrice').val());
				formData.append('percentage-decimals',$('#lstPercentage').val());
				formData.append('upload-limit',$('#txtImgUploadSize').val()+$('#lstImgUploadSizeType').val());
				formData.append('home-page-loading-text',$('#txtLoadingText').val());
				formData.append('home-page-loading-text-font-size',$('#lstLoadingTextSize').val());
            }else if(activeTab=="pills-meta-links-tab"){
				let MetaData = [];

				$('.accordion').each(function () {
					let slug = $(this).data('slug');
					let title = $(this).find('.txtTitle').val().trim();
					let description = $(this).find('.txtDescription').val().trim();
					let accordionCollapse = $(this).find('.accordion-collapse');
					let isTitle = true;
					let isDesc = true;

					/* if (!title) {
						$(this).find('.txtTitle').next('.errors').text('Title is required');isTitle = false;status = false;
					} else if (title.length < 3) {
						$(this).find('.txtTitle').next('.errors').text('Title must be at least 3 characters');isTitle = false;status = false;
					} else if (title.length > 50) {
						$(this).find('.txtTitle').next('.errors').text('Title must be below 50 characters');isTitle = false;status = false;
					}

					if (!description) {
						$(this).find('.txtDescription').next('.errors').text('Description is required');isDesc = false;status = false;
					} else if (description.length < 3) {
						$(this).find('.txtDescription').next('.errors').text('Description must be at least 3 characters');isDesc = false;status = false;
					} else if (description.length > 100) {
						$(this).find('.txtDescription').next('.errors').text('Description must be below 100 characters');isDesc = false;status = false;
					}
					
					if(!isTitle){
						accordionCollapse.collapse('show');
						$(this).find('.txtTitle').focus();
						return false;
					}else if(!isDesc){
						accordionCollapse.collapse('show');
						$(this).find('.txtDescription').focus();
						return false;
					}else if(isTitle && isDesc){
						let Data = {
							Slug: slug,
							MetaTitle: title,
							Description: description
						};
						MetaData.push(Data);
					} */
					status = true;
					let Data = {
						Slug: slug,
						MetaTitle: title,
						Description: description
					};
					MetaData.push(Data);
				});
				
                formData.append('sType','meta');
                formData.append('MetaData',JSON.stringify(MetaData));
            }
            return { status, formData};
        }
        $(document).on('change','#txtMapEmbedUrl',function(){
            $('#google-map').attr('src',$('#txtMapEmbedUrl').val());
        })
        $(document).on('keyup','#txtMapEmbedUrl',function(){
            $('#google-map').attr('src',$('#txtMapEmbedUrl').val());
        })
        $(document).on('click','#chkEmbedMap',function(){
            if($('#chkEmbedMap').prop('checked')){
                $('.mapStatus').show(1000);
            }else{
                $('.mapStatus').hide(1000);
            }
        });
        $(document).on('click','#btnUpdate',async function(){
            
			let { status, formData} = await getData();
			if(status){
				swal({
					title: "Are you sure?",
					text: "do want update this settings!",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-outline-success",
					confirmButtonText: "Yes, Update it!",
					closeOnConfirm: false
				},
				function(){
					swal.close();
					btnLoading($('#btnUpdate'));
					$.ajax({
						type:"post",
						url:"{{url('/')}}/admin/settings/general",
						headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
						data:formData,
						cache: false,
						processData: false,
						contentType: false,
						error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
						complete: function(e, x, settings, exception){btnReset($('#btnUpdate'));ajaxIndicatorStop();},
						success:function(response){
							document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
							if(response.status==true){
								
								toastr.success(response.message, "Success", {
									positionClass: "toast-top-right",
									containerId: "toast-top-right",
									showMethod: "slideDown",
									hideMethod: "slideUp",
									progressBar: !0
								})   
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
			}
        });
        appInit();
    });
</script>
@endsection