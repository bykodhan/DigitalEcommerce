<div class="card shadow-sm rounded-4 h-100 border-0 rounded-4">
    <span class="badge text-dark text-center">
        <i class="bi bi-box2-heart"></i>
        {{ $product->lead_time }}
    </span>
    @if ($product->discount)
        <div class="ribbon-wrapper ribbon-right" title="%{{ $product->discount }} İndirim. Kaçırma!">
            <div class="ribbon fw-bold bg-danger" style="cursor:default">
               %{{ $product->discount }} <i class="bi bi-arrow-down"></i>
            </div>
        </div>
    @endif
    <div class="thumb text-center">
        <img  style="max-height:220px !important" class="img-fluid " loading="lazy" src="{{ asset($product->img) }}" alt="{{ $product->title }}">

        <a class="btn btn-danger rounded-0 border-0 shadow w-75 py-3"
            href="{{ route('product.detail', ['id' => $product->id, 'slug' => $product->slug]) }}">
            <i class="bi bi-cart3"></i> SATIN AL
        </a>

    </div>

    <div class="bg-white rounded-4 text-center">
        <a href="{{ route('category', ['slug' => $product->category->slug]) }}"
            class="hvr-grow border-0 rounded-4 mx-auto " style="margin-top: -1.5rem;z-index:999;"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $product->category->title }}">
            <img class="shadow-sm rounded-circle img-thumbnail p-1" width="50"
                src="{{ asset($product->category->img) }}" alt="{{ $product->category->title }}">
        </a>
    </div>

    <div class="card-body d-flex flex-column m-1 p-1">
        <h5 class="fw-bold mb-2 hvr-forward text-center">
            <a class="link-dark"
                href="{{ route('product.detail', ['id' => $product->id, 'slug' => $product->slug]) }}">
                {{ $product->title }}
            </a>
        </h5>
        <div class="ms-2 d-flex flex-column mt-2 mb-auto">
            @if ($product->accept_features)
                @foreach (explode(',', $product->accept_features) as $value)
                    <span><i class="bi bi-check-circle-fill text-success"></i> {{ $value }}</span>
                @endforeach
            @endif
            @if ($product->unaccept_features)
                @foreach (explode(',', $product->unaccept_features) as $value)
                    <span><i class="bi bi-x-lg text-danger"></i> {{ $value }}</span>
                @endforeach
            @endif

        </div>
        <a title="Satın almak için tıkla!"
            class="btn btn-sm btn-outline-danger rounded-4 border-0 d-flex align-items-center" href="{{ route('product.detail', ['id' => $product->id, 'slug' => $product->slug]) }}">
            <div class="p-1 d-flex align-items-center mx-auto">
                <h5 title="Fiyat : 2.50" class="ms-2 mb-0 fw-bold">
                    @if($product->discount)
                        <del class="text-muted" style="font-size: 14px">{{ $product->price }} </del>
                        {{ $product->discount_price }} <sup>₺</sup>
                    @else
                        {{ $product->price }} <sup>₺</sup>
                    @endif
                </h5>
            </div>
        </a>

    </div>

</div>
