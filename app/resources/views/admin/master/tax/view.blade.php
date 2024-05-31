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
                        <li class="breadcrumb-item">{{ $PageTitle }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-40">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header text-center">
                                <div class="form-row align-items-center">
                                    <div class="col-md-4"> </div>
                                    <div class="col-md-4 my-2">
                                        <h5>{{ $PageTitle }}</h5>
                                    </div>
                                    <div class="col-md-4 my-2 text-right text-md-right">
                                        @if ($crud['restore'] == 1)
                                            <a href="{{ url('/') }}/admin/master/tax/restore"
                                                class="btn  btn-outline-dark btn-sm  mr-10" type="button">Restore</a>
                                        @endif
                                        @if ($crud['add'] == 1)
                                            <a href="{{ url('/') }}/admin/master/tax/create"
                                                class="btn  btn-outline-success btn-sm btn-air-success "
                                                type="button">Create</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-12 col-sm-12">
                                        <table class="table table-sm" id="tblTax">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th class="text-center">Tax Name</th>
                                                    <th class="text-center">Percentage</th>
                                                    <th class="text-center">Active Status</th>
                                                    <th class="text-center noExport">action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
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
            const LoadTable = async () => {
                @if ($crud['view'] == 1)
                    $('#tblTax').dataTable({
                        "bProcessing": true,
                        "bServerSide": true,
                        "ajax": {
                            "url": "{{ url('/') }}/admin/master/tax/data?_token=" + $(
                                'meta[name=_token]').attr('content'),
                            "headers": {
                                'X-CSRF-Token': $('meta[name=_token]').attr('content')
                            },
                            "type": "POST"
                        },
                        deferRender: true,
                        responsive: true,
                        dom: 'Bfrtip',
                        "iDisplayLength": 10,
                        "lengthMenu": [
                            [10, 25, 50, 100, 250, 500, -1],
                            [10, 25, 50, 100, 250, 500, "All"]
                        ],
                        buttons: [
                            'pageLength'
                            @if ($crud['excel'] == 1)
                                , {
                                    extend: 'excel',
                                    footer: true,
                                    title: 'Tax',
                                    "action": DataTableExportOption,
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }
                            @endif
                            @if ($crud['copy'] == 1)
                                , {
                                    extend: 'copy',
                                    footer: true,
                                    title: 'Tax',
                                    "action": DataTableExportOption,
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }
                            @endif
                            @if ($crud['csv'] == 1)
                                , {
                                    extend: 'csv',
                                    footer: true,
                                    title: 'Tax',
                                    "action": DataTableExportOption,
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }
                            @endif
                            @if ($crud['print'] == 1)
                                , {
                                    extend: 'print',
                                    footer: true,
                                    title: 'Tax',
                                    "action": DataTableExportOption,
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }
                            @endif
                            @if ($crud['pdf'] == 1)
                                , {
                                    extend: 'pdf',
                                    footer: true,
                                    title: 'Tax',
                                    "action": DataTableExportOption,
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }
                            @endif
                        ],
                        columnDefs: [{
                            targets: '_all', // Apply to all columns
                            className: 'dt-center' // Center-align the content
                        }]

                    });
                @endif
            }
            $(document).on('click', '.btnEdit', function() {
                window.location.replace("{{ url('/') }}/admin/master/tax/edit/" + $(this).attr(
                    'data-id'));
            });
            $(document).on('click', '.btnDelete', function(e) {
                e.preventDefault();
                var id = $(this).attr("data-id");
                swal({
                    title: "Are you sure?",
                    text: "You want to Delete this tax!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, Delete it!",
                    closeOnConfirm: false
                }, function() {
                    swal.close();
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-Token': $('meta[name=_token]').attr('content')
                        },
                        url: "{{ url('/') }}/admin/master/tax/delete/" + id,
                        success: function(response) {
                            if (response.status == true) {
                                toastr.success(response.message, "Success", {
                                    positionClass: "toast-top-right",
                                    containerId: "toast-top-right",
                                    showMethod: "slideDown",
                                    hideMethod: "slideUp",
                                })
                                $('#tblTax').DataTable().ajax.reload();
                            } else {
                                toastr.error(response.message, "Failed", {
                                    positionClass: "toast-top-right",
                                    containerId: "toast-top-right",
                                    showMethod: "slideDown",
                                    hideMethod: "slideUp",
                                })
                            }
                        }
                    });
                });
            });
            LoadTable();
        });
    </script>
@endsection
