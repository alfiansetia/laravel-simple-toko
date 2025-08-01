@if (!empty($categories))
    <section class="py-5 overflow-hidden">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header d-flex flex-wrap justify-content-between mb-5">
                        <h2 class="section-title">Category</h2>

                        <div class="d-flex align-items-center">
                            <a href="#" class="btn-link text-decoration-none">View All Categories →</a>
                            <div class="swiper-buttons">
                                <button class="swiper-prev category-carousel-prev btn btn-yellow">❮</button>
                                <button class="swiper-next category-carousel-next btn btn-yellow">❯</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="category-carousel swiper">
                        <div class="swiper-wrapper">
                            @foreach ($categories as $item)
                                <a href="index.html" class="nav-link category-item swiper-slide">
                                    <img src="{{ asset('fe/images/icon-vegetables-broccoli.png') }}"
                                        alt="Category Thumbnail">
                                    <h3 class="category-title">{{ $item->name }}</h3>
                                </a>
                            @endforeach
                            {{-- <a href="index.html" class="nav-link category-item swiper-slide">
                                <img src="{{ asset('fe/images/icon-bread-baguette.png') }}" alt="Category Thumbnail">
                                <h3 class="category-title">Breads & Sweets</h3>
                            </a>
                            <a href="index.html" class="nav-link category-item swiper-slide">
                                <img src="{{ asset('fe/images/icon-soft-drinks-bottle.png') }}"
                                    alt="Category Thumbnail">
                                <h3 class="category-title">Fruits & Veges</h3>
                            </a>
                            <a href="index.html" class="nav-link category-item swiper-slide">
                                <img src="{{ asset('fe/images/icon-wine-glass-bottle.png') }}" alt="Category Thumbnail">
                                <h3 class="category-title">Fruits & Veges</h3>
                            </a>
                            <a href="index.html" class="nav-link category-item swiper-slide">
                                <img src="{{ asset('fe/images/icon-animal-products-drumsticks.png') }}"
                                    alt="Category Thumbnail">
                                <h3 class="category-title">Fruits & Veges</h3>
                            </a>
                            <a href="index.html" class="nav-link category-item swiper-slide">
                                <img src="{{ asset('fe/images/icon-bread-herb-flour.png') }}" alt="Category Thumbnail">
                                <h3 class="category-title">Fruits & Veges</h3>
                            </a>
                            <a href="index.html" class="nav-link category-item swiper-slide">
                                <img src="{{ asset('fe/images/icon-bread-herb-flour.png') }}" alt="Category Thumbnail">
                                <h3 class="category-title">Fruits & Veges</h3>
                            </a>
                            <a href="index.html" class="nav-link category-item swiper-slide">
                                <img src="{{ asset('fe/images/icon-bread-herb-flour.png') }}" alt="Category Thumbnail">
                                <h3 class="category-title">Fruits & Veges</h3>
                            </a>
                            <a href="index.html" class="nav-link category-item swiper-slide">
                                <img src="{{ asset('fe/images/icon-bread-herb-flour.png') }}" alt="Category Thumbnail">
                                <h3 class="category-title">Fruits & Veges</h3>
                            </a>
                            <a href="index.html" class="nav-link category-item swiper-slide">
                                <img src="{{ asset('fe/images/icon-bread-herb-flour.png') }}" alt="Category Thumbnail">
                                <h3 class="category-title">Fruits & Veges</h3>
                            </a>
                            <a href="index.html" class="nav-link category-item swiper-slide">
                                <img src="{{ asset('fe/images/icon-bread-herb-flour.png') }}" alt="Category Thumbnail">
                                <h3 class="category-title">Fruits & Veges</h3>
                            </a>
                            <a href="index.html" class="nav-link category-item swiper-slide">
                                <img src="{{ asset('fe/images/icon-bread-herb-flour.png') }}" alt="Category Thumbnail">
                                <h3 class="category-title">Fruits & Veges</h3>
                            </a> --}}

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endif
