@extends('home.home-layout')
@section('home-content')
@if($Page->PageContent!="")
    <section>
        <div class="container">
        <div class="row">
            <h4 class="text-center mt-5">{{$PageTitle}}</h4>
            <div class="col-sm-12 ">
            {!!$Page->PageContent!!}
            </div>
        </div>
        </div>
    </section>
@endif
@endsection