@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}/admin"><i class="f-16 fa fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ url('/') }}/admin/master/clients">Clients</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ url('/') }}/admin/master/clients">{{ $PageTitle }}</a></li>
                        <li class="breadcrumb-item">
                            @if ($isEdit) Update
                            @else
                                Create @endif
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-40">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-7">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header text-center">
                                <div class="form-row align-items-center">
                                    <div class="col-md-4"> </div>
                                    <div class="col-md-4 my-2">
                                        <h5>{{ $PageTitle }}</h5>
                                    </div>
                                    <div class="col-md-4 my-2 text-right text-md-right"></div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-sm-4">
                                        <input type="file" id="txtProfileImage" class="imageScrop" data-max-file-size="{{ $Settings['upload-limit'] }}" data-is-profile-image="1" data-default-file="<?php if ($isEdit == true) { if ($EditData[0]->ProfileImage != '') { echo url('/') . '/' . $EditData[0]->ProfileImage; } } ?>" data-allowed-file-extensions="jpeg jpg png gif" />
                                        <span class="errors" id="txtProfileImage-err"></span>
                                    </div>
                                </div>
                                <div class="row mt-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtName">Client Name <span class="required">*</span></label>
                                            <input type="text" id="txtName" class="form-control" placeholder="Name" value="<?php if ($isEdit == true) { echo $EditData[0]->Name; } ?>">
                                            <span class="errors err-sm" id="txtName-err"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lstClientType">Client Type </label>
                                            <select class="form-control" id="lstClientType">
                                                <option value="Owner" @if($isEdit && $EditData[0]->ClientType == 'Owner') selected @endif>Owner</option>
                                                <option value="Company" @if($isEdit && $EditData[0]->ClientType == 'Company') selected @endif>Company</option>
                                            </select>   
                                            <span class="errors  err-sm" id="lstClientType-err"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtAddress">Address </label>
                                            <textarea class="form-control" placeholder="Address" id="txtAddress" name="Address" rows="3"><?php if ($isEdit == true) {
                                                echo $EditData[0]->Address;
                                            } ?></textarea>
                                            <span class="errors err-sm" id="txtAddress-err"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lstCountry">Country <span class="required">*</span></label>
                                            <select class="form-control select2" id="lstCountry"
                                                data-selected="<?php if ($isEdit) {
                                                    echo $EditData[0]->CountryID;
                                                } else {
                                                    echo $Company['CountryID'];
                                                } ?>">
                                                <option value="">Select a Country</option>
                                            </select>
                                            <span class="errors err-sm" id="lstCountry-err"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lstState">State <span class="required">*</span></label>
                                            <select class="form-control select2" id="lstState"
                                                data-selected="<?php if ($isEdit) {
                                                    echo $EditData[0]->StateID;
                                                } else {
                                                    echo $Company['StateID'];
                                                } ?>">
                                                <option value="">Select a State</option>
                                            </select>
                                            <span class="errors err-sm" id="lstState-err"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lstCity">City <span class="required">*</span></label>
                                            <select class="form-control select2" id="lstCity"
                                                data-selected="<?php if ($isEdit) {
                                                    echo $EditData[0]->CityID;
                                                } else {
                                                    echo $Company['CityID'];
                                                } ?>">
                                                <option value="">Select a City</option>
                                            </select>
                                            <span class="errors err-sm" id="lstCity-err"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lstPostalCode">Postal Code <span class="required">*</span></label>
                                            <select class="form-control select2Tag" id="lstPostalCode"
                                                data-selected="<?php if ($isEdit) {
                                                    echo $EditData[0]->PostalCodeID;
                                                } else {
                                                    echo $Company['PostalCodeID'];
                                                } ?>">
                                                <option value="">Select a Postal Code Or enter</option>
                                            </select>
                                            <span class="errors err-sm" id="lstPostalCode-err"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lstGender">Gender </label>
                                            <select class="form-control select2" id="lstGender"
                                                data-selected="<?php if ($isEdit) {
                                                    echo $EditData[0]->GenderID;
                                                } ?>">
                                                <option value="">Select a Gender</option>
                                            </select>
                                            <span class="errors err-sm" id="lstGender-err"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtEmail">Email</label>
                                            <input type="email" id="txtEmail" class="form-control" placeholder="E-Mail" value="<?php if ($isEdit == true) { echo $EditData[0]->EMail; } ?>">
                                            <span class="errors err-sm" id="txtEmail-err"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtMobileNumber"> MobileNumber <span class="fs-10 fw-500"
                                                    style="color:#ab9898">(Client Name) </span><span
                                                    class="required">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"
                                                        id="CallCode">+91</span></div>
                                                <input type="number" @if ($isEdit) disabled @endif
                                                    id="txtMobileNumber" class="form-control" data-length="0"
                                                    placeholder="Mobile Number enter without country code"
                                                    value="<?php if ($isEdit == true) {
                                                        echo $EditData[0]->MobileNumber;
                                                    } ?>">
                                            </div>

                                            <span class="errors err-sm" id="txtMobileNumber-err"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lstActiveStatus">Active Status</label>
                                            <select class="form-control" id="lstActiveStatus">
                                                <option value="1"
                                                    @if ($isEdit == true) @if ($EditData[0]->ActiveStatus == '1') selected @endif
                                                    @endif >Active</option>
                                                <option value="0"
                                                    @if ($isEdit == true) @if ($EditData[0]->ActiveStatus == '0') selected @endif
                                                    @endif>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-sm-4">
                                                <label for="txtTestimonial">Testimonial Thumbnail</label>
                                                <input type="file" id="txtThumbnail" class="dropify" data-max-file-size="{{ $Settings['upload-limit'] }}" data-remove="0" data-is-cover-image="1" data-default-file="<?php if ($isEdit == true) { if ($EditData[0]->Thumbnail != '') { echo url('/') . '/' . $EditData[0]->Thumbnail; } } ?>" data-allowed-file-extensions="jpeg jpg png gif" />
                                                <span class="errors" id="txtThumbnail-err"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtTestimonial">Testimonial Video Url </label>
                                            <div class="input-group">
                                                <input type="text" id="txtVideoURL" class="form-control" placeholder="Testimonial Video URL" value="<?php if($isEdit){ echo $EditData[0]->VideoURL;} ?>">
                                                <button class="input-group-text btn-outline-primary px-4 position-relative" id="btnPlayVideo"><i class="fa fa-play"></i></button>
                                            </div>
                                            <span class="errors err-sm" id="txtVideoURL-err"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtTestimonial">Testimonial Content</label>
                                            <textarea class="form-control" placeholder="Testimonial" id="txtTestimonial" name="Testimonial" rows="3"><?php if ($isEdit == true) { echo $EditData[0]->Testimonial; } ?></textarea>
                                            <span class="errors err-sm" id="txtTestimonial-err"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-12 text-right">
                                        @if ($crud['view'] == 1)
                                            <a href="{{ url('/') }}/admin/master/clients"
                                                class="btn btn-sm btn-outline-dark mr-10">Cancel</a>
                                        @endif
                                        @if ($crud['edit'] == 1 || $crud['add'] == 1)
                                            <button class="btn btn-sm btn-outline-success btn-air-success" id="btnSave">
                                                @if ($isEdit) Update
                                                @else
                                                    Create @endif
                                            </button>
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
    
    <div class="modal  medium " tabindex="-1" role="dialog" id="ImgCrop">
        <div class="modal-dialog modal-dialog-centered max-width-50" role="document ">
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
                                <button class="btn btn-outline-primary" type="button" data-method="rotate"
                                    data-option="-45" title="Rotate Left"><span class="docs-tooltip"
                                        data-bs-toggle="tooltip" data-animation="false"
                                        title="$().cropper(&quot;rotate&quot;, -45)"><span
                                            class="fa fa-rotate-left"></span></span>
                                    <div class="fs-12"></div>
                                </button>
                                <button class="btn btn-outline-primary" type="button" data-method="rotate"
                                    data-option="45" title="Rotate Right"><span class="docs-tooltip"
                                        data-bs-toggle="tooltip" data-animation="false"
                                        title="$().cropper(&quot;rotate&quot;, 45)"><span
                                            class="fa fa-rotate-right"></span></span>
                                    <div class="fs-12"> </div>
                                </button>
                                <button class="btn btn-outline-primary" type="button" data-method="scaleX"
                                    data-option="-1" title="Flip Horizontal"><span class="docs-tooltip"
                                        data-bs-toggle="tooltip" data-animation="false"
                                        title="$().cropper(&quot;scaleX&quot;, -1)"><span
                                            class="fa fa-arrows-h"></span></span>
                                    <div class="fs-12"></div>
                                </button>
                                <button class="btn btn-outline-primary" type="button" data-method="scaleY"
                                    data-option="-1" title="Flip Vertical"><span class="docs-tooltip"
                                        data-bs-toggle="tooltip" data-animation="false"
                                        title="$().cropper(&quot;scaleY&quot;, -1)"><span
                                            class="fa fa-arrows-v"></span></span>
                                    <div class="fs-12"></div>
                                </button>
                                <button class="btn btn-outline-primary" type="button" data-method="reset"
                                    title="Reset"><span class="docs-tooltip" data-bs-toggle="tooltip"
                                        data-animation="false" title="$().cropper(&quot;reset&quot;)"><span
                                            class="fa fa-refresh"></span></span>
                                    <div class="fs-12"></div>
                                </button>
                                <button class="btn btn-outline-warning btn-upload" id="btnUploadImage"
                                    title="Upload image file"><span class="docs-tooltip" data-bs-toggle="tooltip"
                                        data-animation="false" title="Import image with Blob URLs"><span
                                            class="fa fa-upload"></span></span>
                                    <div class="fs-12"></div>
                                </button>
                                <input class="sr-only display-none" id="inputImage" type="file" name="file"
                                    accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" id="btnCropCancel">Cancel</button>
                    <button type="button" class="btn btn-outline-info" id="btnCropApply">Apply</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
           var uploadedImageURL;
           var URL = window.URL || window.webkitURL;
           var $dataRotate = $('#dataRotate');
           var $dataScaleX = $('#dataScaleX');
           var $dataScaleY = $('#dataScaleY');
           var options = {
               aspectRatio: 1,
               preview: '.img-preview'
           };
           var $image = $('#ImageCrop').cropper(options);
           $('#ImgCrop').modal({
               backdrop: 'static',
               keyboard: false
           });
           $('#ImgCrop').modal('hide');
           $(document).on('change', '.imageScrop', function() {
               let id = $(this).attr('id');
               $image.attr('data-id', id);
               var files = this.files;
               if (files && files.length) {

                   $('#ImgCrop').modal('show');
                   file = files[0];
                   if (/^image\/\w+$/.test(file.type)) {
                       uploadedImageName = file.name;
                       uploadedImageType = file.type;
                       if (uploadedImageURL) {
                           URL.revokeObjectURL(uploadedImageURL);
                       }
                       uploadedImageURL = URL.createObjectURL(file);
                       $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
                   } else {
                       window.alert('Please choose an image file.');
                   }
               }
           });
           $('.docs-buttons').on('click', '[data-method]', function() {
               var $this = $(this);
               var data = $this.data();
               var cropper = $image.data('cropper');
               var cropped;
               var $target;
               var result;
               if (cropper && data.method) {
                   data = $.extend({}, data);
                   if (typeof data.target !== 'undefined') {
                       $target = $(data.target);
                       if (typeof data.option === 'undefined') {
                           try {
                               data.option = JSON.parse($target.val());
                           } catch (e) {
                               console.log(e.message);
                           }
                       }
                   }
                   cropped = cropper.cropped;
                   switch (data.method) {
                       case 'rotate':
                           if (cropped && options.viewMode > 0) {
                               $image.cropper('clear');
                           }
                           break;
                       case 'getCroppedCanvas':
                           if (uploadedImageType === 'image/jpeg') {
                               if (!data.option) {
                                   data.option = {};
                               }
                               data.option.fillColor = '#fff';
                           }
                           break;
                   }
                   result = $image.cropper(data.method, data.option, data.secondOption);
                   switch (data.method) {
                       case 'rotate':
                           if (cropped && options.viewMode > 0) {
                               $image.cropper('crop');
                           }
                           break;
                       case 'scaleX':
                       case 'scaleY':
                           $(this).data('option', -data.option);
                           break;
                       case 'getCroppedCanvas':
                           if (result) {
                               $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);
                               if (!$download.hasClass('disabled')) {
                                   download.download = uploadedImageName;
                                   $download.attr('href', result.toDataURL(uploadedImageType));
                               }
                           }
                           break;
                   }
               }
           });
           $('#inputImage').change(function() {
               var files = this.files;
               var file;
               if (!$image.data('cropper')) {
                   return;
               }
               if (files && files.length) {
                   file = files[0];
                   if (/^image\/\w+$/.test(file.type)) {
                       uploadedImageName = file.name;
                       uploadedImageType = file.type;
                       if (uploadedImageURL) {
                           URL.revokeObjectURL(uploadedImageURL);
                       }
                       uploadedImageURL = URL.createObjectURL(file);
                       $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
                       $('#inputImage').val('');
                   } else {
                       window.alert('Please choose an image file.');
                   }
               }
           });
           $(document).on('click', '#btnUploadImage', function() {
               $('#inputImage').trigger('click')
           });
           $("#btnCropApply").on('click', function() {
               btnLoading($('#btnCropApply'));
               setTimeout(() => {
                   var base64 = $image.cropper('getCroppedCanvas').toDataURL();
                   var id = $image.attr('data-id');
                   $('#' + id).attr('src', base64);
                   $('#' + id).parent().find('img').attr('src', base64)

                   $('#ImgCrop').modal('hide');
                   setTimeout(() => {
                       btnReset($('#btnCropApply'));
                   }, 100);
               }, 100);
           });
           $('#btnCropCancel').on('click', function() {
               var id = $image.attr('data-id');
               $('#' + id).val("");
               $('#' + id).parent().find('button.dropify-clear').trigger('click');
               $('#ImgCrop').modal('hide');
           });
       });
   </script>
    <script>
        $(document).ready(function() {

            $('#btnPlayVideo').on('click', function() {
                $('#txtVideoURL-err').html('');
                var Url = $('#txtVideoURL').val();
                if(!Url){
                    $('#txtVideoURL-err').html('Enter an URL!')
                }else{
                    var embedUrl = Url;
                    if(isYouTubeUrl(Url)){
                        var videoId = extractYouTubeVideoId(Url);
                        embedUrl = 'https://www.youtube.com/embed/' + videoId;
                    }
        
                    var videoPlayerHtml = '<iframe width="100%" height="400" src="' + embedUrl + '" frameborder="0" allowfullscreen></iframe>';
                    
                    bootbox.dialog({
                        title: 'Video Player',
                        message: videoPlayerHtml,
                        className: 'video-modal',
                        closeButton: true,
                    }).find('.modal-dialog').css('--bs-modal-width', '900px');
                }
            });

            $(document).on('click','.dropify-clear',function(){
                $(this).parent().find('input[type="file"]').attr('data-remove',1);
            });
        
            $(document).on('change', '#txtThumbnail', function() {
                if (this.files && this.files.length > 0) {
                    $(this).attr('data-remove', 0);
                }
            });
            function extractYouTubeVideoId(url) {
                var videoIdMatch = url.match(/[?&]v=([^&]+)/);
                return videoIdMatch ? videoIdMatch[1] : null;
            }
            function isYouTubeUrl(url) {
                return /^(https?:\/\/)?(www\.)?(youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/i.test(url);
            }
            const appInit = async () => {
                getCountry();
                getGender();

                $('#txtProfileImage').dropify({
                    showRemove: false
                });
            }

            const getGender = async () => {
                $.ajax({
                    type: "post",
                    url: "{{ url('/') }}/get/gender",
                    headers: {
                        'X-CSRF-Token': $('meta[name=_token]').attr('content')
                    },
                    dataType: "json",
                    async: true,
                    error: function(e, x, settings, exception) {
                        ajaxErrors(e, x, settings, exception);
                    },
                    complete: function(e, x, settings, exception) {},
                    success: function(response) {
                        $('#lstGender').select2('destroy');
                        $('#lstGender option').remove();
                        $('#lstGender').append(
                            '<option value="" selected>Select a Gender</option>');
                        for (let Item of response) {
                            let selected = "";
                            if (Item.GID == $('#lstGender').attr('data-selected')) {
                                selected = "selected";
                            }
                            $('#lstGender').append('<option ' + selected + ' value="' + Item
                                .GID + '">' + Item.Gender + ' </option>');
                        }
                        $('#lstGender').select2();
                    }
                });
            }
            const getCountry = async () => {
                $.ajax({
                    type: "post",
                    url: "{{ url('/') }}/get/country",
                    headers: {
                        'X-CSRF-Token': $('meta[name=_token]').attr('content')
                    },
                    dataType: "json",
                    async: true,
                    error: function(e, x, settings, exception) {
                        ajaxErrors(e, x, settings, exception);
                    },
                    complete: function(e, x, settings, exception) {},
                    success: function(response) {
                        $('#lstCountry').select2('destroy');
                        $('#lstCountry option').remove();
                        $('#lstCountry').append(
                            '<option value="" selected>Select a Country</option>');
                        for (let Item of response) {
                            let selected = "";
                            if (Item.CountryID == $('#lstCountry').attr('data-selected')) {
                                selected = "selected";
                            }
                            $('#lstCountry').append('<option ' + selected +
                                ' data-phone-code="' + Item.PhoneCode +
                                '" data-phone-length="' + Item.PhoneLength + '" value="' +
                                Item.CountryID + '">' + Item.CountryName + ' ( ' + Item
                                .sortname + ' ) ' + ' </option>');
                        }
                        $('#lstCountry').select2();
                        if ($('#lstCountry').val() != "") {
                            $('#lstCountry').trigger('change');
                        }
                    }
                });
            }
            const getStates = async () => {
                $.ajax({
                    type: "post",
                    url: "{{ url('/') }}/get/states",
                    headers: {
                        'X-CSRF-Token': $('meta[name=_token]').attr('content')
                    },
                    dataType: "json",
                    data: {
                        CountryID: $('#lstCountry').val()
                    },
                    async: true,
                    error: function(e, x, settings, exception) {
                        ajaxErrors(e, x, settings, exception);
                    },
                    complete: function(e, x, settings, exception) {},
                    success: function(response) {
                        $('#lstState').select2('destroy');
                        $('#lstState option').remove();
                        $('#lstState').append(
                            '<option value="" selected>Select a State</option>');
                        for (let Item of response) {
                            let selected = "";
                            if (Item.StateID == $('#lstState').attr('data-selected')) {
                                selected = "selected";
                            }
                            $('#lstState').append('<option ' + selected + '  value="' + Item
                                .StateID + '">' + Item.StateName + ' </option>');
                        }
                        $('#lstState').select2();
                        if ($('#lstState').val() != "") {
                            $('#lstState').trigger('change');
                        }
                    }
                });
            }
            const getCity = async () => {
                $.ajax({
                    type: "post",
                    url: "{{ url('/') }}/get/city",
                    headers: {
                        'X-CSRF-Token': $('meta[name=_token]').attr('content')
                    },
                    dataType: "json",
                    data: {
                        CountryID: $('#lstCountry').val(),
                        StateID: $('#lstState').val()
                    },
                    async: true,
                    error: function(e, x, settings, exception) {
                        ajaxErrors(e, x, settings, exception);
                    },
                    complete: function(e, x, settings, exception) {},
                    success: function(response) {
                        $('#lstCity').select2('destroy');
                        $('#lstCity option').remove();
                        $('#lstCity').append(
                            '<option value="" selected>Select a City</option>');
                        for (let Item of response) {
                            let selected = "";
                            if (Item.CityID == $('#lstCity').attr('data-selected')) {
                                selected = "selected";
                            }
                            $('#lstCity').append('<option ' + selected + '  value="' + Item
                                .CityID + '">' + Item.CityName + ' </option>');
                        }
                        $('#lstCity').select2();
                    }
                });
            }
            const getPostalCode = async () => {
                $.ajax({
                    type: "post",
                    url: "{{ url('/') }}/get/postal-code",
                    headers: {
                        'X-CSRF-Token': $('meta[name=_token]').attr('content')
                    },
                    dataType: "json",
                    data: {
                        CountryID: $('#lstCountry').val(),
                        StateID: $('#lstState').val()
                    },
                    async: true,
                    error: function(e, x, settings, exception) {
                        ajaxErrors(e, x, settings, exception);
                    },
                    complete: function(e, x, settings, exception) {},
                    success: function(response) {
                        $('#lstPostalCode').select2('destroy');
                        $('#lstPostalCode option').remove();
                        $('#lstPostalCode').append(
                            '<option value="" selected>Select a Postal Code or Enter</option>'
                        );
                        for (let Item of response) {
                            let selected = "";
                            if (Item.PID == $('#lstPostalCode').attr('data-selected')) {
                                selected = "selected";
                            }
                            $('#lstPostalCode').append('<option ' + selected + '  value="' +
                                Item.PID + '">' + Item.PostalCode + ' </option>');
                        }
                        $('#lstPostalCode').select2({
                            tags: true
                        });
                    }
                });
            }
            const formValidation = () => {
                $('.errors').html('');
                let Name = $('#txtName').val();
                let Gender = $('#lstGender').val();
                let EMail = $('#txtEmail').val();

                let Address = $('#txtAddress').val();
                let Country = $('#lstCountry').val();
                let State = $('#lstState').val();
                let City = $('#lstCity').val();
                let PostalCode = $('#lstPostalCode').val();
                let MobileNumber = $('#txtMobileNumber').val();
                let PhoneLength = $('#lstCountry option:selected').attr('data-phone-length');
                let Thumbnail = $('#txtThumbnail').val();
                let isThumbnailRemoved = $('#txtThumbnail').data('remove');
                let VideoURL = $('#txtVideoURL').val();

                let status = true;
                if (Name == "") {
                    $('#txtName-err').html('Name is required');
                    status = false;
                } else if (Name.length < 2) {
                    $('#txtName-err').html('The Name is must be greater than 2 characters.');
                    status = false;
                } else if (Name.length > 50) {
                    $('#txtName-err').html('The Name is not greater than 50 characters.');
                    status = false;
                }
                if (EMail != "") {
                    if (EMail.isValidEMail() == false) {
                        $('#txtEmail-err').html('E-Mail is not valid');
                        status = false;
                    }
                }
                /* if (Gender == "") {
                    $('#lstGender-err').html('Gender is required');
                    status = false;
                } */

                if (Country == "") {
                    $('#lstCountry-err').html('Country is required');
                    status = false;
                }
                if (State == "") {
                    $('#lstState-err').html('State is required');
                    status = false;
                }
                if (City == "") {
                    $('#lstCity-err').html('City is required');
                    status = false;
                }
                if (PostalCode == "") {
                    $('#lstPostalCode-err').html('Postal Code is required');
                    status = false;
                }
                if (Thumbnail && !VideoURL || isThumbnailRemoved && !VideoURL) {
                    $('#txtVideoURL-err').html('Enter an valid Url');status = false;
                }
                if (MobileNumber == "") {
                    $('#txtMobileNumber-err').html('Mobile Number is required');
                    status = false;
                } else if ($.isNumeric(MobileNumber) == false) {
                    $('#txtMobileNumber-err').html('Mobile Number is must be numeric value');
                    status = false;
                } else if ((parseInt(PhoneLength) > 0) && (parseInt(PhoneLength) != MobileNumber.length)) {
                    $('#txtMobileNumber-err').html('Mobile Number is not valid');
                    status = false;
                }

                return status;
            }
            const getData = async() => {
                let tmp = await UploadImages();
                let formData = new FormData();
                formData.append('Name', $('#txtName').val());
                formData.append('ClientType', $('#lstClientType').val());
                formData.append('Gender', $('#lstGender').val());
                formData.append('ActiveStatus', $('#lstActiveStatus').val());
                formData.append('Address', $('#txtAddress').val());
                formData.append('City', $('#lstCity').val());
                formData.append('StateID', $('#lstState').val());
                formData.append('CountryID', $('#lstCountry').val());
                formData.append('PostalCodeID', $('#lstPostalCode').val());
                formData.append('PostalCode', $('#lstPostalCode option:selected').text());
                formData.append('EMail', $('#txtEmail').val());
                formData.append('MobileNumber', $('#txtMobileNumber').val());
                formData.append('Testimonial', $('#txtTestimonial').val());
                formData.append('VideoURL', $('#txtVideoURL').val());
                formData.append('isThumbnailRemoved', $('#txtThumbnail').data('remove'));          
                formData.append('isThumbnailRemoved', $('#txtThumbnail').attr('data-remove'));                    
          

                if ($('#txtProfileImage').val() != "") {
                    formData.append('ProfileImage', JSON.stringify(tmp.profileImage));                    
                }
                if ($('#txtThumbnail').val() != "") {
                    formData.append('Thumbnail', $('#txtThumbnail')[0].files[0]);
                }
                return formData;
            }
            $(document).on('change', '#lstCountry', function() {
                getStates();
                let CallCode = $('#lstCountry option:selected').attr('data-phone-code');
                if (CallCode != "") {
                    $('#CallCode').html(" ( +" + CallCode + " )");
                }
            });
            $(document).on('change', '#lstState', function() {
                getCity();
                getPostalCode();
            });
            $(document).on('click', '#btnSave', function() {
                let status = formValidation();
                if (status) {
                    swal({
                            title: "Are you sure?",
                            text: "You want @if ($isEdit == true)Update @else Save @endif this Client!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn-outline-success",
                            confirmButtonText: "Yes, @if ($isEdit == true)Update @else Save @endif it!",
                            closeOnConfirm: false
                        },
                        async function() {
                            let formData = await getData();
                            swal.close();
                            btnLoading($('#nextBtn'));
                            @if ($isEdit)
                                let posturl = "{{ url('/') }}/admin/master/clients/edit/{{ $ClientID }}";
                            @else
                                let posturl = "{{ url('/') }}/admin/master/clients/create";
                            @endif
                            $.ajax({
                                type: "post",
                                url: posturl,
                                headers: {
                                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                                },
                                data: formData,
                                cache: false,
                                processData: false,
                                contentType: false,
                                xhr: function() {
                                    var xhr = new window.XMLHttpRequest();
                                    xhr.upload.addEventListener("progress", function(evt) {
                                        if (evt.lengthComputable) {
                                            var percentComplete = (evt.loaded / evt
                                                .total) * 100;
                                            percentComplete = parseFloat(
                                                percentComplete).toFixed(2);
                                            $('#divProcessText').html(
                                                percentComplete +
                                                '% Completed.<br> Please wait for until upload process complete.'
                                            );
                                            //Do something with upload progress here
                                        }
                                    }, false);
                                    return xhr;
                                },
                                beforeSend: function() {
                                    ajaxIndicatorStart(
                                        "Please wait Upload Process on going.");
                                    var percentVal = '0%';
                                    setTimeout(() => {
                                        $('#divProcessText').html(percentVal +
                                            ' Completed.<br> Please wait for until upload process complete.'
                                        );
                                    }, 100);
                                },
                                error: function(e, x, settings, exception) {
                                    ajaxErrors(e, x, settings, exception);
                                },
                                complete: function(e, x, settings, exception) {
                                    btnReset($('#nextBtn'));
                                    ajaxIndicatorStop();
                                },
                                success: function(response) {
                                    document.documentElement.scrollTop =
                                        0; // For Chrome, Firefox, IE and Opera
                                    if (response.status == true) {
                                        swal({
                                            title: "SUCCESS",
                                            text: response.message,
                                            type: "success",
                                            showCancelButton: false,
                                            confirmButtonClass: "btn-outline-success",
                                            confirmButtonText: "Okay",
                                            closeOnConfirm: false
                                        }, function() {
                                            @if ($isEdit == true)
                                                window.location.replace(
                                                    "{{ url('/') }}/admin/master/clients/"
                                                );
                                            @else
                                                window.location.reload();
                                            @endif
                                        });
                                    } else {
                                        toastr.error(response.message, "Failed", {
                                            positionClass: "toast-top-right",
                                            containerId: "toast-top-right",
                                            showMethod: "slideDown",
                                            hideMethod: "slideUp",
                                            progressBar: !0
                                        })
                                        if (response['errors'] != undefined) {
                                            $('.errors').html('');
                                            $.each(response['errors'], function(KeyName,
                                                KeyValue) {
                                                var key = KeyName;
                                                if (key == "Name") {
                                                    $('#txtName-err').html(
                                                        KeyValue);
                                                }
                                                if (key == "ClientType") {
                                                    $('#lstClientType-err').html(
                                                        KeyValue);
                                                }
                                                if (key == "Gender") {
                                                    $('#lstGender-err').html(
                                                        KeyValue);
                                                }

                                                if (key == "Address") {
                                                    $('#txtAddress-err').html(
                                                        KeyValue);
                                                }
                                                if (key == "City") {
                                                    $('#lstCity-err').html(
                                                        KeyValue);
                                                }
                                                if (key == "State") {
                                                    $('#lstState-err').html(
                                                        KeyValue);
                                                }
                                                if (key == "Country") {
                                                    $('#lstCountry-err').html(
                                                        KeyValue);
                                                }
                                                if (key == "PostalCode") {
                                                    $('#lstPostalCode-err').html(
                                                        KeyValue);
                                                }
                                                if (key == "EMail") {
                                                    $('#txtEmail-err').html(
                                                        KeyValue);
                                                }
                                                if (key == "MobileNumber") {
                                                    $('#txtMobileNumber-err').html(
                                                        KeyValue);
                                                }
                                                if (key == "ProfileImage") {
                                                    $('#txtProfileImage-err').html(
                                                        KeyValue);
                                                }
                                                if (key == "ActiveStatus") {
                                                    $('#lstActiveStatus-err').html(
                                                        KeyValue);
                                                }
                                            });
                                        }
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
