    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item home"><a href="{{ route('root') }}"></a></li>
                    @if (!empty($parent_title))
                        <li class="breadcrumb-item"><a href="{{ route($parent_route) }}">{{ $parent_title }}</a></li>
                    @endif
                    @if (!empty($title))
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    @endif
                </ol>
            </nav>
        </div>
