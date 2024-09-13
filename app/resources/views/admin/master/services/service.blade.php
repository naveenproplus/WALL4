@extends('layouts.app')
@section('content')
    @php $GalleryCount=1; @endphp
    <style>
        #divGallery .dropify-clear1 {
            display: none !important;
        }

        .modal-title {
            position: relative;
        }
    </style>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}/admin"><i class="f-16 fa fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item"><a
                                href="{{ url('/') }}/admin/master/services">{{ $PageTitle }}</a></li>
                        <li class="breadcrumb-item">
                            @if ($isEdit) Update
                            @else
                                create
                            @endif
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-40">
        <div class="row  d-flex justify-content-center">
            <div class="col-sm-8 ">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header text-center">
                                <div class="form-row align-items-center">
                                    <div class="col-md-4"> </div>
                                    <div class="col-md-4 my-2">
                                        <h5 id="pageTitle">{{ $PageTitle }}</h5>
                                    </div>
                                    <div class="col-md-4 my-2 text-right text-md-right"></div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row   d-flex justify-content-center">
                                    <div class="col-sm-12">
                                        <form class="form-wizard" id="frmUsers" action="#" method="POST">
                                            <div class="tab" data-page="Service Info">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="txtServiceName">Service Name <span
                                                                    class="required">*</span></label>
                                                            <input type="text" class="form-control" id="txtServiceName"
                                                                value="<?php if ($isEdit) {
                                                                    echo $EditData[0]->ServiceName;
                                                                } ?>">
                                                            <div class="errors err-sm ServiceInfo" id="txtServiceName-err">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="txtSlug">Slug <span
                                                                    class="required">*</span></label>
                                                            <input type="text" disabled class="form-control"
                                                                id="txtSlug" value="<?php if ($isEdit) {
                                                                    echo $EditData[0]->Slug;
                                                                } ?>">
                                                            <div class="errors err-sm ServiceInfo" id="txtSlug-err"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="lstCategory">Category <span
                                                                    class="required">*</span></label>
                                                            <select class="form-control select2" id="lstCategory"
                                                                data-selected="<?php if ($isEdit) {
                                                                    echo $EditData[0]->CID;
                                                                } ?>">
                                                                <option value="">Select a Category</option>
                                                            </select>
                                                            <div class="errors err-sm ServiceInfo" id="lstCategory-err">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="txtHSNSAC">HSN / SAC <span
                                                                    class="required">*</span></label>
                                                            <input type="text" class="form-control" id="txtHSNSAC"
                                                                value="<?php if ($isEdit) {
                                                                    echo $EditData[0]->HSNSAC;
                                                                } ?>">
                                                            <div class="errors err-sm ServiceInfo" id="txtHSNSAC-err"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="txtPrice">Price <span
                                                                    class="required">*</span></label>
                                                            <input type="number"
                                                                step="{{ NumberSteps($Settings['price-decimals']) }}"
                                                                class="form-control" id="txtPrice"
                                                                value="<?php if ($isEdit) {
                                                                    echo NumberFormat($EditData[0]->Price, $Settings['price-decimals']);
                                                                } else {
                                                                    echo NumberFormat(0, $Settings['price-decimals']);
                                                                } ?>">
                                                            <div class="errors err-sm ServiceInfo" id="txtPrice-err"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="lstUOM">UOM <span
                                                                    class="required">*</span></label>
                                                            <select class="form-control select2" id="lstUOM"
                                                                data-selected="<?php if ($isEdit) {
                                                                    echo $EditData[0]->UID;
                                                                } ?>">
                                                                <option value="">Select a UOM</option>
                                                            </select>
                                                            <div class="errors err-sm ServiceInfo" id="lstUOM-err"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="lstTax">Tax <span
                                                                    class="required">*</span></label>
                                                            <select class="form-control select2" id="lstTax"
                                                                data-selected="<?php if ($isEdit) {
                                                                    echo $EditData[0]->TaxID;
                                                                } ?>">
                                                                <option value="">Select a Tax</option>
                                                            </select>
                                                            <div class="errors err-sm ServiceInfo" id="lstTax-err"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="lstTaxType">Tax Type <span
                                                                    class="required">*</span></label>
                                                            <select class="form-control select2" id="lstTaxType">
                                                                <option value="Exclude"
                                                                    @if ($isEdit) @if ($EditData[0]->TaxType == 'Exclude') selected @endif
                                                                    @endif>Exclude
                                                                </option>
                                                                <option value="Include"
                                                                    @if ($isEdit) @if ($EditData[0]->TaxType == 'Include') selected @endif
                                                                    @endif>Include
                                                                </option>
                                                            </select>
                                                            <div class="errors err-sm ServiceInfo" id="lstTaxType-err">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Active Status</label>
                                                            <select class="form-control" id="lstActiveStatus">
                                                                <option value="1"
                                                                    @if ($isEdit && $EditData[0]->ActiveStatus == '1') selected @endif>Active
                                                                </option>
                                                                <option value="0"
                                                                    @if ($isEdit && $EditData[0]->ActiveStatus == '0') selected @endif>
                                                                    Inactive</option>
                                                            </select>
                                                            <div class="errors err-sm ServiceInfo"
                                                                id="lstActiveStatus-err">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab mb-20" data-page="Service Descriptions">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="">Title <span class="required">
                                                                    *</span></label>
                                                            <textarea id="txtTitle" class="form-control" rows="2"><?php if ($isEdit) {
                                                                echo $EditData[0]->Title;
                                                            } ?></textarea>
                                                            <div class="errors err-sm ServiceInfo" id="txtTitle-err">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="">Description 1<span class="required">
                                                                    *</span></label>
                                                            <textarea id="txtDescription1" class="form-control" rows="4"><?php if ($isEdit) {
                                                                echo $EditData[0]->Description1;
                                                            } ?></textarea>
                                                            <div class="errors err-sm ServiceInfo"
                                                                id="txtDescription1-err"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="">Description 2<span class="required">
                                                                    *</span></label>
                                                            <textarea id="txtDescription2" class="form-control" rows="4"><?php if ($isEdit) {
                                                                echo $EditData[0]->Description2;
                                                            } ?></textarea>
                                                            <div class="errors err-sm ServiceInfo"
                                                                id="txtDescription2-err"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="">Description 3<span class="required">
                                                                    *</span></label>
                                                            <textarea id="txtDescription3" class="form-control" rows="4"><?php if ($isEdit) {
                                                                echo $EditData[0]->Description3;
                                                            } ?></textarea>
                                                            <div class="errors err-sm ServiceInfo"
                                                                id="txtDescription3-err"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab mb-20" data-page="Service Images">
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col-sm-12 text-center">
                                                        <label>Service Icon</label>
                                                        <div id="iconContainer">
                                                            @foreach ($ServiceIcons as $item)
                                                                @if ($item)
                                                                    <div
                                                                        class="card icon-card @if ($isEdit && $EditData[0]->ServiceIcon == $item) selected @endif">
                                                                        <i class="flaticon-{{ $item }}"
                                                                            data-title="{{ $item }}"></i>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <span class="errors" id="lstServiceIcon-err"></span>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col-sm-4 text-center">
                                                        <label>Cover Image</label>
                                                        <input type="file" id="txtCoverImg" class="dropify imageScrop"
                                                            data-slno="" data-is-cover-image="1"
                                                            data-max-file-size="{{ $Settings['upload-limit'] }}"
                                                            data-default-file="<?php if ($isEdit == true) {
                                                                if ($EditData[0]->ServiceImage != '') {
                                                                    echo url('/') . '/' . $EditData[0]->ServiceImage;
                                                                }
                                                            } ?>"
                                                            data-allowed-file-extensions="jpeg jpg png gif" />
                                                        <span class="errors" id="txtCoverImg-err"></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">Gallery Images</div>
                                                </div>
                                                <div class="row mt-10 justify-content-center" id="divGallery">
                                                    @if ($isEdit)
                                                        @for ($i = 0; $i < count($EditData[0]->GalleryImages); $i++)
                                                            <div class="col-sm-3">
                                                                <div class="row d-flex justify-content-center">
                                                                    <input type="file"
                                                                        id="txtGalleryImg{{ $GalleryCount }}"
                                                                        class="dropify GalleryItem imageScrop"
                                                                        data-is-cover-image="0"
                                                                        data-slno="{{ $EditData[0]->GalleryImages[$i]->SLNO }}"
                                                                        data-new="0" data-index="{{ $GalleryCount }}"
                                                                        data-default-file="<?php if ($isEdit == true) {
                                                                            if ($EditData[0]->GalleryImages[$i]->ImageUrl != '') {
                                                                                echo url('/') . '/' . $EditData[0]->GalleryImages[$i]->ImageUrl;
                                                                            }
                                                                        } ?>"
                                                                        data-max-file-size="{{ $Settings['upload-limit'] }}"
                                                                        data-allowed-file-extensions="jpeg jpg png gif" />
                                                                    <div class="errors"
                                                                        id="txtGalleryImg{{ $GalleryCount }}-err"></div>
                                                                </div>
                                                            </div>
                                                            @php $GalleryCount++; @endphp
                                                            @if ($GalleryCount % 4 == 0)
                                                </div>
                                                <div class="row mt-10" id="divGallery">
                                                    @endif
                                                    @endfor
                                                    @endif
                                                </div>
                                                <div class="row d-flex justify-content-center mt-20">
                                                    <div class="col-sm-2"><button type="button"
                                                            class="btn btn-outline-info btn-sm" id="btnAddImages">add
                                                            Gallery Image</button></div>
                                                </div>
                                                <div id="galleryContainer"></div>
                                            </div>
                                            <div class="text-center" id="divStepIndicator">
                                                <span class="step active"></span>
                                                <span class="step"></span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-6">
                                        @if ($crud['view'] == true)
                                            <a href="{{ url('/') }}/admin/master/services/"
                                                class="btn btn-sm btn-outline-dark" id="btnCancel">Back</a>
                                        @endif
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        @if (($crud['add'] == true && $isEdit == false) || ($crud['edit'] == true && $isEdit == true))
                                            <button class="btn btn-outline-secondary btn-sm" id="prevBtn"
                                                type="button" style="display: none;">Previous</button>
                                            <button class="btn btn-outline-success btn-sm" id="nextBtn"
                                                type="button">Next</button>
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
            let uploadData = {};
            var URL = window.URL || window.webkitURL;
            var $dataRotate = $('#dataRotate');
            var $dataScaleX = $('#dataScaleX');
            var $dataScaleY = $('#dataScaleY');
            var options = {
                aspectRatio: 9 / 6,
                preview: '.img-preview'
            };
            var $image = $('#ImageCrop').cropper(options);
            $('#ImgCrop').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#ImgCrop').modal('hide');

            const callback = async (response, id, uuid, fileName) => {
                if (response.uploadURL != undefined) {
                    $('#' + id).attr('data-upload-url', response.uploadURL);
                    $('#' + id).attr('src', response.uploadURL);
                }
                delete uploadData[uuid];
                let objKeys = Object.keys(uploadData);
                let detailID = $('#' + id).attr('data-detail-id');
                let rowIndex = $('#' + id).attr('data-row-index');
                if (objKeys.length > 0) {
                    $('.btnUpdateProductImage[data-detail-id="' + detailID + '"]').attr('data-continue', 0);
                } else {
                    $('.btnUpdateProductImage[data-detail-id="' + detailID + '"]').attr('data-continue', 1);
                }
                $('.btnRemoveGallery[data-detail-id="' + detailID + '"][data-row-index="' + rowIndex + '"]')
                    .show();
            }

            $(document).on('change', '.imageScrop', function() {
                let id = $(this).attr('id');
                $image.attr('data-id', id);
                $('#ImgCrop').modal('show');
                var files = this.files;
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
                        $('#' + id).attr('data-file-name', uploadedImageName);
                        $('#' + id).attr('data-file-ext', uploadedImageType);
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
                let id = $image.attr('data-id');
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
                        $('#' + id).attr('data-file-name', uploadedImageName);
                        $('#' + id).attr('data-file-ext', uploadedImageType);
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
                    var id = $image.attr('data-id');
                    let uploadedImageName = $('#' + id).attr('data-file-name');
                    let ext = $('#' + id).attr('data-file-ext');
                    var base64 = $image.cropper('getCroppedCanvas').toDataURL(ext, 1.0);
                    $('#' + id).attr('src', base64);
                    $('#' + id).attr('data-is-new', 1);
                    $('#' + id).attr('data-remove', 0);
                    $('#' + id).parent().find('img').attr('src', base64)
                    let uuid = generateUUID();
                    uploadData[uuid] = new customFileUpload(base64, uuid, id, uploadedImageName, {
                        callback,
                        uploadURL: "{{ route('temp.upload') }}",
                        csrfToken: "{{ csrf_token() }}"
                    });
                    $('#ImgCrop').modal('hide');
                    setTimeout(() => {
                        btnReset($('#btnCropApply'));
                    }, 100);
                }, 100);
            });

            $(document).on('click', '#ImgCrop button[data-dismiss="modal"]', function() {
                var id = $image.attr('data-id');
                $('#' + id).val("");
                $('#' + id).attr('data-is-new', 0);
                $('#' + id).attr('data-remove', 1);
                $('#' + id).attr('data-upload-url', '');
                $('#' + id).attr('src', "");
                $('#' + id).parent().find('img').attr('src', "");
                $('#' + id).parent().find('.dropify-clear').trigger('click');
                $('#ImgCrop').modal('hide');
            });

            $('#btnCropCancel').on('click', function() {
                var id = $image.attr('data-id');
                $('#' + id).val("");
                $('#' + id).parent().find('.dropify-clear').trigger('click');
                $('#ImgCrop').modal('hide');
            });

            $(document).on('click', '.dropify-clear', function() {
                $(this).parent().find('input[type="file"]').attr('data-remove', 1);
                $(this).parent().find('input[type="file"]').attr('data-is-new', 0);
                $(this).parent().find('input[type="file"]').attr('data-upload-url', '');
            });
        });
    </script>
    <script>
        var DeletedGalleryImg = [];
        var DeletedProfileImg = [];

        $(document).ready(function() {
            let GalleryCount = parseInt("{{ $GalleryCount }}");
            var currentTab = 0;
            showTab(currentTab);
            let isServiceName = false;
            let isSlug = false;

            function showTab(n) {
                var x = document.getElementsByClassName("tab");
                x[n].style.display = "block";
                if (n == 0) {
                    document.getElementById("prevBtn").style.display = "none";
                } else {
                    document.getElementById("prevBtn").style.display = "inline";
                }
                if (n == (x.length - 1)) {
                    document.getElementById("nextBtn").innerHTML =
                        @if ($isEdit)
                            "Update"
                        @else
                            "Submit"
                        @endif ;
                } else {
                    document.getElementById("nextBtn").innerHTML = "Next";
                }
                fixStepIndicator(n);
                let page = x[currentTab].getAttribute('data-page');
                if (currentTab == 2) {
                    page += "( " + $('#txtServiceName').val() + " )";
                }
                $('#pageTitle').html(page);
            }

            async function nextPrev(n) {
                var x = document.getElementsByClassName("tab");
                if (n == 1 && !validateForm()) return false;
                if ((parseInt(currentTab) + parseInt(n)) >= x.length) {
                    Save();
                    return false;
                }
                x[currentTab].style.display = "none";
                currentTab = currentTab + n;
                showTab(currentTab);

            }

            function validateForm() {
                let status = true;
                let x = document.getElementsByClassName("tab");
                let page = x[currentTab].getAttribute('data-page');
                if (page == "Service Info") {
                    $("html, body").animate({
                        scrollTop: 0
                    }, "slow");
                    $('.errors.ServiceInfo').html('');
                    let ServiceName = $('#txtServiceName').val();
                    let HSNSAC = $('#txtHSNSAC').val();
                    let Slug = $('#txtSlug').val();
                    let Category = $('#lstCategory').val();
                    let Price = $('#txtPrice').val();
                    let UOM = $('#lstUOM').val();
                    let TaxType = $('#lstTaxType').val();
                    let Tax = $('#lstTax').val();
                    let ActiveStatus = $('#lstActiveStatus').val();

                    if (ServiceName == "") {
                        $('#txtServiceName-err').html('Service name is required');
                        status = false;
                    } else if (ServiceName.length < 3) {
                        $('#txtServiceName-err').html('The Service name is must be greater than 3 characters.');
                        status = false;
                    } else if (ServiceName.length > 100) {
                        $('#txtServiceName-err').html('The Service name is not greater than 100 characters.');
                        status = false;
                    } else if (isServiceName == true) {
                        $('#txtServiceName-err').html('Service Name is not available. Already taken').removeClass(
                            'success');
                        status = false
                    } else if (isServiceName == false) {
                        $('#txtServiceName-err').html('Service Name is available').addClass('success');
                    }
                    if (Slug == "") {
                        $('#txtSlug-err').html('Slug  is required');
                        status = false;
                    } else if (isSlug == true) {
                        $('#txtSlug-err').html('Slug is not available. Already taken').removeClass('success');
                        status = false
                    } else if (isSlug == false) {
                        $('#txtSlug-err').html('Slug is available').addClass('success');
                    }

                    if (HSNSAC == "") {
                        $('#txtHSNSAC-err').html('HSN / SAC is required');
                        status = false;
                    }

                    if (Category == "") {
                        $('#lstCategory-err').html('Category is required');
                        status = false;
                    }

                    if (Price == "") {
                        $('#txtPrice-err').html('Price is required');
                        status = false;
                    } else if (!$.isNumeric(Price)) {
                        $('#txtPrice-err').html('The Price is not numeric value');
                        status = false;
                    } else if (parseFloat(Price) < 0) {
                        $('#txtPrice-err').html('The Price must be equal or greater than zero.');
                        status = false;
                    }
                    if (UOM == "") {
                        $('#lstUOM-err').html('Unit of measurement is required');
                        status = false;
                    }
                    if (Tax == "") {
                        $('#lstTax-err').html('Tax is required');
                        status = false;
                    }
                    if (TaxType == "") {
                        $('#lstTaxType-err').html('Tax type is required');
                        status = false;
                    }

                    if (ActiveStatus == "") {
                        $('#lstActiveStatus-err').html('Active status is required');
                        status = false;
                    }
                } else if (page == "Service Descriptions") {
                    let Title = $('#txtTitle').val();
                    let Description1 = $('#txtDescription1').val();
                    let Description2 = $('#txtDescription2').val();
                    let Description3 = $('#txtDescription3').val();

                    if (Title == "") {
                        $('#txtTitle-err').html('Title is required');
                        status = false;
                    } else if (Title.length < 20) {
                        $('#txtTitle-err').html('The Title must be greater than 20 characters');
                        status = false;
                    }
                    if (Description1 == "") {
                        $('#txtDescription1-err').html('Description 1 is required');
                        status = false;
                    } else if (Description1.length < 20) {
                        $('#txtDescription1-err').html('The Description 1 must be greater than 20 characters');
                        status = false;
                    }
                    if (Description2 == "") {
                        $('#txtDescription2-err').html('Description 2 is required');
                        status = false;
                    } else if (Description2.length < 20) {
                        $('#txtDescription2-err').html('The Description 2 must be greater than 20 characters');
                        status = false;
                    }
                    if (Description3 == "") {
                        $('#txtDescription3-err').html('Description 3 is required');
                        status = false;
                    } else if (Description3.length < 20) {
                        $('#txtDescription3-err').html('The Description 3 must be greater than 20 characters');
                        status = false;
                    }
                } else if (page == "Service Images") {
                    if ($('.icon-card.selected').length == 0) {
                        $('#lstServiceIcon-err').html('Please select any icon');
                        status = false;
                    }
                }
                return status;
            }

            function fixStepIndicator(n) {
                $('#divStepIndicator').html('');
                var tabs = document.getElementsByClassName("tab");
                for (let i = 0; i < tabs.length; i++) {
                    $('#divStepIndicator').append('<span class="step"></span>');
                }

                var i, x = document.getElementsByClassName("step");
                for (i = 0; i < x.length; i++) {
                    x[i].className = x[i].className.replace(" active", "");
                }
                x[n].className += " active";
            }

            $('#prevBtn').click(function() {
                nextPrev(-1);
            });

            $('#nextBtn').click(function() {
                nextPrev(1);
            });

            const appInit = async () => {
                getCategory();
                getTax();
                getUOM();
            }

            const getCategory = async () => {
                $('#lstCategory').select2('destroy');
                $('#lstCategory option').remove();
                $('#lstCategory').append('<option value="" selected>Select a Category</option>');
                $.ajax({
                    type: "post",
                    url: "{{ url('/') }}/admin/master/services/get/category",
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
                        for (let Item of response) {
                            let selected = "";
                            if (Item.CID == $('#lstCategory').attr('data-selected')) {
                                selected = "selected";
                            }
                            $('#lstCategory').append('<option ' + selected + ' value="' + Item
                                .CID +
                                '">' + Item.CName + ' </option>');
                        }
                        if ($('#lstCategory').val() != "") {
                            $('#lstCategory').trigger('change');
                        }
                    }
                });
                $('#lstCategory').select2();
            }

            const getTax = async () => {
                $('#lstTax').select2('destroy');
                $('#lstTax option').remove();
                $('#lstTax').append('<option value="" selected>Select a Tax</option>');
                $.ajax({
                    type: "post",
                    url: "{{ url('/') }}/admin/master/services/get/tax",
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
                        for (let Item of response) {
                            let selected = "";
                            if (Item.TaxID == $('#lstTax').attr('data-selected')) {
                                selected = "selected";
                            }
                            $('#lstTax').append('<option ' + selected + ' value="' + Item
                                .TaxID +
                                '">' + Item.TaxName + ' ( ' + NumberFormat(Item
                                    .TaxPercentage,
                                    'percentage') + '% ) </option>');
                        }
                    }
                });
                $('#lstTax').select2();
            }

            const getUOM = async () => {
                $('#lstUOM').select2('destroy');
                $('#lstUOM option').remove();
                $('#lstUOM').append('<option value="" selected>Select a UOM</option>');
                $.ajax({
                    type: "post",
                    url: "{{ url('/') }}/admin/master/services/get/uom",
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
                        for (let Item of response) {
                            let selected = "";
                            if (Item.UID == $('#lstUOM').attr('data-selected')) {
                                selected = "selected";
                            }
                            $('#lstUOM').append('<option ' + selected + ' value="' + Item.UID +
                                '">' + Item.UName + ' ( ' + Item.UCode + ' ) </option>');
                        }
                    }
                });
                $('#lstUOM').select2();
            }

            const getData = async () => {
                let isRemoved = $('#txtCoverImg').attr('data-remove') != undefined ? $('#txtCoverImg').attr(
                    'data-remove') : 0;
                let isNew = $('#txtCoverImg').attr('data-is-new') != undefined ? $('#txtCoverImg').attr(
                    'data-is-new') : 0;
                let url = $('#txtCoverImg').attr('data-upload-url') != undefined ? $('#txtCoverImg').attr(
                    'data-upload-url') : "";
                let fileName = $('#txtCoverImg').attr('data-file-name') != undefined ? $('#txtCoverImg')
                    .attr('data-file-name') : "";
                let formData = new FormData();

                formData.append('ServiceName', $('#txtServiceName').val());
                formData.append('HSNSAC', $('#txtHSNSAC').val());
                formData.append('Slug', $('#txtSlug').val());
                formData.append('Category', $('#lstCategory').val());
                formData.append('Price', $('#txtPrice').val());
                formData.append('UOM', $('#lstUOM').val());
                formData.append('TaxType', $('#lstTaxType').val());
                formData.append('Tax', $('#lstTax').val());
                formData.append('ActiveStatus', $('#lstActiveStatus').val());
                formData.append('ServiceIcon', $('.icon-card.selected').find('i').data('title'));
                formData.append('Title', $('#txtTitle').val());
                formData.append('Description1', $('#txtDescription1').val());
                formData.append('Description2', $('#txtDescription2').val());
                formData.append('Description3', $('#txtDescription3').val());
                formData.append('profileImage', $('#txtCoverImg').data('upload-url'));

                // Append dynamically added images
                $('.gallery-item input[type="file"]').each(function(index, element) {
                    var $element = $(element);
                    var uploadUrl = $element.data('upload-url');
                    var slno = $element.data('slno');

                    if (uploadUrl) {
                        var imageData = {
                            url: uploadUrl,
                            slno: slno
                        };
                        formData.append('gallery_images[]', JSON.stringify(imageData));
                    }
                });
                formData.append('profileImage', JSON.stringify({
                    url,
                    isRemoved,
                    isNew,
                    fileName
                }));
                formData.append('DeletedGalleryImg', JSON.stringify(DeletedGalleryImg));
                return formData;
            }

            const Save = async () => {
                swal({
                    title: "Are you sure?",
                    text: "You want @if ($isEdit == true)Update @else Save @endif this Service!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if ($isEdit == true)Update @else Save @endif it!",
                    closeOnConfirm: false
                }, async function() {

                    let formData = await getData();
                    swal.close();
                    btnLoading($('#nextBtn'));
                    @if ($isEdit)
                        let posturl =
                            "{{ url('/') }}/admin/master/services/edit/{{ $ServiceID }}";
                    @else
                        let posturl = "{{ url('/') }}/admin/master/services/create";
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
                        beforeSend: function() {
                            $('#divProcessText').html(
                                ' upload completed.<br> Please wait for until upload process complete.'
                            );
                        },
                        error: function(e, x, settings, exception) {
                            ajaxErrors(e, x, settings, exception);
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
                                            "{{ url('/') }}/admin/master/services/"
                                        );
                                    @else
                                        window.location.reload();
                                    @endif
                                });
                            } else {
                                ajaxIndicatorStop();
                                $('#nextBtn').html('next')
                                $('.tab').hide();
                                currentTab = 0;
                                showTab(currentTab);
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
                                        if (key == "ServiceName") {
                                            $('#txtServiceName-err').html(
                                                KeyValue);
                                        }
                                        if (key == "HSNSAC") {
                                            $('#txtHSNSAC-err').html(
                                                KeyValue);
                                        }
                                        if (key == "Slug") {
                                            $('#txtSlug-err').html(
                                                KeyValue);
                                        }
                                        if (key == "Category") {
                                            $('#lstCategory-err').html(
                                                KeyValue);
                                        }
                                        if (key == "Price") {
                                            $('#txtPrice-err').html(
                                                KeyValue);
                                        }
                                        if (key == "UOM") {
                                            $('#lstUOM-err').html(KeyValue);
                                        }
                                        if (key == "TaxType") {
                                            $('#lstTaxType-err').html(
                                                KeyValue);
                                        }
                                        if (key == "Tax") {
                                            $('#lstTax-err').html(KeyValue);
                                        }
                                        if (key == "ActiveStatus") {
                                            $('#lstActiveStatus-err').html(
                                                KeyValue);
                                        }
                                        if (key == "Description") {
                                            $('#txtDescription-err').html(
                                                KeyValue);
                                        }
                                    });
                                }
                            }
                        }
                    });
                });
            }

            const checkServiceName = async (serviceName) => {
                $.ajax({
                    type: "post",
                    url: "{{ url('/') }}/admin/master/services/check/service-name",
                    headers: {
                        'X-CSRF-Token': $('meta[name=_token]').attr('content')
                    },
                    data: {
                        ServiceName: serviceName,
                        serviceID: "<?php if ($isEdit) {
                            echo $ServiceID;
                        } ?>"
                    },
                    dataType: "json",
                    async: true,
                    error: function(e, x, settings, exception) {
                        ajaxErrors(e, x, settings, exception);
                    },
                    complete: function(e, x, settings, exception) {},
                    success: function(response) {
                        if (response.status == true) {
                            isServiceName = true;
                            $('#txtServiceName-err').html(response.message).removeClass(
                                'success');
                        } else {
                            isServiceName = false;
                            $('#txtServiceName-err').html(response.message).addClass('success');
                        }
                    }
                });
            }
            
            const checkSlug = async (Slug) => {
                $.ajax({
                    type: "post",
                    url: "{{ url('/') }}/admin/master/services/check/slug",
                    headers: {
                        'X-CSRF-Token': $('meta[name=_token]').attr('content')
                    },
                    data: {
                        Slug: Slug,
                        serviceID: "<?php if ($isEdit) {
                            echo $ServiceID;
                        } ?>"
                    },
                    dataType: "json",
                    async: true,
                    error: function(e, x, settings, exception) {
                        ajaxErrors(e, x, settings, exception);
                    },
                    complete: function(e, x, settings, exception) {},
                    success: function(response) {

                        if (response.status == true) {
                            isSlug = true;
                            $('#txtSlug-err').html(response.message).removeClass('success');
                        } else {
                            isSlug = false;
                            $('#txtSlug-err').html(response.message).addClass('success');
                        }
                    }
                });
            }

            $(document).on('keyup', '#txtServiceName', async function() {
                let serviceName = $('#txtServiceName').val();
                if (serviceName == "") {
                    $('#txtServiceName-err').html('Service name is required');
                    status = false;
                } else if (serviceName.length < 3) {
                    $('#txtServiceName-err').html(
                        'The service name is must be greater than 3 characters.');
                    status = false;
                } else if (serviceName.length > 100) {
                    $('#txtServiceName-err').html(
                        'The service name is not greater than 100 characters.');
                    status = false;
                } else {
                    $('#txtServiceName-err').html('');
                    let slug = await serviceName.toString().slugify()
                    await $('#txtSlug').val(slug);
                    checkServiceName(serviceName);
                    checkSlug(slug);
                }
            });

            $(document).on('change', '#txtServiceName', async function() {
                let serviceName = $('#txtServiceName').val();
                if (serviceName == "") {
                    $('#txtServiceName-err').html('Service name is required');
                    status = false;
                } else if (serviceName.length < 3) {
                    $('#txtServiceName-err').html(
                        'The service name is must be greater than 3 characters.');
                    status = false;
                } else if (serviceName.length > 100) {
                    $('#txtServiceName-err').html(
                        'The service name is not greater than 100 characters.');
                    status = false;
                } else {
                    $('#txtServiceName-err').html('');
                    let slug = await serviceName.toString().slugify()
                    await $('#txtSlug').val(slug);
                    checkServiceName(serviceName);
                    checkSlug(slug);
                }
            });

            $(document).on('keyup', '#txtHSNSAC', async function() {
                let HSNSAC = $('#txtHSNSAC').val();
                $('#txtHSNSAC-err').html('');
                if (HSNSAC == "") {
                    $('#txtHSNSAC-err').html('HSN / SAC is required');
                    status = false;
                }
            });

            $(document).on('keyup', '#txtPrice', async function() {
                let Price = $('#txtPrice').val();
                $('#txtPrice-err').html('');
                if (Price == "") {
                    $('#txtPrice-err').html('Price is required');
                    status = false;
                } else if (!$.isNumeric(Price)) {
                    $('#txtPrice-err').html('The Price is not numeric value');
                    status = false;
                } else if (parseFloat(Price) < 0) {
                    $('#txtPrice-err').html('The Price must be equal or greater than zero.');
                    status = false;
                }
            });

            $(document).on('change', '#lstUOM', async function() {
                let UOM = $('#lstUOM').val();
                $('#lstUOM-err').html('');
                if (UOM == "") {
                    $('#lstUOM-err').html('Unit of measurement is required');
                    status = false;
                }
            });

            $(document).on('change', '#lstTax', async function() {
                let Tax = $('#lstTax').val();
                $('#lstTax-err').html('');
                if (Tax == "") {
                    $('#lstTax-err').html('Tax is required');
                    status = false;
                }
            });

            $(document).on('change', '#lstTaxType', async function() {
                let TaxType = $('#lstTaxType').val();
                $('#lstTaxType-err').html('');
                if (TaxType == "") {
                    $('#lstTaxType-err').html('Tax type is required');
                    status = false;
                }
            });

            $(document).on('change', '#lstCategory', function() {
                let Category = $('#lstCategory').val();
                $('#lstCategory-err').html('');
                if (Category == "") {
                    $('#lstCategory-err').html('Category is required');
                    status = false;
                }

            });
            appInit();
        });

        $(document).ready(function() {
            initializeDropify();
            var lastInputId = $('#divGallery').find('input[type="file"]').last().attr('id');
            if (lastInputId !== undefined && lastInputId.match(/\d+$/)) {
                var galleryCount = parseInt(lastInputId.match(/\d+$/)[0]) +
                    1;
            } else {
                var galleryCount = 1;
            }

            $(document).on('click', '#btnAddImages', function() {
                var uploadLimit = '{{ $Settings['upload-limit'] }}';
                var newGalleryItem = `
                    <div class="row d-flex justify-content-center mt-20 gallery-item" id="galleryItem${galleryCount}">
                        <div class="col-sm-4 text-center">
                            <label>Gallery Image</label>
                            <input type="file" name="gallery_images[]" id="txtGalleryImg${galleryCount}" class="dropify imageScrop"
                                data-slno="" data-is-cover-image="0" 
                                data-allowed-file-extensions="jpeg jpg png gif" required />
                            <span class="errors" id="txtGalleryImg${galleryCount}-err"></span>
                            <button type="button" class="btn btn-outline-danger btn-sm btnRemoveGallery mt-2"
                                data-index="${galleryCount}">Remove</button>
                        </div>
                    </div>`;

                $('#galleryContainer').append(newGalleryItem);

                setTimeout(function() {
                    initializeDropify($('#txtGalleryImg' + galleryCount));
                }, 0);

                galleryCount++;
            });

            $(document).on('click', '#divGallery .dropify-clear', function(e) {
                const inputElement = $(this).closest('.dropify-wrapper').find('input[type="file"]')[0];
                const dataSlno = inputElement.getAttribute('data-slno');
                DeletedGalleryImg.push(dataSlno);
            });

            $(document).on('click', '.btnRemoveGallery', function() {
                var indexToRemove = $(this).data('index');
                $('#galleryItem' + indexToRemove).remove();
                initializeDropify();
            });

            $(document).on('click', '#divGallery .dropify-clear', function(e) {
                $(this).closest('.gallery-item').remove();
            });

            $(document).on('change', '.GalleryItem', function(e) {
                $(this).attr('data-new', 1);
                let slno = $(this).attr('data-slno');
                if ((slno != "") && (slno != undefined)) {
                    if (jQuery.inArray(slno, DeletedGalleryImg) !== -1) {
                        DeletedGalleryImg.splice(DeletedGalleryImg.indexOf(slno), 1);
                    }
                }
            });
        });


        function initializeDropify() {
            $('.dropify').each(function() {
                $(this).dropify({
                    tpl: {
                        clearButton: '<button type="button" class="dropify-clear">Remove</button>'
                    }
                });
            });
        }

        $(document).on('click', '#divGallery .dropify-clear', function(event) {
            var parentDiv = $(this).closest('.col-sm-3.p-10.text-center');
            parentDiv.remove();
        });

        $(document).on('click', '.icon-card', function() {
            $('.icon-card').removeClass('selected');
            $(this).addClass('selected');
        });
    </script>
@endsection
