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
                        <li class="breadcrumb-item"><a href="{{ url('/') }}/admin"><i class="f-16 fa fa-home"></i></a></li>
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item"><a href="{{ url('/') }}/admin/master/projects">{{ $PageTitle }}</a></li>
                        <li class="breadcrumb-item">@if ($isEdit)Update @else Create @endif</li>
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
                                            <div class="tab" data-page="ProjectInfo">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="txtProjectName">Project Name <span
                                                                    class="required">*</span></label>
                                                            <input type="text" class="form-control" id="txtProjectName"
                                                                value="<?php if ($isEdit) {
                                                                    echo $EditData[0]->ProjectName;
                                                                } ?>">
                                                            <div class="errors err-sm ProjectInfo" id="txtProjectName-err">
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
                                                            <div class="errors err-sm ProjectInfo" id="txtSlug-err"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="lstProjectType">Project Type <span class="required">*</span></label>
                                                            <select class="form-control select2" id="lstProjectType">
                                                                <option value="Commercial"
                                                                    @if ($isEdit == true) @if ($EditData[0]->ProjectType == 'Commercial') selected @endif
                                                                    @endif >Commercial</option>
                                                                <option value="Residential"
                                                                    @if ($isEdit == true) @if ($EditData[0]->ProjectType == 'Residential') selected @endif
                                                                    @endif>Residential</option>
                                                            </select>
                                                            <div class="errors err-sm ProjectInfo" id="lstActiveStatus-err">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="lstProjectArea">Project Area <span
                                                                    class="required">*</span></label>
                                                            <select class="form-control select2" id="lstProjectArea" data-selected="<?php if ($isEdit) {echo $EditData[0]->ProjectAreaID;} ?>">
                                                                <option value="">Select a Project Area</option>
                                                            </select>
                                                            <div class="errors err-sm ProjectInfo" id="lstProjectArea-err">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="lstClient">Client <span
                                                                    class="required">*</span></label>
                                                            <select class="form-control select2" id="lstClient"
                                                                data-selected="<?php if ($isEdit) {
                                                                    echo $EditData[0]->ClientID;
                                                                } ?>">
                                                                <option value="">Select a Client</option>
                                                            </select>
                                                            <div class="errors err-sm ProjectInfo" id="lstClientID-err">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="lstService">Service <span
                                                                    class="required">*</span></label>
                                                            <select class="form-control select2" id="lstService">
                                                                <option value="">Select a Service</option>
                                                                @foreach ($Services as $item)
                                                                    <option value="{{$item->ServiceID}}" @if($isEdit && $item->ServiceID == $EditData[0]->ServiceID) selected @endif>{{$item->ServiceName}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="errors err-sm ProjectInfo" id="lstServiceID-err">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="lstActiveStatus">Active Status</label>
                                                            <select class="form-control" id="lstActiveStatus">
                                                                <option value="1" @if ($isEdit && $EditData[0]->ActiveStatus == '1') selected @endif>Active</option>
                                                                <option value="0" @if ($isEdit && $EditData[0]->ActiveStatus == '0') selected @endif>Inactive</option>
                                                            </select>
                                                            <div class="errors err-sm ProjectInfo" id="lstActiveStatus-err">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="txtAddress">Project Address </label>
                                                            <textarea class="form-control" placeholder="Address" id="txtAddress" name="Address" rows="3"><?php if ($isEdit == true) {
                                                                echo $EditData[0]->ProjectAddress;
                                                            } ?></textarea>
                                                            <span class="errors err-sm" id="txtAddress-err"></span>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="tab" data-page="Project Descriptions">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="txtTitle">Short Description <span class="required"> *</span></label>
                                                            <textarea id="txtTitle" class="form-control" rows="2"><?php if ($isEdit) { echo $EditData[0]->SDesc; } ?></textarea>
                                                            <div class="errors err-sm Project Descriptions" id="txtTitle-err"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="txtDesc">Long Description<span class="required"> *</span></label>
                                                            <textarea id="txtDesc" class="form-control" rows="5"><?php if ($isEdit) { echo $EditData[0]->LDesc; } ?></textarea>
                                                            <div class="errors err-sm Project Descriptions" id="txtDesc-err"></div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="tab mb-20" data-page="ProjectImages">
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col-sm-4 text-center">
                                                        <label>Cover Image</label>
                                                        <input type="file" id="txtCoverImg" class="dropify imageScrop"
                                                            data-slno="" data-is-cover-image="1"
                                                            data-max-file-size="{{ $Settings['upload-limit'] }}"
                                                            data-default-file="<?php if ($isEdit == true) {
                                                                if ($EditData[0]->ProjectImage != '') {
                                                                    echo url('/') . '/' . $EditData[0]->ProjectImage;
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
                                            <a href="{{ url('/') }}/admin/master/projects/"
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
        var DeletedGalleryImg = [];
        $(document).ready(function() {

            const getClients = async () => {
                $('#lstClient').select2('destroy');
                $('#lstClient option').remove();
                $('#lstClient').append('<option value="" selected>Select a Client</option>');

                $.ajax({
                    type: "post",
                    url: "{{ url('/') }}/admin/master/projects/getclients",
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
                        for (let client of response) {
                            let selected = "";
                            if (client.ClientID == $('#lstClient').attr('data-selected')) {
                                selected = "selected";
                            }
                            $('#lstClient').append('<option ' + selected + ' value="' + client
                                .ClientID + '">' + client.Name + '</option>');
                        }
                        $('#lstClient').select2();
                    }
                });
            }

            getClients();

            const getProjectArea = async () => {
                // $('#lstProjectArea').select2('destroy');
                $('#lstProjectArea option').remove();
                $('#lstProjectArea').append('<option value="" selected>Select a Project Area</option>');
                let ProjectType = $('#lstProjectType').val();
                if(ProjectType){
                    $.ajax({
                        type: "post",
                        url: "{{ url('/') }}/admin/master/projects/get-project-area",
                        headers: {
                            'X-CSRF-Token': $('meta[name=_token]').attr('content')
                        },
                        dataType: "json",
                        data: {ProjectType: ProjectType},
                        async: true,
                        error: function(e, x, settings, exception) {
                            ajaxErrors(e, x, settings, exception);
                        },
                        complete: function(e, x, settings, exception) {},
                        success: function(response) {
                            for (let client of response) {
                                let selected = "";
                                if (client.ProjectAreaID == $('#lstProjectArea').attr('data-selected')) {
                                    selected = "selected";
                                }
                                $('#lstProjectArea').append('<option ' + selected + ' value="' +client.ProjectAreaID + '">' + client.ProjectAreaName + '</option>');
                            }
                            // $('#lstProjectArea').select2();
                        }
                    });
                }
            }

            getProjectArea();



            let GalleryCount = parseInt("{{ $GalleryCount }}");
            var currentTab = 0;
            showTab(currentTab);
            let isProjectName = false;
            let isSlug = false;
            // let DeletedGalleryImg = [];

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
                console.log(page)
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
                if (page == "ProjectInfo") {
                    $("html, body").animate({
                        scrollTop: 0
                    }, "slow");
                    $('.errors.ProjectInfo').html('');
                    let ProjectName = $('#txtProjectName').val();
                    let ClientID = $('#lstClient').val();
                    let ServiceID = $('#lstService').val();
                    let ProjectArea = $('#lstProjectArea').val();
                    let Slug = $('#txtSlug').val();


                    if (ProjectName == "") {
                        $('#txtProjectName-err').html('Project name is required');
                        status = false;
                    } else if (ProjectName.length < 3) {
                        $('#txtProjectName-err').html('The Project name must be greater than 3 characters.');
                        status = false;
                    } else if (ProjectName.length > 100) {
                        $('#txtProjectName-err').html('The Project name must not exceed 100 characters.');
                        status = false;
                    }

                    if (ClientID == "") {
                        $('#lstClientID-err').html('Client is required');
                        status = false;
                    }
                    if (ServiceID == "") {
                        $('#lstServiceID-err').html('Service is required');
                        status = false;
                    }
                    if (Slug == "") {
                        $('#txtSlug-err').html('Slug is required');
                        status = false;
                    }

                    if (ProjectArea == "") {
                        $('#lstProjectArea-err').html('Project Area is required');
                        status = false;
                    }
                }else if (page == "Project Descriptions"){
                    $('.errors.Project Descriptions').html('');
                    let SDesc = $('#txtTitle').val();
                    let LDesc = $('#txtDesc').val();

                    if (SDesc == "") {
                        $('#txtTitle-err').html('Short Description is required');status = false;
                    }else if (SDesc.length < 5){
                        $('#txtTitle-err').html('Short Description must be greater than 5 characters');status = false;
                    }

                    if (LDesc == "") {
                        $('#txtDesc-err').html('Long Description is required');status = false;
                    }else if (LDesc.length < 10){
                        $('#txtDesc-err').html('Long Description must be greater than 10 characters');status = false;
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

            }



            const getData = async () => {
                let tmp = await UploadImages();
                let formData = new FormData();
                formData.append('ProjectName', $('#txtProjectName').val());
                formData.append('Address', $('#txtAddress').val());
                formData.append('ActiveStatus', $('#lstActiveStatus').val());
                formData.append('SDesc', $('#txtTitle').val());
                formData.append('LDesc', $('#txtDesc').val());


                // Append dynamically added images
                $('.gallery-item input[type="file"]').each(function(index, element) {
                    var files = $(element)[0].files;
                    if (files.length > 0) {
                        $.each(files, function(i, file) {
                            formData.append('gallery_images[]', file);
                        });
                    }
                });

                formData.append('ProjectAreaID', $('#lstProjectArea').val());
                formData.append('Slug', $('#txtSlug').val());
                formData.append('ClientID', $('#lstClient').val());
                formData.append('ServiceID', $('#lstService').val());
                formData.append('Images', JSON.stringify(tmp));
                formData.append('DeletedGalleryImg', JSON.stringify(DeletedGalleryImg));
                console.log("Deleted Gallery Images:", DeletedGalleryImg);

                return formData;
            }

            const Save = async () => {
                swal({
                    title: "Are you sure?",
                    text: "You want @if ($isEdit == true)Update @else Save @endif this Project!",
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
                            "{{ url('/') }}/admin/master/projects/edit/{{ $ProjectID }}";
                    @else
                        let posturl = "{{ url('/') }}/admin/master/projects/create";
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
                                            "{{ url('/') }}/admin/master/projects/"
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
                                        if (key == "ProjectName") {
                                            $('#txtProjectName-err').html(
                                                KeyValue);
                                        }
                                        if (key == "ClientID") {
                                            $('#lstClientID-err').html(
                                                KeyValue);
                                        }
                                        if (key == "ServiceID") {
                                            $('#lstServiceID-err').html(
                                                KeyValue);
                                        }
                                        if (key == "ProjectAreaID") {
                                            $('#lstProjectArea-err').html(
                                                KeyValue);
                                        }
                                        if (key == "Slug") {
                                            $('#txtSlug-err').html(
                                                KeyValue);
                                        }
                                    });
                                }
                            }
                        }
                    });
                });
            }
            const UploadImages = async () => {
                let uploadImages = await new Promise((resolve, reject) => {
                    ajaxIndicatorStart(
                        "% Completed. Please wait until the upload process is complete.");
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
                            $('#divProcessText').html(percentage +
                                '% Completed. Please wait until the upload process is complete.'
                            );
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
                                headers: {
                                    'X-CSRF-Token': $('meta[name=_token]')
                                        .attr('content')
                                },
                                data: formData,
                                dataType: "json",
                                error: function(e, x, settings, exception) {
                                    ajaxErrors(e, x, settings,
                                        exception);
                                },
                                complete: uploadComplete,
                                success: function(response) {
                                    if (response.referData
                                        .isCoverImage == 1) {
                                        images.coverImg = {
                                            uploadPath: response
                                                .uploadPath,
                                            fileName: response
                                                .fileName
                                        };
                                    } else {
                                        images.gallery.push({
                                            uploadPath: response
                                                .uploadPath,
                                            fileName: response
                                                .fileName,
                                            slno: response
                                                .referData.slno
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
                                    isCoverImage: $('#' + id).attr(
                                        'data-is-cover-image')
                                };
                                upload(formData);
                            } else {
                                completed++;
                                let percentage = (100 * completed) / count;
                                $('#divProcessText').html(percentage +
                                    '% Completed. Please wait until the upload process is complete.'
                                );
                                checkUploadCompleted();
                            }
                        });
                    }, 200);
                });
                return uploadImages;
            };

            $(document).on('keyup', '#txtProjectName', async function() {
                let projectName = $('#txtProjectName').val();
                if (projectName == "") {
                    $('#txtProjectName-err').html('Project name is required');
                    status = false;
                } else if (projectName.length < 3) {
                    $('#txtProjectName-err').html(
                        'The Project name is must be greater than 3 characters.');
                    status = false;
                } else if (projectName.length > 100) {
                    $('#txtProjectName-err').html(
                        'The Project name is not greater than 100 characters.');
                    status = false;
                } else {
                    $('#txtProjectName-err').html('');
                    let slug = await projectName.toString().slugify()
                    await $('#txtSlug').val(slug);
                    checkProjectName(projectName);
                    checkSlug(slug);
                }
            });

            $(document).on('change', '#txtProjectName', async function() {
                let projectName = $('#txtProjectName').val();
                if (projectName == "") {
                    $('#txtProjectName-err').html('Project name is required');
                    status = false;
                } else if (projectName.length < 3) {
                    $('#txtProjectName-err').html(
                        'The Project name is must be greater than 3 characters.');
                    status = false;
                } else if (projectName.length > 100) {
                    $('#txtProjectName-err').html(
                        'The Project name is not greater than 100 characters.');
                    status = false;
                }
            });



            $(document).on('change', '#lstClient', async function() {
                let clientID = $('#lstClient').val();
                $('#lstClientID-err').html('');
                if (clientID == "") {
                    $('#lstClientID-err').html('Client is required');
                    status = false;
                }
            });

            $(document).on('change', '#lstService', async function() {
                let clientID = $('#lstService').val();
                $('#lstServiceID-err').html('');
                if (clientID == "") {
                    $('#lstServiceID-err').html('Service is required');
                    status = false;
                }
            });
            $(document).on('change', '#lstProjectType', async function() {
                getProjectArea();
            });

            appInit();
        });

        $(document).ready(function() {
            // Function to initialize Dropify
            function initializeDropify() {
                $('.dropify').each(function() {
                    $(this).dropify({
                        tpl: {
                            clearButton: '<button type="button" class="dropify-clear">Remove</button>'
                        }
                    });
                });
            }

            // Initialize Dropify on page load
            initializeDropify();

            var lastInputId = $('#divGallery').find('input[type="file"]').last().attr('id');
            // Check if lastInputId is not undefined and matches the expected pattern
            if (lastInputId !== undefined && lastInputId.match(/\d+$/)) {
                var galleryCount = parseInt(lastInputId.match(/\d+$/)[0]) +
                    1; // Extract the number from the last input ID and increment
            } else {
                // If lastInputId is undefined or does not match the pattern, set galleryCount to 1
                var galleryCount = 1;
            }

            // Event handler for adding new input box
            $(document).on('click', '#btnAddImages', function() {
                var uploadLimit = '{{ $Settings['upload-limit'] }}';
                var newGalleryItem = `
                    <div class="row d-flex justify-content-center mt-20 gallery-item" id="galleryItem${galleryCount}">
                        <div class="col-sm-4 text-center">
                            <label>Gallery Image</label>
                            <input type="file" name="gallery_images[]" id="txtGalleryImg${galleryCount}" class="dropify imageScrop"
                                data-slno="" data-is-cover-image="0" data-max-file-size="${uploadLimit}"
                                data-allowed-file-extensions="jpeg jpg png gif" required />
                            <span class="errors" id="txtGalleryImg${galleryCount}-err"></span>
                            <button type="button" class="btn btn-outline-danger btn-sm btnRemoveGallery mt-2"
                                data-index="${galleryCount}">Remove</button>
                        </div>
                    </div>`;

                $('#galleryContainer').append(newGalleryItem);

                // Initialize Dropify for the newly added input field
                setTimeout(function() {
                    initializeDropify($('#txtGalleryImg' + galleryCount));
                }, 0);

                galleryCount++;
                //alert("count is :"+galleryCount);
            });

            $(document).on('click', '#divGallery .dropify-clear', function(e) {
                const inputElement = $(this).closest('.dropify-wrapper').find('input[type="file"]')[0];

                const dataSlno = inputElement.getAttribute('data-slno');

                console.log("data-slno:", dataSlno);

                DeletedGalleryImg.push(dataSlno);
                console.log("DeletedGalleryImg:", DeletedGalleryImg);
            });

            $(document).on('click', '.btnRemoveGallery', function() {
                var indexToRemove = $(this).data('index');
                $('#galleryItem' + indexToRemove).remove();
                initializeDropify(); // Reinitialize Dropify after removal
            });

            $(document).on('click', '#divGallery .dropify-clear', function(e) {
                // Remove the corresponding gallery item, but keep the Dropify instance intact
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

        const checkProjectName = async (projectName) => {
            $.ajax({
                type: "post",
                url: "{{ url('/') }}/admin/master/projects/check/project-name",
                headers: {
                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                },
                data: {
                    ProjectName: projectName,
                    ProjectID: "<?php if ($isEdit) {
                        echo $ProjectID;
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
                        isProjectName = true;
                        $('#txtProjectName-err').html(response.message).removeClass(
                            'success');
                    } else {
                        isProjectName = false;
                        $('#txtProjectName-err').html(response.message).addClass('success');
                    }
                }
            });
        }

        const checkSlug = async (Slug) => {
            $.ajax({
                type: "post",
                url: "{{ url('/') }}/admin/master/projects/check/slug",
                headers: {
                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                },
                data: {
                    Slug: Slug,
                    projectID: "<?php if ($isEdit) {
                        echo $ProjectID;
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

        $(document).ready(function() {
            var uploadedImageURL;
            var URL = window.URL || window.webkitURL;
            var $dataRotate = $('#dataRotate');
            var $dataScaleX = $('#dataScaleX');
            var $dataScaleY = $('#dataScaleY');
            var options = {
                // aspectRatio: 700/1167,
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
        $(document).on('click', '#divGallery .dropify-clear', function(event) {
            // Get the parent div of the input element
            var parentDiv = $(this).closest('.col-sm-3.p-10.text-center');
            // Remove the entire input section
            parentDiv.remove();
        });

    </script>
@endsection
