<section class="py-5 pt-0">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="bootstrap-tabs product-tabs">
                    <div class="tabs-header d-flex justify-content-between border-bottom my-5">
                        <h3>Products</h3>
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                @foreach ($categories as $item)
                                    <a href="#"
                                        class="nav-link text-uppercase fs-6 {{ $loop->first ? 'active' : '' }}"
                                        id="cat{{ $item->id }}-tab" data-bs-toggle="tab"
                                        data-bs-target="#cat{{ $item->id }}" role="tab"
                                        aria-controls="cat{{ $item->id }}"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                        {{ $item->name }}
                                    </a>
                                @endforeach


                            </div>
                        </nav>
                    </div>
                    <div class="tab-content" id="nav-tabContent">


                        @foreach ($categories as $category)
                            @php
                                $items = $products[$category->id] ?? collect();
                            @endphp

                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="cat{{ $category->id }}" role="tabpanel"
                                aria-labelledby="cat{{ $category->id }}-tab">

                                <div
                                    class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">

                                    @foreach ($items as $item)
                                        <div class="col">
                                            <div class="product-item">
                                                {{-- <span class="badge bg-success position-absolute m-3">-30%</span> --}}
                                                <button type="button" onclick="add_to_cart('{{ $item->id }}')"
                                                    class="btn-wishlist">
                                                    <svg width="24" height="24">
                                                        <use xlink:href="#cart"></use>
                                                    </svg>
                                                </button>
                                                <figure>
                                                    <a href="javascript:void(0);" title="Product Title">
                                                        <img src="{{ $item->image }}" class="tab-image">
                                                    </a>
                                                </figure>
                                                <h3>{{ $item->name }}</h3>
                                                <span class="qty">{{ $item->category->name }}</span>
                                                {{-- <span class="rating">
                                                    <svg width="24" height="24" class="text-primary">
                                                        <use xlink:href="#star-solid"></use>
                                                    </svg> 4.5
                                                </span> --}}
                                                <span class="price">{{ hrg($item->price) }}</span>
                                                {{-- <div class="d-flex align-items-center justify-content-between">
                                                    <div class="input-group product-qty">
                                                        <span class="input-group-btn">
                                                            <button type="button"
                                                                class="quantity-left-minus btn btn-danger btn-number"
                                                                data-type="minus">
                                                                <svg width="16" height="16">
                                                                    <use xlink:href="#minus"></use>
                                                                </svg>
                                                            </button>
                                                        </span>
                                                        <input type="text" name="quantity"
                                                            class="form-control input-number" value="1">
                                                        <span class="input-group-btn">
                                                            <button type="button"
                                                                class="quantity-right-plus btn btn-success btn-number"
                                                                data-type="plus">
                                                                <svg width="16" height="16">
                                                                    <use xlink:href="#plus"></use>
                                                                </svg>
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <a href="#" class="nav-link">Add to Cart
                                                        <iconify-icon icon="uil:shopping-cart"></iconify-icon>
                                                    </a>
                                                </div> --}}
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<form action="{{ route('fe.cart.store') }}" id="add-to-cart" method="POST">
    @csrf
    <input type="hidden" id="cart_product" name="product_id" value="0">
</form>

@push('js')
    <script>
        function add_to_cart(id) {
            document.getElementById('cart_product').value = id;
            document.getElementById('add-to-cart').submit();
        }
    </script>
@endpush
