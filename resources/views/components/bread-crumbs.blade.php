<div class="col-md-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white">
            @foreach ($links as $key => $link)
                @if ($loop->iteration == sizeof($links))
                    <li class="breadcrumb-item active" aria-current="page">{{ $key }}</li>
                @else
                    <li class="breadcrumb-item">
                        <a href="{{ $link }}">{{ $key }}</a>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
</div>
