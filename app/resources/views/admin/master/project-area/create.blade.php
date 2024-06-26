@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}/admin"><i class="f-16 fa fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item"><a
                                href="{{ url('/') }}/admin/master/project-area">{{ $PageTitle }}</a></li>
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
            <div class="col-sm-5 col-12">
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
                                <div class="row  d-flex justify-content-center">
                                    <div class="col-sm-7">
                                        <input type="file" id="txtProjectAreaImage" class="imageScrop"
                                            data-max-file-size="{{ $Settings['upload-limit'] }}"
                                            data-default-file="<?php if ($isEdit == true) {
                                                if ($EditData[0]->ProjectAreaImage != '') {
                                                    echo url('/') . '/' . $EditData[0]->ProjectAreaImage;
                                                }
                                            } ?>"
                                            data-allowed-file-extensions="jpeg jpg png gif"
                                            data-is-cover-image="1" />
                                        <span class="errors" id="txtProjectAreaImage-err"></span>
                                    </div>
                                </div>
                                <div class="row mt-20">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtProjectAreaName">Project Area Name <span
                                                    class="required">*</span></label>
                                            <input type="text" id="txtProjectAreaName" class="form-control"
                                                placeholder="Project Area Name" value="<?php if ($isEdit == true) {
                                                    echo $EditData[0]->ProjectAreaName;
                                                } ?>">
                                            <span class="errors err-sm" id="txtProjectAreaName-err"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="lstProjectType">Project Type <span class="required">*</span></label>
                                            <select class="form-control" id="lstProjectType">
                                                <option value="Commercial"
                                                    @if ($isEdit == true) @if ($EditData[0]->ProjectType == 'Commercial') selected @endif
                                                    @endif >Commercial</option>
                                                <option value="Residential"
                                                    @if ($isEdit == true) @if ($EditData[0]->ProjectType == 'Residential') selected @endif
                                                    @endif>Residential</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
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
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-12 text-right">
                                        @if ($crud['view'] == 1)
                                            <a href="{{ url('/') }}/admin/master/project-area"
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
                aspectRatio: 700/1167,
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

            
            $('#txtProjectAreaImage').dropify({
                showRemove: false
            });
            
            const SUploadImages = async () => {
                let uploadImages = await new Promise((resolve, reject) => {
                    ajaxIndicatorStart("% Completed. Please wait until the upload gets complete.");
                    setTimeout(() => {
                        let count = $("input.imageScrop").length;
                        let completed = 0;
                        let rowIndex = 0;
                        let images = {
                            coverImg: {
                                uploadPath: "",
                                fileName: ""
                            },
                            gallery: []
                        };
                        
                        const uploadComplete = async (e, x, settings, exception) => {
                            completed++;
                            let percentage = (100 * completed) / count;
                            $('#divProcessText').html(percentage +'% Completed. Please wait until the upload gets complete.');
                            checkUploadCompleted();
                        };

                        const checkUploadCompleted = async () => {
                            if (count <= completed) {
                                ajaxIndicatorStop();
                                resolve(images);
                            }
                        };

                        const upload = async (formData) => {
                            $.ajax({
                                type: "post",
                                url: "{{ url('/') }}/admin/tmp/upload-image",
                                headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                                data: formData,
                                dataType: "json",
                                error: function(e, x, settings, exception) {ajaxErrors(e, x, settings,exception);},
                                complete: uploadComplete,
                                success: function(response) {
                                    if (response.referData.isCoverImage == 1) {
                                        images.coverImg = {
                                            uploadPath: response.uploadPath,
                                            fileName: response.fileName
                                        };
                                    } else {
                                        images.gallery.push({
                                            uploadPath: response.uploadPath,
                                            fileName: response.fileName,
                                            slno: response.referData.slno
                                        });
                                    }
                                    console.log(images);
                                }
                            });
                        };

                        // Loop through each imageScrop input
                        $("input.imageScrop").each(function(index) {
                            let id = $(this).attr('id');
                            if ($('#' + id).val() != "") {
                                rowIndex++;
                                let formData = {};
                                formData.image = $('#' + id).attr('src');
                                formData.referData = {
                                    index: rowIndex,
                                    id: id,
                                    slno: $('#' + id).attr('data-slno'),
                                    isCoverImage: $('#' + id).attr('data-is-cover-image')};
                                upload(formData);
                            } else {
                                completed++;
                                let percentage = (100 * completed) / count;
                                $('#divProcessText').html(percentage +'% Completed. Please wait until the upload gets complete.');
                                checkUploadCompleted();
                            }
                        });
                    }, 200);
                });
                return uploadImages;
            };
            const formValidation = () => {
                $('.errors').html('')
                let ProjectAreaName = $('#txtProjectAreaName').val();
                let status = true;
                if (ProjectAreaName == "") {
                    $('#txtProjectAreaName-err').html('Project Area is required');
                    status = false;
                } else if (ProjectAreaName.length < 2) {
                    $('#txtProjectAreaName-err').html('The Project Area is must be greater than 2 characters.');
                    status = false;
                } else if (ProjectAreaName.length > 100) {
                    $('#txtProjectAreaName-err').html('The Project Area is not greater than 100 characters.');
                    status = false;
                }
                return status;
            }
            const getData = async() => {
                let tmp = await SUploadImages();
                let formData = new FormData();
                formData.append('ProjectAreaName', $('#txtProjectAreaName').val());
                formData.append('ProjectType', $('#lstProjectType').val());
                formData.append('ActiveStatus', $('#lstActiveStatus').val());
                if ($('#txtProjectAreaImage').val() != "") {
                    formData.append('Images', JSON.stringify(tmp));
                }
                return formData;
            }
            $(document).on('click', '#btnSave', async function() {
                let status = formValidation();
                if (status) {
                    const formData = await getData();
                    swal({
                            title: "Are you sure?",
                            text: "You want @if ($isEdit == true)Update @else Save @endif this Project Area!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn-outline-success",
                            confirmButtonText: "Yes, @if ($isEdit == true)Update @else Save @endif it!",
                            closeOnConfirm: false
                        },
                        function() {
                            swal.close();
                            btnLoading($('#nextBtn'));
                            @if ($isEdit)
                                let posturl =
                                    "{{ url('/') }}/admin/master/project-area/edit/{{ $ProjectAreaID }}";
                            @else
                                let posturl =
                                "{{ url('/') }}/admin/master/project-area/create";
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
                                                    "{{ url('/') }}/admin/master/project-area/");
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
                                                if (key == "ProjectAreaName") {
                                                    $('#txtProjectAreaName-err')
                                                        .html(KeyValue);
                                                }
                                                if (key == "ProjectAreaImage") {
                                                    $('#txtProjectAreaImage-err')
                                                        .html(KeyValue);
                                                }
                                            });
                                        }
                                    }
                                }
                            });
                        });
                }
            });
        });
    </script>
@endsection
