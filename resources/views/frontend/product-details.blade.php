@extends('frontend.master')

@section('content')
    <main>
        <section class="product-details-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-12">
                        <div class="product-details-wrapper">
                            <div class="row">
                                <div class="col-lg-7 col-md-7">
                                    <div class="product-images-slider-outer">
                                        <div class="slider slider-content">
                                            @foreach ($product->galleryImage as $image)
                                                <div>
                                                    <img src="{{ $image->image }}" alt="slider images">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="slider slider-thumb">
                                            @foreach ($product->galleryImage as $image)
                                                <div>
                                                    <img src="{{ $image->image }}" alt="slider images">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5">
                                    <div class="product-details-content">
                                        <h3 class="product-name">
                                            {{ $product->name }}
                                        </h3>
                                        <div class="product-price">
                                            <span>{{ $product->discount_price }} Tk.</span>
                                            <span class="" style="color: #f74b81;">
                                                <del>{{ $product->regular_price }} Tk.</del>
                                            </span>
                                        </div>
                                        <form action="{{url('/add-cart-details/'.$product->id)}}" method="POST">
                                            @csrf
                                            <div class="product-details-select-items-wrap">
                                                @foreach ($product->color as $singleColor)
                                                <div class="product-details-select-item-outer">
                                                    <input type="radio" name="color" id="color" value="{{$singleColor->color_name}}"
                                                        class="category-item-radio">
                                                    <label for="color" class="category-item-label">
                                                        {{$singleColor->color_name}}
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="product-details-select-items-wrap">
                                                @foreach ($product->size as $singleSize)
                                                <div class="product-details-select-item-outer">
                                                    <input type="radio" name="size" value="{{$singleSize->size_name}}"
                                                        class="category-item-radio">
                                                    <label for="size" class="category-item-label">{{$singleSize->size_name}}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="purchase-info-outer">
                                                <div class="product-incremnt-decrement-outer" style="display: block">
                                                    <a title="Decrement" class="decrement-btn" style="margin-top: -10px;">
                                                        <i class="fas fa-minus"></i>
                                                    </a>
                                                    <input type="number" readonly name="qty" placeholder="Qty"
                                                        value="1" min="1" id="qty" style="height: 35px">
                                                    <a title="Increment" class="increment-btn" style="margin-top: -10px;">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </div>
                                                <div>
                                                    <button type="submit" name="action" value="addToCart" id="addToCart"
                                                        class="cart-btn-inner">
                                                        <i class="fas fa-shopping-cart"></i>
                                                        Add to Cart
                                                    </button>
                                                    <button type="submit" name="action" value="buyNow" id="buyNow"
                                                        class="cart-btn-inner">
                                                        <i class="fas fa-truck"></i>
                                                        Quick Order
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <button type="button" class="product-details-hot-line">
                                            <i class="fas fa-phone-alt"></i>
                                            For Call : 0123456854
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="product-details-info">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-description-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-description" type="button" role="tab"
                                            aria-controls="pills-description" aria-selected="true">
                                            Description
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-review-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-review" type="button" role="tab"
                                            aria-controls="pills-review" aria-selected="true">
                                            Review
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-policy-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-policy" type="button" role="tab"
                                            aria-controls="pills-policy" aria-selected="true">
                                            Product Policy
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-description" role="tabpanel"
                                        aria-labelledby="pills-description-tab">
                                        {!!$product->description!!}
                                    </div>
                                    <div class="tab-pane fade" id="pills-review" role="tabpanel"
                                        aria-labelledby="pills-review-tab">
                                        @foreach ($product->review as $review)
                                        <div class="review-item-wrapper">
                                            <div class="review-item-left">
                                                @if ($review->image != null)
                                                    <img src="{{$review->image}}" height="50" width="50">
                                                    @else
                                                    <i class="fas fa-user"></i>
                                                @endif
                                            </div>
                                            <div class="review-item-right">
                                                <h4 class="review-author-name">
                                                    {{$review->customer_name}}
                                                    <span
                                                        class=" d-inline bg-danger badge-sm badge text-white">Verified</span>
                                                </h4>
                                                <p class="review-item-message">
                                                    {{$review->comments}}
                                                </p>
                                                <span class="review-item-rating-stars">
                                                    @if ($review->rating==5)
                                                        <i class="fa-star fas"></i>
                                                        <i class="fa-star fas"></i>
                                                        <i class="fa-star fas"></i>
                                                        <i class="fa-star fas"></i>
                                                        <i class="fa-star fas"></i>
                                                    @elseif ($review->rating==4)
                                                        <i class="fa-star fas"></i>
                                                        <i class="fa-star fas"></i>
                                                        <i class="fa-star fas"></i>
                                                        <i class="fa-star fas"></i>
                                                        <i class="fa-star fa"></i>
                                                    @elseif ($review->rating==3)
                                                        <i class="fa-star fas"></i>
                                                        <i class="fa-star fas"></i>
                                                        <i class="fa-star fas"></i>
                                                        <i class="fa-star fa"></i>
                                                        <i class="fa-star fa"></i>
                                                    @elseif ($review->rating==2)
                                                        <i class="fa-star fas"></i>
                                                        <i class="fa-star fas"></i>
                                                        <i class="fa-star fa"></i>
                                                        <i class="fa-star fa"></i>
                                                        <i class="fa-star fa"></i>
                                                    @else
                                                        <i class="fa-star fas"></i>
                                                        <i class="fa-star fa"></i>
                                                        <i class="fa-star fa"></i>
                                                        <i class="fa-star fa"></i>
                                                        <i class="fa-star fa"></i>  
                                                    @endif

                                                </span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="tab-pane fade" id="pills-policy" role="tabpanel"
                                        aria-labelledby="pills-policy-tab">
                                        {!!$product->product_policy!!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <div class="product-details-sidebar">
                            <div class="product-details-categoris">
                                <h3 class="product-details-title">
                                    Category
                                </h3>
                                @foreach ($detailsPageCategory as $category)
                                <a href="{{url('/category-products/'.$category->slug)}}" class="category-item-outer">
                                    <img src="{{$category->image}}" alt="category image">
                                    {{$category->name}}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                                        <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="product-page-header-wrapper">
                                    <div class="left-side-box">
                                        <h4 class="title">
                                            Related Products
                                        </h4>
                                    </div>
                                    <div class="right-side-box">
                                        <h4 class="product-qty">
                                            Total Products
                                            <span class="number">{{$products->count()}}</span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            @foreach ($products as $product)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="product__item-outer">
                                    <div class="product__item-image-outer">
                                        <a href="{{url('/product-details/'.$product->slug)}}" class="product__item-image-inner">
                                            <img src="{{$product->image}}" alt="Product Image" />
                                        </a>
                                        <div class="product__item-add-cart-btn-outer">
                                            <a href="{{url('/add-cart/'.$product->id)}}" class="product__item-add-cart-btn-inner">
                                                Add to Cart
                                            </a>
                                        </div>
                                        <div class="product__type-badge-outer">
                                            <span class="product__type-badge-inner">
                                               {{ucfirst($product->product_type)}}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="product__item-info-outer">
                                        <a href="{{url('/product-details/'.$product->slug)}}" class="product__item-name">
                                            {{$product->name}}
                                        </a>
                                        <div class="product__item-price-outer">
                                            <div class="product__item-discount-price">
                                                <del>{{$product->regular_price}} Tk.</del>
                                            </div>
                                            <div class="product__item-regular-price">
                                                <span>{{$product->discount_price}} Tk.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('script')
    <script>
        let qtyInput = document.getElementById('qty');

        let plusBtn = document.querySelector('.increment-btn');
        let minusBtn = document.querySelector('.decrement-btn');

        plusBtn.addEventListener('click', function(){
            if(parseInt(qtyInput.value) < 5){
                qtyInput.value = parseInt(qtyInput.value) + 1;
            }
        });

        minusBtn.addEventListener('click', function(){
            if(parseInt(qtyInput.value) > 1){
                qtyInput.value = parseInt(qtyInput.value) - 1;
            }
        });

    </script>
@endpush
