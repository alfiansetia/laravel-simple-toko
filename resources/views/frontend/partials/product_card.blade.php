<section class="py-5 pt-0">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="bootstrap-tabs product-tabs">
                    <div class="tabs-header d-flex justify-content-between border-bottom my-5 mt-2 mb-2">
                        <h3>Products</h3>
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                @foreach ($products as $item)
                                    <a href="#"
                                        class="nav-link text-uppercase fs-6 {{ $loop->first ? 'active' : '' }}"
                                        id="cat{{ $item->first()->category->id }}-tab" data-bs-toggle="tab"
                                        data-bs-target="#cat{{ $item->first()->category->id }}" role="tab"
                                        aria-controls="cat{{ $item->first()->category->id }}"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                        {{ $item->first()->category->name }}
                                    </a>
                                @endforeach


                            </div>
                        </nav>
                    </div>
                    <div class="tab-content" id="nav-tabContent">
                        @foreach ($products as $group)
                            @php
                                $category = $group->first()->category;
                            @endphp
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="cat{{ $category->id }}" role="tabpanel"
                                aria-labelledby="cat{{ $category->id }}-tab">

                                <div
                                    class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                                    @foreach ($group as $item)
                                        <div class="col">
                                            <div class="product-item">
                                                <button type="button" onclick="add_to_cart('{{ $item->id }}')"
                                                    class="btn-wishlist">
                                                    <svg width="24" height="24">
                                                        <use xlink:href="#cart"></use>
                                                    </svg>
                                                </button>
                                                <figure>
                                                    <a href="javascript:void(0);" title="{{ $item->name }}">
                                                        <img src="{{ $item->image }}" class="tab-image">
                                                    </a>
                                                </figure>
                                                <h3>{{ $item->name }}</h3>
                                                <span class="qty">{{ $item->category->name }}</span>
                                                <span class="price">{{ hrg($item->price) }}</span>
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
