@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}/admin"><i class="f-16 fa fa-home"></i></a></li>
                        <li class="breadcrumb-item">{{ $PageTitle }}</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <div class="bookmark pull-right">
                        <a href="{{ url('/') }}/admin/home/gallery/upload" class="btn btn sm btn-outline-dark"
                            id="btnUploadGallery">Upload</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Gallery Images</h5>
                    </div>
                    <div class="my-gallery card-body row gallery-with-description">
                        @for ($i = 0; $i < count($galleryImages); $i++)
                            <figure class="col-xl-4 col-sm-6" data-tran-no="{{ $galleryImages[$i]->ID }}">
                                <a href="{{ url('/') }}/{{ $galleryImages[$i]->GalleryImage }}"
                                    data-lightbox="gallery-images">
                                    <img src="{{ url('/') }}/{{ $galleryImages[$i]->GalleryImage }}"
                                        alt="Image {{ $i }}">
                                </a>
                                <div class="caption text-center">
                                    @if ($crud['restore'] == 1)
                                        <button type="button" data-id="{{ $galleryImages[$i]->ID }}"
                                            class="btn btn-outline-success btn-sm  m-2 btnRestore"><i
                                                class="fa fa-repeat"></i></button>
                                    @endif
                                </div>
                            </figure>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    <link rel="stylesheet" href="{{ url('/') }}/assets/plugins/lightbox/css/lightbox.css">
    <script src="{{ url('/') }}/assets/plugins/lightbox/js/lightbox.js"></script>
    <script>
        $(document).ready(function() {
            $('.btnRestore').click(function() {
                var id = $(this).data('id');
                var figure = $(this).closest('figure'); // Get the parent figure element

                swal({
                    title: "Are you sure?",
                    text: "You want to Restore this Category!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, Restore it!",
                    closeOnConfirm: false,
                    closeOnCancel: true // Close popup on cancel
                }, function(isConfirm) {
                    // If user confirms
                    if (isConfirm) {
                        $.ajax({
                            type: 'POST',
                            url: 'restore/' + id,
                            headers: {
                                'X-CSRF-Token': $('meta[name=_token]').attr('content')
                            },
                            success: function(response) {
                                toastr.success(response.message, "Success");
                                // Remove the figure element from the page
                                figure.remove();
                                swal.close(); // Close popup on success
                            },
                            error: function(xhr, status, error) {
                                toastr.error("Failed to restore item.", "Error");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
