@extends('layouts.home')
@section('content')
@if($PageContent->PageContent!="")
    <section>
        <div class="container">
        <div class="row" style="margin:20px;">
            <div class="col-sm-12 ">
            <?php echo $PageContent->PageContent; ?>
            </div>
        </div>
        </div>
    </section>
@endif
@endsection