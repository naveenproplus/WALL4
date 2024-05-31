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
                                href="{{ url('/') }}/admin/master/category">{{ $PageTitle }}</a></li>
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
                                            <label class="txtTaxName"> Tax Name <span class="required"> * </span></label>
                                            <input type="text" class="form-control" id="txtTaxName"
                                                value="<?php if ($isEdit == true) {
                                                    echo $EditData[0]->TaxName;
                                                } ?>">
                                            <div class="errors err-sm" id="txtTaxName-err"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="txtPercentage"> Percentage <span class="required"> *
                                                </span></label>
                                            <input type="number" step="0.01" class="form-control" id="txtPercentage"
                                                value="<?php if ($isEdit == true) {
                                                    echo $EditData[0]->TaxPercentage;
                                                } ?>">
                                            <div class="errors err-sm" id="txtPercentage-err"></div>
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
                                            <a href="{{ url('/') }}/admin/master/tax"
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
                let TaxName = $('#txtTaxName').val();
                let Percentage = $('#txtPercentage').val();
                if (TaxName == "") {
                    $('#txtTaxName-err').html('The category name is required.');
                    status = false;
                } else if (TaxName.length < 2) {
                    $('#Percentage-err').html('TaxName  must be greater than 2 characters');
                    status = false;
                } else if (TaxName.length > 100) {
                    $('#txtTaxName-err').html('Category Name may not be greater than 100 characters');
                    status = false;
                }

                if (Percentage == "") {
                    $('#txtPercentage-err').html('The Percentage  is required.');
                    status = false;
                } else if ($.isNumeric(Percentage) == false) {
                    $('#txtPercentage-err').html('The Percentage  is must be numeric.');
                    status = false;
                } else if (Percentage.length > 100) {
                    $('#txtPercentage-err').html('Percentage  may not be greater than 100 characters');
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
                        text: "You want @if ($isEdit == true)Update @else Save @endif this Tax!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-outline-success",
                        confirmButtonText: "Yes, @if ($isEdit == true)Update @else Save @endif it!",
                        closeOnConfirm: false
                    }, function() {
                        swal.close();
                        btnLoading($('#btnSave'));
                        let postUrl = "{{ url('/') }}/admin/master/tax/create";
                        let formData = new FormData();
                        formData.append('TaxName', $('#txtTaxName').val());
                        formData.append('Percentage', $('#txtPercentage').val());
                        formData.append('ActiveStatus', $('#lstActiveStatus').val());

                        @if ($isEdit == true)
                            postUrl =
                                "{{ url('/') }}/admin/master/tax/edit/{{ $TaxID }}";
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
                                                "{{ url('/') }}/admin/master/tax"
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
                                            if (key == "TaxName") {
                                                $('#txtTaxName-err').html(
                                                    KeyValue);
                                            }
                                            if (key == "Percentage") {
                                                $('#txtPercentage-err').html(
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
