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
                                href="{{ url('/') }}/admin/master/unit-of-measurement">{{ $PageTitle }}</a></li>
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
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="txtUCode">Unit Code<span class="required"> * </span></label>
                                            <input type="text" class="form-control" placeholder=" Code" id="txtUCode"
                                                value="<?php if ($isEdit == true) {
                                                    echo $EditData[0]->UCode;
                                                } ?>">
                                            <div class="errors err-sm" id="txtUCode-err"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="txtUName">Unit Name <span class="required"> * </span></label>
                                            <input type="text" class="form-control" placeholder="Name" id="txtUName"
                                                value="<?php if ($isEdit == true) {
                                                    echo $EditData[0]->UName;
                                                } ?>">
                                            <div class="errors err-sm" id="txtUName-err"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="lstActiveStatus"> Active Status</label>
                                            <select class="form-control" id="lstActiveStatus">
                                                <option value="1"
                                                    @if ($isEdit == true) @if ($EditData[0]->ActiveStatus == '1') selected @endif
                                                    @endif >Active</option>
                                                <option value="0"
                                                    @if ($isEdit == true) @if ($EditData[0]->ActiveStatus == '0') selected @endif
                                                    @endif>Inactive</option>
                                            </select>
                                            <div class="errors err-sm" id="lstActiveStatus-err"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-12 text-right">
                                        @if ($crud['view'] == 1)
                                            <a href="{{ url('/') }}/admin/master/unit-of-measurement"
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
                $('.errors').html('');
                let status = true;
                let UCode = $('#txtUCode').val();
                let UName = $('#txtUName').val();
                if (UCode == "") {
                    $('#txtUCode-err').html('Unit Code  is required.');
                    status = false;
                } else if (UCode.length > 100) {
                    $('#txtUCode-err').html('Unit Code  may not be greater than 100 characters');
                    status = false;
                }
                if (UName == '') {
                    $('#txtUName-err').html('The Unit Name name is required.');
                    status = false;
                }
                if (status == false) {
                    $("html, body").animate({
                        scrollTop: 0
                    }, "slow");
                }
                return status;
            }

            $('#btnSave').click(function() {
                let status = formValidation();
                if (status) {
                    swal({
                        title: "Are you sure?",
                        text: "You want @if ($isEdit == true)Update @else Save @endif this Unit of measurement!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-outline-success",
                        confirmButtonText: "Yes, @if ($isEdit == true)Update @else Save @endif it!",
                        closeOnConfirm: false
                    }, function() {
                        swal.close();
                        btnLoading($('#btnSave'));
                        let postUrl = "{{ url('/') }}/admin/master/unit-of-measurement/create";
                        let formData = new FormData();
                        formData.append('UCode', $('#txtUCode').val());
                        formData.append('UID', $('#UID').val());
                        formData.append('UName', $('#txtUName').val());
                        formData.append('ActiveStatus', $('#lstActiveStatus').val());

                        @if ($isEdit == true)
                            postUrl =
                                "{{ url('/') }}/admin/master/unit-of-measurement/edit/{{ $UID }}";
                        @endif
                        $.ajax({
                            type: "post",
                            url: postUrl,
                            headers: {
                                'X-CSRF-Token': $('meta[name=_token]').attr('content')
                            },
                            data: formData,
                            cache: false,
                            processData: false,
                            contentType: false,
                            error: function(e, x, settings, exception) {
                                ajaxErrors(e, x, settings, exception);
                            },
                            complete: function(e, x, settings, exception) {
                                btnReset($('#btnSave'));
                                $("html, body").animate({
                                    scrollTop: 0
                                }, "slow");
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
                                                "{{ url('/') }}/admin/master/unit-of-measurement"
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
                                            if (key == "txtUCode") {
                                                $('#txtUCode-err').html(
                                                    KeyValue);
                                            }
                                            if (key == "UName") {
                                                $('#txtUName-err').html(
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
        });
    </script>
@endsection
