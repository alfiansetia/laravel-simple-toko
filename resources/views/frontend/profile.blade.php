@extends('layouts.frontend')
@section('content')
    <section class="py-5 pb-0" style="background: url({{ asset('fe/images/background-pattern.jpg') }});">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <h1 class="page-title pb-2">List Transaction</h1>
                <nav class="breadcrumb fs-6">
                    <a class="breadcrumb-item nav-link" href="{{ route('fe.index') }}">Home</a>
                    {{-- <a class="breadcrumb-item nav-link" href="#">Pages</a> --}}
                    <span class="breadcrumb-item active" aria-current="page">profile</span>
                </nav>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container-fluid">
            <div class="row g-5">
                <div class="col-12">

                    <div class="table-responsive cart">
                        <table class="table" style="cursor: pointer">
                            <thead>
                                <tr>
                                    <th scope="col" class="card-title text-uppercase text-muted">Date</th>
                                    <th scope="col" class="card-title text-uppercase text-muted">Code</th>
                                    <th scope="col" class="card-title text-uppercase text-muted">Total</th>
                                    <th scope="col" class="card-title text-uppercase text-muted">Status</th>
                                    <th scope="col" class="card-title text-uppercase text-muted"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $item)
                                    <tr>
                                        <td scope="row" class="py-4 pb-0">
                                            {{ $item->date }}
                                        </td>
                                        <td scope="row" class="py-4 pb-0">
                                            <a
                                                href="{{ route('fe.transaction.detail', $item->code) }}"><b>{{ $item->code }}</b></a>
                                        </td>
                                        <td class="py-4 pb-0">
                                            <div class="total-price">
                                                <span class="money text-dark">{{ hrg($item->total) }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 pb-0">
                                            <div class="total-price">
                                                <span class="money text-dark">{{ $item->status }}</span>
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
                                    Empty cart
                                @endforelse
                            </tbody>
                        </table>
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
