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
                                href="{{ url('/') }}/admin/master/project-type">{{ $PageTitle }}</a></li>
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
                                        <input type="file" id="txtProjectTypeImage" class="dropify"
                                            data-max-file-size="{{ $Settings['upload-limit'] }}"
                                            data-default-file="<?php if ($isEdit == true) {
                                                if ($EditData[0]->ProjectTypeImage != '') {
                                                    echo url('/') . '/' . $EditData[0]->ProjectTypeImage;
                                                }
                                            } ?>"
                                            data-allowed-file-extensions="jpeg jpg png gif" />
                                        <span class="errors" id="txtProjectTypeImage-err"></span>
                                    </div>
                                </div>
                                <div class="row mt-20">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtProjectTypeName">Project Type Name <span
                                                    class="required">*</span></label>
                                            <input type="text" id="txtProjectTypeName" class="form-control"
                                                placeholder="Project Type" value="<?php if ($isEdit == true) {
                                                    echo $EditData[0]->ProjectTypeName;
                                                } ?>">
                                            <span class="errors err-sm" id="txtProjectTypeName-err"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Active Status</label>
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
                                            <a href="{{ url('/') }}/admin/master/project-type"
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
    <script>
        $(document).ready(function() {
            const formValidation = () => {
                $('.errors').html('')
                let ProjectTypeName = $('#txtProjectTypeName').val();
                let status = true;
                if (ProjectTypeName == "") {
                    $('#txtProjectTypeName-err').html('Project Type is required');
                    status = false;
                } else if (ProjectTypeName.length < 2) {
                    $('#txtProjectTypeName-err').html('The Project Type is must be greater than 2 characters.');
                    status = false;
                } else if (ProjectTypeName.length > 100) {
                    $('#txtProjectTypeName-err').html('The Project Type is not greater than 100 characters.');
                    status = false;
                }
                return status;
            }
            const getData = () => {
                let formData = new FormData();
                formData.append('ProjectTypeName', $('#txtProjectTypeName').val());
                formData.append('ActiveStatus', $('#lstActiveStatus').val());
                if ($('#txtProjectTypeImage').val() != "") {
                    formData.append('ProjectTypeImage', $('#txtProjectTypeImage')[0].files[0]);
                }
                return formData;
            }
            $(document).on('click', '#btnSave', function() {
                let status = formValidation();
                if (status) {
                    const formData = getData();
                    swal({
                            title: "Are you sure?",
                            text: "You want @if ($isEdit == true)Update @else Save @endif this Category!",
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
                                    "{{ url('/') }}/admin/master/project-type/edit/{{ $PID }}";
                            @else
                                let posturl =
                                "{{ url('/') }}/admin/master/project-type/create";
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
                                                    "{{ url('/') }}/admin/master/project-type/"
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
                                                if (key == "ProjectTypeName") {
                                                    $('#txtProjectTypeName-err')
                                                        .html(KeyValue);
                                                }
                                                if (key == "ProjectTypeImage") {
                                                    $('#txtProjectTypeImage-err')
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
            appInit();
        });
    </script>
@endsection
