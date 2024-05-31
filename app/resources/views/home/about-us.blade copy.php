@extends('layouts.home')
@section('content')
<style>
    .blog-left{
        border-radius: 0 30px 0 0;
        background: transparent;
        box-shadow: none;
    }
    .blog-right{
        border-radius: 0 0 0 30px;
        background: transparent;
        box-shadow: none;
    }
    .blog-desc{
        
    }
</style>
@if($PageContent->PageContent!="")

    <section>
        <div class="row" style="margin:20px;">
            <div class="col-sm-12 "><?php echo $PageContent->PageContent; ?></div>
        </div>
    </section>

@endif
@endsection