@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin"><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Enquiry</li>
					<li class="breadcrumb-item">{{$PageTitle}}</li>
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
								<div class="col-md-4">	</div>
								<div class="col-md-4 my-2">
									<h5>{{$PageTitle}}</h5>
								</div>
								<div class="col-md-4 my-2 text-right text-md-right">
									@if($crud['restore']==1)
										<a href="{{ url('/') }}/admin/enquiry/contact-us/restore" class="btn  btn-outline-dark btn-sm  full-right mr-10" type="button" >Restore</a>
									@endif
								</div>
							</div>
						</div>
						<div class="card-body " >
							<div class="row d-flex justify-content-center">
								<div class="col-sm-2 col-12">
									<div class="form-group">
										<label for="dtpFromDate">From Date</label>
										<input type="date" class="form-control" id="dtpFromDate" max="{{date('Y-m-d')}}" value="{{date('Y-m-01')}}">
									</div>
								</div>
								<div class="col-sm-2 col-12">
									<div class="form-group">
										<label for="dtpToDate">To Date</label>
										<input type="date" class="form-control" min="{{date('Y-m-d')}}" id="dtpToDate" value="{{date('Y-m-d')}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12 col-sm-12">
									<table class="table table-sm vertical-center" id="tblEnquiry">
										<thead>
											<tr>
												<th class="text-center">Date</th>
												<th class="text-center">Name</th>
												<th class="text-center">Mobile Number</th>
												<th class="text-center">E-Mail</th>
												<th class="text-center">Subject</th>
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
    $(document).ready(function(){
		let tblEnquiry=null;
        const LoadTable=async()=>{
			@if($crud['view']==1)
			if(tblEnquiry!=null){
				tblEnquiry.fnDestroy();
			}
			tblEnquiry=$('#tblEnquiry').dataTable( {
				"bProcessing": true,
				"bServerSide": true,
                "ajax": {"url": "{{url('/')}}/admin/enquiry/contact-us/data?FromDate="+$('#dtpFromDate').val()+"&ToDate="+$('#dtpToDate').val()+"&_token="+$('meta[name=_token]').attr('content'),"headers":{ 'X-CSRF-Token' : $('meta[name=_token]').attr('content') } ,"type": "POST"},
				deferRender: true,
				responsive: true,
				dom: 'Bfrtip',
				"iDisplayLength": 10,
				order: [[0, 'desc']],
				"lengthMenu": [[10, 25, 50,100,250,500, -1], [10, 25, 50,100,250,500, "All"]],
				buttons: [
					'pageLength' 
					@if($crud['excel']==1) ,{extend: 'excel',footer: true,title: '{{$PageTitle}}',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif 
					@if($crud['copy']==1) ,{extend: 'copy',footer: true,title: '{{$PageTitle}}',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['csv']==1) ,{extend: 'csv',footer: true,title: '{{$PageTitle}}',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['print']==1) ,{extend: 'print',footer: true,title: '{{$PageTitle}}',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['pdf']==1) ,{extend: 'pdf',footer: true,title: '{{$PageTitle}}',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
				],
				columnDefs: [{
					targets: '_all', // Apply to all columns
					className: 'dt-center' // Center-align the content
				}]
			});
			@endif
        }
		$(document).on('change','#dtpFromDate',function(){
			$('#dtpToDate').attr('min',$('#dtpFromDate').val());
			LoadTable();
		});
		$(document).on('change','#dtpToDate',function(){LoadTable();});
		$(document).on('click','.btnDelete',function(e){
        	e.preventDefault();
            var id = $(this).attr("data-id");
            swal({
                title: "Are you sure?",
                text: "You want to Delete this Enquiry!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-success",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: false
            },function(){
                swal.close();
                $.ajax({
                    type: "post",
                	headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    url: "{{url('/')}}/admin/enquiry/contact-us/delete/"+ id,
                    success: function (response) {
                        if(response.status==true){
                            toastr.success(response.message, "Success", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",})
                        	$('#tblEnquiry').DataTable().ajax.reload();
                		}else{
							toastr.error(response.message, "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",})
						}
					}
            	});
        	});
		});

		$(document).on('click','.btnView',function(e){
        	e.preventDefault();
            var id = $(this).attr("data-id");
            $.ajax({
                type: "post",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                url: "{{url('/')}}/admin/enquiry/contact-us/details/"+ id,
                success: function (response) {
                    if(response!=""){
						bootbox.dialog({
                            title: 'Contact Enquiry Details',
                            closeButton: true,
                            message: response,
                            size:'large',
                            buttons: {}
                        });
                	}
				}
            });
		});
        LoadTable();
    });
</script>
@endsection