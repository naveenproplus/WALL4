<div class="row">
    <div class="col-6 col-sm-4 fw-600">Service Name <span class="full-right"> : </span></div>
    <div class="col-6 col-sm-8 fw-600"> <a href="{{url('/')}}/services/{{$data->Slug}}" target="_blank"> {{$data->ServiceName}} <a></div>
</div>
<div class="row mt-20">
    <div class="col-6 col-sm-4 fw-600">Name <span class="full-right"> : </span></div>
    <div class="col-6 col-sm-8"> {{$data->Name}}</div>
</div>
<div class="row mt-20">
    <div class="col-6 col-sm-4 fw-600">E-Mail <span class="full-right"> : </span></div>
    <div class="col-6 col-sm-8">  {{$data->Email}}</div>
</div>
<div class="row mt-20">
    <div class="col-6 col-sm-4 fw-600">Mobile Number <span class="full-right"> : </span></div>
    <div class="col-6 col-sm-8"> {{$data->MobileNumber}}</div>
</div>
<div class="row mt-20">
    <div class="col-6 col-sm-4 fw-600">Enquiry On <span class="full-right"> : </span></div>
    <div class="col-6 col-sm-8">{{date($Settings['date-format']." ".$Settings['time-format'], strtotime($data->CreatedOn))}}</div>
</div>
