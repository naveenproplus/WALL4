@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/chartist.css">
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/rating.css">
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-lg-6">
				<ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}/admin"><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Dashboard</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 box-col-12">
            <div class="card card-with-border">
                <div class="card-header p-10"><div class="card-title fw-600 fs-16">Services</div></div>
                <div class="card-body p-0 m-0">
                    <div class="row project-details m-0 social-row py-4 d-flex justify-content-center">
                        <div class="col-sm-3 col-6">
                            <div class="project-incomes text-center">
                                <i class="fa fa-thumbs-up fs-24 txt-success"></i>
                                <h6 class="mb-0 mt-20">Active</h6>
                                <p class="mb-0 mt-10 fw-600">{{$Services['Active']}}</p>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="project-incomes text-center">

                                <i class="fa fa-thumbs-down fs-24 txt-warning"></i>
                                <h6 class="mb-0 mt-20">Inactive</h6>
                                <p class="mb-0 mt-10 fw-600">{{$Services['Inactive']}}</p>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="project-incomes text-center">

                                <i class="fa fa-trash fs-24 txt-danger"></i>
                                <h6 class="mb-0 mt-20">Deleted</h6>
                                <p class="mb-0 mt-10 fw-600">{{$Services['Deleted']}}</p>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6" style="border:none;">
                            <div class="project-incomes text-center">

                                <i class="fa fa-check fs-24 txt-success"></i>
                                <h6 class="mb-0 mt-20">Total</h6>
                                <p class="mb-0 mt-10 fw-600">{{$Services['Total']}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row d-none">
        <div class="col-sm-12 box-col-12">
            <div class="card card-with-border">
                <div class="card-header p-10"><div class="card-title fw-600 fs-16">Users</div></div>
                <div class="card-body p-0 m-0">
                    <div class="row project-details m-0 social-row py-4 d-flex justify-content-center">
                        <div class="col-sm-3 col-6">
                            <div class="project-incomes text-center">
                                <i class="fa fa-user-plus fs-24 txt-success"></i>
                                <h6 class="mb-0 mt-20">Active</h6>
                                <p class="mb-0 mt-10 fw-600">{{$Users['Active']}}</p>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="project-incomes text-center">

                                <i class="fa fa-user-o fs-24 txt-warning"></i>
                                <h6 class="mb-0 mt-20">Inactive</h6>
                                <p class="mb-0 mt-10 fw-600">{{$Users['Inactive']}}</p>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="project-incomes text-center">

                                <i class="fa fa-user-times fs-24 txt-danger"></i>
                                <h6 class="mb-0 mt-20">Deleted</h6>
                                <p class="mb-0 mt-10 fw-600">{{$Users['Deleted']}}</p>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6" style="border:none;">
                            <div class="project-incomes text-center">

                                <i class="fa fa-users fs-24 txt-success"></i>
                                <h6 class="mb-0 mt-20">Total</h6>
                                <p class="mb-0 mt-10 fw-600">{{$Users['Total']}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header"><h5 class="card-title"> Service Enquiries </h5></div>
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Year</label>
                                <select class="form-control select2" id="lstYear">
                                    <option value="">Select a year</option>
                                    @for($year=intval($Settings['app-init-year']);$year<=date("Y");$year++)
                                        <option @if(date("Y")==$year) selected @endif  value="{{$year}}">{{$year}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Month</label>
                                <select class="form-control select2" id="lstMonth">
                                    <option value="">Select a month</option>
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 table-responsive pb-20" id="divServiceEnquiryChart">
                            <div class="service-enquiries flot-chart-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($cruds_1['Services']['view']==1)
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header"><h5 class="card-title">Recently  Added Services</h5><span class="full-right fs-14 fw-600"><a href="{{url('/')}}/admin/master/services">View All</a></span></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-sm" id="tblServices">
                                <thead>
                                    <tr>
										<th class="text-center">Date & Time</th>
										<th class="text-center">Service Name</th>
										<th class="text-center">Category</th>
										<th class="text-center">Price</th>
										<th class="text-center">Active Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($RecentServices as $index=>$Item)
                                        <tr>
                                            <td>{{date($Settings['date-format']." ".$Settings['time-format'],strtotime($Item->CreatedOn))}}</td>
                                            <td><a target="_blank" href="{{url('/')}}/services/{{$Item->Slug}}">{{$Item->ServiceName}}</a></td>

                                            <td>{{$Item->CategoryName}}</td>
                                           
                                            <td class="text-right">{{NumberFormat($Item->Price,$Settings['price-decimals'])}}</td>
                                            <td class="text-center">
                                                @if($Item->ActiveStatus)
                                                    <span class='badge badge-success m-1'>Active</span>
                                                @else
                                                    <span class='badge badge-danger m-1'>Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if($cruds_1['ServiceEnquiries']['view']==1)
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header"><h5 class="card-title">Recent Service Enquiries</h5><span class="full-right fs-14 fw-600"><a href="{{url('/')}}/admin/enquiry/service">View All</a></span></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-sm" id="tblServiceEnquiries">
                                <thead>
                                    <tr>
										<th class="text-center">Date & Time</th>
										<th class="text-center">Service</th>
										<th class="text-center">Name</th>
										<th class="text-center">Mobile Number</th>
										{{-- <th class="text-center">E-Mail</th>
										<th class="text-center">Subject</th> --}}
										<th class="text-center noExport">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ServiceEnquiries as $index=>$Item)
                                        <tr>
                                            <td>{{date($Settings['date-format']." ".$Settings['time-format'],strtotime($Item->CreatedOn))}}</td>
                                            <td><a target="_blank" href="{{url('/')}}/services/{{$Item->Slug}}">{{$Item->ServiceName}}</a></td>
                                            <td>{{$Item->Name}}</td>
                                            <td>{{$Item->MobileNumber}}</td>
                                            {{-- <td>{{$Item->Email}}</td>
                                            <td>{{$Item->Subject}}</td> --}}
                                            <td class="text-center">
                                                <button type="button" data-id="{{$Item->TranNo}}" class="btn  btn-outline-primary m-5 btnServiceEnquiryView" data-original-title="View Enquiry"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if($cruds_1['ContactEnquiries']['view']==1)
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header"><h5 class="card-title">Recent Contact Enquiries</h5> <span class="full-right fs-14 fw-600"><a href="{{url('/')}}/admin/enquiry/contact-us">View All</a></span></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-sm" id="txtContactEnquiries">
                                <thead>
                                    <tr>
										<th class="text-center">Date & Time</th>
										<th class="text-center">Name</th>
										<th class="text-center">Mobile Number</th>
										<th class="text-center">E-Mail</th>
										<th class="text-center">Subject</th>
										<th class="text-center noExport">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ContactEnquiries as $index=>$Item)
                                        <tr>
                                            <td>{{date($Settings['date-format']." ".$Settings['time-format'],strtotime($Item->CreatedOn))}}</td>
                                            <td>{{$Item->Name}}</td>
                                            <td>{{$Item->MobileNumber}}</td>
                                            <td>{{$Item->Email}}</td>
                                            <td>{{$Item->Subject}}</td>
                                            <td class="text-center">
                                                <button type="button" data-id="{{$Item->TranNo}}" class="btn  btn-outline-primary m-5 btnContactEnquiryView" data-original-title="View Enquiry"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
<style></style>
<script src="{{url('/')}}/assets/js/chart/chartist/chartist.js"></script>
<script src="{{url('/')}}/assets/js/chart/chartist/chartist-plugin-tooltip.js"></script>
<script src="{{url('/')}}/assets/js/chart/apex-chart/apex-chart.js"></script>
<script src="{{url('/')}}/assets/js/chart/apex-chart/stock-prices.js"></script>
<script src="{{url('/')}}/assets/js/counter/jquery.waypoints.min.js"></script>
<script src="{{url('/')}}/assets/js/counter/jquery.counterup.min.js"></script>
<script src="{{url('/')}}/assets/js/counter/counter-custom.js"></script>
<script src="{{url('/')}}/assets/js/rating/jquery.barrating.js"></script>
<script src="{{url('/')}}/assets/js/rating/rating-script.js"></script>
<script>
    $(document).ready(function(){

        const appInit=async()=>{
            getServiceEnquiryData();
            $('#tblServices').dataTable({
				deferRender: true,
				responsive: true,
				dom: 'Bfrtip',
				"iDisplayLength": 10,
                searching:false,
                info:false,
                ordering: false,
                paging: false,
				order: [[0, 'desc']],
				"lengthMenu": [[10, 25, 50,100,250,500, -1], [10, 25, 50,100,250,500, "All"]],
                buttons: [],
                 columnDefs: [{
                className: "text-center",
                targets: "_all"
            }]
            });
            $('#tblServiceEnquiries').dataTable({
				deferRender: true,
				responsive: true,
				dom: 'Bfrtip',
				"iDisplayLength": 10,
                searching:false,
                info:false,
                ordering: false,
                paging: false,
				order: [[0, 'desc']],
				"lengthMenu": [[10, 25, 50,100,250,500, -1], [10, 25, 50,100,250,500, "All"]],
                buttons: [],
                 columnDefs: [{
                className: "text-center",
                targets: "_all"
            }]
            });
            $('#txtContactEnquiries').dataTable({
				deferRender: true,
				responsive: true,
				dom: 'Bfrtip',
				"iDisplayLength": 10,
                searching:false,
                info:false,
                ordering: false,
                paging: false,
				order: [[0, 'desc']],
				"lengthMenu": [[10, 25, 50,100,250,500, -1], [10, 25, 50,100,250,500, "All"]],
                buttons: [], 
                columnDefs: [{
                className: "text-center",
                targets: "_all"
            }]
            });
        }
        const getServiceEnquiryData=async()=>{
            $('#divServiceEnquiryChart').html('<div class="service-enquiries flot-chart-container"></div>');
            let Year=await $('#lstYear').val();
            let Month=await $('#lstMonth').val();
            $.ajax({
                type: "post",
                data:{Year,Month},
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                url: "{{url('/')}}/admin/dashboard/get/service-enquiry-chart",
                success: function (response) {

                    ServiceEnquiryChart(response);
				}
            });
        }
        const ServiceEnquiryChart=async (data)=>{
            new Chartist.Bar('.service-enquiries', data,
            {
                stackBars: true,
                axisX: {
                    labelInterpolationFnc: function(value) {
                        return value.split(/\s+/).map(function(word) {
                            return word[0];
                        }).join('');
                    }
                },
                axisY: {
                    offset: 20
                }
            },
            [
                ['screen and (min-width: 400px)', {
                    reverseData: true,
                    horizontalBars: true,
                    axisX: {
                        labelInterpolationFnc: Chartist.noop
                    },
                    axisY: {
                        offset: 60
                    }
                }],
                ['screen and (min-width: 800px)', {
                    stackBars: false,
                    seriesBarDistance: 10
                }],
                ['screen and (min-width: 1000px)', {
                    reverseData: false,
                    horizontalBars: false,
                    seriesBarDistance: 15
                }]
            ]);
        }

		$(document).on('click','.btnServiceEnquiryView',function(e){
        	e.preventDefault();
            var id = $(this).attr("data-id");
            $.ajax({
                type: "post",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                url: "{{url('/')}}/admin/enquiry/service/details/"+ id,
                success: function (response) {
                    if(response!=""){
						bootbox.dialog({
                            title: 'Service Enquiry Details',
                            closeButton: true,
                            message: response,
                            size:'large',
                            buttons: {}
                        });
                	}
				}
            });
		});

		$(document).on('click','.btnContactEnquiryView',function(e){
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
		$(document).on('change','#lstYear',function(e){getServiceEnquiryData();});
        $(document).on('change','#lstMonth',function(e){getServiceEnquiryData();});
        appInit();
    });
</script>
@endsection
