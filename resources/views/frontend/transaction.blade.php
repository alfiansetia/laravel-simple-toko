@extends('layouts.frontend')
@section('content')
    <section class="py-5 pb-0 pt-1" style="background: url({{ asset('fe/images/background-pattern.jpg') }});">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <h1 class="page-title pb-2">Detail Transaksi {{ $data->code }}</h1>
                <nav class="breadcrumb fs-6">
                    <a class="breadcrumb-item nav-link" href="{{ route('fe.index') }}">Home</a>
                    {{-- <a class="breadcrumb-item nav-link" href="#">Pages</a> --}}
                    <span class="breadcrumb-item active" aria-current="page">profile</span>
                </nav>
            </div>
        </div>
    </section>

    <section class="py-5 pt-2">
        <div class="container-fluid">
            <div class="row g-5">
                <div class="col-md-4">
                    <div class="cart-totals bg-grey py-5 pt-0">
                        <div class="total-price pb-2">
                            <table cellspacing="0" class="table text-uppercase">
                                <tbody>
                                    <tr class="order-total pt-2 pb-2 border-bottom">
                                        <th>Tanggal</th>
                                        <td data-title="Total">
                                            <span class="price-amount amount text-dark ps-5">
                                                <bdi>
                                                    <span class="price-currency-symbol"></span>{{ $data->date }}</bdi>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="order-total pt-2 pb-2 border-bottom">
                                        <th>Kode</th>
                                        <td data-title="Total">
                                            <span class="price-amount amount text-dark ps-5">
                                                <bdi>
                                                    <span class="price-currency-symbol"></span>{{ $data->code }}</bdi>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="order-total pt-2 pb-2 border-bottom">
                                        <th>Total</th>
                                        <td data-title="Total">
                                            <span class="price-amount amount text-dark ps-5">
                                                <bdi>
                                                    <span class="price-currency-symbol"></span>{{ hrg($data->total) }}</bdi>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="order-total pt-2 pb-2 border-bottom">
                                        <th>Status</th>
                                        <td data-title="Total">
                                            <span class="price-amount amount text-dark ps-5">
                                                <bdi>
                                                    <span class="price-currency-symbol"></span>{{ $data->status }}</bdi>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="button-wrap row g-2">
                            <div class="col-md-12">
                                @if ($data->isDone())
                                    <a href="{{ route('fe.transaction.download', $data->code) }}"
                                        class="btn btn-success py-3 px-4 text-uppercase btn-rounded-none w-100">Download
                                        Bukti</a>
                                @else
                                    <a href="https://api.whatsapp.com/send/?phone={{ config('services.whatsapp_admin') }}&text=Halo, Mohon konfirmasi pesanan saya, Order {{ $data->code }}&type=phone_number&app_absent=0"
                                        target="_blank"
                                        class="btn btn-primary py-3 px-4 text-uppercase btn-rounded-none w-100">Chat
                                        Admin</a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">

                    <div class="table-responsive cart">
                        <table class="table" style="cursor: pointer">
                            <thead>
                                <tr>
                                    <th scope="col" class="card-title text-uppercase text-muted">Product</th>
                                    <th scope="col" class="card-title text-uppercase text-muted">Qty</th>
                                    <th scope="col" class="card-title text-uppercase text-muted">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data->items as $item)
                                    <tr>
                                        <td scope="row" class="py-4 pb-0">
                                            <div class="cart-info d-flex flex-wrap align-items-center mb-1">
                                                <div class="col-lg-3">
                                                    <div class="card-image">
                                                        <img src="{{ $item->product->image_url }}" alt="cloth"
                                                            class="img-fluid" width="50">
                                                    </div>
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="card-detail ps-3">
                                                        <h5 class="card-title">
                                                            {{ $item->product->name }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td scope="row" class="py-4 pb-0">
                                            {{ $item->qty }} x {{ hrg($item->price) }}
                                        </td>
                                        <td class="py-4 pb-0">
                                            <div class="total-price">
                                                <span class="money text-dark">{{ hrg($item->qty * $item->price) }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    Item Kosong
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection
