@extends('layouts.frontend')
@section('content')
    <section class="py-5 pt-1">
        <div class="container-fluid">
            <div class="row g-5">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>Profile</h5>
                            <form method="POST" action="{{ route('fe.profile.update') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ $user->name }}" placeholder="Nama"
                                        required autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="whatsapp" class="form-label">No Whatsapp</label>
                                    <input type="phone" class="form-control @error('whatsapp') is-invalid @enderror"
                                        name="whatsapp" id="whatsapp" placeholder="6282xx" value="{{ $user->whatsapp }}"
                                        required>
                                    @error('whatsapp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="password" placeholder="Password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" id="password_confirmation"
                                        placeholder="Konfirmasi Password">
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-dark">Update Profile</button>
                                    @if ($user->isAdmin())
                                        <a href="{{ route('filament.admin.pages.dashboard') }}"
                                            class="btn btn-danger">Dashboard Admin</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">

                            <h5>Daftar Transaksi</h5>

                            <div class="table-responsive cart">
                                <table class="table" style="cursor: pointer">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="card-title text-uppercase text-muted">Tanggal</th>
                                            <th scope="col" class="card-title text-uppercase text-muted">Kode</th>
                                            <th scope="col" class="card-title text-uppercase text-muted">Total</th>
                                            <th scope="col" class="card-title text-uppercase text-muted">Status</th>
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
                                                    <a href="{{ route('fe.transaction.detail', $item->code) }}">
                                                        <div class="total-price">
                                                            <span
                                                                class="money {{ $item->isPending() ? 'bg-warning' : ($item->isDone() ? 'bg-success' : 'bg-danger') }}">{{ $item->status }}</span>
                                                        </div>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            Tidak ada transaksi
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $transactions->links() }}
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection
