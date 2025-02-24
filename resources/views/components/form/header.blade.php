<div class="col-12">
    <div class="row row-main-order">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="validate_form">
            @csrf
            @if ($method == 'PUT')
                @method('PUT')
            @endif
            <div class="card-bg px-4">
                <div class="card-create-survey">
                    <h3 class="block-title border-bottom mb-4 pb-4"> {{ $title }}</h3>
