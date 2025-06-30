@extends('layouts.frontend')
@section('content')
    <section class="py-5 pb-0 pt-1" style="background: url({{ asset('fe/images/background-pattern.jpg') }});">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <h1 class="page-title pb-2">Daftar Keranjang</h1>
                <nav class="breadcrumb fs-6">
                    <a class="breadcrumb-item nav-link" href="{{ route('fe.index') }}">Home</a>
                    {{-- <a class="breadcrumb-item nav-link" href="#">Pages</a> --}}
                    <span class="breadcrumb-item active" aria-current="page">Keranjang</span>
                </nav>
            </div>
        </div>
    </section>

    <section class="py-5 pt-1">
        <div class="container-fluid">
            <div class="row g-5">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">

                            <div class="table-responsive cart">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="card-title text-uppercase text-muted">Produk</th>
                                            <th scope="col" class="card-title text-uppercase text-muted">Quantity</th>
                                            <th scope="col" class="card-title text-uppercase text-muted">Subtotal</th>
                                            <th scope="col" class="card-title text-uppercase text-muted"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0;
                                        @endphp
                                        @forelse ($carts as $item)
                                            @php
                                                $total += $item->qty * $item->product->price;
                                            @endphp
                                            <tr>
                                                <td scope="row" class="py-4 pb-0">
                                                    <div class="cart-info d-flex flex-wrap align-items-center mb-1">
                                                        <div class="col-lg-3">
                                                            <div class="card-image">
                                                                <img src="{{ $item->product->image }}" alt="cloth"
                                                                    class="img-fluid" width="50">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="card-detail ps-3">
                                                                <h5 class="card-title">
                                                                    <a href="javascript:void(0);"
                                                                        class="text-decoration-none">{{ $item->product->name }}
                                                                        ({{ $item->product->category->name }})
                                                                    </a>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-4 pb-0">
                                                    {{ $item->qty }} x {{ hrg($item->product->price) }}
                                                </td>
                                                <td class="py-4 pb-0">
                                                    <div class="total-price">
                                                        <span
                                                            class="money text-dark">{{ hrg($item->qty * $item->product->price) }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-4 pb-0">
                                                    <div class="cart-remove">
                                                        <a href="javascript:void(0);"
                                                            onclick="remove_from_cart('{{ $item->id }}')">
                                                            <svg width="24" height="24">
                                                                <use xlink:href="#trash"></use>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            Keranjang Kosong
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">

                            <div class="cart-totals bg-grey py-5 pt-0">
                                <h4 class="text-dark pb-4">Total Keranjang</h4>
                                <div class="total-price pb-2">
                                    <table cellspacing="0" class="table text-uppercase">
                                        <tbody>
                                            <tr class="order-total pt-2 pb-2 border-bottom">
                                                <th>Total</th>
                                                <td data-title="Total">
                                                    <span class="price-amount amount text-dark ps-5">
                                                        <bdi>
                                                            <span
                                                                class="price-currency-symbol"></span>{{ hrg($total) }}</bdi>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="button-wrap row g-2">
                                    <div class="col-md-12">
                                        <a href="https://api.whatsapp.com/send/?phone=6282324129752&text=Halo saya ada pertanyaan&type=phone_number&app_absent=0"
                                            target="_blank"
                                            class="btn btn-success py-3 px-4 text-uppercase btn-rounded-none w-100 mb-2">Chat
                                            Whatsapp Admin</a>
                                        <form action="{{ route('fe.cart.checkout') }}" method="POST">
                                            @csrf
                                            <button type="submit" @disabled(count($carts ?? []) < 1)
                                                class="btn btn-primary py-3 px-4 text-uppercase btn-rounded-none w-100">Proceed
                                                to
                                                checkout</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <form action="" id="remove-from-cart" method="POST">
        @csrf
        @method('DELETE')
    </form>
@endsection
@push('js')
    <script>
        function remove_from_cart(cartId) {
            const form = document.getElementById('remove-from-cart');
            form.action = "{{ route('fe.cart.index') }}/" + cartId;
            form.submit();
        }
    </script>
@endpush
