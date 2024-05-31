@extends('layouts.home')
@section('content')
    <div class="breadcrumb-main">
        <div class="container">
            <div class="breadcrumb-container">
                <h2 class="page-title">FAQ</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/') }}/faq">FAQ</a></li>
                </ul>
            </div>
        </div>
    </div>
    <main>
        <div id="service-category" class="container">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <!-- Accordion items will be dynamically populated here -->
            </div>
        </div>
    </main>

     <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ url('/') }}/get/faq",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    response.forEach(function(faq, index) {
                        var accordionItem = `
                        <div class="accordion-item border">
                            <h2 class="accordion-header" id="flush-heading${index}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapse${index}" aria-expanded="false" aria-controls="flush-collapse${index}">
                                    ${faq.FAQ}
                                </button>
                            </h2>
                            <div id="flush-collapse${index}" class="accordion-collapse collapse" aria-labelledby="flush-heading${index}"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">${faq.Answer}</div>
                            </div>
                        </div>
                    `;
                        $('#accordionFlushExample').append(accordionItem);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // Handle error here
                }
            });
        });
    </script>
@endsection
