@extends('layouts.app')
@section('content')
    <style>
        .dropify-wrapper {
            height: 300px;
        }

        .cropper {
            min-height: 300px
        }
    </style>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}/admin"><i class="f-16 fa fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ url('/') }}/admin/home/gallery">{{ $PageTitle }}</a>
                        </li>
                        <li class="breadcrumb-item">Upload</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-40">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-5 col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row" id="divAdd">
                            <div class="col-sm-12 text-center">
                                <label>Gallery Image <span class="fs-13" style="color:rgba(0,0,0,0.75)"></span></label>
                                <input type="file" class="dropify imageScrop" id="txtBanner"
                                    data-default-file="<?php if ($isEdit == true) {
                                        if ($EditData[0]->GalleryImage != '') {
                                            echo url('/') . '/' . $EditData[0]->GalleryImage;
                                        }
                                    } ?>" data-allowed-file-extensions="jpeg jpg png gif">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-12 text-left">
                                <label for="">Select Gallery</label>
                                <select class="form-control select2" id="lstGallery">
                                    <!-- Placeholder option -->
                                    <option value="" disabled selected>Select a Gallery</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="card-footer">

                        <div class="row">
                            <div class="col-sm-12 text-right">
                                @if ($crud['view'] == 1)
                                    <a href="{{ url('/') }}/admin/home/gallery"
                                        class="btn btn-sm btn-outline-dark mr-10">Cancel</a>
                                @endif
                                @if ($crud['edit'] == 1 || $crud['add'] == 1)
                                    <button class="btn btn-sm btn-outline-success btn-air-success" id="btnUpload">upload
                                    </button>
                                @endif
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
                                <button class="btn btn-outline-primary" type="button" data-method="rotate" data-option="45"
                                    title="Rotate Right"><span class="docs-tooltip" data-bs-toggle="tooltip"
                                        data-animation="false" title="$().cropper(&quot;rotate&quot;, 45)"><span
                                            class="fa fa-rotate-right"></span></span>
                                    <div class="fs-12"> </div>
                                </button>
                                <button class="btn btn-outline-primary" type="button" data-method="scaleX" data-option="-1"
                                    title="Flip Horizontal"><span class="docs-tooltip" data-bs-toggle="tooltip"
                                        data-animation="false" title="$().cropper(&quot;scaleX&quot;, -1)"><span
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
                                <!--<button class="btn btn-outline-warning btn-upload" id="btnUploadImage" title="Upload image file"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="Import image with Blob URLs"><span class="fa fa-upload"></span></span><div class="fs-12"></div></button>-->
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
        const getData = () => {
            let formData = new FormData();
            if ($('#txtBanner')[0].files.length > 0) {
                formData.append('galleryImage', $('#txtBanner')[0].files[0]);
            }
            formData.append('GalleryID', $('#lstGallery').val());
            return formData;
        }

        $(document).on('click', '#btnUpload', function() {
            // Check if it's in edit view
            var isEdit = "{{ $isEdit }}";

            // Check if it's in create view and if the image file is not selected
            if (!isEdit && $('#txtBanner').val() == "") {
                toastr.error('Image not selected', "Failed", {
                    positionClass: "toast-top-right",
                    containerId: "toast-top-right",
                    showMethod: "slideDown",
                    hideMethod: "slideUp",
                    progressBar: !0
                });
                return; // Exit the function early
            }

            // Proceed with confirmation dialog
            swal({
                title: "Are you sure?",
                text: "You want " + (isEdit ? "Update" : "Save") + " this gallery!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-success",
                confirmButtonText: "Yes, " + (isEdit ? "Update" : "Save") + " it!",
                closeOnConfirm: false
            }, function() {
                swal.close();
                btnLoading($('#btnUpload'));
                let formData = getData();
                let posturl = isEdit ? "{{ url('/') }}/admin/home/gallery/edit/{{ isset($ID) ? $ID : '' }}" : "{{ url('/') }}/admin/home/gallery/upload";
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
                    beforeSend: function() {
                        ajaxIndicatorStart("Please wait Upload Process on going.");
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
                        document.documentElement.scrollTop =0; // For Chrome, Firefox, IE and Opera
                            if (response.status == true) {
                                swal({
                                    title: "SUCCESS",
                                    text: response
                                        .message,
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonClass: "btn-outline-success",
                                    confirmButtonText: "Okay",
                                    closeOnConfirm: false
                                },
                                function() {
                                    @if ($isEdit == true)
                                        window
                                            .location
                                            .replace(
                                                "{{ url('/') }}/admin/home/gallery"
                                                );
                                    @else
                                        window
                                            .location
                                            .reload();
                                    @endif
                                });
                            } else {
                                toastr.error(
                                    response
                                    .message,
                                    "Failed", {
                                        positionClass: "toast-top-right",
                                        containerId: "toast-top-right",
                                        showMethod: "slideDown",
                                        hideMethod: "slideUp",
                                        progressBar:
                                            !0
                                    })
                            }
                        
                    }
                });
            });
        });
    });

        /*
        $(document).ready(function() {
            var uploadedImageURL;
            var URL = window.URL || window.webkitURL;
            var $dataRotate = $('#dataRotate');
            var $dataScaleX = $('#dataScaleX');
            var $dataScaleY = $('#dataScaleY');
            var options = {
                dragMode: 'move',
                aspectRatio: 12 / 5,
                cropBoxResizable: true,
                preview: '.img-preview'
            };
            var $image = $('#ImageCrop').cropper(options);
            $('#ImgCrop').modal({backdrop: 'static',keyboard: false});
            $('#ImgCrop').modal('hide');
            $(document).on('change', '.imageScrop', function() {
                let id = $(this).attr('id');
                setTimeout(() => {
                    
                    if($('#'+id).value!=""){

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
                        }
                }, 500);
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
            $('#btnCropCancel').on('click',function(){
                var id = $image.attr('data-id');
                $('#' + id).val("");
                $('#' + id).parent().find('button.dropify-clear').trigger('click');
                $('#ImgCrop').modal('hide');
            });
        });*/
    </script>

    <script>
        $(document).ready(function() {
            // Make an AJAX request to fetch gallery names
            $.ajax({
                type: "GET",
                headers: {
                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                },
                url: "{{ url('/') }}/admin/home/gallery/get-gallery-name/",
                success: function(response) {
                    // Clear existing options
                    $("#lstGallery").empty();

                    // Append new options
                    $.each(response, function(index, gallery) {
                        $("#lstGallery").append($('<option>', {
                            value: gallery.GalleryID,
                            text: gallery.GalleryName
                        }));
                    });

                    // Prevent deselection of default option
                    $("#lstGallery").change(function() {
                        $(this).find("option[value='']").prop("disabled", true);
                    });

                    // Preselect option based on PHP logic

                    <?php if ($isEdit && isset($EditData[0]->GalleryID)) { ?>
                    var selectedGalleryID = "<?php echo $EditData[0]->GalleryID; ?>";
                    $("#lstGallery").val(selectedGalleryID);
                    <?php } ?>
                },
                error: function(xhr, status, error) {
                    // Handle error response if needed
                }
            });
        });
    </script>
@endsection
